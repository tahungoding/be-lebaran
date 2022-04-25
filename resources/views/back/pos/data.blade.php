@extends('layouts.main', ['web' => $web])
@section('title', 'Pos')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
  integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

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

  #buttonGroup {
    display: block;
  }

  @media screen and (max-width: 455px) {
    .desktop-search {
      display: none;
    }

    .mobile-search-card {
      display: block !important;
    }
  }
</style>
@endsection
@section('container')
<section class="section">
  <div class="section-header">
    <h1>Pos</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Pos</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between w-100">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahPos"><i
                  class="fas fa-plus-circle"></i></button>
            </div>
          </div>
        </div>
       
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <table id="pos_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
          <thead>
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Jenis Pos</th>
                    <th>Kecamatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            @php
                $increment = 1;
            @endphp
            <tbody>
                @foreach($pos as $posdata)
                <tr>
                    <td>{{ $increment++ }}</td>
                    <td>{{ $posdata->nama }}</td>
                    <td>{{ ucwords(str_replace("_", ' ', $posdata->jenis_pos)) }}</td>
                   
                    <td>
                     @php 
                        if(isset($posdata)) {
                            $kecamatan = \App\Models\District::where('id', '=', $posdata->district_id)->first();
                        }
                     @endphp

                     {{ $kecamatan->name }}
                    </td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                            data-target="#editPos{{$posdata->id}}" onclick="validateFormEdit({{ $posdata }})"><i class="fa fa-edit"></i></button>
                        <button type="button" data-toggle="modal" data-target="#deleteConfirm"
                            class="btn btn-sm btn-danger" onclick="deleteThisPos({{ $posdata }})"><i
                                class="fa fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
  </div>
</section>

<div class="modal fade" tabindex="-1" role="dialog" id="tambahPos">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Pos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('pos.store') }}" method="post" id="tambahPosForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" placeholder="Nama Pos">
          </div>
          <div class="form-group">
            <label for="jenis_pos">Jenis Pos</label>
            <select class="form-control" name="jenis_pos" style="color:#6c757d !important;">
              <option value="">Pilih Kecamatan</option>
              <option value="pos_pelayanan">Pos Pelayanan</option>
              <option value="pos_terpadu">Pos Terpadu</option>
              <option value="pos_pengaman">Pos Pengaman</option>
            </select>
          </div>
          <div class="form-group">
            <label for="whatsapp_message">Kecamatan</label>
            <select class="form-control" name="district_id" style="color:#6c757d !important;">
              <option value="">Pilih Kecamatan</option>
              @foreach($districts as $districts_data)
                <option value="{{ $districts_data->id }}">
                    {{ $districts_data->name }}
                </option>
              @endforeach
            </select>
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

@foreach ($pos as $Allpos)
<div class="modal fade" tabindex="-1" role="dialog" id="editPos{{$Allpos->id}}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Pos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('pos.update', $Allpos->id) }}" method="post" id="editPosForm{{$Allpos->id}}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="checkPosName" value="{{ $Allpos->nama }}">
        <div class="modal-body">
          <div class="form-group">
            <label for="edit_nama">Nama</label>
            <input type="text" class="form-control" name="edit_nama" id="editName" placeholder="Nama Pos"
              value="{{ $Allpos->nama }}">
          </div>
          <div class="form-group">
            <label for="edit_jenis_pos">Jenis Pos</label>
            <select class="form-control" name="edit_jenis_pos" style="color:#6c757d !important;">
              <option value="">Pilih Kecamatan</option>
              <option value="pos_pelayanan" {{ $Allpos->jenis_pos == 'pos_pelayanan' ? 'selected' : '' }}>Pos Pelayanan</option>
              <option value="pos_terpadu" {{ $Allpos->jenis_pos == 'pos_terpadu' ? 'selected' : '' }}>Pos Terpadu</option>
              <option value="pos_pengaman" {{ $Allpos->jenis_pos == 'pos_pengaman' ? 'selected' : '' }}>Pos Pengaman</option>
            </select>
          </div>
          <div class="form-group">
            <label for="message">Kecamatan</label>
            <select class="form-control" name="edit_district_id" style="color:#6c757d !important;">
              <option value="">Pilih Kecamatan</option>
              @foreach($districts as $districts_data)
                <option value="{{ $districts_data->id }}" {{ $districts_data->id == $Allpos->district_id   ? 'selected' : '' }}>
                    {{ $districts_data->name }}
                </option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-primary" id="editPosButton">Ubah</button>
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
      <form action="{{ route('pos.destroy', '') }}" method="post" id="deletePosForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> data pos ini ?
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-primary" id="deleteModalButton">Ya, Hapus Data</button>
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
      <div class="modal-body">
        Apakah anda yakin untuk <b>menghapus semua</b> pos ?
      </div>
      <div class="modal-footer bg-whitesmoke br">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
        <button type="button" class="btn btn-primary" id="deleteAllModalButton">Ya, Hapus Semua</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
  integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
  crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#pos_table').DataTable();
});
</script>
<script>
  $('.dropify').dropify();
