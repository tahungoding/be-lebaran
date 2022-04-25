@extends('layouts.main', ['web' => $web])
@section('title', 'Kecelakaan')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
  integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
  crossorigin="anonymous" referrerpolicy="no-referrer" />

  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

  <!-- Load Leaflet from CDN -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.8.0/dist/leaflet.css"
  integrity="sha512-hoalWLoI8r4UszCkZ5kL8vayOGVae1oxXe/2A4AO6J9+580uKHDO3JdHb7NzwwzK5xr/Fs0W40kiNHxM9vyTtQ=="
  crossorigin=""/>
  <script src="https://unpkg.com/leaflet@1.8.0/dist/leaflet.js"
  integrity="sha512-BB3hKbKWOc9Ez/TAwyWxNXeoV9c1v6FIeYiBieIWkpLjauysF18NzgR1MBNBXf8/KABdlkX68nAhlwcDFLGPCQ=="
  crossorigin=""></script>

  <!-- Load Esri Leaflet from CDN -->
  <script src="https://unpkg.com/esri-leaflet@2.5.0/dist/esri-leaflet.js"
    integrity="sha512-ucw7Grpc+iEQZa711gcjgMBnmd9qju1CICsRaryvX7HJklK0pGl/prxKvtHwpgm5ZHdvAil7YPxI1oWPOWK3UQ=="
    crossorigin=""></script>

  <!-- Load Esri Leaflet Geocoder from CDN -->
  <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
    integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
    crossorigin="">
  <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js"
    integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA=="
    crossorigin=""></script>
    
<style>
  .dropify-wrapper {
    border: 1px solid #e2e7f1;
    border-radius: .3rem;
    height: 150px;
  }

  #map { height: 300px }
  .card {
    border-radius: 10px;
  }

  #map-edit { height: 300px }
  .card {
    border-radius: 10px;
  }

  #map-detail { height: 300px }
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
    <h1>Kecelakaan</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Kecelakaan</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between w-100">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahKecelakaan"><i
                  class="fas fa-plus-circle"></i></button>
            </div>
          </div>
        </div>
       
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <table id="kecelakaan_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
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
                @foreach($kecelakaan as $data)
                <tr>
                    <td>{{ $increment++ }}</td>
                    <td>{{ $data->lokasi }}</td>
                    <td><a href="javascript:void(0)" data-target="#detailKecelakaan{{ $data->id }}" data-toggle="modal"><i class="fas fa-eye"></i></a></td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="modal"
                            data-target="#editKecelakaan{{$data->id}}" onclick="validateFormEdit({{ $data }})"
                            ><i class="fa fa-edit"></i></button>
                        <button type="button" data-toggle="modal" data-target="#deleteConfirm"
                            class="btn btn-sm btn-danger" onclick="deleteThisKecelakaan({{ $data }})"><i
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

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="tambahKecelakaan">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tambah Kecelakaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('kecelakaan.store') }}" method="post" id="tambahKecelakaanForm" enctype="multipart/form-data">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="lokasi">Lokasi</label>
            <input type="text" class="form-control" name="lokasi" placeholder="Lokasi">
          </div>
          <div class="form-group">
            <label for="ringkas_kejadian">Ringkasan Kejadian</label>
            <textarea name="ringkas_kejadian" class="form-control" style="height: 20vh;"></textarea>
          </div>
          <div class="form-group">
            <label for="detail_kejadian">Detail Kejadian</label>
            <textarea name="detail_kejadian" class="form-control my-editor" id="my-editor" style="height: 30vh;"></textarea>
          </div>
          
          <div class="form-group">
            <label for="waktu">Waktu</label>
            <input type="time" name="waktu" class="form-control">
          </div>
          <div id="map"></div>
          <div class="form-group">
            <label for="latitude">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control">
          </div>
          <div class="form-group">
            <label for="longitude">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control">
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

@foreach ($kecelakaan as $data)
<div class="modal fade" tabindex="-1" role="dialog" id="editKecelakaan{{$data->id}}">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content modal-lg">
      <div class="modal-header">
        <h5 class="modal-title">Edit Kecelakaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('kecelakaan.update', $data->id) }}" method="post" id="editKecelakaanForm{{$data->id}}"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" id="checkKecelakaanName" value="{{ $data->nama }}">
        <div class="modal-body">
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" name="edit_lokasi" value="{{ $data->lokasi }}" placeholder="Lokasi">
              </div>
              <div class="form-group">
                <label for="ringkas_kejadian">Ringkasan Kejadian</label>
                <textarea name="edit_ringkas_kejadian" class="form-control" style="height: 20vh;">{{ $data->ringkas_kejadian }}</textarea>
              </div>
              <div class="form-group">
                <label for="detail_kejadian">Detail Kejadian</label>
                <textarea name="edit_detail_kejadian" id="my-editor-edit" class="form-control my-editor-edit" style="height: 30vh;">{{ $data->detail_kejadian }}</textarea>
              </div>
              {{-- <div class="form-group">
                <label for="file_pendukung">File Pendukung</label>
                <input type="file" class="form-control dropify" name="file_pendukung"
                    data-allowed-file-extensions="png jpg jpeg svg" data-show-remove="false" data-default-file="@if(!empty($kemacetanData->file_pendukung) &&
                    Storage::exists($kemacetanData->file_pendukung)){{ Storage::url($kemacetanData->file_pendukung) }}@endif">
                <button></button>  
            </div> --}}
              <div class="form-group">
                <label for="waktu">Waktu</label>
                <input type="time" name="edit_waktu" class="form-control" value="{{ $data->waktu }}">
              </div>
              <div id="map-edit"></div>
              <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" id="editLatitude" name="edit_latitude" class="form-control" value="{{ $data->latitude }}">
              </div>
              <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" id="editLongitude" name="edit_longitude" class="form-control" value="{{ $data->longitude }}">
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

