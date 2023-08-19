@extends('layouts.template')


@section('styles')
<style type="text/css">
	.btn-primary {
		color: #fff !important;
	}
</style>
@endsection


@section('content')
<div class="row">

	<div class="col-lg-12">
		<div class="card">
			<div class="card-header">
				<h4 class="card-title"> 
					<span class="d-inline-block">
						{{ $title ?? 'Judul' }}
					</span>

					@if($permohonan->status == 'Tertunda')
					<a class="btn btn-primary float-right" href="{{ route('permohonan.konfirmasi_permohonan', $permohonan->id_permohonan) }}">
						<i class="fa fa-pencil-alt mr-2"></i> Konfirmasi Permohonan
					</a>
					@endif
				</h4>
			</div>

			<div class="card-body">
				<div class="row">
					<div class="col-lg-6">
						<div class="mb-3">
							<div class="mb-2"><b> Nomor Pendaftaran </b></div>
							<div> {{ $permohonan->no_pendaftaran }} </div>
						</div>

						<div class="mb-3">
							<div class="mb-2"><b> Nama Yayasan </b></div>
							<div> {{ $permohonan->nama_yayasan }} </div>
						</div>

						<div class="mb-3">
							<div class="mb-2"><b> Nama Ketua Yayasan </b></div>
							<div> {{ $permohonan->nama_ketua_yayasan }} </div>
						</div>

						<div class="mb-3">
							<div class="mb-2"><b> Email </b></div>
							<div> {{ $permohonan->email }} </div>
						</div>

						<div class="mb-3">
							<div class="mb-2"><b> Nomor Telepon </b></div>
							<div> {{ $permohonan->no_telp }} </div>
						</div>
					</div>

					<div class="col-lg-6">
						<div class="mb-3">
							<div class="mb-2"><b> Tanggal Permohonan </b></div>
							<div> {{ $permohonan->created_at->format('d/m/Y') }} </div>
						</div>

						<div class="mb-3">
							<div class="mb-2"><b> Nama PKBM </b></div>
							<div> {{ $permohonan->nama_pendidikan }} </div>
						</div>

						<div class="mb-3">
							<div class="mb-2"><b> Nama Ketua PKBM </b></div>
							<div> {{ $permohonan->nama_kepala_pendidikan }} </div>
						</div>

						<div class="mb-3">
							<div class="mb-2"><b> Alamat Lengkap </b></div>
							<div> {{ $permohonan->alamat }} </div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="card-header">
				<h4 class="card-title"> 
					<span class="d-inline-block">
						Persyaratan
					</span>
				</h4>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<tr>
								<th width="50"> No. </th>
								<th> Nama Persyaratan </th>
								<th> Input </th>
							</tr>
						</thead>
						<tbody>
							@foreach($permohonan->permohonanDetail as $detail)
							<tr>
								<td> {{ $loop->iteration }} </td>
								<td> {{ $detail->namaPersyaratan() }} </td>
								<td> {!! $detail->response() !!} </td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection