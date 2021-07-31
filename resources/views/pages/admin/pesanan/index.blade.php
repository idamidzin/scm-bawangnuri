@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Pesanan Produk {{ ucwords($status) }}
	</div>
</div>
<div class="container-fluid">
	<!-- DATATABLE DEMO 1-->
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<a href="{{ route('pesanan_produk.index') }}?status=baru" class="{{ $status == 'baru' ? 'text-info':'text-muted' }}"> Pesanan Baru
					<span class="badge badge-pill badge-info">{{ $baru_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('pesanan_produk.index') }}?status=diterima" class="{{ $status == 'diterima' ? 'text-success':'text-muted' }}"> Pesanan Diterima
					<span class="badge badge-pill badge-success">{{ $diterima_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('pesanan_produk.index') }}?status=retur" class="{{ $status == 'retur' ? 'text-warning':'text-muted' }}"> Pesanan Retur
					<span class="badge badge-pill badge-warning">{{ $retur_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('pesanan_produk.index') }}?status=trash" class="{{ $status == 'trash' ? 'text-danger':'text-muted' }}">
					Sampah
					<span class="badge badge-pill badge-danger">{{ $trash_count }}</span>
				</a>
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
			<div class="responsive">
				<table class="table table-bordered table-hover" id="datatable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Nama Pemesan</th>
							<th class="text-center">Detail Pesanan</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@if($records->count()>0)
						@foreach($records as $row)
						<tr>
							<td class="text-center">{{ $loop->iteration }}</td>
							<td>
								<strong class="text-dark">{{ $row->User->nama }}</strong>
								<p class="text-inverse">{{ $row->User->nohp }}<br>{{ $row->User->alamat }}</p>
							</td>
							<td class="text-left">
								<li>{{ $row->Produk->nama }}</li>
								<li>{{ $row->jumlah }} {{ $row->Produk->satuan }}</li>
								<li>@rupiah($row->harga)/{{ $row->Produk->satuan }}</li>
								<li>Di pesan pada tanggal <span class="badge badge-warning">{{ tanggalIndo($row->tanggal) }}</span></li>
								<li>
									@if($row->bukti_pembayaran)
									<a href="{{ asset('storage/bukti_pembayaran_order_produk/'.$row->bukti_pembayaran) }}" target="_blank">Lihat Bukti Pembayaran</a>
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
							</td>                            
							<td class="text-center">
								@if($row->deleted_at == null)
								@if($row->status == 0)
								<span class="badge badge-danger btn open-form" data-toggle="modal" data-id='{{ $row->id }}' data-target="#penolakan">Cancel</span>
								@if($row->bukti_pembayaran)
								<a href="{{ route('pesanan_produk.proses', $row->hashid) }}?status=1" class="badge badge-success btn">Terima</a>
								@endif
								@elseif($row->status == 1)
								<span class="badge badge-secondary">Menunggu</span>
								@elseif($row->status == 2)
								<span class="badge badge-success">Selesai</span>
								@elseif($row->status == 3)
								<a href="{{ route('pesanan_produk.proses_retur', $row->hashid) }}?status=1" class="badge badge-success btn d-block mt-2">Proses</a>
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
				<form action="{{ route('pesanan_produk.delete') }}" method="post">
					@method('PATCH')
					@csrf
					<div class="form-group">
						<div class="modal-body">
							<input type="hidden" name="id" id="id" class="form-control" readonly />
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
@endsection

@endsection
@section('scripts')
<script src="{{ mix('/js/sweetalert.js') }}"></script>
<script src="{{ mix('/js/datatable.js') }}"></script>
<script type="text/javascript">

	$(document).on("click", ".open-form", function () {
		var id = $(this).data('id');
		console.log('id', id);
		$(".modal-body #id").val( id );
	});

	$(document).ready(function(){
		$('#datatable').DataTable();
	});

	function execRemove(method, hashid) {
		$("#action-form").attr('action', 'pesanan-produk/delete/' + hashid);
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
		$("#action-form").attr('action', 'pesanan-produk/restore/' + hashid);
		$("#action-form input[name=_method]").val("POST");
		$("#action-form").submit();
	};
</script>
@endsection