@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Tambah Produk
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Tambah Produk
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
				<form action="{{ route('produk.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Nama Produk</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="nama" value="{{ old('nama') }}" placeholder="" />
							@if ($errors->has('nama'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('nama') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Satuan</label>
						<div class="col-sm-7">
							<input type="text" name="satuan" value="{{ 'kg' }}" class="form-control" readonly="">
							@if ($errors->has('satuan'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('satuan') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Harga</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="harga" value="{{ old('harga') }}" placeholder="" onkeypress="return hanyaAngka(event)" id="rupiah"/>
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
							<input autofocus class="form-control" required type="number" name="stok" value="{{ old('stok') }}" placeholder="" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
							@if ($errors->has('stok'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('stok') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Foto Produk</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="file" name="foto" value="{{ old('foto') }}" placeholder="" />
							@if ($errors->has('foto'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('foto') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Keterangan</label>
						<div class="col-sm-7">
							<textarea autofocus class="form-control" required type="text" name="keterangan" value="{{ old('keterangan') }}" placeholder=""></textarea>
							@if ($errors->has('keterangan'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('keterangan') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group row">
							<div class="col-xl-12 text-center">
								<a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
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