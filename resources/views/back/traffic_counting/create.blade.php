@extends('layouts.main', ['web' => $web])
@section('title', 'Traffic Counting')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.css" rel="stylesheet" />

    <style>
        .dz-image img {
      width: 120px;
      height: 120px;
   }

   .dropzone {
        border: 1px solid #e6e6e6 ;
        border-radius: 4px ;
        color: #c8c8c9 ;
   }
        .dropify-wrapper {
            border: 1px solid #e2e7f1;
            border-radius: .3rem;
            height: 150px;
        }

        #map {
            height: 300px
        }

        .card {
            border-radius: 10px;
        }

        #map-edit {
            height: 300px
        }

        .card {
            border-radius: 10px;
        }

        #map-detail {
            height: 300px
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
            <h1>Traffic Counting</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Dashboard</div>
                <div class="breadcrumb-item">Traffic Counting</div>
                <div class="breadcrumb-item active"><a href="{{ url()->current() }}">Tambah Traffic Counting</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('traffic-counting.store') }}" method="post" id="tambahTrafficForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label>Upload Gambar</label>
                                    <div class="needsclick dropzone" id="document-dropzone">
                                    </div>
                                    <span class="errorImage" style="display: none;">Gambar Produk harus di isi</span>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('traffic-counting.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary" id="tambahTrafficCountingButton">Simpan
                                Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/min/dropzone.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.3.0/dist/sweetalert2.all.min.js"></script>

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

        });
    </script>
   <script>
    var uploadedDocumentMap = {}
       Dropzone.options.documentDropzone = {
          url: '{{ route('traffic-counting.store') }}',
          maxFilesize: 20, // MB
          addRemoveLinks: true,
          autoProcessQueue: false,
          parallelUploads:10,
          uploadMultiple:true,
          acceptedFiles: ".jpeg,.jpg,.png,.gif",
          headers: {
             'X-CSRF-TOKEN': "{{ csrf_token() }}"
          },
          success: function(file, response) {
             Swal.fire({
             title: 'Berhasil',
             text: "Grafik telah berhasil di tambahkan!",
             icon: 'success',
             confirmButtonColor: '#7066e0',
             confirmButtonText: 'Ok'
             }).then((result) => {
                 if (result.isConfirmed) {
                     window.location = "{{ route('traffic-counting.index') }}";
                 } else {
                     window.location = "{{ route('traffic-counting.index') }}";
                 }
             })
          },
          init: function() {
             var myDropzone = this;
            

             $("#tambahTrafficCountingButton").click(function () {
                if (myDropzone.getQueuedFiles().length > 0) {   
                    $('#tambahTrafficForm').on('submit', function(e){
                        return true;
                    });   

                    $(".dropzone").css("cssText", "border: 1px solid #e6e6e6 !important; color: #c8c8c9 !important;");
                    $(".errorImage").css("cssText", "display: none !important;");
                } else { 
                    $('#tambahTrafficForm').on('submit', function(e){
                        event.preventDefault();
                        return false;
                    });     

                    $(".dropzone").css("cssText", "border: 1px solid #f1556c !important; color: #f1556c !important;");
                    $(".errorImage").css("cssText", "display: block !important; color: #f1556c; font-size: .875rem; font-weight: 400; line-height: 1.5; margin-top: 5px; padding: 0;");
                }
             });
            
             this.on("addedfiles", function(files) {
                $("#tambahTrafficCountingButton").click(function (e) {
                    if(!$("#tambahTrafficForm").valid()) {

                    } else {
                        e.preventDefault();
                        myDropzone.processQueue();
                    }
                });

                if (myDropzone.getQueuedFiles().length > 0) {                        
                    $(".dropzone").css("cssText", "border: 1px solid #e6e6e6 !important; color: #c8c8c9 !important;");
                    $(".errorImage").css("cssText", "display: none !important;");
                } else {                       
                    $(".dropzone").css("cssText", "border: 1px solid #f1556c !important; color: #f1556c !important;");
                    $(".errorImage").css("cssText", "display: block !important; color: #f1556c; font-size: .875rem; font-weight: 400; line-height: 1.5; margin-top: 5px; padding: 0;");
                }

            });
 
             this.on('sendingmultiple', function(file, xhr, formData) {
                 // Append all form inputs to the formData Dropzone will POST
                 var data = $('#tambahTrafficForm').serializeArray();
                 $.each(data, function(key, el) {
                     formData.append(el.name, el.value);
                 });
             });
          },
          removedfile: function(file) {
             file.previewElement.remove()
             var name = ''
             if (typeof file.file_name !== 'undefined') {
                name = file.file_name
             } else {
                name = uploadedDocumentMap[file.name]
             }
             $('form').find('input[name="photo[]"][value="' + name + '"]').remove()
          }
       }
  </script>

@endsection
