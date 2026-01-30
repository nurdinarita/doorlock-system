@extends('layouts.home')

@section('title', 'Dashboard')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0">Dashboard</h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">

        {{-- STAT BOX --}}
        <div class="row">

            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $totalMembers }}</h3>
                        <p>Total Members</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $todayAccess }}</h3>
                        <p>Today Access</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-door-open"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $todayEntry }}</h3>
                        <p>Entry</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sign-in-alt"></i>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-6">
                <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>{{ $todayExit }}</h3>
                        <p>Exit</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-sign-out-alt"></i>
                    </div>
                </div>
            </div>

        </div>

        {{-- LATEST ACCESS LOG --}}
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-history mr-1"></i>
                            Latest Access Logs
                        </h3>
                    </div>

                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Card UID</th>
                                    <th>Action</th>
                                    <th>Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($latestLogs as $log)
                                    <tr>
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
                                        <td>{{ date('d/M/Y, H:i:s', strtotime($log->logged_at)) }} WIB</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted">
                                            No access data yet
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('access-logs.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-history mr-1"></i> View All
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
@endsection
