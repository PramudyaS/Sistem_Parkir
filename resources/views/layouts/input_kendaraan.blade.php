@extends('master_layout.master')

@section('title','Input Kendaraan Masuk')


@section('content')
<form action="/transaksi/StoreInput" method="post">
<div class="row">
	<div class="col-md-6 offset-md-3">
	<br><br><br>
	<div class="card card-default">
		<div class="card-header">
			<h3>Input Kendaraan</h3>
		</div>
		<div class="card-body">
			<div class="col-md-12">
				<div class="form-group">
				<label for="">No Polisi</label>
				<input type="text" name="no_polisi" value="" placeholder="" class="form-control{{ $errors->has('no_polisi') ? ' is-invalid' : '' }}" autocomplete="off" maxlength="7">
				@if ($errors->has('no_polisi'))
					<span class="help-block">
						<p style="color:red">Alert  {{ $errors->first('no_polisi') }}</p>
					</span>
				@endif
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Jenis Kendaraan</label>
					<select name="jenis_kendaraan" id="jenis_kendaraan" class="form-control{{ $errors->has('jenis_kendaraan') ? ' is-invalid' : '' }}">
						<option value="">Pilih Kendaraan</option>
						@foreach ($jenis_kendaraan as $datas)
							<option value="{{ $datas->jenis_kendaraan }}">{{ $datas->jenis_kendaraan }}</option>
						@endforeach
					</select>
					@if ($errors->has('jenis_kendaraan'))
						<span class="help-block">
							<p style="color:red">Alert {{ $errors->first('jenis_kendaraan') }}</p>
						</span>
					@endif
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Tarif</label>
					<input type="number" name="tarif" id="tarifs" value="" placeholder="" class="form-control{{ $errors->has('tarif') ? ' is-invalid' : ''  }} text-center" readonly="">
					@if ($errors->has('tarif'))
						<span class="help-block">
							<p style="color:red">Alert {{ $errors->first('tarif') }}</p>
						</span>
					@endif
				</div>
			</div>
			<div class="col-md-12">
				<div class="form-group">
					<label for="">Tanggal Masuk</label>
					<input type="text" name="tgl_masuk" value="{{ $automatic_date }}" placeholder="" class="form-control{{ $errors->has('tgl_masuk') ? ' is-invalid' : '' }} text-center" readonly="">
					@if ($errors->has('tgl_masuk'))
						<span class="help-block">
							<p style="color:red">Alert {{ $errors->first('tgl_masuk') }}</p>
						</span>
					@endif
				</div>
			</div>
			<br>
			{{ csrf_field() }}
			<div class="row">
			<div class="col-md-12">
				<button type="submit" class="btn btn-outline-primary btn-block" name="simpan">Simpan</button>
			</div>
			</div>
		</div>
	</div>
	</div>
</div>
</form>


@endsection