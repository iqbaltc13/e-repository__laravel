@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0"><i class="fas fa-user-plus me-2"></i>Edit Profile</h4>

            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PATCH')
                    <div class="row">
                        <!-- Basic Information -->
                        <div class="col-md-6">
                            <h5 class="mb-3 text-success"><i class="fas fa-user me-2"></i>Informasi Personal</h5>

                            <div class="mb-3">
                                <label for="full_name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input id="full_name" type="text" class="form-control @error('full_name') is-invalid @enderror"
                                       name="full_name" value="{{ old('full_name', $user->full_name) }}" required autofocus>
                                @error('full_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="username" class="form-label">Username/NIM<span class="text-danger">*</span></label>
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
                                       name="username" value="{{ old('username',$user->username) }}" required>
                                {{-- <small class="form-text text-muted">Username/NIM akan digunakan untuk login</small> --}}
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email" value="{{ old('email', $user->email) }}" required>
                                <small class="form-text text-muted">Email akan digunakan untuk verifikasi akun</small>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>








                            <div class="mb-3">
                                <label for="phone" class="form-label">Nomor Telepon</label>
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror"
                                       name="phone" value="{{ old('phone', $user->phone) }}" placeholder="+628123456789">
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
                                <label for="organization" class="form-label">Organisasi</label>
                                <input id="organization" type="text" class="form-control @error('organization') is-invalid @enderror"
                                       name="organization" value="{{ old('organization', $user->organization) }}" placeholder="Nama organisasi ">
                                @error('organization')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <h6 class="mb-3 mt-4">Informasi Institusi</h6>


                            <div class="mb-3">
                                <label for="institution_code" class="form-label">Universitas <span class="text-danger">*</span></label>
                                <select class="form-select @error('institution_code') is-invalid @enderror"
                                        id="institution_code" name="institution_code" required>
                                        @if($user->institution)
                                            <option value="{{ $user->institution_code }}" selected>{{ $user->institution->institution_name }}</option>
                                        @endif

                                </select>
                                @error('institution_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3">
                                <label for="faculty_code" class="form-label">Fakultas <span class="text-danger">*</span></label>
                                <select class="form-select @error('faculty_code') is-invalid @enderror"
                                        id="faculty_code" name="faculty_code" >
                                        @if($user->faculty)
                                            <option value="{{ $user->faculty_code }}" selected>{{ $user->faculty->faculty_name }}</option>
                                        @endif
                                </select>
                                @error('faculty_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="department_code" class="form-label">Departemen/Prodi <span class="text-danger">*</span></label>
                                <select class="form-select @error('department_code') is-invalid @enderror"
                                        id="department_code" name="department_code" >
                                        @if($user->prodi)
                                            <option value="{{ $user->department_code }}" selected>{{ $user->prodi->department_name }}</option>
                                        @endif
                                </select>
                                @error('department_code')
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
                                          name="address" rows="3" placeholder="Alamat lengkap">{{ old('address', $user->address) }}</textarea>
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
                                          name="bio" rows="3" placeholder="Ceritakan tentang diri Anda...">{{ old('bio', $user->bio) }}</textarea>
                                @error('bio')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Conditions -->


                    <div class="d-grid">
                        <a href="{{ route('profile.show') }}" class="btn btn-secondary btn-lg ">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-success btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Simpan Perubahan
                        </button>
                    </div>



                    <div class="text-center">

                    </div>
                </form>
            </div>
        </div>

        <!-- Password Requirements Info -->
        <div class="card mt-3">
            <div class="card-body">

            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Real-time password validation

</script>
<script>
   $(document).ready(function() {
            // Inisialisasi Select2 dengan tema Bootstrap
            function initializeSelect2(selector, placeholder) {
                $(selector).select2({
                    theme: 'bootstrap',
                    placeholder: placeholder,
                    allowClear: true,
                    language: 'id',
                    escapeMarkup: function(markup) {
                        return markup;
                    }
                });
            }

            // Inisialisasi semua select2
            initializeSelect2('#institution_code', 'Pilih Universitas...');
            initializeSelect2('#faculty_code', 'Pilih Fakultas...');
            initializeSelect2('#department_code', 'Pilih Program Studi...');

            // Fungsi untuk menampilkan loading
            function showLoading(selector) {
                $(selector).prop('disabled', true);
                $(selector).html('<option value="">Memuat...</option>');
            }

            // Fungsi untuk reset select
            function resetSelect(selector, placeholder) {
                $(selector).prop('disabled', true);
                $(selector).html(`<option value="">${placeholder}</option>`);
                $(selector).val('').trigger('change');
            }

            async function loadUniversitas() {
            try {
                showLoading('#institution_code');

                const response = await $.ajax({
                    url: "{{ route('get-universitas') }}", // Endpoint API Anda
                    method: 'GET',
                    dataType: 'json'
                });

                let options = '<option value="">-- Pilih Universitas --</option>';
                response.data.forEach(univ => {
                    options += `<option value="${univ.institution_code}">${univ.institution_name}</option>`;
                });

                $('#institution_code').html(options).prop('disabled', false);

            } catch (error) {
                console.error('Error loading universitas:', error);
                $('#institution_code').html('<option value="">Error memuat data</option>');
            }
        }

        async function loadFakultas(universitasCode) {
            if (!universitasCode) {
                resetSelect('#faculty_code', '-- Pilih Fakultas --');
                resetSelect('#department_code', '-- Pilih Program Studi --');
                return;
            }

            try {
                showLoading('#faculty_code');
                resetSelect('#department_code', '-- Pilih Program Studi --');

                const response = await $.ajax({
                    url: "{{ route('get-fakultas') }}",
                    method: 'GET',
                    data: { institution_code: universitasCode },
                    dataType: 'json'
                });

                let options = '<option value="">-- Pilih Fakultas --</option>';
                response.data.forEach(fakultas => {
                    options += `<option value="${fakultas.faculty_code}">${fakultas.faculty_name}</option>`;
                });

                $('#faculty_code').html(options).prop('disabled', false);

            } catch (error) {
                console.error('Error loading fakultas:', error);
                $('#faculty_code').html('<option value="">Error memuat data</option>');
            }
        }

        async function loadProdi(universitasCode, fakultasCode) {
            if (!universitasCode || !fakultasCode) {
                resetSelect('#department_code', '-- Pilih Program Studi --');
                return;
            }

            try {
                showLoading('#department_code');

                const response = await $.ajax({
                    url: "{{ route('get-prodi') }}",
                    method: 'GET',
                    data: {
                        institution_code: universitasCode,
                        faculty_code: fakultasCode
                    },
                    dataType: 'json'
                });

                let options = '<option value="">-- Pilih Program Studi --</option>';
                response.data.forEach(prodi => {
                    options += `<option value="${prodi.department_code}">${prodi.department_name}</option>`;
                });

                $('#department_code').html(options).prop('disabled', false);

            } catch (error) {
                console.error('Error loading prodi:', error);
                $('#department_code').html('<option value="">Error memuat data</option>');
            }
        }
         $('#institution_code').on('change', function() {
                const universitasCode = $(this).val();
                loadFakultas(universitasCode);
        });

        $('#faculty_code').on('change', function() {
            const universitasCode = $('#institution_code').val();
            const fakultasCode = $(this).val();
            loadProdi(universitasCode, fakultasCode);
        });

        loadUniversitas();


    });
</script>

@endpush
@endsection
