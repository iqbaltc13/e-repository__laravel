<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Institution;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:manage-users')->except(['show', 'edit', 'update']);
    }

    public function index()
    {
        $users = User::with(['institution', 'faculty', 'prodi'])->paginate(10);
        return view('users.index', compact('users'));
    }

    public function getData(Request $request): JsonResponse
    {

            $users = User::select([
                'id',
                'full_name',
                'username',
                'email',
                'role',
                'organization',
                'email_verified_at'
            ]);

            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('actions', function ($user) {
                    $divGroup = '<div class="btn-group" role="group">';
                    $viewBtn = '<button class="btn btn-sm btn-outline-info" title="View" onclick="viewUser(' . $user->id . ')" title="View">
                                    <i class="fa fa-eye"></i>
                                </button>';

                    $editBtn = '<button class="btn btn-sm btn-outline-warning" title="Edit" onclick="editUser(' . $user->id . ')" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </button>';
                    $verifyBtn = '<button class="dropdown-item text-success" title="Verify Email" onclick="verifyEmail(' . $user->id . ')" title="Verify Email">
                                    <i class="fas fa-check me-1"></i>Verify Email
                                </button>';
                    $resetBtn = '<button class="dropdown-item text-warning" title="Reset Password" onclick="resetPassword(' . $user->id . ')" title="Reset Password">
                                    <i class="fas fa-key me-1"></i>Reset Password
                                </button>';
                    $deleteBtn = '<button class="dropdown-item text-danger" title="Delete" onclick="deleteUser(' . $user->id . ')" title="Delete">
                                    <i class="fas fa-trash me-1"></i>Delete
                                </button>';
                    $divGroupDropdownMenu = '<div class="btn-group" role="group">
                                                <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                                    <i class="fas fa-cog"></i>
                                                </button>
                                                <ul class="dropdown-menu">';

                    if((!$user->email_verified_at)){
                        $divGroupDropdownMenu .= '<li> ' . $verifyBtn . '</li>';
                    }
                    $divGroupDropdownMenu .= '<li> ' . $resetBtn . '</li>';
                    if($user->id !== Auth::id()){
                        $divGroupDropdownMenu .= '<li><hr class="dropdown-divider"></li> ' . $deleteBtn . '</li>';
                    }



                    return $divGroup.$viewBtn . $editBtn . $divGroupDropdownMenu.'</ul></div></div>';
                })
                ->editColumn('role', function ($user) {

                    $color = 'secondary';
                    if($user->role === 'admin'){
                        $color = 'danger';
                    }elseif($user->role === 'editor'){
                        $color = 'success';
                    }elseif($user->role === 'member'){
                        $color = 'info';
                    }
                    return '<span class="badge bg-' . $color . '">' . $user->role . '</span>';
                })
                ->addColumn('status', function ($user) {
                    $statusColors = [
                        'Verified' => 'success',
                        'Unverified' => 'warning'
                    ];
                    $icon = is_null($user->email_verified_at) ? 'clock' : 'check';
                    $status = is_null($user->email_verified_at) ? 'Unverified' : 'Verified';
                    return '<span class="badge bg-' . $statusColors[$status] . '">
                                <i class="fa fa-' . $icon . '"></i> ' . $status . '
                            </span>';
                })
                ->filter(function ($query) use ($request) {
                    // Global search
                    if ($request->has('search') && $request->search['value']) {
                        $searchValue = $request->search['value'];
                        $query->where(function($q) use ($searchValue) {
                            $q->where('full_name', 'like', "%{$searchValue}%")
                              ->orWhere('username', 'like', "%{$searchValue}%")
                              ->orWhere('email', 'like', "%{$searchValue}%")
                              ->orWhere('role', 'like', "%{$searchValue}%")
                              ->orWhere('organization', 'like', "%{$searchValue}%");
                        });
                    }

                    // Individual column filters
                    if ($request->filled('full_name')) {
                        $query->where('full_name', 'like', "%{$request->full_name}%");
                    }
                    if ($request->filled('username')) {
                        $query->where('username', 'like', "%{$request->username}%");
                    }
                    if ($request->filled('email')) {
                        $query->where('email', 'like', "%{$request->email}%");
                    }
                    if ($request->filled('role')) {
                        $query->where('role', $request->role);
                    }
                    if ($request->filled('organization')) {
                        $query->where('organization', 'like', "%{$request->organization}%");
                    }

                })
                ->rawColumns(['role', 'status', 'actions'])
                ->make(true);


        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function create()
    {
        $institutions = Institution::where('status', 'aktif')->get();
        $faculties = Faculty::where('status', 'aktif')->get();
        $departments = Department::all();

        return view('users.create', compact('institutions', 'faculties', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,member,editor',
            'institution_code' => 'required|exists:institutions,institution_code',
            'faculty_code' => 'required|exists:faculties,faculty_code',
            'department_code' => 'required|exists:departments,department_code',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'organization' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        User::create([
            'full_name' => $request->full_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'institution_code' => $request->institution_code,
            'faculty_code' => $request->faculty_code,
            'department_code' => $request->department_code,
            'phone' => $request->phone,
            'address' => $request->address,
            'country' => $request->country,
            'organization' => $request->organization,
            'department' => $request->department,
            'bio' => $request->bio,
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil dibuat!');
    }

    public function show(User $user)
    {
        $user->load(['institution', 'faculty', 'prodi', 'journals']);
        return view('profile.show', compact('user'));
    }

    public function edit(User $user)
    {
        $institutions = Institution::where('status', 'aktif')->get();
        $faculties = Faculty::where('status', 'aktif')->get();
        $departments = Department::all();

        return view('users.edit', compact('user', 'institutions', 'faculties', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'full_name' => 'required|string|max:255|unique:users,fullname,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,member,editor',
            'institution_code' => 'nullable|exists:institutions,institution_code',
            'faculty_code' => 'nullable|exists:faculties,faculty_code',
            'department_code' => 'nullable|exists:departments,department_code',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:100',
            'organization' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
        ]);

        $data = $request->except(['password', 'password_confirmation']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.show', $user)->with('success', 'User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->journals()->count() > 0) {
            return redirect()->back()->with('error', 'User tidak dapat dihapus karena masih memiliki jurnal!');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
    public function resetPassword(User $user)
    {
        $newPassword = 'password123';
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Password user {$user->full_name} berhasil direset ke: {$newPassword}");
    }

    public function verifyEmail(User $user)
    {
        if ($user->hasVerifiedEmail()) {
            return redirect()->route('admin.users.index')
                ->with('info', 'Email sudah terverifikasi');
        }

        $user->markEmailAsVerified();

        return redirect()->route('admin.users.index')
            ->with('success', 'Email berhasil diverifikasi');
    }

}
