@extends('layouts.main', ['web' => $web])
@section('title', 'Permission')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
  integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.1.9/css/fixedHeader.bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css">
<style>
  .dropify-wrapper {
    border: 1px solid #e2e7f1;
    border-radius: .3rem;
    height: 150px;
  }

  .card {
    border-radius: 10px;
  }

  label.error {
    color: #f1556c;
    font-size: 13px;
    font-size: .875rem;
    font-weight: 400;
    line-height: 1.5;
    margin-top: 5px;
    padding: 0;
  }

  input.error {
    color: #f1556c;
    border: 1px solid #f1556c;
  }

  table.dataTable.no-footer {
    border-bottom: 1px solid #f4f4f4 !important;
  }

  .table:not(.table-sm) thead th {
    background-color: rgba(0, 0, 0, 0.75) !important;
    color: #fff !important;
  }
</style>
@endsection
@section('container')
<section class="section">
  <div class="section-header">
    <h1>Permission</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Permission</div>
    </div>
  </div>

  <div class="section-body">

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between w-100">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahPermission"><i
                  class="fas fa-plus-circle"></i></button>
              @if (count($permission))
              <div class="d-flex justify-content-between">
                <button class="btn btn-sm btn-danger" id="deleteAllButton" data-toggle="modal"
                  data-target="#deleteAllConfirm" style="margin-right: 20px;"><i class="fas fa-trash"></i></button>
              </div>
              @else
              <div class="d-flex justify-content-between">
                <button class="btn btn-sm btn-danger" id="deleteAllEmpty" style="margin-right: 20px;" disabled><i
                    class="fas fa-trash"></i></button>
              </div>
              @endif
            </div>
            <br>
            <div class="card">
              <div class="card-body">
                <table id="permissionTable" class="table table-striped" style="width:100%">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    @php
                    $increment = 1;
                    @endphp
                    @foreach ($permission as $permissions)
                    <tr>
                      <td>{{ $increment++ }}</td>
                      <td>{{ $permissions->name }}</td>
                      <td>
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                          data-target="#editPermission{{$permissions->id}}" onclick="validateEditPermission({{$permissions}})"><i
                            class="far fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                          data-target="#deleteConfirm" onclick="deleteThisPermission({{$permissions}})"><i
                            class="far fa-trash-alt"></i></button>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@section('modal')
<div class="modal fade" tabindex="-1" role="dialog" id="tambahPermission">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('permissions.store') }}" method="post" id="tambahPermissionForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama Permission</label>
            <input type="text" class="form-control" name="name" placeholder="Nama Permission">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-primary" id="tambahButton">Tambah</button>
        </div>
      </form>
    </div>
  </div>
</div>

@foreach ($permission as $permissions)
<div class="modal fade" tabindex="-1" role="dialog" id="editPermission{{$permissions->id}}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Permission</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('permissions.update', $permissions->id) }}" method="post" id="editPermissionForm{{$permissions->id}}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="checkPermissionName{{ $permissions->id }}" value="{{ $permissions->name }}">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_name">Nama Permission</label>
            <input type="text" class="form-control" name="edit_name" id="edit_name" placeholder="Nama Permission"
              value="{{ $permissions->name }}">
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-primary" id="editButton">Ubah</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endforeach

<div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirm">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('permissions.destroy', '') }}" method="post" id="deletePermissionForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> permission ini ?
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="button" class="btn btn-primary" id="deleteModalButton">Ya, Hapus</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="deleteAllConfirm">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus Semua</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('permissions.destroyAll') }}" method="post" id="destroyAllForm">
        @csrf
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus semua</b> permission ?
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="button" class="btn btn-primary" id="deleteAllModalButton">Ya, Hapus Semua</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('js')
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
  integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
  $('.dropify').dropify();

$(document).ready(function() {
  $('#permissionTable').DataTable( {
        responsive: true,
        "searching": false
  });
});
</script>

<script>
  $(document).ready(function() {

  $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  $("#tambahPermissionForm").validate({
      rules: {
          name:{
              required: true,
              remote: {
                    url: "{{ route('checkPermissionName') }}",
                    type: "post",
              }
          },
      },
      messages: {
        name:{
                required: "Nama Permission harus di isi",
                remote: "Role sudah tersedia"
          },
      },
      submitHandler: function(form) {
        $("#tambahButton").prop('disabled', true);
            form.submit();
      }
  });
});
function validateEditPermission(data) {
  $("#editPermissionForm" + data.id).validate({
      rules: {
          edit_name:{
              required: true,
              remote: {
                        param: {
                              url: "{{ route('checkPermissionName') }}",
                              type: "post",
                        },
                        depends: function(element) {
                          // compare name in form to hidden field
                          return ($(element).val() !== $('#checkPermissionName' + data.id).val());
                        },
                }
          },
      },
      messages: {
          edit_name: {
                  required: "Nama Permission harus di isi",
                  remote: "Role sudah tersedia"
          },
      },
      submitHandler: function(form) {
        $("#editButton").prop('disabled', true);
            form.submit();
      }
  });
}

const deletePermission = $("#deletePermissionForm").attr('action');

function deleteThisPermission(data) {
  $("#deletePermissionForm").attr('action', `${deletePermission}/${data.id}`);
}

$("#deleteModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#deletePermissionForm").submit();
});

$("#deleteAllModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#destroyAllForm").submit();
});

</script>
@endsection