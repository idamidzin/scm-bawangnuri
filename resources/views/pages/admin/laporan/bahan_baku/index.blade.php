@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Laporan Transaksi Pengeluaran untuk Bahan Baku
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="col-sm-6 offset-sm-3">
			<div class="card">
				<div class="card-body" id="card-body">
					<div class="card card-default">
						<div class="card-header">Rekap Transaksi Pengeluaran Untuk Bahan Baku</div>
						<div class="card-body">
							<form id="form-laporan" target="_blank" action="{{route('admin.laporan.transaksi.bahan.cetak')}}" method="POST">
								@csrf
								<div class="form-row">
									<div class="col-sm-4">
										<select class="custom-select custom-select-sm" name="bulan">
											<option @if(date('m')=='01') selected @endif value="01">Januari</option>
											<option @if(date('m')=='02') selected @endif value="02">Februari</option>
											<option @if(date('m')=='03') selected @endif value="03">Maret</option>
											<option @if(date('m')=='04') selected @endif value="04">April</option>
											<option @if(date('m')=='05') selected @endif value="05">Mei</option>
											<option @if(date('m')=='06') selected @endif value="06">Juni</option>
											<option @if(date('m')=='07') selected @endif value="07">Juli</option>
											<option @if(date('m')=='08') selected @endif value="08">Agustus</option>
											<option @if(date('m')=='09') selected @endif value="09">September</option>
											<option @if(date('m')=='10') selected @endif value="10">Oktober</option>
											<option @if(date('m')=='11') selected @endif value="11">November</option>
											<option @if(date('m')=='12') selected @endif value="12">Desember</option>
										</select>
									</div>
									<div class="col-sm-4">
										<select name='tahun' class='custom-select custom-select-sm' name='tahun'>
										<?php for ($i=date('Y'); $i>=2020; $i--){ ?>
											<option value="{{$i}}">{{$i}}</option>
										<?php } ?>
										</select>
									</div>
									<div class="col-auto">
										<button class="btn btn-danger mb-2" type="submit">Cetak Excel</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('body-area')

@endsection
@section('styles')
@endsection
@section('scripts')
@endsection