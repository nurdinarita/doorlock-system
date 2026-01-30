@extends('layouts.home')

@section('title', 'Settings')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Profile Settings</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active">Settings</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- PROFILE INFO -->
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-user mr-1"></i>
                            Profile Information
                        </h3>
                    </div>

                    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">
                                <label>Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    class="form-control"
                                    value="{{ auth()->user()->name }}"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label>Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ auth()->user()->email }}"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label>Profile Photo</label>
                                <input type="file" name="avatar" class="form-control" accept="image/*">
                                <small class="text-muted">
                                    Kosongkan jika tidak ingin mengganti foto
                                </small>
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-primary">
                                <i class="fas fa-save mr-1"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- CHANGE PASSWORD -->
            <div class="col-md-6">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-lock mr-1"></i>
                            Change Password
                        </h3>
                    </div>

                    <form action="{{ route('settings.password') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="form-group">
                                <label>Current Password</label>
                                <input
                                    type="password"
                                    name="current_password"
                                    class="form-control"
                                    placeholder="Current Password"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label>New Password</label>
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control"
                                    placeholder="New Password"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <label>Confirm New Password</label>
                                <input
                                    type="password"
                                    name="password_confirmation"
                                    class="form-control"
                                    placeholder="Confirm New Password"
                                    required
                                >
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button class="btn btn-warning">
                                <i class="fas fa-key mr-1"></i> Change Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
