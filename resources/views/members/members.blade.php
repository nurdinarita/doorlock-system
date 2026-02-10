@extends('layouts.home')

@section('title', 'Members')

@section('main-content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Members</h1>
        </div>
        <!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">Members</li>
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
                <a href="{{ route('members.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Add Member
                </a>

                <form method="GET" action="{{ route('members.index') }}" class="ml-auto">
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
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($members as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="{{ asset('storage/' . $member->image) }}" 
                                    alt="User Image" 
                                    class="img-circle elevation-1 mr-3" 
                                    style="width: 40px; height: 40px; object-fit: cover;">
                                
                                <div class="d-flex flex-column align-items-start">
                                    <span class="font-weight-bold" style="line-height: 1.2;">
                                        {{ $member->name }}
                                    </span>
                                    <small class="text-muted">
                                        {{ $member->email ?? '-' }}
                                    </small>
                                </div>
                            </div>
                        </td>
                        <td>{{ $member->card_uid }}</td>
                        <td>
                            <button
                                class="btn btn-info btn-sm"
                                data-toggle="modal"
                                data-target="#viewModal"
                                data-name="{{ $member->name }}"
                                data-email="{{ $member->email }}"
                                data-uid="{{ $member->card_uid }}"
                                data-image="{{ asset('storage/' . $member->image) }}"
                            >
                                <i class="fas fa-eye"></i>
                            </button>
                            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                            <button 
                                class="btn btn-danger btn-sm"
                                data-toggle="modal"
                                data-target="#deleteModal"
                                data-id="{{ $member->id }}"
                                data-name="{{ $member->name }}"
                            >
                                <i class="fas fa-trash"></i>
                            </button>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted py-2">
                            <i class="fas fa-info-circle mr-1"></i>
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            @if ($members->hasPages())
            <div class="card-footer clearfix" style="margin-top: -15px;">
                <div class="float-right pagination-sm m-0">
                    {{ $members->links('pagination::bootstrap-4') }}
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

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      
      <form id="deleteForm" method="POST" action="{{ route('members.destroy') }}">
        @csrf
        @method('DELETE')
        <input type="hidden" name="id" id="deleteMemberId">

        <div class="modal-header bg-danger">
          <h5 class="modal-title text-white" id="deleteModalLabel">
            Konfirmasi Hapus
          </h5>
          <button type="button" class="close text-white" data-dismiss="modal">
            <span>&times;</span>
          </button>
        </div>

        <div class="modal-body">
          <p class="mb-0">
            Yakin ingin menghapus member:
            <strong id="memberName"></strong>?
          </p>
          <small class="text-muted">
            Data yang dihapus tidak dapat dikembalikan.
          </small>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-danger">
            Ya, Hapus
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- View Detail Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header bg-info">
        <h5 class="modal-title text-white">
          Detail Member
        </h5>
        <button type="button" class="close text-white" data-dismiss="modal">
          <span>&times;</span>
        </button>
      </div>

      <div class="modal-body text-center">
        <img
          id="viewImage"
          src=""
          class="img-circle elevation-2 mb-3"
          style="width:100px;height:100px;object-fit:cover;"
        >

        <h5 id="viewName" class="mb-1"></h5>
        <p id="viewEmail" class="text-muted mb-2"></p>

        <span class="badge badge-secondary">
          UID: <span id="viewUID"></span>
        </span>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">
          Tutup
        </button>
      </div>

    </div>
  </div>
</div>


@endsection

@section('scripts')
<script>
    $('#deleteModal').on('show.bs.modal', function (event) {
      const button = $(event.relatedTarget)

      $('#memberName').text(button.data('name'))
      $('#deleteMemberId').val(button.data('id'))
    })
</script>

<script>
$('#viewModal').on('show.bs.modal', function (event) {
    const button = $(event.relatedTarget)

    $('#viewName').text(button.data('name'))
    $('#viewEmail').text(button.data('email'))
    $('#viewUID').text(button.data('uid'))
    $('#viewImage').attr('src', button.data('image'))
})
</script>

@endsection