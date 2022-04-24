@extends('layouts.main', ['web' => $web])
@section('title', 'Profile')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
    integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    .dropify-wrapper {
        border: 1px solid #e2e7f1;
        border-radius: .3rem;
        height: 100% !important;
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

    select.error {
        color: #f1556c;
        border: 1px solid #f1556c;
    }

    #buttonGroup {
        display: block;
    }
</style>
@endsection
@section('container')
<section class="section">
    <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="{{ route('dashboard.index')}}">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Hi, {{ Auth::user()->username }}!</h2>
        <p class="section-lead">
            Ubah informasi tentang diri Anda di halaman ini.
        </p>

        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <form method="post" action="{{ route('profile.update', Auth::user()->id) }}" id="profileEditForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="checkProfileUsername" value="{{ Auth::user()->username }}">
                        <input type="hidden" id="checkProfileEmail" value="{{ Auth::user()->email }}">
                        <div class="card-header">
                            <h4>Edit Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="fullname" value="{{ Auth::user()->fullname }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" value="{{ Auth::user()->username }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Password</label>
                                    <div class="input-group" id="showOrHide">
                                        <input type="password" class="form-control" name="password">
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <div id="errorPassword"></div>
                                </div>

                                <div class="form-group col-md-6 col-12">
                                    <label>Nomor Telepon</label>
                                    <input type="tel" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Tempat Lahir</label>
                                    <input type="text" class="form-control" name="place_of_birth" value="{{ Auth::user()->place_of_birth }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Tanggal Lahir</label>
                                    <input type="date" class="form-control" name="date_of_birth" value="{{ Auth::user()->date_of_birth }}">
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Alamat</label>
                                    <textarea name="address" class="form-control" style="height: 100%;">{{ Auth::user()->address }}</textarea>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Foto</label>
                                    <input type="file" class="form-control dropify" name="photo"
                                        data-allowed-file-extensions="png jpg jpeg svg" data-show-remove="false" data-default-file="@if(!empty(Auth::user()->photo) &&
                                        Storage::exists(Auth::user()->photo)){{ Storage::url(Auth::user()->photo) }}@endif">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-primary" id="editProfileButton">Simpan Perubahan</button>
                            </div>
                    </form>
                </div>
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
    $.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#profileEditForm").validate({
      rules: {
        fullname:{
              required: true,
          },
        username:{
              required: true,
              remote: {
                        param: {
                              url: "{{ route('checkProfileUsername') }}",
                              type: "post",
                        },
                        depends: function(element) {
                          // compare name in form to hidden field
                          return ($(element).val() !== $('#checkProfileUsername').val());
                        },
                      }
        },
        email:{
              required: true,
              email: true,
              remote: {
                        param: {
                              url: "{{ route('checkProfileEmail') }}",
                              type: "post",
                        },
                        depends: function(element) {
                          // compare name in form to hidden field
                          return ($(element).val() !== $('#checkProfileEmail').val());
                        },
                      }
          },
          password:{
              required: true,
          },
      },
      messages: {
        fullname: {
                required: "Nama Lengkap harus di isi.",
            },
            username: {
                  required: "Username harus di isi.",
                  remote: "Username sudah tersedia."
            },
            email: {
                required: "Email harus di isi.",
                email: "Masukkan Email yang valid.",
                remote: "Email sudah tersedia."
            },
            password: {
                  required: "Password harus di isi.",
            },
      },
      errorPlacement: function(error, element) {
        if(element.attr("name") == "password") {
          error.appendTo("#errorPassword");
          // $(".dropify-wrapper").css('border-color', '#f1556c');
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function(form) {
        $("#editProfileButton").prop('disabled', true);
            form.submit();
      }
  });


  $(document).ready(function() {
      $("#showOrHide button").on('click', function(event) {
          event.preventDefault();
          if($("#showOrHide input").attr("type") == "text") {
            $('#showOrHide input').attr('type', 'password');
            $('#showOrHide i').addClass( "fa-eye-slash" );
            $('#showOrHide i').removeClass( "fa-eye" );
          } else if($('#showOrHide input').attr("type") == "password"){
            $('#showOrHide input').attr('type', 'text');
            $('#showOrHide i').removeClass( "fa-eye-slash" );
            $('#showOrHide i').addClass( "fa-eye" );
        }
      });
  });
</script>
@endsection