@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Permintaan Order
	</div>
</div>
<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
					Permintaan Order
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
				<form action="{{ route('order.store') }}" method="POST">
					@csrf
					<!-- <div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Kebutuhan Bahan</label>
						<div class="col-sm-2">
							<div class="input-group mb-3">
								<input class="form-control" type="number" name="kebutuhan" value="{{ $persediaan->stok }}" placeholder="Masukan kebutuhan jumlah persediaan bahan" onkeypress="return event.charCode >= 48 && event.charCode <=57" readOnly>
								<div class="input-group-append"><span class="input-group-text" id="basic-addon2">Kg</span></div>
							</div>
							@if ($errors->has('kebutuhan'))
							<span class="invalid-feedback">
								<strong>{{ $errors->first('kebutuhan') }}</strong>
							</span>
							@endif
						</div>
					</div> -->
					<div class="form-group row">
						<label class="col-sm-3 col-form-label text-right">Pilih Supplier</label>
						<div class="col-sm-8">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th data-check-all="">
											<div class="checkbox c-checkbox" data-toggle="tooltip" data-title="Check All" data-original-title="" title=""><label><input type="checkbox"><span class="fa fa-check"></span></label></div>
										</th>
										<th class="text-center">Supplier</th>
										<th class="text-center">Bahan</th>
										<th class="text-center">Stok (Kg)</th>
										<th class="text-center">Harga</th>
										<th class="text-center">Kebutuhan Order</th>
									</tr>
								</thead>
								<tbody>
									@foreach($bahan as $row)
									<tr>
										<td class="text-center">
											<div class="checkbox c-checkbox">
												<label>
													<div class="checkbox c-checkbox">
														<label>
															<input type="checkbox" name="bahan_id[]" id="bahan_id" value="{{ $row->id }}">
															<span class="fa fa-check"></span>
														</label>
													</div>
												</label>
											</div>
										</td>
										<td>{{ $row->Supplier->nama }}</td>
										<td>{{ $row->nama }}</td>
										<td class="text-center">{{ $row->jumlah }}</td>
										<td class="text-right">@rupiah($row->harga)</td>
										<td class="text-center">
											<div class="input-group">
												<input class="form-control" type="number" name="jumlah[]" value="{{ old('jumlah') }}" placeholder="Jumlah Order" onkeypress="return event.charCode >= 48 && event.charCode <=57">
												<div class="input-group-append"><span class="input-group-text" id="basic-addon2">Kg</span></div>
											</div>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group row">
						<div class="col-xl-12 text-center">
							<a href="{{ route('order.index') }}" class="btn btn-secondary">Kembali</a>
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