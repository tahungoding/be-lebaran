@extends('layouts.main', ['web' => $web])
@section('title', 'Traffic Counting')
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

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.10.3/simple-lightbox.min.css"
        integrity="sha512-Ne9/ZPNVK3w3pBBX6xE86bNG295dJl4CHttrCp3WmxO+8NQ2Vn8FltNr6UsysA1vm7NE6hfCszbXe3D6FUNFsA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        
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
            <h1>Traffic Counting</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Traffic Counting</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between w-100">
                                <a href="{{ route('traffic-counting.create') }}" class="btn btn-sm btn-primary"><i
                                        class="fas fa-plus-circle"></i></a></a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <table id="traffic_counting_table" class="table table-striped table-bordered dt-responsive nowrap"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        @php
                            $increment = 1;
                        @endphp
                        <tbody>
                            @foreach ($traffic_counting as $data)
                                <tr>
                                    <td>{{ $increment++ }}</td>
                                    <td>
                                        <div class="gallery" style="overflow: hidden;">
                                            <a href="{{ $data->gambar }}"><img src="{{ $data->gambar }}"
                                            style="width: 100px; height: 100px; object-fit: cover;" /></a>
                                        </div>
                                    </td>
                                   
                                    <td>
                                        <button type="button" data-toggle="modal" data-target="#deleteConfirm"
                                            class="btn btn-sm btn-danger"
                                            onclick="deleteThisTrafficCounting({{ $data }})"><i
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


    <div class="modal fade" tabindex="-1" role="dialog" id="detailTrafficCounting">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Traffic Counting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="lokasi">Keterangan</label>
                        <input type="text" class="form-control" id="keterangan" readonly>
                    </div>
                    <div class="form-group col-md-12 col-12">
                        <label>Gambar</label>
                        <div class="gallery" style="overflow: hidden;">
                                <a href="" id="gambar">
                                    <img src="" id="gambarSrc" style="width: 150px; height: 150px; object-fit: cover;" />
                                </a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="statusConfirmOn">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Status Traffic Counting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('traffic-counting.status', '') }}" method="post" style="display: inline-block" id="statusOnForm">
                    @csrf
                    <input type="hidden" name="status" value="on">
                    
                    <div class="modal-body">
                        Apakah anda yakin untuk <b>mengubah</b> status traffic counting ini menjadi <b>ON</b>?
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Ya, Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" id="statusConfirmOff">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Status Traffic Counting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('traffic-counting.status', '') }}" method="post" style="display: inline-block" id="statusOffForm">
                    @csrf
                    <input type="hidden" name="status" value="off">
                    
                    <div class="modal-body">
                        Apakah anda yakin untuk <b>mengubah</b> status traffic counting ini menjadi <b>OFF</b>?
                    </div>
                    <div class="modal-footer bg-whitesmoke br">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Ya, Ubah</button>
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
                <form action="{{ route('traffic-counting.destroy', '') }}" method="post" id="deleteTrafficCountingForm">
                    @csrf
                    @method('delete')
                    <div class="modal-body">
                        Apakah anda yakin untuk <b>menghapus</b> data traffic counting ini ?
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/simplelightbox/2.10.3/simple-lightbox.min.js"
    integrity="sha512-XGiM73niqHXRwBELBEktUKuGXC9yHyaxEsVWvUiCph8yxkaNkGeXJnqs5Ls1RSp4Q+PITMcCy2Dw7HxkzBWQCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script>
        $(document).ready(function() {
            $('#traffic_counting_table').DataTable();
        });
    </script>
    {{-- Keep tab active on reload --}}
<script>
    $(document).ready(function(){
    $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
        localStorage.setItem('activeTab', $(e.target).attr('href'));
    });
    var activeTab = localStorage.getItem('activeTab');
    if(activeTab){
        $('#pills-tab a[href="' + activeTab + '"]').tab('show');
    }
});
</script>
    <script>
        $('.dropify').dropify();
    </script>
<script>
    var lightbox = new SimpleLightbox('.gallery a', {
        /* options */ });
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

        const deleteTrafficCounting = $("#deleteTrafficCountingForm").attr('action');

        function deleteThisTrafficCounting(data) {
            $("#deleteTrafficCountingForm").attr('action', `${deleteTrafficCounting}/${data.id}`);
        }

        const statusOnFormConst = $("#statusOnForm").attr('action');

        function statusOnData(data) {
            $("#statusOnForm").attr('action', `${statusOnFormConst}/${data.id}`);
        }

        const statusOffFormConst = $("#statusOffForm").attr('action');

        function statusOffData(data) {
            $("#statusOffForm").attr('action', `${statusOffFormConst}/${data.id}`);
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
        var map;
        console.log(map); // should output the object that represents instance of Leaflet

        

        function mapDetail(data) {
            var dataLatitude = [data.latitude];
            var dataLongitude = [data.longitude];

            console.log(dataLatitude[0]);
            console.log(dataLongitude[0]);
            console.log(data.id);

           
            var map = L.map(`map-detail`, {
                // Set latitude and longitude of the map center (required)
                center: [-6.8578387, 107.9210544],
                // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
                zoom: 15
            });
            L.control.scale().addTo(map);

            var marker;
            var marker = L.marker(-6.8578387, 107.9210544]).addTo(map);


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

            var modal = $("#detailKemacetan");
            modal.on('shown.bs.modal', function() {
                setTimeout(function() {
                    map.invalidateSize();
                }, 1);

            })

            $('#myModal').on('hidden.bs.modal', function() {
                var dataLatitude = '';
                var dataLongitude = '';
            })
        }

        setTimeout(function() {
            $('.pointer').fadeOut('slow');
        }, 3400);
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
    </script>

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
