@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Tambah Bahan
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Tambah Bahan
					<div class="float-right">
						
					</div>
				</div>
			</div>
			<div class="card-body">
				@if( session('msg') )
				<?php $msg = session('msg'); ?>
				<div class="alert alert-{{ $msg['type'] }} alert-remove">
					{!! $msg['text'] !!}
				</div>
				@endif
				<form action="{{ route('supplier.bahan.store') }}" method="POST">
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Bahan Baku</label>
						<div class="col-sm-7">
							<select class="form-control" required name="nama">
								<option value="">-- Pilih Bahan Baku --</option>
								<option value="Bawang Merah Mentah">Bawang Merah Mentah</option>
								<option value="Tepung">Tepung</option>
							</select>
							@if ($errors->has('nama'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('nama') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Harga</label>
						<div class="col-sm-7">
							<div class="input-group">
								<input autofocus class="form-control" required type="text" name="harga" value="{{ old('harga') }}" placeholder="" onkeypress="return hanyaAngka(event)" id="rupiah"/>
								<div class="input-group-append"><span class="input-group-text" id="basic-addon2"><strong>/Kg</strong></span></div>
							</div>
							@if ($errors->has('harga'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('harga') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Jumlah Stok</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="number" name="jumlah" value="{{ old('jumlah') }}" placeholder="" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
							@if ($errors->has('jumlah'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('jumlah') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group row">
							<div class="col-xl-12 text-center">
								<a href="{{ route('supplier.bahan.index') }}" class="btn btn-secondary">Kembali</a>
								<button class="btn btn-primary mb-2 mt-2" type="submit">Simpan</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

@endsection
@section('scripts')
<script type="text/javascript">
	function hanyaAngka(evt) {
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}

	var rupiah = document.getElementById('rupiah');
	rupiah.addEventListener('keyup', function(e){
		rupiah.value = formatRupiah(this.value, 'Rp. ');
	});

	function formatRupiah(angka, prefix){
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split           = number_string.split(','),
		sisa            = split[0].length % 3,
		rupiah          = split[0].substr(0, sisa),
		ribuan          = split[0].substr(sisa).match(/\d{3}/gi);

		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}

		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
	}
</script>
@endsection