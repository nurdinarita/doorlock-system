@extends('layouts.home')

@section('title', 'Access Logs')

@section('main-content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Access Logs</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Access Logs</li>
        </ol>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex align-items-center">
                    <form method="GET" action="{{ route('access-logs.index') }}" class="ml-auto">
                        <div class="input-group input-group-sm">
                            <input
                                type="search"
                                name="search"
                                class="form-control"
                                placeholder="Search name / email / UID"
                                value="{{ request('search') }}"
                                autocomplete="off"
                            >
                            <div class="input-group-append">
                                <button class="btn btn-secondary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th style="width: 400px;">Name</th>
                      <th>Card UID</th>
                      <th style="width: 200px;">Action</th>
                      <th style="width: 200px;">Time</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($access_logs as $log)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $log->member->image) }}" 
                                    alt="User Image" 
                                    class="img-circle elevation-1 mr-3" 
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                
                                <div class="d-flex flex-column align-items-start">
                                    <span class="font-weight-bold" style="line-height: 1.2;">
                                        {{ $log->member->name }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $log->member->email ?? '-' }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $log->card_uid }}</td>
                        <td>
                            @if($log->action === 'entry')
                                <span class="badge badge-success">
                                    <i class="fas fa-sign-in-alt"></i> Entry
                                </span>
                            @else
                                <span class="badge badge-danger">
                                    <i class="fas fa-sign-out-alt"></i> Exit
                                </span>
                            @endif
                        </td>
                        <td>
                            {{-- {{ $log->logged_at->format('d M Y, H:i:s') }} --}}
                            {{ date('d/M/Y, H:i:s', strtotime($log->logged_at)) }} WIB
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            @if ($access_logs->hasPages())
            <div class="card-footer clearfix" style="margin-top: -15px;">
                <div class="float-right pagination-sm m-0">
                    {{ $access_logs->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
            </div>
        </div>
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection