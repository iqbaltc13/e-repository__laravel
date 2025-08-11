<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Institution;
use App\Models\Faculty;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
        $users = User::with(['institution', 'faculty', 'departmentRelation'])->paginate(10);
        return view('users.index', compact('users'));
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
            'fullname' => 'required|string|max:255|unique:users',
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
            'fullname' => $request->fullname,
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
        $user->load(['institution', 'faculty', 'departmentRelation', 'journals']);
        return view('users.show', compact('user'));
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
            'fullname' => 'required|string|max:255|unique:users,fullname,' . $user->id,
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
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
}
