@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-user-plus me-2"></i>Create New User</h1>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i>Back to Users
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf



                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-success"><i class="fas fa-user me-2"></i>Informasi Personal</h5>

                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror"
                                       name="full_name" value="{{ old('full_name') }}" required autofocus>
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username/NIM<span class="text-danger">*</span></label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                       name="username" value="{{ old('username') }}" required>
                                {{-- <small class="form-text text-muted">Username/NIM akan digunakan untuk login</small> --}}
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                    name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input id="password_confirmation" type="password" class="form-control"
                                    name="password_confirmation" required>
                            </div>
                            <div class="mb-3">
                                <label for="role" class="form-label">Role<span class="text-danger">*</span></label>
                                <select id="role" class="form-control @error('role') is-invalid @enderror" name="role" required>
                                    <option value="">Pilih Role</option>
                                    <option value="member" >Member</option>
                                    <option value="editor" >Editor</option>
                                    <option value="admin" >Admin</option>
                                </select>
                                {{-- <small class="form-text text-muted">Username/NIM akan digunakan untuk login</small> --}}
                                @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email') }}" required>
                                <small class="form-text text-muted">Email akan digunakan untuk verifikasi akun</small>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>








                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone') }}" placeholder="+628123456789">
                                @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="country" class="form-label">Negara</label>
                                <input id="country" type="text" class="form-control @error('country') is-invalid @enderror"
                                       name="country" value="{{ old('country', 'Indonesia') }}">
                                @error('country')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Institution & Organization -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-success"><i class="fas fa-building me-2"></i>Institusi & Organisasi</h5>

                            <div class="mb-3">
                                <label for="organization" class="form-label">Organisasi/Kampus/Institusi</label>
                                <input id="organization" type="text" class="form-control @error('organization') is-invalid @enderror"
                                       name="organization" value="{{ old('organization') }}" placeholder="nama sekolah/kampus/korporat/organisasi">
                                @error('organization')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label for="departemen" class="form-label">Departemen/Divisi</label>
                                <input id="departemen" type="text" class="form-control @error('departemen') is-invalid @enderror"
                                       name="departemen" value="{{ old('departemen') }}" placeholder="Departemen atau divisi">
                                @error('departemen')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="institution_code" class="form-label">Kode Institusi</label>
                                <input id="institution_code" type="text" class="form-control @error('institution_code') is-invalid @enderror"
                                       name="institution_code" value="{{ old('institution_code') }}" placeholder="INST001">
                                @error('institution_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="faculty_code" class="form-label">Kode Fakultas</label>
                                <input id="faculty_code" type="text" class="form-control @error('faculty_code') is-invalid @enderror"
                                       name="faculty_code" value="{{ old('faculty_code') }}" placeholder="FTECH">
                                @error('faculty_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="department_code" class="form-label">Kode Departemen</label>
                                <input id="department_code" type="text" class="form-control @error('department_code') is-invalid @enderror"
                                       name="department_code" value="{{ old('department_code') }}" placeholder="DCOMP">
                                @error('department_code')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label for="address" class="form-label">Alamat</label>
                                <textarea id="address" class="form-control @error('address') is-invalid @enderror"
                                          name="address" rows="3" placeholder="Alamat lengkap">{{ old('address') }}</textarea>
                                @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="mb-4">
                                <label for="bio" class="form-label">Bio/Deskripsi Diri</label>
                                <textarea id="bio" class="form-control @error('bio') is-invalid @enderror"
                                          name="bio" rows="3" placeholder="Ceritakan tentang diri Anda...">{{ old('bio') }}</textarea>
                                @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->


                    <div class="d-grid">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-lg ">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Simpan
                        </button>
                    </div>



                    <div class="text-center">

                    </div>


        </form>
    </div>
</div>
@endsection
