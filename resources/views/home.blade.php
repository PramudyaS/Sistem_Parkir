@extends('master_layout.master')

@section('title','HomePage')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-4" style="margin-top:7%">
                <div class="card card-default">
                    <div class="card-header bg-primary">
                        <h3 class="text-center" style="color:white">Ruang Parkir</h3>
                    </div>
                    <div class="card-body">
                       <div class="card-title">
                           <h3 class="text-center">Mobil : {{ $r_mobil->stok }}</h3>
                       </div>
                       <div class="card-title">
                           <h3 class="text-center">Motor : {{ $r_motor->stok }}</h3>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top:7%">
                <div class="card card-default">
                    <div class="card-header bg-success">
                        <h3 class="text-center" style="color:white">Kendaraan Parkir Hari Ini</h3>
                    </div>
                    <div class="card-body">
                       <div class="card-title">
                           <h3 class="text-center">Mobil : {{ $mobil }}</h3>
                       </div>
                       <div class="card-title">
                           <h3 class="text-center">Motor : {{ $motor }}</h3>
                       </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4" style="margin-top:7%">
                <div class="card card-default" style="height:190px">
                    <div class="card-header bg-warning">
                        <h3 class="text-center" style="color:white">Pendapatan Hari Ini</h3>
                    </div>
                    <div class="card-body">
                       <h1 class="text-center" style="margin-top:5%">Rp.{{ number_format($pendapatan) }}</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
