@extends('layouts.app')
@section('content')
@if( session('msg') )
<?php $msg = session('msg'); ?>
<div class="alert alert-{{ $msg['type'] }} alert-remove">
    {!! $msg['text'] !!}
</div>
@endif
@if(auth()->user()->Role->nama == 'Admin' || auth()->user()->Role->nama == 'Pimpinan')
<div class="content-heading">
    <div>Dashboard<small data-localize="dashboard.WELCOME">Selamat Datang {{auth()->user()->nama}}</small></div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body bg-gray-dark rounded">
                <h1>Selamat Datang</h1>
                di Halaman {{auth()->user()->Role->nama}} (<strong style="color: yellow">{{ucwords(auth()->user()->nama)}}</strong>)
            </div>
        </div>
    </div>      
</div>
<!-- START cards box-->
<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-info-dark justify-content-center rounded-left"><em class="fas fa-user-secret fa-3x"></em></div>
            <div class="col-8 py-3 bg-info rounded-right">
                <div class="h3 mt-0">{{ $supplier_count }}</div>
                <div class="text-uppercase">Supplier</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-purple-dark justify-content-center rounded-left"><em class="fas fa-user-tag fa-3x"></em></div>
            <div class="col-8 py-3 bg-purple rounded-right">
                <div class="h3 mt-0">{{ $distributor_count }}</div>
                <div class="text-uppercase">Distributor</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-success-dark justify-content-center rounded-left"><em class="fas fa-shopping-bag fa-3x"></em></div>
            <div class="col-8 py-3 bg-success rounded-right">
                <div class="h3 mt-0">{{ $produk_count }}</div>
                <div class="text-uppercase">Stok Produk Jadi</div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-pink-dark justify-content-center rounded-left"><em class="far fa-money-bill-alt fa-3x"></em></div>
            <div class="col-8 py-3 bg-pink rounded-right">
                <div class="h3 mt-0">@rupiah($transaksi_produk_count)</div>
                <div class="text-uppercase">Pendapatan dari Produk</div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-default p-2">
            <div class="card-header">
                <div class="card-title">Stok Bahan Baku Supplier</div>
            </div>
            <div class="list-group">
                <div class="row">
                    @foreach($bahan as $row)
                    <div class="col-sm-4">
                        <div class="list-group-item">
                            <div class="media">
                                <div class="align-self-start mr-2"><span class="fa-stack"><em class="fa fa-circle fa-stack-2x {{ $row->jumlah > 0 ? 'text-success' : 'text-danger' }}"></em><em class="fa fa-tasks fa-stack-1x fa-inverse text-white"></em></span></div>
                                <div class="media-body text-truncate">
                                    <p class="mb-1"><a class="{{ $row->jumlah > 0 ? 'text-success' : 'text-danger' }} m-0">{{ $row->Supplier ? $row->Supplier->nama : '' }}</a></p>
                                    @if($row->jumlah > 0)
                                    <h5>{{ $row->nama }}: {{ $row->jumlah }}Kg</h5>
                                    @else
                                    <h5>{{ $row->nama }} Stok Kosong</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-12">
        <div class="card card-default p-2">
            <div class="card-header">
                <div class="card-title">Stok Produk Jadi</div>
            </div>
            <div class="list-group">
                <div class="row">
                    @foreach($produk as $row)
                    <div class="col-sm-4">
                        <div class="list-group-item">
                            <div class="media">
                                <div class="align-self-start mr-2"><span class="fa-stack"><em class="fa fa-circle fa-stack-2x {{ $row->stok > 0 ? 'text-success' : 'text-danger' }}"></em><em class="fa fa-tasks fa-stack-1x fa-inverse text-white"></em></span></div>
                                <div class="media-body text-truncate">
                                    <p class="mb-1"><a class="{{ $row->stok > 0 ? 'text-success' : 'text-danger' }} m-0">{{ $row->nama }}</a></p>
                                    @if($row->stok > 0)
                                    <h5>Tersedia {{ $row->stok }}Kg</h5>
                                    @else
                                    <h5>Stok Kosong</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(auth()->user()->Role->nama == 'Supplier')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body bg-gray-dark rounded">
                <p>
                    <h1>Selamat Datang</h1>
                    <strong style="color: yellow">{{ucwords(auth()->user()->nama)}}</strong> di Halaman Supplier
                </p>
            </div>
        </div>
    </div>      