</script>

<script>
  $(document).ready(function() {

  $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  $("#tambahPosForm").validate({
      rules: {
          nama:{
              required: true,
              remote: {
                        url: "{{ route('checkPosName') }}",
                        type: "post",
              }
          },
          jenis_pos:{
              required: true,
          },
          kecamatan:{
              required: true,
          },
      },
      messages: {
          nama: {
                required: "Nama harus di isi",
                remote: "Nama sudah tersedia"
          },
          jenis_pos: {
                  required: "Jenis Pos harus di isi",
          },
          kecamatan: {
                  required: "Kecamatan harus di isi",
          },
      },
      submitHandler: function(form) {
        $("#tambahButton").prop('disabled', true);
            form.submit();
      }
  });
});

function validateFormEdit(data) {
  $("#editPosForm" + data.id).validate({
      rules: {
        edit_nama:{
              required: true,
              remote: {
                        param: {
                              url: "{{ route('checkPosName') }}",
                              type: "post",
                        },
                        depends: function(element) {
                          // compare name in form to hidden field
                          return ($(element).val() !== $('#checkPosName').val());
                        },
                      }
          },
          edit_jenis_pos:{
              required: true,
          },
          edit_kecamatan:{
              required: true,
          },
      },
      messages: {
        edit_nama: {
                required: "Nama harus di isi",
                remote: "Nama sudah tersedia"
          },
          edit_jenis_pos: {
                  required: "Jenis Pos harus di isi",
          },
          edit_kecamatan: {
                  required: "Kecamatan harus di isi",
          },
      },
      submitHandler: function(form) {
        $("#editPosButton").prop('disabled', true);
            form.submit();
      }
  });
}
$("#deleteAllModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#destroyAllForm").submit();
});

const deletePos = $("#deletePosForm").attr('action');

  function deleteThisPos(data) {
    $("#deletePosForm").attr('action', `${deletePos}/${data.id}`);
  }

  function readDescription(data) {
    $("#descriptionText").html(data.description);
  }

  $("#setting").click(function() {
      $("#checkAllEmpty").toggle();  
      $("#deleteAllEmpty").toggle();
  });

  function setting() {
    $("input:checkbox").toggle();
    $("#deleteAllButton").toggle(); 
  }


  $("#deleteAllButton").attr('disabled', true); 

  $("#checkAll").click(function () {
        $('input:checkbox').not(this).prop('checked', this.checked);
        if($(this).is(":checked")){
            $("#deleteAllButton").attr('disabled', false); 
            $(".checkbox").attr('disabled', false); 
        } else if($(this).is(":not(:checked)")) {
            $("#deleteAllButton").attr('disabled', true); 
            $(".checkbox").attr('disabled', true); 
        }
    });
</script>
@endsection