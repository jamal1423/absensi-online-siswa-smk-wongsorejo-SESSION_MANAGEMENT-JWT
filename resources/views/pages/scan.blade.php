@extends('layouts.main')

@push('styles')
<style>
    #map-canvas {
        height: 400px;
        margin: 0px;
        padding: 0px;
        display: none;
    }

    .file-upload {
      background-color: #ffffff;
      width: 100%;
      margin: 0 auto;
      /*padding: 20px;*/
    }

    .file-upload-btn {
      width: 100%;
      margin: 0;
      color: #fff;
      background: #1e88e5;
      border: none;
      padding: 10px;
      border-radius: 4px;
      border-bottom: 4px solid #1e88e5;
      transition: all .2s ease;
      outline: none;
      text-transform: uppercase;
      font-weight: 700;
    }

    .file-upload-btn:hover {
      background: #1e88e5;
      color: #ffffff;
      transition: all .2s ease;
      cursor: pointer;
    }

    .file-upload-btn:active {
      border: 0;
      transition: all .2s ease;
    }

    .file-upload-content {
      display: none;
      text-align: center;
    }

    .file-upload-input {
      position: absolute;
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      outline: none;
      opacity: 0;
      cursor: pointer;
    }

    .image-upload-wrap {
      margin-top: 20px;
      border: 4px dashed #1e88e5;
      /* background-image:url("../assets/img/scanner.png"); */
      position: relative;
    }

    .image-dropping,
    .image-upload-wrap:hover {
      background-color: #1e88e5;
      border: 4px dashed #ffffff;
    }

    .image-title-wrap {
      padding: 0 15px 15px 15px;
      color: #222;
    }

    .drag-text {
      text-align: center;
    }

    .drag-text h3 {
      font-weight: 100;
      text-transform: uppercase;
      color: #1e88e5;
      padding: 60px 0;
    }

    .file-upload-image {
      max-height: 100%;
      max-width: 100%;
      margin: auto;
      padding: 5px;
    }

    .remove-image {
      width: 200px;
      margin: 0;
      color: #fff;
      background: #cd4535;
      border: none;
      padding: 10px;
      border-radius: 4px;
      border-bottom: 4px solid #b02818;
      transition: all .2s ease;
      outline: none;
      text-transform: uppercase;
      font-weight: 700;
    }

    .remove-image:hover {
      background: #c13b2a;
      color: #ffffff;
      transition: all .2s ease;
      cursor: pointer;
    }

    .remove-image:active {
      border: 0;
      transition: all .2s ease;
    }

    .kamera
    {
       width:100%;
        height:20%;
    }

    .small-video {
        transform-origin: bottom left;
        width: 100%;
        height: 120vw;
        object-fit: cover;

        z-index: 4;
        visibility: visible;
        border-radius:10px;
    }
</style>    
@endpush

