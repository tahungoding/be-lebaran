@extends('layouts.main', ['web' => $web])
@section('title', 'Pos Gatur')
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
    <h1>Pos Gatur</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
      <div class="breadcrumb-item">Pos Gatur</div>
    </div>
  </div>

  <div class="section-body">
    <div class="row">
      <div class="col-12 col-md-12 col-lg-12">
        <div class="card">
          <div class="card-header">
            <div class="d-flex justify-content-between w-100">
              <a href="{{ route('pos-gatur.create') }}" class="btn btn-sm btn-primary"><i
                  class="fas fa-plus-circle"></i></a>
            </div>
          </div>
        </div>
       
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <table id="pos_gatur_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pos Gatur</th>
                    <th>Pos</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            @php
                $increment = 1;
            @endphp
            <tbody>
                @foreach($pos_gatur as $posdata)
                <tr>
                    <td>{{ $increment++ }}</td>
                    <td>{{ $posdata->nama }}</td>
                    <td>{{ $posdata->pos->nama }}</td>
                    <td>
                      <a href="{{ route('pos-gatur.edit', $posdata->id) }}"
                        class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                        <button type="button" data-toggle="modal" data-target="#deleteConfirm"
                            class="btn btn-sm btn-danger" onclick="deleteThisPosGatur({{ $posdata }})"><i
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


<div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirm">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hapus</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ route('pos-gatur.destroy', '') }}" method="post" id="deletePosGaturForm">
        @csrf
        @method('delete')
        <div class="modal-body">
          Apakah anda yakin untuk <b>menghapus</b> data pos gatur ini ?
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
        Apakah anda yakin untuk <b>menghapus semua</b> pos gatur ?
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
    $('#pos_gatur_table').DataTable();
});
</script>
<script>
  $('.dropify').dropify();
</script>
<script>
  
</script>
<script>
        const updateLink = $('#editPosGaturForm').attr('action');
        const idForm = $('#editPosGaturForm').attr('id');

        const checkPosGaturNameId = $('#checkPosGaturName').attr('id');

        function setEditData(data) {
            var posData = {!! json_encode($pos) !!};
            console.log(posData);
            $("#editPos").html('');
            for (let [key, value] of Object.entries(posData)) {
              $("#editPos").append(`<option value="${value.id}" ${value.id} == ${data.pos_id} ? 'checked' : ''>${value.nama}</option>`);
            }
            // make form id unique for jquery validaiton
            $('#editPosGaturForm').attr('id', `${idForm}${data.id}`);
            $('#editPosGaturForm' + data.id).attr('action', `${updateLink}/${data.id}`);

            // make checkPosgaturNmae unique
            $('#checkPosGaturName').attr('id', `${checkPosGaturNameId}${data.id}`);
            $('#checkPosGaturName' + data.id).val(data.nama);

            $('[name="edit_nama"]').val(data.nama);
            $('[name="edit_pos_id"]').val(data.pos_id);
            $('[name="edit_latitude"]').val(data.latitude);
            $('[name="edit_longitude"]').val(data.longitude);
            editPosGaturValidate(data);
        }
</script>
<script>
  $(document).ready(function() {

  $.ajaxSetup({
      headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  $("#tambahPosGaturForm").validate({
      rules: {
          nama:{
              required: true,
              remote: {
                        url: "{{ route('checkPosGaturName') }}",
                        type: "post",
              }
          },
          latitude:{
              required: true,
              number: true,
          },
          longitude:{
              required: true,
              number: true,
          },
      },
      messages: {
          nama: {
                required: "Nama harus di isi",
                remote: "Nama sudah tersedia"
          },
          latitude: {
                  required: "Latitude harus di isi",
                  number: "latitude harus berupa nomor",
          },
          longitude: {
                  required: "Longitude harus di isi",
                  number: "Longitude harus berupa nomor",
          },
      },
      submitHandler: function(form) {
        $("#tambahButton").prop('disabled', true);
            form.submit();
      }
  });
});

function editPosGaturValidate(data) {
  $("#editPosGaturForm" + data.id).validate({
      rules: {
        edit_nama:{
              required: true,
              remote: {
                        param: {
                              url: "{{ route('checkPosGaturName') }}",
                              type: "post",
                        },
                        depends: function(element) {
                          // compare name in form to hidden field
                          return ($(element).val() !== $('#checkPosGaturName' + data.id).val());
                        },
                      }
          },
          edit_latitude:{
              required: true,
              number: true,
          },
          edit_longitude:{
              required: true,
              number: true,
          },
      },
      messages: {
        edit_nama: {
                required: "Nama harus di isi",
                remote: "Nama sudah tersedia"
          },
          edit_latitude: {
                  required: "Latitude harus di isi",
                  number: "Latitude harus berupa nomor",
          },
          edit_longitude: {
                  required: "Longitude harus di isi",
                  number: "Longitude harus berupa nomor",
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

const deletePos = $("#deletePosGaturForm").attr('action');

  function deleteThisPosGatur(data) {
    $("#deletePosGaturForm").attr('action', `${deletePos}/${data.id}`);
  }

 
  
  $("#deleteAllButton").attr('disabled', true); 
</script>
<script>
  var x = document.getElementById("demo");
  
  function getLocation() {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
      x.innerHTML = "Geolocation is not supported by this browser.";
    }
  }
  
  function showPosition(position) {
    $('#latitude').val(position.coords.latitude)
    $('#longitude').val(position.coords.longitude)
  }

  // Edit

    var xedit = document.getElementById("editDemo");

    function getEditLocation() {

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showEditPosition);
      } else { 
        xedit.innerHTML = "Geolocation is not supported by this browser.";
      }
    }
    
    function showEditPosition(position) {
      $('#editLatitude').val(position.coords.latitude)
      $('#editLongitude').val(position.coords.longitude)
    }

  </script>
@endsection