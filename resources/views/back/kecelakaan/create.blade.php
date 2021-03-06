@extends('layouts.main', ['web' => $web])
@section('title', 'Kemacetan')
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
            <h1>Tambah Kecelakaan</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item">Dashboard</div>
                <div class="breadcrumb-item">Kecelakaan</div>
                <div class="breadcrumb-item"><a href="{{ url()->current() }}">Tambah Kecelakaan</a></div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('kecelakaan.store') }}" method="post" id="tambahKecelakaanForm"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-4 col-12">
                                <label>Lokasi</label>
                                <input type="text" class="form-control" name="lokasi" placeholder="Lokasi">
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <label>Pos</label>
                                <select name="nama_pos" class="form-control">
                                    @foreach ($pos as $posData)
                                        <option value="{{ $posData->nama }}">{{ $posData->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-12">
                                <label>Waktu</label>
                                <input type="time" name="waktu" class="form-control">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12 col-12">
                                <label>Ringkasan Kejadian</label>
                                <textarea name="ringkas_kejadian" class="form-control" style="height: 30vh;"></textarea>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label>Detail Kejadian</label>
                                <textarea name="detail_kejadian" class="form-control" style="height: 30vh;"></textarea>
                            </div>
                            <div class="form-group col-md-12 col-12">
                                <label>Upload Gambar (optional)</label>
                                <input type="file" class="form-control dropify" name="file_pendukung" id="file_pendukung"
                                    data-allowed-file-extensions="png jpg jpeg" data-show-remove="false">
                            </div>
                            
                            <div class="form-group col-md-12 col-12">
                                <label>Map</label>
                                <div id="map"></div>
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Latitiude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control">
                            </div>
                            <div class="form-group col-md-6 col-12">
                                <label>Longitude</label>
                                <input type="text" name="longitude" id="longitude" class="form-control">
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('kecelakaan.index') }}" class="btn btn-secondary">Kembali</a>
                            <button type="submit" class="btn btn-primary" id="tambahKecelakaanButton">Simpan
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
    <script src="https://cdn.tiny.cloud/1/nnd7pakaxqr7isf3oqefsdlew1jsidgl78umfeus6tg21ng0/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>


<script>
    $('.dropify').dropify();
</script>
    <script>
        $(document).ready(function() {

            $("#tambahKecelakaanForm").validate({
                rules: {
                    lokasi: {
                        required: true,
                    },
                    ringkas_kejadian: {
                        required: true,
                    },
                    nama_pos: {
                        required: true,
                    },
                    detail_kejadian: {
                        required: true,
                    },
                    waktu: {
                        required: true,
                    },
                    latitude: {
                        required: true,
                    },
                    longitude: {
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
                    nama_pos: {
                        required: "Nama Pos harus di isi",
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
                    $("#tambahKecelakaanButton").prop('disabled', true);
                    form.submit();
                }
            });
        });
    </script>

    <script type="text/javascript">
        // Initialize the map and assign it to a variable for later use
        var map = L.map('map', {
            // Set latitude and longitude of the map center (required)
            center: [-6.8578387, 107.9210544],
            // Set the initial zoom level, values 0-18, where 0 is most zoomed-out (required)
            zoom: 10
        });
        L.control.scale().addTo(map);
        var marker;

        var gcs = L.esri.Geocoding.geocodeService();

        map.on('click', mapClicked);

        function mapClicked(e) {

            gcs.reverse().latlng(e.latlng).run((err, res) => {
                if (marker) {
                    map.removeLayer(marker);
                }
                if (err) return;
                document.getElementById('latitude').value = e.latlng.lat
                document.getElementById('longitude').value = e.latlng.lng
                marker = L.marker(res.latlng).addTo(map).bindPopup(res.address.Match_addr).openPopup();

                if (status == 1) {
                    map.removeLayer(results);

                }

                var results = new L.LayerGroup().addTo(map);

            });
        }

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
            var status = 1;
            results.clearLayers();
            for (var i = data.results.length - 1; i >= 0; i--) {
                results.addLayer(L.marker(data.results[i].latlng));
                document.getElementById('latitude').value = data.results[i].latlng.lat
                document.getElementById('longitude').value = data.results[i].latlng.lng
            }
        });

        setTimeout(function() {
            $('.pointer').fadeOut('slow');
        }, 3400);
    </script>
@endsection