@section('content')
<div class="main-content">
    <div class="breadcrumb">
        <h1 id="titleForm">Scan QR</h1>
    </div>
   
    <!-- CARD ICON-->
    <div class="row">
        <div class="col-lg-6 col-md-12">
            <div class="row" id="modeScan">
                <div class="col-md-6">
                    <div class="card bg-dark text-white mb-4">
                        <div class="col-xl-6">
                            <div class="form-group control-group">
                                <div id="sourceSelectPanel" style="display:none">
                                    <label for="sourceSelect">Select Camera </label>
                                        <select id="sourceSelect" class="form-control">
                                    </select>
                                </div>
                            </div>
                            
                            <div>
                                <a class="button" id="startButton" style="display:none;">Start</a>
                                <a class="button" id="resetButton" style="display:none;">Reset</a>
                            </div>
                        </div>
                        <video id="video" class="small-video" style="margin-top:-12px;" poster="{{ asset('siswa/assets/images/scanner.png') }}"  style="-webkit-mask-box-image: url('./assets/images/scanner2.png');"></video>
                        <audio id='alert' src='{{ asset('siswa/assets/beep.wav') }}'></audio>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="background-color: #f32e0f;">
                        <div class="card-body text-center"><i class="i-Warning-Window" style="color: yellow;"></i>
                            <div class="content" style="max-width: 100%;">
                                <p class="text-14 line-height-1" style="margin-bottom: 0px;padding: 10px;color:white;">Saat SCAN QR, pastikan kamu berada pada area absen yang telah ditentukan.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <input type="hidden" class="form-control" name="nis" class="form-control" placeholder="NIS" autocomplete="off" id="nis">
                <input type="hidden" class="form-control" name="nama" class="form-control" placeholder="Nama Siswa" autocomplete="off" id="nama">
                <input type="hidden" class="form-control" name="username" class="form-control" placeholder="Username" autocomplete="off" id="username">
                <input type="hidden" class="form-control" name="kelas" class="form-control" placeholder="Kelas" autocomplete="off" id="kelas" oninput="getData('', this.value)" onmousedown="value = '';">
            </div>
        </div>
    </div>
    
    <div id="map-canvas"></div>
    <div id="map-canvas2"></div>

    <div id="loadingmessage" style="display:none">
        <img src="{{ asset('gambar-umum/loading.gif') }}" style="top:0px;left:0px;z-index:999999;position:absolute" />
        <h3 class="text-center" style="margin-top: 200px;">Sedang memeriksa lokasi...</h3>
    </div>
    <div id="successClockin" style="display:none">
        <img src="{{ asset('gambar-umum/success3.gif') }}" style="display: block;margin-left: auto;margin-right: auto;" />
        <h3 class="text-center" style="margin-top: 10px;">Berhasil clock-in</h3>
        <div class="ul-widget__item" style="width: 100%;">
            <a href="{{ url('/dashboard') }}" style="width: 100%;"><button class="btn btn-info ripple m-1" style="width: 100%;" type="button">Kembali</button></a>
        </div>
    </div>
    <div id="successClockout" style="display:none">
        <img src="{{ asset('gambar-umum/success3.gif') }}" style="display: block;margin-left: auto;margin-right: auto;" />
        <h3 class="text-center" style="margin-top: 10px;">Berhasil clock-out</h3>
        <div class="ul-widget__item" style="width: 100%;">
            <a href="{{ url('/dashboard') }}" style="width: 100%;"><button class="btn btn-info ripple m-1" style="width: 100%;" type="button">Kembali</button></a>
        </div>
    </div>
    <div id="wrongClockin" style="display:none">
        <img src="{{ asset('gambar-umum/wrong2.gif') }}" style="display: block;margin-left: auto;margin-right: auto;" />
        <h3 class="text-center" style="margin-top: 10px;">Terjadi kesalahan, atau lokasi tidak valid</h3>
        <div class="ul-widget__item" style="width: 100%;">
            <a href="{{ url('/scan-data') }}" style="width: 100%;"><button class="btn btn-danger ripple m-1" style="width: 100%;" type="button">Scan Ulang</button></a>
        </div>
    </div>

    <div class="row" id="resultScan" style="display:none">
        <div class="col-md-6 col-lg-6 col-xl-4 mt-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="ul-widget1">
                        @if ($cekAbsen > 0)
                            <h3 class="ul-widget1__title">Clock Out</h3>
                            <form method="POST" id="formClockOut">
                                @method('post')
                                @csrf
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title">NIS</h3>
                                    </div>
                                    <span class="ul-widget__number text-primary" id="nis-out">...</span>
                                </div>
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title">Nama</h3>
                                    </div>
                                    <span class="ul-widget__number text-danger" id="nama-out">...</span>
                                </div>
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title">Kelas</h3>
                                    </div>
                                    <span class="ul-widget__number text-success" id="kelas-out">...</span>
                                </div>
                                <div class="ul-widget__item">
                                    <button class="btn btn-primary ripple m-1" type="button" onclick="initializeClockOut(this)" style="width: 100%;">Clock-Out</button>
                                    <div class="ul-widget__item" style="width: 100%;">
                                        <a href="{{ url('/scan-data') }}" style="width: 100%;"><button class="btn btn-danger ripple m-1" style="width: 100%;" type="button">Scan Ulang</button></a>
                                    </div>
                                </div>
                            </form>
                        @else
                            <h3 class="ul-widget1__title">Clock In</h3>
                            <form method="POST" id="formClockIn">
                                @method('post')
                                @csrf
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title">NIS</h3>
                                    </div>
                                    <span class="ul-widget__number text-primary" id="nis-in">...</span>
                                </div>
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title">Nama</h3>
                                    </div>
                                    <span class="ul-widget__number text-danger" id="nama-in">...</span>
                                </div>
                                <div class="ul-widget__item">
                                    <div class="ul-widget__info">
                                        <h3 class="ul-widget1__title">Kelas</h3>
                                    </div>
                                    <span class="ul-widget__number text-success" id="kelas-in">...</span>
                                </div>
                                <div class="ul-widget__item">
                                    <button class="btn btn-primary ripple m-1" type="button" onclick="initializeClockIn(this)" style="width: 100%;">Clock-In</button>
                                    <div class="ul-widget__item" style="width: 100%;">
                                        <a href="{{ url('/scan-data') }}" style="width: 100%;"><button class="btn btn-danger ripple m-1" style="width: 100%;" type="button">Scan Ulang</button></a>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAP_API_KEY') }}"></script>
