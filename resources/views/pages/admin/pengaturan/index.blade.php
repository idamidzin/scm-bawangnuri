@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Pengaturan Persediaan Minimum
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Persediaan
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
				<form action="{{ route('pengaturan.update', $persediaan->hashid) }}" method="POST">
					@method('PUT')
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Persediaan Stok Bahan</label>
						<div class="col-sm-7">
							<input class="form-control" type="number" name="stok" value="{{ $persediaan->stok }}" placeholder="Masukan kebutuhan jumlah persediaan bahan" onkeypress="return event.charCode >= 48 && event.charCode <=57">
							@if ($errors->has('stok'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('stok') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group row">
							<div class="col-xl-12 text-center">
								<a href="{{ route('user.index') }}" class="btn btn-secondary">Kembali</a>
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

@endsection