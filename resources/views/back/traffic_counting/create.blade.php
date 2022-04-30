@extends('layouts.main', ['web' => $web])
@section('title', 'Traffic Counting')
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
                                <input type="file" class="form-control dropify" name="gambar" id="gambar"
                                    data-allowed-file-extensions="png jpg jpeg" data-show-remove="false">
                                <span class="errorGambar"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="">Pilih Status</option>
                                    <option value="on">ON</option>
                                    <option value="off">OFF</option>
                                </select>
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
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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

            $("#tambahTrafficForm").validate({
                rules: {
                    gambar: {
                        required: true,
                    },
                    status: {
                        required: true,
                    },
                   
                },
                messages: {
                    gambar: {
                        required: "Gambar harus di isi",
                    },

                    status: {
                        required: "Keterangan harus di isi",
                    },
                    
                },
                errorPlacement : function(error, element) {
                    if(element.attr("name") == "gambar") {
                        $(".errorGambar").html(error);
                        $(".dropify-wrapper").css("border", "1px solid #f1556c");
                    }
                    else {
                        error.insertAfter(element); // default error placement.
                    }
                },

                success: function (error) {
                    $(".dropify-wrapper").css("border", "1px solid #e2e7f1");
                },
                submitHandler: function(form) {
                    $("#tambahTrafficCountingButton").prop('disabled', true);
                    form.submit();
                }
            });

        });
    </script>

@endsection
