@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Profile
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-6 offset-md-3">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Perbarui Profile Anda
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
				<form action="{{ route('distributor.profile.update', $user->hashid) }}" method="POST">
					@method('PUT')
					@csrf
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Nama</label>
						<div class="col-sm-7">
							<input class="form-control" type="text" name="nama" value="{{ $user->nama }}" placeholder="Masukan Nama Lengkap">
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
							<input class="form-control" type="email" name="email" value="{{ $user->email }}" placeholder="Masukan Email">
							@if ($errors->has('email'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('email') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Jenis Kelamin</label>
						<div class="col-sm-7">
							<select class="form-control" name="jenis_kelamin">
								<option @if($user->jenis_kelamin == "L") selected @endif value="L">Laki-laki</option>
								<option @if($user->jenis_kelamin == "P") selected @endif value="P">Perempuan</option>
							</select>
							@if ($errors->has('jenis_kelamin'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('jenis_kelamin') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Alamat</label>
						<div class="col-sm-7">
							<textarea class="form-control" name="alamat">{{ $user->alamat }}</textarea>
							@if ($errors->has('alamat'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('alamat') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">No HP</label>
						<div class="col-sm-7">
							<input class="form-control" type="number" name="nohp" value="{{ $user->nohp }}" placeholder="Masukan No HP" onkeypress="return event.charCode >= 48 && event.charCode <=57">
							@if ($errors->has('nohp'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('nohp') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Nama Rekening</label>
						<div class="col-sm-7">
							<input class="form-control" type="text" name="nama_rekening" value="{{ $user->nama_rekening }}" placeholder="Masukan Nama Rekening">
							@if ($errors->has('nama_rekening'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('nama_rekening') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">No Rekening</label>
						<div class="col-sm-7">
							<input class="form-control" type="number" name="no_rekening" value="{{ $user->no_rekening }}" placeholder="Masukan No Rekening" onkeypress="return event.charCode >= 48 && event.charCode <=57">
							@if ($errors->has('no_rekening'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('no_rekening') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right"><strong>Akun</strong></label>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Username</label>
						<div class="col-sm-7">
							<input class="form-control" type="text" name="username" value="{{ $user->username }}" placeholder="Masukan Username" disabled>
							@if ($errors->has('username'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('username') }}</strong>
							</span>
							@endif
						</div>
					</div>
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Password</label>
						<div class="col-sm-7">
							<input class="form-control" type="password" name="password" placeholder="Masukan Password Baru">
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