@extends('layouts.main')
@section('content')
<div class="main-content">
    <div class="breadcrumb">
        <h1 class="mr-2">Riwayat Absensi</h1>
    </div>
    <div class="separator-breadcrumb border-top"></div>
    <div class="row">
        @foreach ($dataAbsen as $absen)
        <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-icon-bg card-icon-bg-primary o-hidden mb-4" style="background-color: #7beb8e;">
                <div class="card-body text-center"><i class="i-Calendar-4"></i>
                    <div class="content" style="max-width: 100%;">
                        <span class="text-primary text-14 text-right">In : {{ date('d-m-Y H:i:s', strtotime($absen->tgl_clock_in )) }}</span>
                        <span class="text-primary text-14 text-right">
                            @if($absen->clock_out == '')
                                Out :  <span class="text-danger">Belum Clock-Out</span>
                            @else
                                Out : {{ date('d-m-Y H:i:s', strtotime($absen->tgl_clock_out )) }}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection