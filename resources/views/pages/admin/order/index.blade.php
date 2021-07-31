@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Order {{ ucwords($status) }}
	</div>
</div>
<div class="container-fluid">
	<div class="card">
		<div class="card-header" style="font-size: 15px;">
			@if( session('msg-stok') )
			<?php $msg = session('msg-stok'); ?>
			<div class="alert alert-{{ $msg['type'] }} alert-remove">
				{!! $msg['text'] !!}
			</div>
			@endif
			<strong>Jumlah Stok Bahan Baku Saat Ini :</strong>
			<br>
			<table>
				<thead>
					<tr>
						<th>
							Bawang Merah Mentah
						</th>
						<th class="pl-5"> :
							@if($stok_bawang <= 100 && $stok_bawang > 0)
							<span class="badge badge-pill badge-warning">{{ 'Stok Bawang Hampir Habis ('.$stok_bawang.')' }}</span>
							@elseif($stok_bawang <= 0)
							<span class="badge badge-pill badge-danger">{{ 'Stok Bawang Habis' }}</span>
							@else
							<span class="badge badge-pill badge-success">{{ $stok_bawang > 0 ? $stok_bawang.'Kg' : '0' }}</span>
							@endif
						</th>
						<th class="pl-4">
							<a href="" class="btn btn-sm btn-purple open-form-stok" data-toggle="modal" data-name="bahan" data-id='{{ "Bawang Merah Mentah" }}' data-target="#stok"><em class="fas fa-calculator"></em></a>
						</th>
					</tr>
					<tr>
						<th>
							Tepung
						</th>
						<th class="pl-5"> :
							@if($stok_tepung <= 100 && $stok_tepung > 0)
							<span class="badge badge-pill badge-warning">{{ 'Stok Tepung Hampir Habis ('.$stok_tepung.')' }}</span>
							@elseif($stok_tepung <= 0)
							<span class="badge badge-pill badge-danger">{{ 'Stok Tepung Habis' }}</span>
							@else
							<span class="badge badge-pill badge-success">{{ $stok_tepung > 0 ? $stok_tepung.'Kg' : '0' }}</span>
							@endif
						</th>
						<th class="pl-4">
							<a href="" class="btn btn-sm btn-purple open-form-stok" data-name="bahan" data-toggle="modal" data-id='{{ "Tepung" }}' data-target="#stok"><em class="fas fa-calculator"></em></a>
						</th>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
<div class="container-fluid">
	<!-- DATATABLE DEMO 1-->
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<a href="{{ route('order.index') }}?status=baru" class="{{ $status == 'baru' ? 'text-info':'text-muted' }}"> Order Baru
					<span class="badge badge-pill badge-info">{{ $baru_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('order.index') }}?status=diterima" class="{{ $status == 'diterima' ? 'text-success':'text-muted' }}"> Order Diterima
					<span class="badge badge-pill badge-success">{{ $diterima_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('order.index') }}?status=retur" class="{{ $status == 'retur' ? 'text-warning':'text-muted' }}"> Pesanan Retur
					<span class="badge badge-pill badge-warning">{{ $retur_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('order.index') }}?status=trash" class="{{ $status == 'trash' ? 'text-danger':'text-muted' }}">
					Sampah
					<span class="badge badge-pill badge-danger">{{ $trash_count }}</span>
				</a>
				<div class="float-right">
					<a href="{{ route('order.create') }}" class="btn btn-primary btn-sm">Tambah Order</a>
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
			<div class="responsive">
				<table class="table table-bordered table-hover" id="datatable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Detail Order</th>
							<th class="text-center">Status Order</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@if($records->count()>0)
						@foreach($records as $row)
						<tr>
							<td class="text-center">{{ $loop->iteration }}</td>
							<td class="text-left">
								<li>{{ $row->Bahan->nama }} ({{ $row->Bahan->Supplier->nama }})</li>
								<li>{{ $row->jumlah }} {{ $row->Bahan->satuan }}</li>
								<li>@rupiah($row->harga)/{{ $row->Bahan->satuan }}</li>
								<li>Di pesan pada tanggal <span class="badge badge-warning">{{ tanggalIndo($row->tanggal) }}</span></li>
								<li>
									@if($row->bukti_pembayaran)
									<a href="{{ asset('storage/bukti_pembayaran/'.$row->bukti_pembayaran) }}" target="_blank">Lihat Bukti Pembayaran</a>
									@else
									<span class="badge badge-secondary">Pembayaran Pending</span>
									@endif
								</li>
								<h4 class="text-info mt-2">Total Bayar</h4>
								<h4 class="text-inverse">@rupiah($row->harga*$row->jumlah)</h4>
								@if($row->deleted_at)
								<hr>
								Alasan Cancel : {{ $row->alasan_cancel }}
								@endif
								@if($row->status == 3)
								Alasan Retur : {{ $row->alasan_retur }}
								@endif
							</td>        
							<td class="text-center">
								@if($row->status == 0)
								<span class="badge badge-secondary">Permintaan Pending</span>
								@elseif($row->status == 1)
								<span class="badge badge-success">Permintaan Diterima</span>
								@elseif($row->status == 2)
								<span class="badge badge-success">Selesai</span>
								@elseif($row->status == 3)
								<span class="badge badge-warning">Retur</span>
								@endif
							</td>                    
							<td class="text-center">
								@if($row->deleted_at == null)
								@if($row->status == 0)
								<span class="badge badge-danger btn open-form-cancel" data-toggle="modal" data-id='{{ $row->id }}' data-target="#penolakan">Cancel</span>
								<a href="{{ route('order.form.upload', $row->hashid) }}" class="badge badge-info btn">Upload</a>
								@elseif($row->status == 1)
								<a href="{{ route('order.proses', $row->hashid) }}?status=2" class="badge badge-success btn d-block">Bahan Diterima</a>
								<a href="#" class="badge badge-danger btn d-block mt-2 open-form-retur" data-toggle="modal" data-id='{{ $row->id }}' data-target="#retur">Retur Bahan</a>
								@else
								-
								@endif
								@else
								<button type="button" class="btn btn-success btn-sm" onclick="restore('{{ $row->hashid }}')" title="Restore">Restore</button>
								<button type="button" title="destroy" onclick="willRemove('{{ $row->hashid }}','DESTROY')" class="btn btn-danger btn-sm">Destroy</button>
								@endif
							</td>
						</tr>
						@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<form id="action-form" action="" method="POST">
	{{ csrf_field() }}
	{{ method_field('PATCH') }}
	<input type="hidden" name="id">
