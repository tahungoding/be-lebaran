@extends('layouts.main', ['web' => $web])
@section('title', 'Kemacetan')
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
    <h1>Kemacetan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Kemacetan</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between w-100">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahKemacetan"><i
                  class="fas fa-plus-circle"></i></button>
            </div>
          </div>
        </div>
       
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <table id="kemacetan_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Lokasi</th>
                    <th>Detail</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            @php
                $increment = 1;
            @endphp
            <tbody>
                @foreach($kemacetan as $data)
                <tr>
                    <td>{{ $increment++ }}</td>
                    <td>{{ $data->lokasi }}</td>
                    <td><a href="javascript:void(0)" data-target="#detailKemacetan{{ $data->id }}" data-toggle="modal"><i class="fas fa-eye"></i></a></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                            data-target="#editKemacetan{{$data->id}}"
                            ><i class="fa fa-edit"></i></button>
                        <button type="button" data-toggle="modal" data-target="#deleteConfirm"
                            class="btn btn-sm btn-danger" onclick="deleteThisKemacetan({{ $data }})"><i
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

<div class="modal fade" tabindex="-1" role="dialog" id="tambahKemacetan">
  <div class="modal-dialog " role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kemacetan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('kemacetan.store') }}" method="post" id="tambahKemacetanForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" placeholder="Lokasi">
          </div>
          <div class="form-group">
            <label for="ringkas_kejadian">Ringkasan Kejadian</label>
            <textarea name="ringkas_kejadian" class="form-control" style="height: 30vh;"></textarea>
          </div>
          <div class="form-group">
            <label for="detail_kejadian">Detail Kejadian</label>
            <textarea name="detail_kejadian" class="form-control" style="height: 30vh;"></textarea>
          </div>
          <div class="form-group">
            <label for="file_pendukung">File Pendukung</label>
            <input type="file" class="form-control dropify" name="file_pendukung"
                    data-allowed-file-extensions="png jpg jpeg svg" data-show-remove="false">
          </div>
          <div class="form-group">
            <label for="waktu">Waktu</label>
            <input type="time" name="waktu" class="form-control">
          </div>
          <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" class="form-control">
          </div>
          <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" class="form-control">
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

@foreach ($kemacetan as $kemacetanData)
<div class="modal fade" tabindex="-1" role="dialog" id="editKemacetan{{$kemacetanData->id}}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kemacetan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('kemacetan.update', $kemacetanData->id) }}" method="post" id="editKemacetanForm"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="checkKemacetanName" value="{{ $kemacetanData->nama }}">
        <div class="modal-body">
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" name="edit_lokasi" value="{{ $kemacetanData->lokasi }}" placeholder="Lokasi">
              </div>
              <div class="form-group">
                <label for="ringkas_kejadian">Ringkasan Kejadian</label>
                <textarea name="edit_ringkas_kejadian" class="form-control" style="height: 30vh;">{{ $kemacetanData->ringakas_kejadian }}</textarea>
              </div>
              <div class="form-group">
                <label for="detail_kejadian">Detail Kejadian</label>
                <textarea name="edit_detail_kejadian" class="form-control" style="height: 30vh;">{{ $kemacetanData->detail_kejadian }}</textarea>
              </div>
              <div class="form-group">
                <label for="file_pendukung">File Pendukung</label>
                <input type="file" class="form-control dropify" name="file_pendukung"
                    data-allowed-file-extensions="png jpg jpeg svg" data-show-remove="false" data-default-file="@if(!empty($kemacetanData->file_pendukung) &&
                    Storage::exists($kemacetanData->file_pendukung)){{ Storage::url($kemacetanData->file_pendukung) }}@endif">
                <button></button>  
            </div>
              <div class="form-group">
                <label for="waktu">Waktu</label>
                <input type="time" name="edit_waktu" class="form-control" value="{{ $kemacetanData->waktu }}">
              </div>
              <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" name="edit_latitude" class="form-control" value="{{ $kemacetanData->latitude }}"">
              </div>
              <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" name="edit_longitude" class="form-control" value="{{ $kemacetanData->longitude }}">
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

