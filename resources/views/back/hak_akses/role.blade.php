@extends('layouts.main', ['web' => $web])
@section('title', 'Role')
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
    <h1>Role</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Role</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between w-100">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahRole"><i
                  class="fas fa-plus-circle"></i></button>
              @if (count($role))
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
                <table id="roleTable" class="table table-striped" style="width:100%">
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
                    @foreach ($role as $roles)
                    <tr>
                      <td>{{ $increment++ }}</td>
                      <td>{{ $roles->name }}</td>
                      <td>
                        <button type="button" class="btn btn-sm btn-warning" data-toggle="modal"
                          data-target="#editRole{{$roles->id}}" onclick="validateEditRole({{$roles}})"><i
                            class="far fa-edit"></i></button>
                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                          data-target="#deleteConfirm" onclick="deleteThisRole({{$roles}})"><i
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
<div class="modal fade" tabindex="-1" role="dialog" id="tambahRole">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('roles.store') }}" method="post" id="tambahRoleForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="name">Nama Role</label>
            <input type="text" class="form-control" name="name" placeholder="Nama Role">
          </div>
          <div class="form-group">
            <label for="permission">Permission</label>
            @foreach ($permission as $item)
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" name="permission" type="checkbox" value="{{$item->name}}"
                id="{{$item->name}}">
              <label class="custom-control-label" for="{{$item->name}}">
                {{$item->name}}
              </label>
            </div>
            @endforeach
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

@foreach ($role as $roles)
<div class="modal fade" tabindex="-1" role="dialog" id="editRole{{$roles->id}}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Role</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('roles.update', $roles->id) }}" method="post" id="editRoleForm{{$roles->id}}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="checkRoleName{{ $roles->id }}" value="{{ $roles->name }}">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_name">Nama Role</label>
            <input type="text" class="form-control" name="edit_name" id="edit_name" placeholder="Nama Role"
              value="{{ $roles->name }}">
          </div>
          <div class="form-group">
            <label for="permission">Permission</label>
            @foreach ($permission as $item)
            <div class="custom-control custom-checkbox">
              <input class="custom-control-input" name="edit_permission" type="checkbox" value="{{$item->name}}"
                id="{{$item->name}}">
              <label class="custom-control-label" for="{{$item->name}}">
                {{$item->name}}
              </label>
            </div>
            @endforeach
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
      <form action="{{ route('roles.destroy', '') }}" method="post" id="deleteRoleForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> role ini ?
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
      <form action="{{ route('roles.destroyAll') }}" method="post" id="destroyAllForm">
        @csrf
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus semua</b> role ?
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
  $('#roleTable').DataTable( {
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
  
  $("#tambahRoleForm").validate({
      rules: {
          name:{
              required: true,
              remote: {
                    url: "{{ route('checkRoleName') }}",
                    type: "post",
              }
          }
      },
      messages: {
        name:{
                required: "Nama Role harus di isi",
                remote: "Role sudah tersedia",
          },
      },
      submitHandler: function(form) {
        $("#tambahButton").prop('disabled', true);
            form.submit();
      }
  });
});
function validateEditRole(data) {
  $("#editRoleForm" + data.id).validate({
      rules: {
          edit_name:{
              required: true,
              remote: {
                        param: {
                              url: "{{ route('checkRoleName') }}",
                              type: "post",
                        },
                        depends: function(element) {
                          // compare name in form to hidden field
                          return ($(element).val() !== $('#checkRoleName' + data.id).val());
                        },
                }
          }
      },
      messages: {
          edit_name: {
                  required: "Nama Role harus di isi",
                  remote: "Role sudah tersedia",
          },
      },
      submitHandler: function(form) {
        $("#editButton").prop('disabled', true);
            form.submit();
      }
  });
}

const deleteRole = $("#deleteRoleForm").attr('action');

function deleteThisRole(data) {
  $("#deleteRoleForm").attr('action', `${deleteRole}/${data.id}`);
}

$("#deleteModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#deleteRoleForm").submit();
});

$("#deleteAllModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#destroyAllForm").submit();
});

</script>
@endsection