@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Pengguna
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Edit pengguna
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
				<form action="{{ route('user.update', $user->hashid) }}" method="POST">
					@method('PUT')
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Nama</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="nama" value="{{ old('nama') ? old('nama') : $user->nama }}" placeholder="" />
							@if ($errors->has('nama'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('nama') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Email</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="email" value="{{ old('email') ? old('email') : $user->email }}" placeholder="" />
							@if ($errors->has('email'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Hak Akses</label>
						<div class="col-sm-7">
							<select class="form-control" name="role" required="">
								<option value="">-- Pilih Hak Akses --</option>
								<option {{ $user->role == 1 ? 'selected' : '' }} value="1">Superadmin</option>
								<option {{ $user->role == 2 ? 'selected' : '' }} value="2">Pemilik</option>
								<option {{ $user->role == 3 ? 'selected' : '' }} value="3">Supplier</option>
								<option {{ $user->role == 4 ? 'selected' : '' }} value="4">Distributor</option>
							</select>
							@if ($errors->has('role'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('role') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Username</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" required type="text" name="username" value="{{ old('username') ? old('username') : $user->username }}" placeholder="" />
							@if ($errors->has('username'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('username') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Ganti Password</label>
						<div class="col-sm-7">
							<input autofocus class="form-control" type="password" name="password" value="{{ old('password') }}" placeholder="" />
							<small>*Abaikan password jika tidak ingin merubah password</small>
							@if ($errors->has('password'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('password') }}</strong>
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