@foreach ($kemacetan as $kemacetanData)
<div class="modal fade" tabindex="-1" role="dialog" id="detailKemacetan{{$kemacetanData->id}}">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Kemacetan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" value="{{ $kemacetanData->lokasi }}" placeholder="Lokasi" readonly>
              </div>
              <div class="form-group">
                <label for="ringkas_kejadian">Ringkasan Kejadian</label>
                <textarea class="form-control" readonly style="height: 30vh;">{{ $kemacetanData->ringakas_kejadian }}</textarea>
              </div>
              <div class="form-group">
                <label for="detail_kejadian">Detail Kejadian</label>
                <textarea class="form-control" readonly style="height: 30vh;">{{ $kemacetanData->detail_kejadian }}</textarea>
              </div>
              <div class="form-group">
                <label for="waktu">Waktu</label>
                <input type="time" class="form-control" value="{{ $kemacetanData->waktu }}" readonly>
              </div>
              <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" class="form-control" value="{{ $kemacetanData->latitude }}" readonly>
              </div>
              <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" class="form-control" value="{{ $kemacetanData->longitude }}" readonly>
              </div>
              <div class="form-group">
                <label for="file_pendukung">File Pendukung</label>
                <a href="">{{ $kemacetanData->file_pendukung }}</a>
              </div>
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
        </div>
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
      <form action="{{ route('kemacetan.destroy', '') }}" method="post" id="deleteKemacetanForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> kemacetan ini ?
        </div>
        <div class="modal-footer bg-whitesmoke br">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
          <button type="submit" class="btn btn-primary" id="deleteModalButton">Ya, Hapus Semua</button>
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
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
    $('#kemacetan_table').DataTable();
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
  
  $("#tambahKemacetanForm").validate({
      rules: {
          lokasi:{
              required: true,
          },
          ringkas_kejadian:{
              required: true,
          },
          detail_kejadian:{
              required: true,
          },
          waktu:{
              required: true,
          },
          latitude:{
              required: true,
          },
          longitude:{
              required: true,
          },
      },
      messages: {
          lokasi: {
                required: "Lokasi harus di isi",
          },
          ringkas_kejadian: {
                  required: "Ringkasan Kejadian harus di isi",
          },
          detail_kejadian: {
                  required: "Detail Kejadian harus di isi",
          },
          waktu: {
                  required: "Waktu harus di isi",
          },
          latitude: {
                  required: "Latitude harus di isi",
          },
          longitude: {
                  required: "Longtitude harus di isi",
          },
      },
      submitHandler: function(form) {
        $("#tambahButton").prop('disabled', true);
            form.submit();
      }
  });
});

  $("#editKemacetanForm").validate({
      rules: {
          edit_lokasi:{
              required: true,
          },
          edit_ringkas_kejadian:{
              required: true,
          },
          edit_detail_kejadian:{
              required: true,
          },
          edit_waktu:{
              required: true,
          },
          edit_latitude:{
              required: true,
          },
          edit_longitude:{
              required: true,
          },
      },
      messages: {
          edit_lokasi: {
                required: "Lokasi harus di isi",
          },
          edit_ringkas_kejadian: {
                  required: "Ringkasan Kejadian harus di isi",
          },
          edit_detail_kejadian: {
                  required: "Detail Kejadian harus di isi",
          },
          edit_waktu: {
                  required: "Waktu harus di isi",
          },
          edit_latitude: {
                  required: "Latitude harus di isi",
          },
          edit_longitude: {
                  required: "Longtitude harus di isi",
          },
      },
      submitHandler: function(form) {
        $("#editPosButton").prop('disabled', true);
            form.submit();
      }
  });

$("#deleteAllModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#destroyAllForm").submit();
});

const deleteKemacetan = $("#deleteKemacetanForm").attr('action');

  function deleteThisPos(data) {
    $("#deleteKemacetanForm").attr('action', `${deleteKemacetan}/${data.id}`);
  }

  $("#deleteAllButton").attr('disabled', true); 


</script>
@endsection