<script src="{{ asset('siswa/assets/js/scripts/zxing.js') }}"></script>
<script type="text/javascript">
    window.addEventListener('load', function () {
        callCam();
    })

    function callCam () {
        let selectedDeviceId;
        const codeReader = new ZXing.BrowserMultiFormatReader()
        console.log('ZXing code reader initialized')
        codeReader.getVideoInputDevices()
        codeReader.listVideoInputDevices()
        .then((videoInputDevices) => {
            const sourceSelect = document.getElementById('sourceSelect')
            
            //const backCamIndex = videoInputDevices.length - 1
            //selectedDeviceId = videoInputDevices[backCamIndex].deviceId
            if (videoInputDevices.length > 1) {
                videoInputDevices.forEach((element) => {
                    const sourceOption = document.createElement('option')
                    sourceOption.text = element.label
                    sourceOption.value = element.deviceId
                    sourceSelect.appendChild(sourceOption)
                })
                
                const backCamIndex = videoInputDevices.length - 1
                selectedDeviceId = videoInputDevices[backCamIndex].deviceId
                sourceSelect[backCamIndex].setAttribute('selected', true)

                // sourceSelect.onchange = () => {
                // 	selectedDeviceId = sourceSelect.value;
                    
                // };
                const sourceSelectPanel = document.getElementById('sourceSelectPanel')
                sourceSelectPanel.style.display = 'none'
            }
            cameraOn(codeReader, selectedDeviceId)
            document.getElementById('startButton').addEventListener('click', () => {
                cameraOn(codeReader, selectedDeviceId)
            })
            document.getElementById('resetButton').addEventListener('click', () => {
                codeReader.reset()
                document.getElementById('kelas').value = '';
                console.log('Reset.')
            })
            document.getElementById('sourceSelect').addEventListener('change', () => {
                codeReader.reset()
                cameraOn(codeReader, selectedDeviceId)
            })
        })
        .catch((err) => {
        console.error(err)
        })
    }
</script>

<script>
    function cameraOn(codeReader, selectedDeviceId) {
          codeReader.decodeFromVideoDevice(selectedDeviceId, 'video', (result, err) => {
              if (result) 
            {
                document.getElementById("alert").play()
                getData(result.text)
              }
              if (err && !(err instanceof ZXing.NotFoundException)) {
                console.error(err)
                //document.getElementById('barcode').value = err
              }
        })
    }

    function getData (value) {
        var pass_data = {'hasil' : value};
        $.ajax({
            url : '/cari-data',
            type : "POST",
            data : pass_data,
            success: function (response) 
            {
                let {
                    responData,
                    dataSiswa
                } = response

                $('#modeScan').css("display", "none");
                $('#resultScan').css("display", "block");
                $('#titleForm').text('Hasil Scan');
                $('#nis-in').text(dataSiswa.nis);
                $('#nama-in').text(dataSiswa.nama);
                $('#kelas-in').text(dataSiswa.kelas);
                $('#nis-out').text(dataSiswa.nis);
                $('#nama-out').text(dataSiswa.nama);
                $('#kelas-out').text(dataSiswa.kelas);
            }
        });
    }
</script>

