@extends('layouts.main')
@section('content')
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">#ABSENSI_ONLINE</h1> <h6 class="mr-2">SMK Negeri Wongsorejo</h6>
        {{-- <ul>
            <li><a href="#">Dashboard</a></li>
            <li>Selamat Datang</li>
        </ul> --}}
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        @if ($cekAbsen > 0)
            @foreach ($dataAbsen as $absen)
                @if($absen->clock_in == "YES" && $absen->clock_out == "")
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="background-color: #cc9f09;">
                            <a href="{{ url('/scan-data') }}">
                                <div class="card-body text-center"><img src="{{ asset('gambar-umum/qr.png') }}" style="width: 65px;height: 65px;"alt="">
                                    <div class="content" style="max-width: 100%;font-weight:bold;">
                                        <p class="text-muted mt-0 mb-0"><label id="txtNama">...</label></p>
                                        <p class="text-primary text-16 line-height-1 mb-1">Scan QR untuk keluar</p>
                                        <p class="text-primary text-16 line-height-1 mb-1">dari area sekolah.</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
                @if($absen->clock_in == "YES" && $absen->clock_out == "YES")
                    <div class="col-lg-3 col-md-6 col-sm-6">
                        <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="background-color: #899af5;">
                            <a href="#">
                                <div class="card-body text-center"><img src="{{ asset('gambar-umum/qr.png') }}" style="width: 65px;height: 65px;"alt="">
                                    <div class="content" style="max-width: 100%;font-weight:bold;">
                                        <p class="text-muted mt-0 mb-0"><label id="txtNama">...</label></p>
                                        <p class="text-primary text-16 line-height-1 mb-1">Absensi Complete!</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @endif
            @endforeach
        @else
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="background-color: #b9ecef;">
                    <a href="{{ url('/scan-data') }}">
                        <div class="card-body text-center"><img src="{{ asset('gambar-umum/qr.png') }}" style="width: 65px;height: 65px;"alt="">
                            <div class="content" style="max-width: 100%;font-weight:bold;">
                                <p class="text-muted mt-0 mb-0"><label id="txtNama">...</label></p>
                                <p class="text-primary text-16 line-height-1 mb-1">Scan QR untuk masuk</p>
                                <p class="text-primary text-16 line-height-1 mb-1">ke area sekolah.</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endif
        
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="background-color: #7beb8e;">
                <a href="riwayat-kehadiran">
                    <div class="card-body text-center"><i class="i-Calendar-4"></i>
                        <div class="content" style="max-width: 100%;">
                            <p class="text-primary text-16 line-height-1" style="margin-top: 15px;">Riwayat Kehadiran</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" onclick="lokasiAbsen()" data-toggle="modal" data-target="#lokasiSaatAbsen" style="background-color: #f3d2c2;">
                <div class="card-body text-center"><i class="i-Map-Marker"></i>
                    <div class="content" style="max-width: 100%;">
                        <p class="text-primary text-16 line-height-1" style="margin-top: 15px;">Lokasi Absen</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="background-color: #d1c9dd;" onClick="cek()" data-toggle="modal" data-target="#lokasiSaatIni">
                <div class="card-body text-center"><i class="i-Map-Marker"></i>
                    <div class="content" style="max-width: 100%;">
                        <p class="text-primary text-16 line-height-1" style="margin-top: 15px;">Lokasi Saat Ini</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!-- Footer Start -->

