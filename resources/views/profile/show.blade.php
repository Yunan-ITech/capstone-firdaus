@extends('layouts.app')

@section('content')
<div class="container py-3" style="background: linear-gradient(135deg, rgba(102,126,234,0.06), rgba(118,75,162,0.06)); border-radius: 16px;">
    <div class="row justify-content-center mb-4">
        <div class="col-lg-10">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width:60px;height:60px; background: linear-gradient(135deg, #667eea, #764ba2); box-shadow: 0 8px 20px rgba(102,126,234,0.45);">
                        <i class="fas fa-user text-white fs-3"></i>
                    </div>
                    <div>
                        <h3 class="mb-0">Profil Admin</h3>
                        <small class="text-muted">Kelola informasi akun dan keamanan login Anda</small>
                    </div>
                </div>
                <div class="text-muted">
                    <small><i class="fas fa-envelope me-1"></i>{{ auth()->user()->email }}</small>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 border-0 shadow-sm">
                        <div class="card-header border-0 pb-0" style="background: linear-gradient(135deg, rgba(102,126,234,0.12), rgba(118,75,162,0.12));">
                            <h5 class="mb-1"><i class="fas fa-id-card me-2 text-primary"></i>Informasi Akun</h5>
                            <small class="text-muted">Perbarui data dasar akun admin</small>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama</label>
                                    <input id="name" type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="email" class="form-control" 
                                           value="{{ auth()->user()->email }}" disabled>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header bg-transparent border-0 pb-0">
                            <h5 class="mb-1"><i class="fas fa-lock me-2 text-primary"></i>Keamanan Akun</h5>
                            <small class="text-muted">Ubah password untuk menjaga keamanan akun</small>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.password.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Password Saat Ini</label>
                                    <input id="current_password" type="password" 
                                           class="form-control @error('current_password') is-invalid @enderror" 
                                           name="current_password" required>
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password Baru</label>
                                    <input id="password" type="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           name="password" required>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                                    <input id="password_confirmation" type="password" 
                                           class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-key me-1"></i> Ubah Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
