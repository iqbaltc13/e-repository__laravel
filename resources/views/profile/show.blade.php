@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header Section -->
    <div class="bg-white shadow-sm border-b">
        <div class="container mx-auto px-6 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Profile Saya</h1>
                    <p class="text-gray-600 mt-1">Kelola informasi pribadi dan akademik Anda</p>
                </div>
                <a href="{{ route('profile.edit') }}"
                   class="bg-blue-600 hover:bg-blue-700 text-black px-6 py-2.5 rounded-lg font-medium transition-colors duration-200 flex items-center">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-6 py-8">
        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6 rounded-r-lg">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-400 mr-3"></i>
                    <span class="text-green-800 font-medium">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            <!-- Profile Card -->
            <div class="xl:col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-6">
                    <!-- Avatar Section -->
                    <div class="text-center mb-6">
                        <div class="relative inline-block">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-2xl font-bold mx-auto shadow-lg">
                                {{ strtoupper(substr($user->full_name, 0, 2)) }}
                            </div>
                            @if($user->email_verified_at)
                                <div class="absolute -bottom-1 -right-1 w-7 h-7 bg-green-500 rounded-full flex items-center justify-center border-3 border-white shadow-md">
                                    <i class="fas fa-check text-white text-xs"></i>
                                </div>
                            @endif
                        </div>

                        <h2 class="text-xl font-bold text-gray-900 mt-4">{{ $user->full_name }}</h2>
                        <p class="text-gray-600">{{ '@' . $user->username }}</p>

                        <!-- Role Badge -->
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium mt-3
                            @if($user->role === 'admin') bg-red-100 text-red-800
                            @elseif($user->role === 'editor') bg-blue-100 text-blue-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            <i class="fas fa-user-tag mr-1.5"></i>
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>

                    <!-- Quick Stats -->
                    <div class="space-y-4 border-t pt-6">
                        @if($user->created_at)
                        <div class="flex items-center text-sm">
                            <i class="fas fa-calendar-alt text-gray-400 w-4 mr-3"></i>
                            <span class="text-gray-600">Bergabung {{ $user->created_at->format('M Y') }}</span>
                        </div>
                        @endif
                        @if($user->country)
                            <div class="flex items-center text-sm">
                                <i class="fas fa-map-marker-alt text-gray-400 w-4 mr-3"></i>
                                <span class="text-gray-600">{{ $user->country }}</span>
                            </div>
                        @endif
                        @if($user->organization)
                            <div class="flex items-center text-sm">
                                <i class="fas fa-building text-gray-400 w-4 mr-3"></i>
                                <span class="text-gray-600">{{ $user->organization }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="xl:col-span-3 space-y-6">
                <!-- Contact Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <i class="fas fa-address-card text-blue-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Kontak</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Email</dt>
                                <dd class="flex items-center">
                                    <i class="fas fa-envelope text-gray-400 mr-3"></i>
                                    <div>
                                        <div class="text-gray-900 font-medium">{{ $user->email }}</div>
                                        @if($user->email_verified_at)
                                            <div class="text-xs text-green-600 flex items-center mt-1">
                                                <i class="fas fa-check-circle mr-1"></i>Terverifikasi
                                            </div>
                                        @else
                                            <div class="text-xs text-red-600 flex items-center mt-1">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>Belum terverifikasi
                                            </div>
                                        @endif
                                    </div>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Telepon</dt>
                                <dd class="flex items-center">
                                    <i class="fas fa-phone text-gray-400 mr-3"></i>
                                    <span class="text-gray-900">{{ $user->phone ?: 'Tidak diisi' }}</span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Academic Information -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-100 rounded-lg mr-3">
                                <i class="fas fa-graduation-cap text-green-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Informasi Akademik</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Kode Institusi</dt>
                                <dd class="flex items-center">
                                    <i class="fas fa-university text-gray-400 mr-3"></i>
                                    <span class="text-gray-900">{{ $user->institution_code ?: 'Tidak diisi' }}</span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Kode Fakultas</dt>
                                <dd class="flex items-center">
                                    <i class="fas fa-building text-gray-400 mr-3"></i>
                                    <span class="text-gray-900">{{ $user->faculty_code ?: 'Tidak diisi' }}</span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Kode Departemen</dt>
                                <dd class="flex items-center">
                                    <i class="fas fa-sitemap text-gray-400 mr-3"></i>
                                    <span class="text-gray-900">{{ $user->department_code ?: 'Tidak diisi' }}</span>
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Organisasi</dt>
                                <dd class="flex items-center">
                                    <i class="fas fa-users text-gray-400 mr-3"></i>
                                    <span class="text-gray-900">{{ $user->organization ?: 'Tidak diisi' }}</span>
                                </dd>
                            </div>

                            <div class="md:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 mb-2">Departemen</dt>
                                <dd class="flex items-center">
                                    <i class="fas fa-tags text-gray-400 mr-3"></i>
                                    <span class="text-gray-900">{{ $user->departemen ?: 'Tidak diisi' }}</span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>

                <!-- Address & Bio -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Address -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <div class="flex items-center">
                                <div class="p-2 bg-orange-100 rounded-lg mr-3">
                                    <i class="fas fa-map-marker-alt text-orange-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Alamat</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($user->address)
                                <p class="text-gray-700 leading-relaxed">{{ $user->address }}</p>
                            @else
                                <p class="text-gray-500 italic">Alamat belum diisi</p>
                            @endif
                        </div>
                    </div>

                    <!-- Bio -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                        <div class="border-b border-gray-200 px-6 py-4">
                            <div class="flex items-center">
                                <div class="p-2 bg-purple-100 rounded-lg mr-3">
                                    <i class="fas fa-user-edit text-purple-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Bio</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            @if($user->bio)
                                <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $user->bio }}</p>
                            @else
                                <p class="text-gray-500 italic">Bio belum diisi</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Account Details -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200">
                    <div class="border-b border-gray-200 px-6 py-4">
                        <div class="flex items-center">
                            <div class="p-2 bg-indigo-100 rounded-lg mr-3">
                                <i class="fas fa-info-circle text-indigo-600"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Detail Akun</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            @if($user->created_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Tanggal Bergabung</dt>
                                <dd class="text-gray-900">{{ $user->created_at->format('d F Y, H:i') }}</dd>
                            </div>
                            @endif
                            @if($user->updated_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Terakhir Diperbarui</dt>
                                <dd class="text-gray-900">{{ $user->updated_at->format('d F Y, H:i') }}</dd>
                            </div>
                            @endif
                            <div>
                                <dt class="text-sm font-medium text-gray-500 mb-2">Status Email</dt>
                                <dd>
                                    @if($user->email_verified_at)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Terverifikasi
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times mr-1"></i>Belum Terverifikasi
                                        </span>
                                    @endif
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast notification container -->
<div id="toast-container" class="fixed top-4 right-4 z-50"></div>

<script>
// Copy profile link function (if needed)
function copyProfileLink() {
    const profileUrl = window.location.href;
    navigator.clipboard.writeText(profileUrl).then(function() {
        showToast('Link profile berhasil disalin!', 'success');
    });
}

// Toast notification function
function showToast(message, type = 'info') {
    const toastContainer = document.getElementById('toast-container');
    const toast = document.createElement('div');

    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'fa-check' : type === 'error' ? 'fa-times' : 'fa-info';

    toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg mb-2 flex items-center transform translate-x-full transition-transform duration-300`;
    toast.innerHTML = `<i class="fas ${icon} mr-2"></i>${message}`;

    toastContainer.appendChild(toast);

    // Animate in
    setTimeout(() => {
        toast.classList.remove('translate-x-full');
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        toast.classList.add('translate-x-full');
        setTimeout(() => {
            if (toast.parentNode) {
                toast.parentNode.removeChild(toast);
            }
        }, 300);
    }, 3000);
}
</script>

@endsection
