@extends('layouts.home')

@section('title', 'Members')

@section('main-content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ isset($member) ? 'Edit Member' : 'Add Member' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">Members</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">

            <!-- FORM -->
            <div class="col-md-8">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Member Information</h3>
                    </div>

                    <form 
                        action="{{ isset($member) ? route('members.update', $member->id) : route('members.store') }}" 
                        method="POST" 
                        enctype="multipart/form-data"
                    >
                        @csrf
                        @isset($member)
                            @method('PUT')
                        @endisset

                        <div class="card-body">
                            <div class="form-group">
                                <label for="card_uid">Card UID</label>
                                <input
                                    type="text"
                                    name="card_uid"
                                    id="card_uid"
                                    class="form-control @error('card_uid') is-invalid @enderror"
                                    placeholder="Tap your card"
                                    value="{{ old('card_uid', $member->card_uid ?? '') }}"
                                    autocomplete="off"
                                    required
                                >
                                @error('card_uid')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    placeholder="Full name"
                                    value="{{ old('name', $member->name ?? '') }}"
                                    required
                                >
                                @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Email address"
                                    value="{{ old('email', $member->email ?? '') }}"
                                    required
                                >
                                @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="image">Photo</label>
                                <input
                                    type="file"
                                    name="image"
                                    id="image"
                                    class="form-control @error('image') is-invalid @enderror"
                                    accept="image/*"
                                    {{ isset($member) ? '' : 'required' }}
                                >
                                @isset($member)
                                    <small class="text-muted">Kosongkan jika tidak ingin mengganti foto</small>
                                @endisset
                                @error('image')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>

                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">
                                {{ isset($member) ? 'Update' : 'Save' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- PHOTO PREVIEW -->
            <div class="col-md-4">
                <div class="card card-outline card-secondary text-center">
                    <div class="card-header">
                        <h3 class="card-title">Photo Preview</h3>
                    </div>

                    <div class="card-body">
                        @isset($member)
                            <img
                                src="{{ asset('storage/' . $member->image) }}"
                                alt="Member Photo"
                                class="img-fluid img-circle elevation-2"
                                style="width: 150px; height: 150px; object-fit: cover;"
                            >
                            <p class="mt-3 mb-0"><strong>{{ $member->name }}</strong></p>
                            <small class="text-muted">{{ $member->email }}</small>
                        @else
                            <div class="text-muted">
                                <i class="fas fa-user-circle fa-7x mb-3"></i>
                                <p>No photo uploaded</p>
                            </div>
                        @endisset
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('card_uid');
    let lastUID = '';

    setInterval(async () => {
        try {
            const res = await fetch('/api/last-rfid', { cache: 'no-store' });
            const data = await res.json();

            if (!data || !data.uid) return;

            // Cegah duplikat
            if (data.uid === lastUID) return;

            lastUID = data.uid;
            input.value = data.uid;

            input.classList.add('is-valid');
            input.style.backgroundColor = '#e6fffa';

            setTimeout(() => {
                input.style.backgroundColor = '';
            }, 300);

        } catch (e) {
            console.error(e);
        }
    }, 500); // 500ms lebih manusiawi
});
</script>
@endsection
