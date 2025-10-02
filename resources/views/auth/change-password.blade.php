@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0"><i class="fas fa-key me-2"></i>Change Password</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror"
                                       name="current_password" required autofocus>
                                @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                                       name="password" required>
                                @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input id="password_confirmation" type="password" class="form-control"
                                       name="password_confirmation" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('profile.edit') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to Profile
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div class="bg-light p-3 rounded">
                            <h6 class="text-primary"><i class="fas fa-shield-alt me-2"></i>Password Requirements</h6>
                            <ul class="list-unstyled mb-0">
                                <li><i class="fas fa-check text-success me-2"></i>Minimum 8 characters</li>
                                <li><i class="fas fa-check text-success me-2"></i>At least one uppercase letter</li>
                                <li><i class="fas fa-check text-success me-2"></i>At least one lowercase letter</li>
                                <li><i class="fas fa-check text-success me-2"></i>At least one number</li>
                                <li><i class="fas fa-check text-success me-2"></i>At least one special character</li>
                            </ul>
                        </div>

                        <div class="mt-3 p-3 bg-warning bg-opacity-10 border border-warning rounded">
                            <h6 class="text-warning"><i class="fas fa-exclamation-triangle me-2"></i>Security Tips</h6>
                            <ul class="list-unstyled mb-0 small">
                                <li>• Use a unique password you don't use elsewhere</li>
                                <li>• Avoid personal information in passwords</li>
                                <li>• Consider using a password manager</li>
                                <li>• Don't share your password with anyone</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
