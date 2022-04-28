@extends('layouts.main', ['web' => $web])
@section('title', 'Kecelakaan')
@section('css')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.min.css"
        integrity="sha512-EZSUkJWTjzDlspOoPSpUFR0o0Xy7jdzW//6qhUkoZ9c4StFkVsp9fbbd0O06p9ELS3H486m4wmrCELjza4JEog=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap4.min.css">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css"
        integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
        crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"
        integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
        crossorigin=""></script>


    <!-- Load Esri Leaflet from CDN -->
    <script src="https://unpkg.com/esri-leaflet@2.1.4/dist/esri-leaflet.js"
        integrity="sha512-m+BZ3OSlzGdYLqUBZt3u6eA0sH+Txdmq7cqA1u8/B2aTXviGMMLOfrKyiIW7181jbzZAY0u+3jWoiL61iLcTKQ=="
        crossorigin=""></script>


    <!-- Load Esri Leaflet Geocoder from CDN -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.2.9/dist/esri-leaflet-geocoder.css"
        integrity="sha512-v5YmWLm8KqAAmg5808pETiccEohtt8rPVMGQ1jA6jqkWVydV5Cuz3nJ9fQ7ittSxvuqsvI9RSGfVoKPaAJZ/AQ=="
        crossorigin="">
    <script src="https://unpkg.com/esri-leaflet-geocoder@2.2.9/dist/esri-leaflet-geocoder.js"
        integrity="sha512-QXchymy6PyEfYFQeOUuoz5pH5q9ng0eewZN8Sv0wvxq3ZhujTGF4eS/ySpnl6YfTQRWmA2Nn3Bezi9xuF8yNiw=="
        crossorigin=""></script>

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
                                <a class="btn btn-sm btn-primary" href="{{ route('kecelakaan.create') }}"><i
                                        class="fas fa-plus-circle"></i></button></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="kecelakaan_table" class="table table-striped table-bordered dt-responsive nowrap"
                        style="width:100%">
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
                            @foreach ($kecelakaan as $data)
                                <tr>
                                    <td>{{ $increment++ }}</td>
                                    <td>{{ $data->lokasi }}</td>
                                    <td><a href="{{ route('kecelakaan.show', $data->id) }}"><i class="fas fa-eye"></i></a></td>
                                    <td>
                                        <a href="{{ route('kecelakaan.edit', $data->id) }}"
                                            class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></a>
                                        <button type="button" data-toggle="modal" data-target="#deleteConfirm"
                                            class="btn btn-sm btn-danger"
                                            onclick="deleteThisKecelakaan({{ $data }})"><i
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

    <div class="modal fade" tabindex="-1" role="dialog" id="detailKecelakaan">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
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
                        <input type="text" class="form-control" id="detail_lokasi" placeholder="Lokasi" readonly>
                    </div>
                    <div class="form-group">
                        <label for="ringkas_kejadian">Ringkasan Kejadian</label>
                        <textarea class="form-control" readonly style="height: 20vh;" id="detail_ringkas_kejadian"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="detail_kejadian">Detail Kejadian</label>
                        <textarea class="form-control my-editor-detail" id="my-editor-detail" readonly style="height: 30vh;"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="waktu">Waktu</label>
                        <input type="time" class="form-control" id="detail_waktu" readonly>
                    </div>
                    <div id="map"></div>
                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="detail_latitude" readonly>
                    </div>
                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="detail_longitude" readonly>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </div>
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
        function setDetailData(data) {

            $('[id="detail_lokasi"]').val(data.lokasi);
            $('[id="detail_ringkas_kejadian"]').val(data.ringkas_kejadian);
            CKEDITOR.instances["my-editor-detail"].setData(data.detail_kejadian);
            $('[id="detail_waktu"]').val(data.waktu);
            $('[id="detail_latitude"]').val(data.latitude);
            $('[id="detail_longitude"]').val(data.longitude);
        }
    </script>
    <script>
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
        CKEDITOR.replace('my-editor-detail', options);
    </script>

    <script type="text/javascript">
        // Initialize the map and assign it to a variable for later use
        function mapDetail(data) {
            var map = L.map('map', {
                // Set latitude and longitude of the map center (required)
                center: [data.latitude, data.longitude],
                // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
                zoom: 15
            });
            L.control.scale().addTo(map);

            var marker;
            var marker = L.marker([data.latitude, data.longitude]).addTo(map);

            // Create a Tile Layer and add it to the map
            //var tiles = new L.tileLayer('http://{s}.tile.stamen.com/watercolor/{z}/{x}/{y}.png').addTo(map);
            L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            // search for places via agol and our trailheads by name
            var arcgisOnline = L.esri.Geocoding.arcgisOnlineProvider();
            var searchControl = L.esri.Geocoding.geosearch({
                providers: [
                    arcgisOnline,
                    L.esri.Geocoding.featureLayerProvider({
                        url: 'https://services.arcgis.com/T4FFVOBhIY0maRRS/arcgis/rest/services/wenatchee_rec_sites/FeatureServer/4',
                        searchFields: ['REC_NAME'],
                        label: 'Trailheads',
                        bufferRadius: 5000,
                        formatSuggestion: function(feature) {
                            return feature.properties.REC_NAME;
                        }
                    })
                ],
                useMapBounds: false,
            }).addTo(map);

            var results = new L.LayerGroup().addTo(map);

            searchControl.on('results', function(data) {
                results.clearLayers();
                for (var i = data.results.length - 1; i >= 0; i--) {
                    results.addLayer(L.marker(data.results[i].latlng));
                }
            });

            var modal = $("#detailKecelakaan");
            modal.on('shown.bs.modal', function() {
                setTimeout(function() {
                    map.invalidateSize();
                }, 1);

            })
        }

        setTimeout(function() {
            $('.pointer').fadeOut('slow');
        }, 3400);
    </script>

    {{-- FIX Leaflet modal problem --}}

    <script>
        var x = document.getElementById("editDemo");

        function getEditLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showEditPosition);
            } else {
                x.innerHTML = "Geolocation is not supported by this browser.";
            }
        }

        function showEditPosition(position) {
            $('#edit_latitude').val(position.coords.latitude)
            $('#edit_longitude').val(position.coords.longitude)
        }
    </script>
@endsection
