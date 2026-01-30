@extends('layouts.app')

@section('title')
    @yield('title')
@endsection

@section('content')
   <div class="wrapper">
      <!-- Navbar -->
      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"
              ><i class="fas fa-bars"></i
            ></a>
          </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="user-image img-circle elevation-2" alt="User Image" style="width: 40px; height: 40px; object-fit: cover;">
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <li class="user-header" style="height: auto; text-align: left; padding: 15px;">
                <div class="media">
                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="img-circle elevation-2 mr-3" alt="User Image" style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="media-body">
                    <h4 style="margin-top: 5px; margin-bottom: 2px; font-size: 1.2rem;">{{ auth()->user()->name }}</h4>
                    <p class="text-muted" style="font-size: 0.9rem;">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                </li>
                
                <div class="dropdown-divider"></div>

                <li>
                <a href="#" class="dropdown-item" style="padding: 15px;" data-toggle="modal" data-target="#changePasswordModal">
                    <i class="fas fa-cog mr-2 text-muted"></i> Change Password
                </a>

                </li>

                <div class="dropdown-divider"></div>

                <li class="user-footer" style="padding: 15px; border-top: none;">
                    <a href="#" class="btn btn-danger" 
                    style="background-color: #ff4d6d; border-color: #ff4d6d; padding: 5px 20px;"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
        </ul>
      </nav>
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('dashboard') }}" class="brand-link">
          <img
            src="{{ asset('dist/img/AdminLTELogo.png') }}"
            alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3"
            style="opacity: 0.8"
          />
          <span class="brand-text font-weight-light">Doorlock System</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
          <!-- Sidebar Menu -->
          <nav class="mt-2">
            <ul
              class="nav nav-pills nav-sidebar flex-column"
              data-widget="treeview"
              role="menu"
              data-accordion="false"
            >
              <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-item">
                <a href="{{ route('dashboard') }}"
                    class="nav-link {{ trim($__env->yieldContent('title')) === 'Dashboard' ? 'active' : '' }}">

                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('members.index') }}" class="nav-link {{ trim($__env->yieldContent('title')) === 'Members' ? 'active' : '' }}">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Members
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('access-logs.index') }}" class="nav-link {{ trim($__env->yieldContent('title')) === 'Access Logs' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-file-alt"></i>
                  <p>
                    Access Logs
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('settings.index') }}" class="nav-link {{ trim($__env->yieldContent('title')) === 'Settings' ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cogs"></i>
                  <p>
                    Settings
                  </p>
                </a>
              </li>

            </ul>
          </nav>
          <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        @yield('main-content')
      </div>
      <!-- /.content-wrapper -->
      <footer class="main-footer">
        <strong
          >Copyright &copy; 2014-2021
          <a href="https://adminlte.io">AdminLTE.io</a>.</strong
        >
        All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
          <b>Version</b> 3.2.0
        </div>
      </footer>
    </div>
    <!-- ./wrapper -->


<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-labelledby="changePasswordLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <form action="{{ route('settings.password') }}" method="POST">
      @csrf
      @method('PUT')

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="changePasswordLabel">
            <i class="fas fa-key mr-1"></i> Change Password
          </h5>
          <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <div class="form-group">
            <label>Current Password</label>
            <input type="password" name="current_password" class="form-control" placeholder="Current Password" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label>New Password</label>
            <input type="password" name="password" class="form-control" placeholder="New Password" autocomplete="off" required>
          </div>

          <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm New Password" autocomplete="off" required>
          </div>
        </div>

        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
            Close
          </button>
          <button type="submit" class="btn btn-warning btn-sm">
            <i class="fas fa-key mr-1"></i> Change Password
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

@endsection

@section('scripts')
    @yield('scripts')
@endsection