<div class="modal fade" id="lokasiSaatIni" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lokasi Saat Ini</h5>
            </div>
            <div class="modal-body">
                <div id="map" style="height: 400px;"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="lokasiSaatAbsen" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Lokasi Absen</h5>
            </div>
            <div class="modal-body">
                <div id="mapAbsen" style="height: 400px;"></div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}"></script>
    <script type="text/javascript" src="{{ asset('siswa/assets/js/jquery-3.2.1.min.js') }}"></script>
    <script>
    $(document).ready(function() {
        $.ajax({
            url: "/get-data-dashboard",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                let {
                    dataUser,
                } = data

                $('#txtNama').text('Hi, '+dataUser.nama);
            }
        });
    });

    //CEK LOKASI SAAT INI
    function cek(){
        if (navigator.geolocation) {
            // navigator.geolocation.getCurrentPosition(showPosition, showError);
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            view.innerHTML = "Yah browsernya ngga support Geolocation bro!";
        }
    }

    function showPosition(position) {
        lt = position.coords.latitude;
        lg = position.coords.longitude;

        var mapOptions = {
        center: new google.maps.LatLng(lt, lg),
        zoom: 18,
        streetViewControl: false
        
        };

        var map = new google.maps.Map(document.getElementById('map'),
        mapOptions);

        marker = new google.maps.Marker({
            map: map,
            draggable: false,
            position: mapOptions.center
        });	
        marker.setMap(map);
    
        $.ajax({
            url: "/get-cek-map",
            type: "GET",
            dataType: "JSON",
            success: function(data){
                let {
                    dataUser,
                    cekLokasi
                } = data

                var geocoder = new google.maps.Geocoder;
                var lokasi = new google.maps.LatLng(cekLokasi.latitude, cekLokasi.longitude);


                var showcircle = new google.maps.Circle({
                    strokeColor: '#8080ff',
                    strokeOpacity: 0.7,
                    strokeWeight: 1,
                    fillColor: '#8080ff',
                    fillOpacity: 0.15,
                    draggable: false,
                    map: map,
                    center: lokasi,
                    radius: parseFloat(cekLokasi.radius)
                });
                showcircle.setMap(map);

                geocoder.geocode({'location': mapOptions.center}, function(results, status) {
                    if (status === 'OK') {
                    if (results[0]) {
                        
                        var alamat = results[0].formatted_address;
                        var contentString = '<div id="content">'+
                                                '<h4 id="firstHeading" class="firstHeading"> Lokasi Absen '+ cekLokasi.nama +'</h4>'+
                                                '<div id="bodyContent">'+
                                                    '<p>'+ cekLokasi.lokasi + '</p>'+
                                                    '<hr>'+
                                                    '<p>' + alamat + '</p>'+
                                                '</div>'+
                                            '</div>';

                        var info = new google.maps.InfoWindow();

                        google.maps.event.addListener(showcircle, 'click', function(e) {
                            info.setContent(contentString);
                            info.setPosition(this.getCenter());
                            info.open(map);
                        });
                    } else {
                        window.alert('No results found');
                    }
                    } else {
                    window.alert('Geocoder failed due to: ' + status);
                    }
                });
            }
        });
    }
    </script>

    <script>
        // CEK LOKASI ABSEN
        function lokasiAbsen() {		
            $.ajax({
                url: '/get-cek-map',
                type: 'GET',
                dataType: 'JSON',
                success: function(data){
                    let {
                        dataUser,
                        cekLokasi
                    } = data

                    var mapOptions = {
                    center: new google.maps.LatLng(cekLokasi.latitude, cekLokasi.longitude),
                    zoom: 17,
                    streetViewControl: false
                    
                    };
                    var geocoder = new google.maps.Geocoder;
                    var map = new google.maps.Map(document.getElementById('mapAbsen'),
                    mapOptions);

                    var citymap = {
                        "cb":{
                            center: {lat: parseFloat(cekLokasi.latitude), lng: parseFloat(cekLokasi.longitude)}
                        },
                    };
                    
                    for (var kota in citymap){

                        var showcircle = new google.maps.Circle({
                            strokeColor: '#8080ff',
                            strokeOpacity: 0.7,
                            strokeWeight: 1,
                            fillColor: '#8080ff',
                            fillOpacity: 0.15,
                            draggable: false,
                            map: map,
                            center: citymap[kota].center,
                            radius: parseFloat(cekLokasi.radius)
                        });
                    }
                    showcircle.setMap(map);

                    geocoder.geocode({'location': mapOptions.center}, function(results, status) {
                        if (status === 'OK') {
                        if (results[0]) {
                            
                            var alamat = results[0].formatted_address;
                            var contentString = '<div id="content">'+
                                                    '<h4 id="firstHeading" class="firstHeading"> Lokasi Absen '+ cekLokasi.nama +'</h4>'+
                                                    '<div id="bodyContent">'+
                                                        '<p>'+ cekLokasi.lokasi + '</p>'+
                                                        '<hr>'+
                                                        '<p>' + alamat + '</p>'+
                                                    '</div>'+
                                                '</div>';

                            var info = new google.maps.InfoWindow();

                            google.maps.event.addListener(showcircle, 'click', function(e) {
                                info.setContent(contentString);
                                info.setPosition(this.getCenter());
                                info.open(map);
                            });
                        } else {
                            window.alert('No results found');
                        }
                        } else {
                        window.alert('Geocoder failed due to: ' + status);
                        }
                    });
                }
            });
        }
    </script>
@endpush