<script>
    function initializeClockIn() {
        $('#loadingmessage').show();
        $('#resultScan').hide();
        $.ajax({
            url: '/get-cek-map',
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                let {
                    dataUser,
                    cekLokasi
                } = data

                var position_now = false
                lokasi_cek(cekLokasi.latitude, cekLokasi.longitude, cekLokasi.radius, cekLokasi.lokasi)
                
                function lokasi_cek(latitude, longitude, radius_loc, lokasi){
                    
                    var lt = latitude;
                    var ln = longitude;
                    var radius = radius_loc;
                    var lokasi = lokasi;
                    var center = new google.maps.LatLng(lt, ln);

                    var radius_circle = parseFloat(radius); // 35 m

                    var markerPositions = [
                        {lat: 0, lng: 0}
                    ];

                    var markers=[];
                    // draw map
                    var mapOptions = {
                        center: center,
                        zoom: 18,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    var map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
                    var circle = drawCircle(mapOptions.center, radius_circle);

                    // markers
                    for (var i=0; i<markerPositions.length; i++) {
                        markers.push(
                        new google.maps.Marker({
                            position: new google.maps.LatLng(markerPositions[i].lat, markerPositions[i].lng),
                            map: map,
                            //draggable: true
                            })
                        );
                    }

                    if (navigator.geolocation) {
                        // navigator.geolocation.getCurrentPosition(showPosition, showError);
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else {
                        view.innerHTML = "Yah browsernya ngga support Geolocation bro!";
                    }

                    function showPosition(position) {
                        lt = position.coords.latitude;
                        lg = position.coords.longitude;
                        
                        for (var i=0; i<markerPositions.length; i++) {

                            markers[i].setPosition( new google.maps.LatLng(lt, lg) );

                            var distance = calculateDistance(
                            markers[i].getPosition().lat(),
                            markers[i].getPosition().lng(),
                            circle.getCenter().lat(),
                            circle.getCenter().lng(),
                            "K"
                            );

                            if (distance * 1000 < radius_circle) {  // radius is in meter; distance in km
                                position_now = true;

                                $.ajax({
                                    url: '/proses-clockin',
                                    type: "POST",
                                    dataType: "JSON",
                                    cache: false,
                                    data: {
                                        kelas: '',
                                        nama: '',
                                        userlog: '',
                                        clock_in: '',
                                        tgl_clock_in: '',
                                        clock_out: '',
                                        tgl_clock_out: '',
                                        latitude: lt,
                                        longitude: lg,
                                        lokasi: '',
                                    },success: function(msg){
                                        // console.log(msg)
                                        if (msg=="sukses" ) {
                                            $('#loadingmessage').hide();
                                            $('#titleForm').hide();
                                            $('#successClockin').show();
                                        }else{
                                            $('#loadingmessage').hide();
                                            $('#titleForm').hide();
                                            $('#wrongClockin').show();
                                        }
                                    }	
                                });
                                
                            }
                            else {
                                $('#loadingmessage').hide();
                                $('#titleForm').hide();
                                $('#wrongClockin').show();
                            }
                        }
                    }

                    function drawCircle(center, radius) {
                        return new google.maps.Circle({
                            strokeColor: '#0000FF',
                            strokeOpacity: 0.7,
                            strokeWeight: 1,
                            fillColor: '#0000FF',
                            fillOpacity: 0.15,
                            // draggable: true,
                            map: map,
                            center: center,
                            radius: radius
                        });
                    }

                    function calculateDistance(lat1, lon1, lat2, lon2, unit) {
                        var radlat1 = Math.PI * lat1/180;
                        var radlat2 = Math.PI * lat2/180;
                        var radlon1 = Math.PI * lon1/180;
                        var radlon2 = Math.PI * lon2/180;
                        var theta = lon1-lon2;
                        var radtheta = Math.PI * theta/180;
                        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
                        dist = Math.acos(dist);
                        dist = dist * 180/Math.PI;
                        dist = dist * 60 * 1.1515;
                        if (unit=="K") { dist = dist * 1.609344; }
                        if (unit=="N") { dist = dist * 0.8684; }
                        return dist;
                    }

                    if (position_now == true ){
                        return true
                    }else{
                        return false
                    }
                }
            }
        });

    }
    //google.maps.event.addDomListener(window, 'load', initializeClockIn);
</script>

<script>
    function initializeClockOut() {
        $('#loadingmessage').show();
        $('#resultScan').hide();
        $.ajax({
            url: '/get-cek-map',
            type: 'GET',
            dataType: 'JSON',
            success: function(data){
                let {
                    dataUser,
                    cekLokasi
                } = data

                var position_now = false
                lokasi_cek(cekLokasi.latitude, cekLokasi.longitude, cekLokasi.radius, cekLokasi.lokasi)
                
                function lokasi_cek(latitude, longitude, radius_loc, lokasi){
                    
                    var lt = latitude;
                    var ln = longitude;
                    var radius = radius_loc;
                    var lokasi = lokasi;
                    var center = new google.maps.LatLng(lt, ln);

                    var radius_circle = parseFloat(radius); // 35 m

                    var markerPositions = [
                        {lat: 0, lng: 0}
                    ];

                    var markers=[];
                    // draw map
                    var mapOptions = {
                        center: center,
                        zoom: 18,
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                    };
                    var map = new google.maps.Map(document.getElementById('map-canvas2'), mapOptions);
                    var circle = drawCircle(mapOptions.center, radius_circle);

                    // markers
                    for (var i=0; i<markerPositions.length; i++) {
                        markers.push(
                        new google.maps.Marker({
                            position: new google.maps.LatLng(markerPositions[i].lat, markerPositions[i].lng),
                            map: map,
                            //draggable: true
                            })
                        );
                    }

                    if (navigator.geolocation) {
                        // navigator.geolocation.getCurrentPosition(showPosition, showError);
                        navigator.geolocation.getCurrentPosition(showPosition);
                    } else {
                        view.innerHTML = "Yah browsernya ngga support Geolocation bro!";
                    }

                    function showPosition(position) {
                        lt = position.coords.latitude;
                        lg = position.coords.longitude;
                        
                        for (var i=0; i<markerPositions.length; i++) {

                            markers[i].setPosition( new google.maps.LatLng(lt, lg) );

                            var distance = calculateDistance(
                            markers[i].getPosition().lat(),
                            markers[i].getPosition().lng(),
                            circle.getCenter().lat(),
                            circle.getCenter().lng(),
                            "K"
                            );

                            if (distance * 1000 < radius_circle) { 
                                position_now = true;

                                $.ajax({
                                    url: '/proses-clockout',
                                    type: 'GET',
                                    dataType: 'JSON',
                                    success: function(msg){
                                        if (msg=="sukses" ) {
                                            $('#loadingmessage').hide();
                                            $('#titleForm').hide();
                                            $('#successClockout').show();
                                        }else{
                                            $('#loadingmessage').hide();
                                            $('#titleForm').hide();
                                            $('#wrongClockout').show();
                                        }
                                    }	
                                });
                                
                            }
                            else {
                                $('#loadingmessage').hide();
                                $('#titleForm').hide();
                                $('#wrongClockout').show();
                            }
                        }
                    }

                    function drawCircle(center, radius) {
                        return new google.maps.Circle({
                            strokeColor: '#0000FF',
                            strokeOpacity: 0.7,
                            strokeWeight: 1,
                            fillColor: '#0000FF',
                            fillOpacity: 0.15,
                            // draggable: true,
                            map: map,
                            center: center,
                            radius: radius
                        });
                    }

                    function calculateDistance(lat1, lon1, lat2, lon2, unit) {
                        var radlat1 = Math.PI * lat1/180;
                        var radlat2 = Math.PI * lat2/180;
                        var radlon1 = Math.PI * lon1/180;
                        var radlon2 = Math.PI * lon2/180;
                        var theta = lon1-lon2;
                        var radtheta = Math.PI * theta/180;
                        var dist = Math.sin(radlat1) * Math.sin(radlat2) + Math.cos(radlat1) * Math.cos(radlat2) * Math.cos(radtheta);
                        dist = Math.acos(dist);
                        dist = dist * 180/Math.PI;
                        dist = dist * 60 * 1.1515;
                        if (unit=="K") { dist = dist * 1.609344; }
                        if (unit=="N") { dist = dist * 0.8684; }
                        return dist;
                    }

                    if (position_now == true ){
                        return true
                    }else{
                        return false
                    }
                }
            }
        });
    }
    //google.maps.event.addDomListener(window, 'load', initializeClockOut);
</script>
@endpush