</form>
@section('body-area')
<div class="modal fade" id="penolakan" role="dialog" aria-labelledby="penolakan" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="penolakan">Cancel Pesanan</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{ route('order.delete') }}" method="post">
					@method('PATCH')
					@csrf
					<div class="form-group">
						<div class="modal-body-cancel">
							<input type="hidden" name="id" id="id-cancel" class="form-control" readonly />
							<b>&nbsp;Alasan Cancel</b>
							<input type="text" required name="alasan" class="form-control" placeholder="Tuliskan sesuatu disini" />
						</div>
					</div>
					<p class="text-center">
						<button class="btn btn-primary"><i class="fas fa-sync-alt"></i> Proses</button>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="retur" role="dialog" aria-labelledby="retur" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="retur">Retur Pesanan</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{ route('order.retur') }}" method="post">
					@method('PATCH')
					@csrf
					<div class="form-group">
						<div class="modal-body-retur">
							<input type="hidden" name="id" id="id-retur" class="form-control" readonly />
							<b>&nbsp;Alasan Retur</b>
							<input type="text" required name="alasan" class="form-control" placeholder="Tuliskan sesuatu disini" />
						</div>
					</div>
					<p class="text-center">
						<button class="btn btn-primary"><i class="fas fa-sync-alt"></i> Proses</button>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="stok" role="dialog" aria-labelledby="stok" aria-hidden="true">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="stok">Stok Bahan Terpakai</h4>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<form action="{{ route('stok.update') }}" method="post">
					@csrf
					<div class="form-group">
						<div class="modal-body-stok">
							<input type="hidden" name="bahan" id="bahan-stok" class="form-control" readonly/>
							<input type="hidden" name="target" id="target-stok" class="form-control" readonly/>
							<b>&nbsp;Jumlah Bahan (Kg)</b>
							<input autofocus class="form-control" required type="number" name="jumlah" value="{{ old('jumlah') }}" placeholder="Masukan Jumlah Bahan Terpakai" onkeypress="return event.charCode >= 48 && event.charCode <=57"/>
						</div>
					</div>
					<p class="text-center">
						<button class="btn btn-primary"><i class="fas fa-sync-alt"></i> Simpan</button>
					</p>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@endsection
@section('scripts')
<script src="{{ mix('/js/sweetalert.js') }}"></script>
<script src="{{ mix('/js/datatable.js') }}"></script>
<script type="text/javascript">

	$(document).on("click", ".open-form-stok", function () {
		var bahan = $(this).data('id');
		var target = $(this).data('name');
		console.log('bahan', bahan);
		console.log('target', target);
		$(".modal-body-stok #bahan-stok").val( bahan );
		$(".modal-body-stok #target-stok").val( target );
	});

	$(document).on("click", ".open-form-cancel", function () {
		var id = $(this).data('id');
		console.log('id', id);
		$(".modal-body-cancel #id-cancel").val( id );
	});

	$(document).on("click", ".open-form-retur", function () {
		var id = $(this).data('id');
		console.log('id', id);
		$(".modal-body-retur #id-retur").val( id );
	});

	$(document).ready(function(){
		$('#datatable').DataTable();
	});

	function execRemove(method, hashid) {
		$("#action-form").attr('action', 'order/delete/' + hashid);
		$("#action-form input[name=_method]").val(method);
		$("#action-form").submit();
	}

	function willRemove(id, method) {
		swal({
			title: "Apakah Anda Yakin?",
			text: "anda yakin menghapus pesanan ini?",
			icon: "warning",
			buttons: ["Batal", "Ya"]
		})
		.then(function(willDelete) {
			if (willDelete) {
				if (method === "DELETE") execRemove('PATCH', id)
					else execRemove('DELETE', id)
				}
		});
	};

	function restore (hashid) {
		$("#action-form").attr('action', 'order/restore/' + hashid);
		$("#action-form input[name=_method]").val("POST");
		$("#action-form").submit();
	};
</script>
@endsection