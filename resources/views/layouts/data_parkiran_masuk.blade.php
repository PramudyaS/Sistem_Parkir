@extends('master_layout.master')

@section('title','Data Parkiran Masuk')


@section('content')
<div class="row">
	<div class="col-md-10 offset-md-1">
		<br><br>
		@if (session('message'))
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<h3>Success <span class="fa fa-check"></span></h3>
				<hr style="margin-top:-0.6%">
				{{ session('message') }}
				<button type="button" class="close" data-dismiss="alert">
					<span>&times;</span>
				</button>
			</div>
		@endif
		<br><br>
		<table class="table table-bordered table-striped" id="example" width="100%">
			<thead>
				<th class="text-center">No</th>
				<th class="text-center">No Polisi</th>
				<th class="text-center">Jenis Kendaraan</th>
				<th class="text-center">Jam masuk</th>
				<th class="text-center">Tanggal Masuk</th>
				<th class="text-center">Action</th>
			</thead>
			<tbody>
				@if (count($data) <= 0)
					<tr>
						<td colspan="6" class="text-center">Data Empty</td>
					</tr>
				@else
				@foreach ($data as $datas)
				<tr>
				<td class="text-center">{{ $no++ }}</td>
				<td class="text-center">{{ $datas->plat_nomor }}</td>
				<td class="text-center">{{ $datas->jenis_kendaraan }}</td>
				<td class="text-center">{{ $datas->jam_masuk }}</td>
				<td class="text-center">{{ $datas->tgl_masuk }}</td>
				<td>
					<div class="btn-group" style="margin-left:17%">
					<a href="/transaksi/editDataParkiranMasuk/{{ $datas->id }}" class="btn btn-success"><span class="fa fa-pencil"></span></a>
					<a href="/transaksi/ParkirSelesai/{{ $datas->id }}" class="btn btn-primary">Selesai</a>
					<a href="/transaksi/struk/{{ $datas->id }}" class="btn btn-dark">Struk</a>
					</div>
				</td>
				</tr>
				@endforeach
				@endif
			</tbody>
		</table>
	
	</div>
</div>


@endsection