</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-info-dark justify-content-center rounded-left"><em class="fas fa-fire fa-3x"></em></div>
            <div class="col-8 py-3 bg-info rounded-right">
                <div class="h3 mt-0">{{ $bahan_supplier_bawang_count }}Kg</div>
                <div class="text-uppercase">Bahan Bawang</div>
            </div>
        </div>
    </div>
    @if(count($bahan_supplier_tepung) > 0)
    <div class="col-xl-3 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-danger-dark justify-content-center rounded-left"><em class="fas fa-fire fa-3x"></em></div>
            <div class="col-8 py-3 bg-danger rounded-right">
                <div class="h3 mt-0">{{ $bahan_supplier_tepung_count }}Kg</div>
                <div class="text-uppercase">Bahan Tepung</div>
            </div>
        </div>
    </div>
    @endif
    <div class="col-xl-3 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-success-dark justify-content-center rounded-left"><em class="fas fa-money-bill-alt fa-3x"></em></div>
            <div class="col-10 py-3 bg-success rounded-right">
                <div class="h3 mt-0">@rupiah($transaksi_sup_count)</div>
                <div class="text-uppercase">Jumlah Transaksi</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-12">
        <div class="card card-default p-2">
            <div class="card-header">
                <div class="card-title">Stok Bahan Baku PABRIK</div>
            </div>
            <?php
                if ($stok_bawang <= 100 && $stok_bawang > 0) {
                    $classBawang = 'text-warning';
                }elseif($stok_bawang <= 0){
                    $classBawang = 'text-danger';
                }else{
                    $classBawang = 'text-success';
                }

                if ($stok_tepung <= 100 && $stok_tepung > 0) {
                    $classTepung = 'text-warning';
                }elseif($stok_tepung <= 0){
                    $classTepung = 'text-danger';
                }else{
                    $classTepung = 'text-success';
                }
            ?>
            <div class="list-group">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="list-group-item">
                            <div class="media">
                                <div class="align-self-start mr-2"><span class="fa-stack"><em class="fa fa-circle fa-stack-2x {{ $classBawang }}"></em><em class="fa fa-tasks fa-stack-1x fa-inverse text-white"></em></span></div>
                                <div class="media-body text-truncate">
                                    <p class="mb-1"><a class="{{ $classBawang }} m-0">Stok Bawang Merah Mentah</a></p>
                                    @if($stok_bawang <= 100 && $stok_bawang > 0)
                                    <h5>Stok Bawang Sangat Minim</h5>
                                    @elseif($stok_bawang <= 0)
                                    <h5>Stok Bawang Habis</h5>
                                    @else
                                    <h5>{{ $stok_bawang }}Kg</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="list-group-item">
                            <div class="media">
                                <div class="align-self-start mr-2"><span class="fa-stack"><em class="fa fa-circle fa-stack-2x {{ $classTepung }}"></em><em class="fa fa-tasks fa-stack-1x fa-inverse text-white"></em></span></div>
                                <div class="media-body text-truncate">
                                    <p class="mb-1"><a class="{{ $classTepung }} m-0">Stok Tepung</a></p>
                                    @if($stok_tepung <= 100 && $stok_tepung > 0)
                                    <h5>Stok Tepung Sangat Minim</h5>
                                    @elseif($stok_tepung <= 0)
                                    <h5>Stok Tepung Habis</h5>
                                    @else
                                    <h5>{{ $stok_tepung }}Kg</h5>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@elseif(auth()->user()->Role->nama == 'Distributor')
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body bg-gray-dark rounded">
                <p>
                    <h1>Selamat Datang</h1>
                    <strong style="color: yellow">{{ucwords(auth()->user()->nama)}}</strong> di Halaman Distributor
                </p>
            </div>
        </div>
    </div>      
</div>
<div class="row">
    <div class="col-xl-3 col-md-6">
        <div class="card flex-row align-items-center align-items-stretch border-0">
            <div class="col-4 d-flex align-items-center bg-success-dark justify-content-center rounded-left"><em class="fas fa-money-bill-alt fa-3x"></em></div>
            <div class="col-10 py-3 bg-success rounded-right">
                <div class="h3 mt-0">@rupiah($transaksi_produk_distributor_count)</div>
                <div class="text-uppercase">Jumlah Transaksi</div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@section('scripts')
<script src="{{ mix('/js/sparkline.js') }}"></script>
<script src="{{ mix('/js/easypiechart.js') }}"></script>
<script src="{{ mix('/js/flot.js') }}"></script>
@endsection