@foreach ($kecelakaan as $data)
<div class="modal fade" tabindex="-1" role="dialog" id="detailKecelakaan{{$data->id}}">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Detail Kecelakaan</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="lokasi">Lokasi</label>
                <input type="text" class="form-control" value="{{ $data->lokasi }}" placeholder="Lokasi" readonly>
              </div>
              <div class="form-group">
                <label for="ringkas_kejadian">Ringkasan Kejadian</label>
                <textarea class="form-control" readonly style="height: 20vh;">{{ $data->ringkas_kejadian }}</textarea>
              </div>
              <div class="form-group">
                <label for="detail_kejadian">Detail Kejadian</label>
                <textarea class="form-control my-editor-detail" id="my-editor-detail" readonly style="height: 30vh;">{{ $data->detail_kejadian }}</textarea>
              </div>
              <div class="form-group">
                <label for="waktu">Waktu</label>
                <input type="time" class="form-control" value="{{ $data->waktu }}" readonly>
              </div>
              <div id="map-detail"></div>
              <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" class="form-control" value="{{ $data->latitude }}" readonly>
              </div>
              <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" id="" class="form-control" value="{{ $data->longitude }}" readonly>
              </div>
              {{-- <div class="form-group">
                <label for="file_pendukung">File Pendukung</label>
                <a href="">{{ $data->file_pendukung }}</a>
              </div> --}}
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
      <form action="{{ route('kecelakaan.destroy', '') }}" method="post" id="deleteKecelakaanForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> data kecelakaan ini ?
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
<script src="https://cdn.datatables.net/1.11.0/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.0/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.1.9/js/dataTables.fixedHeader.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
    $('#kecelakaan_table').DataTable();
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
  
  $("#tambahKecelakaanForm").validate({
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

function validateFormEdit(data) {
  $("#editKecelakaanForm" + data.id).validate({
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
}

$("#deleteAllModalButton").click(function() {
    $(this).attr('disabled', true); 
    $("#destroyAllForm").submit();
});

const deleteKecelakaan = $("#deleteKecelakaanForm").attr('action');

  function deleteThisKecelakaan(data) {
    $("#deleteKecelakaanForm").attr('action', `${deleteKecelakaan}/${data.id}`);
  }

  $("#deleteAllButton").attr('disabled', true); 

  
</script>
<script src="//cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
<script>
  var options = {
    filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
    filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
    filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
    filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
  };
</script>
<script>
    CKEDITOR.replaceAll('my-editor');
    CKEDITOR.replaceAll('my-editor-edit');
    CKEDITOR.replaceAll('my-editor-detail');
</script>

<script>

// var map = L.map('map', {
//   scrollWheelZoom: false
// }).setView([51.505, -0.09], 13);

// L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//     attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
// }).addTo(map);

// L.marker([51.5, -0.09]).addTo(map)
//     .bindPopup('A pretty CSS3 popup.<br> Easily customizable.')
//     .openPopup();

  var map = L.map('map', {
    scrollWheelZoom: false
  }).setView(new L.LatLng(-6.8578387, 107.9210544), 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

  var gcs = L.esri.Geocoding.geocodeService();

  map.on('click', (e)=>{
    gcs.reverse().latlng(e.latlng).run((err, res)=>{
      if(err) return;
      document.getElementById('latitude').value = e.latlng.lat
      document.getElementById('longitude').value = e.latlng.lng
      L.marker(res.latlng).addTo(map).bindPopup(res.address.Match_addr).openPopup();
    });
  });

  var mapEdit = L.map('map-edit', {
    scrollWheelZoom: false
  }).setView(new L.LatLng(-6.8578387, 107.9210544), 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(mapEdit);

  var gcs = L.esri.Geocoding.geocodeService();

  mapEdit.on('click', (e)=>{
    gcs.reverse().latlng(e.latlng).run((err, res)=>{
      if(err) return;
      document.getElementById('editLatitude').value = e.latlng.lat
      document.getElementById('editLongitude').value = e.latlng.lng
      L.marker(res.latlng).addTo(mapEdit).bindPopup(res.address.Match_addr).openPopup();
    });
  });

  var mapDetail = L.map('map-detail', {
    scrollWheelZoom: false
  }).setView(new L.LatLng(-6.8578387, 107.9210544), 15);

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(mapDetail);

  var gcs = L.esri.Geocoding.geocodeService();

  // mapDetail.on('click', (e)=>{
  //   gcs.reverse().latlng(e.latlng).run((err, res)=>{
  //     if(err) return;
  //     document.getElementById('editLatitude').value = e.latlng.lat
  //     document.getElementById('editLongitude').value = e.latlng.lng
  //     L.marker(res.latlng).addTo(mapEdit).bindPopup(res.address.Match_addr).openPopup();
  //   });
  // });

  
  
</script>
@endsection