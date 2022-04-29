@extends('layouts.main', ['web' => $web])
@section('title', 'Manajemen User')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.10.3/simple-lightbox.min.css" integrity="sha512-Ne9/ZPNVK3w3pBBX6xE86bNG295dJl4CHttrCp3WmxO+8NQ2Vn8FltNr6UsysA1vm7NE6hfCszbXe3D6FUNFsA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

        .gallery a {
            cursor: pointer;
        }
        .gallery a img {
            border-radius: 150%;
            width: 30px;
            height: 30px;
        }

        .gallery {
            display: inline-block;
            padding: 5px;
        }

    </style>
@endsection
@section('container')
    <section class="section">
        <div class="section-header">
            <h1>Manajemen User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Manajemen User</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahUser"><i
                                        class="fas fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    
                    <table id="user_table" class="table table-striped table-bordered dt-responsive nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Lengkap</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Photo</th>
                                <th>Role</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @php
                            $increment = 1;
                        @endphp
                        <tbody>
                            @foreach ($user as $data)
                                <tr>
                                    <td>{{ $increment++ }} </td>
                                    <td>{{ $data->fullname }}
                                        @if (Cache::has('user-is-online-' . $data->id))
                                            <span style="color: #28B62C;" class="ml-2">online</span>
                                            <span class="indicator online"></span>
                                        @endif
                                    </td>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>
                                        <div class="gallery" style="overflow: hidden;">
                                            @if($data->photo && !empty($data->photo))
                                            <a href="{{ $data->photo }}"><img src="{{ $data->photo }}" style="width: 60px; height: 60px; object-fit: cover;"/></a>
                                            @else
                                            <a href="{{ asset('assets/img/avatar/avatar-1.png') }}" style="width: 60px; height: 60px; object-fit: cover;"><img src="{{ asset('assets/img/avatar/avatar-1.png') }}" style="width: 60px; height: 60px; object-fit: cover;"/></a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $color = 'secondary';
                                            if ($data->role == 'super_admin') {
                                                $color = 'warning';
                                            } elseif ($data->role == 'pos') {
                                                $color = 'primary';
                                            } elseif ($data->role == 'admin') {
                                                $color = 'success';
                                            }
                                        @endphp
                                        <span
                                            class="badge badge-{{ $color }} font-15">{{ ucwords(str_replace('_', ' ', $data->role)) }}</span>
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editUser"
                                            onclick="setEditData({{ $data }})"><i
                                                class="fa fa-edit"></i></button>
                                        <button type="button" data-toggle="modal" data-target="#deleteConfirm"
                                            class="btn btn-sm btn-danger" onclick="deleteThisUser({{ $data }})"><i
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

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" id="tambahUser">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('manajemen-user.store') }}" method="post" id="tambahUserForm"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-12">
                                <label for="election">Nama Lengkap</label>
                                <input class="form-control mb-1 @error('fullname') is-invalid @enderror" type="text"
                                    id="fullname" placeholder="Contoh: Iqbal Rivaldi" name="fullname"
                                    value="{{ old('fullname') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="period">Username</label>
                                <input class="form-control mb-1 @error('username') is-invalid @enderror" type="text"
                                    id="username" placeholder="Contoh: iqbal1402" name="username"
                                    value="{{ old('username') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="period">Email</label>
                                <input class="form-control mb-1 @error('email') is-invalid @enderror" minlength="3"
                                    type="email" id="email" placeholder="Contoh: briana67@gmail.com" name="email"
                                    value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="period">Password</label>
                                <div class="input-group mb-1">
                                    <input class="form-control @error('password') is-invalid @enderror" type="password"
                                        name="password" id="passwordId" placeholder="Masukan Password Anda">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary fa fa-eye toggle-password tombol"
                                            type="button"></button>
                                    </div>
                                </div>
                                <label for="passwordId" id="passwordV" generated="true" class="error"></label>
                                <script>
                                    if (document.getElementById('passwordV').innerHTML == "") {
                                        document.getElementById('passwordV').style.display = "none";
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="period">Password Confirmation</label>
                                <div class="input-group mb-1">
                                    <input class="form-control" type="password" name="password_confirmation"
                                        id="passwordConfirm" placeholder="Masukan Konfirmasi Password Anda"
                                        value="{{ old('email') }}">
                                    <div class="input-group-append">
                                        <button class="btn btn-secondary fa fa-eye toggle-password-confirm"
                                            type="button"></button>
                                    </div>
                                </div>
                                <label for="passwordConfirm" id="password_confirm" generated="true"
                                    class="error"></label>
                                <script>
                                    if (document.getElementById('password_confirm').innerHTML == "") {
                                        document.getElementById('password_confirm').style.display = "none";
                                    }
                                </script>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="period">Role</label>
                                <select class="form-control mb-1" onchange="showPos(this.value)" name="role" id="role">
                                    <option value="admin">Admin</option>
                                    <option value="pos">Pos</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="pos_section" style="display: none">
                            <div class="col-12">
                                <label for="period">Pilih Pos</label>
                                <select class="form-control mb-1" name="pos_id" id="pos_id">
                                    @foreach ($pos as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }} ({{ $item->alamat }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
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

    <div class="modal fade" tabindex="-1" role="dialog" id="editUser">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content modal-lg">
                <div class="modal-header">
                    <h5 class="modal-title">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('manajemen-user.update', '') }}" method="post" id="editUserForm"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="checkUsername">
                    <input type="hidden" id="checkEmail">
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="col-12">
                                <label for="name">Nama Lengkap</label>
                                <input class="form-control mb-1 @error('edit_fullname') is-invalid @enderror" type="text"
                                    id="Edit" placeholder="Contoh: Briana White" name="edit_fullname" required>

                                @error('edit_fullname')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="username">Username</label>
                                <input class="form-control mb-1 @error('edit_username') is-invalid @enderror" type="text"
                                    id="edit_username" placeholder="Contoh: briana67" name="edit_username" required>
                                @error('edit_username')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="email">Email</label>
                                <input class="form-control mb-1 @error('edit_email') is-invalid @enderror" minlength="3"
                                    maxlength="35" type="email" id="edit_email" placeholder="Contoh: briana67@gmail.com"
                                    name="edit_email" required>
                                @error('edit_email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-12">
                                <label for="role">Role</label>
                                <select class="form-control mb-1 @error('edit_role') is-invalid @enderror"
                                    onchange="showEditPos(this.value)" name="edit_role" id="edit_role" required>
                                    {{-- <option value="admin" {{ $data->role == 'admin' ? 'checked' : '' }}>Admin</option>
                                    <option value="pos" {{ $data->role == 'pos' ? 'checked' : '' }}>Pos</option> --}}
                                </select>

                                @error('role')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group" id="edit_pos_section" style="display: none">
                            <div class="col-12">
                                <label for="period">Pilih Pos</label>
                                <select class="form-control mb-1" name="edit_pos_id" id="edit_pos_id">
                                    {{-- @foreach ($pos as $item)
                                        <option value="{{$item->id}}">{{$item->nama}} ({{$item->alamat}})</option>
                                    @endforeach --}}
                                </select>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary" id="editUserButton">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="deleteConfirm">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('manajemen-user.destroy', '') }}" method="post" id="deleteUserForm">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        Apakah anda yakin untuk <b>menghapus</b> data user ini ?
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.10.3/simple-lightbox.min.js" integrity="sha512-XGiM73niqHXRwBELBEktUKuGXC9yHyaxEsVWvUiCph8yxkaNkGeXJnqs5Ls1RSp4Q+PITMcCy2Dw7HxkzBWQCw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    <script>
        $(document).ready(function() {
            $('#user_table').DataTable();
        });
    </script>
    <script>
        var lightbox = new SimpleLightbox('.gallery a', { /* options */ });
    </script>
    <script>
        $('.dropify').dropify();
    </script>
    <script>
        const updateLink = $('#editUserForm').attr('action');
        const idForm = $('#editUserForm').attr('id');

        const checkUsernameId = $('#checkUsername').attr('id');
        const checkEmailId = $('#checkEmail').attr('id');

        function setEditData(data) {
            $('#edit_pos_section').hide();
            $("#edit_role").html('');
            $("#edit_role").append(`<option value="admin" ${data.role} == 'admin' ? 'checked' : ''>Admin</option>`);
            $("#edit_role").append(`<option value="pos" ${data.role} == 'pos' ? 'checked' : ''>Pos</option>`);



            var posData = {!! json_encode($pos) !!};
            $("#edit_pos_id").html('');
            for (let [key, value] of Object.entries(posData)) {
                $("#edit_pos_id").append(
                    `<option value="${value.id}" ${value.id} == ${data.pos_id} ? 'checked' : ''>${value.nama}</option>`);
            }

            // make form id unique for jquery validaiton
            $('#editUserForm').attr('id', `${idForm}${data.id}`);
            $('#editUserForm' + data.id).attr('action', `${updateLink}/${data.id}`);

            // make check unique
            $('#checkUsername').attr('id', `${checkUsernameId}${data.id}`);
            $('#checkUsername' + data.id).val(data.username);

            $('#checkEmail').attr('id', `${checkEmailId}${data.id}`);
            $('#checkEmail' + data.id).val(data.email);

            $('[name="edit_fullname"]').val(data.fullname);
            $('[name="edit_username"]').val(data.username);
            $('[name="edit_email"]').val(data.email);
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

            $("#tambahUserForm").validate({
                rules: {
                    fullname: {
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                    },
                    username: {
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                        remote: {
                            url: "{{ route('user.checkUsername') }}",
                            type: "post",
                        }
                    },
                    email: {
                        required: true,
                        minlength: 3,
                        maxlength: 100,
                        remote: {
                            url: "{{ route('user.checkEmail') }}",
                            type: "post",
                        }
                    },
                    password: {
                        required: true,
                        minlength: 2
                    },
                    password_confirmation: {
                        required: true,
                        equalTo: "#passwordId"
                    },
                    role: {
                        required: true,
                    },
                },
                messages: {
                    fullname: {
                        required: "Nama harus di isi",
                        minlength: "Nama tidak boleh kurang dari 3 karakter",
                        maxlength: "Nama tidak boleh lebih dari 30 karakter"
                    },
                    username: {
                        required: "Username harus di isi",
                        minlength: "Username tidak boleh kurang dari 3 karakter",
                        maxlength: "Username tidak boleh lebih dari 30 karakter",
                        remote: "Username sudah tersedia"

                    },
                    email: {
                        required: "Email harus di isi",
                        email: "Email yang di isikan harus valid",
                        minlength: "Email tidak boleh kurang dari 3 karakter",
                        maxlength: "Email tidak boleh lebih dari 100 karakter",
                        remote: "Email sudah tersedia"
                    },
                    password: {
                        required: "Password harus di isi",
                        minlength: "Password tidak boleh kurang dari 2 karakter"
                    },
                    password_confirmation: {
                        required: "Konfirmasi Password harus di isi",
                        equalTo: "Konfirmasi Password tidak sama"
                    },
                    role: {
                        required: "Role harus di isi"
                    },
                },
                submitHandler: function(form) {
                    $("#tambahButton").prop('disabled', true);
                    form.submit();
                }
            });
        });

        function validateFormEdit(data) {
            $("#editUserForm" + data.id).validate({
                rules: {
                    edit_fullname: {
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                    },
                    edit_username: {
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                        remote: {
                            param: {
                                url: "{{ route('user.checkUsername') }}",
                                type: "post",
                            },
                            depends: function(element) {
                                // compare name in form to hidden field
                                return ($(element).val() !== $('#checkUsername').val());
                            },

                        }
                    },
                    edit_email: {
                        required: true,
                        minlength: 3,
                        maxlength: 30,
                        remote: {
                            param: {
                                url: "{{ route('user.checkEmail') }}",
                                type: "post",
                            },
                            depends: function(element) {
                                // compare name in form to hidden field
                                return ($(element).val() !== $('#checkEmail').val());
                            },

                        }
                    },
                    edit_role: {
                        required: true,
                    },
                },
                messages: {
                    edit_fullname: {
                        required: "Nama harus di isi",
                        minlength: "Nama tidak boleh kurang dari 3 karakter",
                        maxlength: "Nama tidak boleh lebih dari 30 karakter"
                    },
                    edit_username: {
                        required: "Username harus di isi",
                        minlength: "Username tidak boleh kurang dari 3 karakter",
                        maxlength: "Username tidak boleh lebih dari 30 karakter",
                        remote: "Username sudah tersedia"
                    },
                    edit_email: {
                        required: "Email harus di isi",
                        email: "Email yang di isikan harus valid",
                        minlength: "Email tidak boleh kurang dari 3 karakter",
                        maxlength: "Email tidak boleh lebih dari 30 karakter",
                        remote: "Email sudah tersedia"
                    },
                    edit_role: {
                        required: "Role harus di isi"
                    },
                },
                submitHandler: function(form) {
                    $("#editUserButton").prop('disabled', true);
                    form.submit();
                }
            });
        }

        // password show/hide toggle
        $(".toggle-password").click(function() {
            $(this).toggleClass("far fa-eye-slash");
            var password = document.getElementById("passwordId");
            if (password.type === "password") {
                password.type = "text";
            } else {
                password.type = "password";
            }

        });

        // password confirm show/hide toggle
        $(".toggle-password-confirm").click(function() {
            $(this).toggleClass("far fa-eye-slash");
            var passwordConfirm = document.getElementById("passwordConfirm");

            if (passwordConfirm.type === "password") {
                passwordConfirm.type = "text";

            } else {
                passwordConfirm.type = "password";
            }

        });

        // edit password show/hide toggle
        $(".toggle-edit-password").click(function() {
            $(this).toggleClass("far fa-eye-slash");
            var editPassword = document.getElementById("editPassword");

            if (editPassword.type === "password") {
                editPassword.type = "text";

            } else {
                editPassword.type = "password";
            }

        });

        // edit password confirm show/hide toggle
        $(".toggle-edit-password-confirm").click(function() {
            $(this).toggleClass("far fa-eye-slash");
            var editPasswordConfirm = document.getElementById("editPasswordConfirm");

            if (editPasswordConfirm.type === "password") {
                editPasswordConfirm.type = "text";

            } else {
                editPasswordConfirm.type = "password";
            }

        });

        $("#deleteAllModalButton").click(function() {
            $(this).attr('disabled', true);
            $("#destroyAllForm").submit();
        });

        const deleteUser = $("#deleteUserForm").attr('action');

        function deleteThisUser(data) {
            $("#deleteUserForm").attr('action', `${deleteUser}/${data.id}`);
        }

        $("#deleteAllButton").attr('disabled', true);
    </script>
    <script>
        function showPos(val) {
            $('#pos_section').hide();
            if (val == 'pos') {
                $('#pos_section').show();
            }
        }
    </script>

    <script>
        function showEditPos(val) {
            $('#edit_pos_section').hide();
            if (val == 'pos') {
                $('#edit_pos_section').show();
            }
        }
    </script>
@endsection
