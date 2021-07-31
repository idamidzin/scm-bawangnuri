@extends('layouts.app')
@section('content')
<div class="content-heading">
	<div>
		Form Upload Bukti Pembayaran Retur
	</div>
</div>

<div class="container">
	<div class="row">
		<div class="col-sm-4">
			<div class="card b mb-2">
				<div class="card-header bb">
					<h4 class="card-title">Rincian Order Retur</h4>
				</div>
				<div class="card-body bt">
					<h4 class="b0">Order #{{ $pesanan->hashid }}</h4>
					<span class="badge badge-info">{{ tanggalIndo($pesanan->tanggal) }}</span>
				</div>
				<table class="table">
					<tbody>
						<tr>
							<td>{{ $pesanan->Bahan->nama }}</td>
							<td>
								<div class="text-right text-bold"></div>
							</td>
						</tr>
						<tr>
							<td>Sub Total</td>
							<td>
								<div class="text-right text-bold">@rupiah($pesanan->harga)/Kg</div>
							</td>
						</tr>
						<tr>
							<td>Jumlah</td>
							<td>
								<div class="text-right text-bold">{{ $pesanan->jumlah }}Kg</div>
							</td>
						</tr>
					</tbody>
				</table>
				<div class="card-body">
					<div class="clearfix">
						<div class="float-right text-right">
							<div class="text-bold">@rupiah($pesanan->harga*$pesanan->jumlah)</div>
							<div class="text-sm">IDR</div>
						</div>
						<div class="float-left text-bold text-dark">Total Pembayaran</div>
					</div>
				</div>
				<div class="card-body text-center">
					<h6>Metode Pembayaran</h6>
					<h4>
						{{ $pesanan->User->nama_rekening }} <br>
						<strong class="text-inverse" style="font-size: 30px;">{{ $pesanan->User->no_rekening }}</strong> <br> 
						a.n {{ $pesanan->User->nama }}
					</h4>
				</div>
			</div>
		</div>
		<div class="col-sm-8">
			<div class="card b mb-2">
				<div class="card-header bb">
					<h4 class="card-title">Upload Bukti Retur</h4>
				</div>
				<div class="card-body">
					<form action="{{ route('supplier.pesanan.upload', $pesanan->hashid) }}" method="POST" enctype="multipart/form-data">
						@method('PUT')
						@csrf
						@if($pesanan->bukti_pembayaran_retur)
						<div class="input-group">
							<a href="{{ asset('storage/bukti_pembayaran_retur/'.$pesanan->bukti_pembayaran_retur) }}" target="_blank">Lihat Bukti</a>
						</div>
						@endif
						<div class="input-group">
							<input type="file" name="bukti_pembayaran" class="form-control" required>
						</div>
						<div class="form-group mt-2">
							<button type="submit" class="btn btn-primary">Kirim</button>
							<a href="{{ route('supplier.pesanan.index') }}" class="btn btn-secondary d-inline float-right">Kembali</a>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('scripts')

@endsection