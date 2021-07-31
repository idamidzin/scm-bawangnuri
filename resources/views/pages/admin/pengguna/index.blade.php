@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Data Pengguna
	</div>
</div>
<div class="container-fluid">
	<!-- DATATABLE DEMO 1-->
	<div class="card">
		<div class="card-header">
			<div class="card-title">
				<a href="{{ route('user.index') }}?req=Supplier" class="{{ $req == 'Supplier' ? 'text-info':'text-muted' }}"> Supplier
					<span class="badge badge-pill {{ $req == 'Supplier' ? 'bg-info':'bg-gray-lighter' }}">{{ $supplier_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('user.index') }}?req=Distributor" class="{{ $req == 'Distributor' ? 'text-success':'text-muted' }}"> Distributor
					<span class="badge badge-pill {{ $req == 'Distributor' ? 'bg-success':'bg-gray-lighter' }}">{{ $distributor_count }}</span>
				</a>
				&nbsp; | &nbsp;
				<a href="{{ route('user.index') }}?req=Trash" class="{{ $req == 'Trash' ? 'text-danger':'text-muted' }}">
					Trash
					<span class="badge badge-pill {{ $req == 'Trash' ? 'bg-danger':'bg-gray-lighter' }}">{{ $trash_count }}</span>
				</a>
				<div class="float-right">
					<!-- <a href="{{ route('user.create') }}" class="btn btn-primary">Data Baru</a> -->
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
			<div class="table-responsive">
				<table class="table table-bordered table-hover" id="datatable">
					<thead>
						<tr>
							<th class="text-center">No</th>
							<th class="text-center">Aksi</th>
							<th class="text-center">Nama</th>
							<th class="text-center">Email</th>
							<th class="text-center">No Hp</th>
							<th class="text-center">KTP</th>
							<th class="text-center">Jenis Kelamin</th>
							<th class="text-center">No Rekening</th>
							<th class="text-center">Alamat</th>
						</tr>
					</thead>
					<tbody>
						@if($records->count()>0)
						@foreach($records as $row)
						<tr>
							<td class="text-center">{{ $loop->iteration }}</td>
							<td class="text-center">
								@if($row->deleted_at == null)
								<button type="button" title="delete" onclick="willRemove('{{ $row->hashid }}','DELETE')" class="btn btn-danger btn-sm"> 
									<i class="fa fa-trash"></i>
								</button>
								@if($row->is_valid == NULL || $row->is_valid == 0)
								<br>
								<button type="button" title="validasi akun" onclick="willValidasi('{{ $row->hashid }}','PUT')" class="btn btn-success btn-sm mt-2"> 
									<i class="fas fa-check-circle"></i>
								</button>
								@endif
								@else
								<button type="button" class="btn btn-success btn-sm" onclick="restore('{{ $row->hashid }}')" title="Restore">Restore</button>
								<button type="button" title="destroy" onclick="willRemove('{{ $row->hashid }}','DESTROY')" class="btn btn-danger btn-sm">Destroy</button>
								@endif
							</td>
							<td>{{ $row->nama }}</td>
							<td>{{ $row->email }}</td>                               
							<td class="text-center">{{ $row->nohp }}</td>                               
							<td class="text-center">
								@if($row->ktp)
									<a href="{{ asset('storage/ktp/'.$row->ktp) }}" target="_blank">	
										<img src="{{ asset('storage/ktp/'.$row->ktp) }}" width="200px">
									</a>
								@else
									-
								@endif
							</td>                               
							<td class="text-center">{{ $row->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>                               
							<td class="text-center">{{ $row->nama_rekening.' '.$row->no_rekening }}</td>                               
							<td class="text-center">{{ $row->alamat ? $row->alamat : '-' }}</td>                               
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
@endsection
@section('scripts')
<script src="{{ mix('/js/sweetalert.js') }}"></script>
<script src="{{ mix('/js/datatable.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#datatable').DataTable();
	});

	function execRemove(method, hashid) {
		$("#action-form").attr('action', 'pengguna/delete/' + hashid);
		$("#action-form input[name=_method]").val(method);
		$("#action-form").submit();
	}


	function willRemove(id, method) {
		swal({
			title: "Apakah Anda Yakin?",
			text: "anda yakin menghapus data ini?",
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

	function execValidasi(method, hashid) {
		$("#action-form").attr('action', 'pengguna/validasi/' + hashid);
		$("#action-form input[name=_method]").val(method);
		$("#action-form").submit();
	}

	function willValidasi(id, method) {
		swal({
			title: "Apakah Anda Yakin?",
			text: "anda yakin akan memvalidasi akun ini?",
			icon: "warning",
			buttons: ["Batal", "Ya"]
		})
		.then(function(willValidasi) {
			if (willValidasi) {
				if (method === "PUT") execValidasi('PUT', id)
					else execValidasi('PUT', id)
				}
		});
	};

	function restore (hashid) {
		$("#action-form").attr('action', 'pengguna/restore/' + hashid);
		$("#action-form input[name=_method]").val("POST");
		$("#action-form").submit();
	};

	$(document).on('click','#call_id', function() {
		$.get("{{ route('call') }}",{call_id:$(this).val()},function(res){
			console.log('response', res);
		},'json');
	});
</script>
@endsection