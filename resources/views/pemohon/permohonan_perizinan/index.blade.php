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

					<button class="btn btn-primary float-right" data-toggle="modal" data-target="#create-modal">
						<i class="fa fa-plus mr-2"></i> Buat
					</button>
				</h4>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable">
						
						<thead>
							<tr>
								<th> Tanggal </th>
								<th> No Pendaftaran </th>
								<th> Nama Yayasan </th>
								<th> Nama Pendidikan </th>
								<th> Status </th>
								<th width="100"> Aksi </th>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<th> Tanggal </th>
								<th> No Pendaftaran </th>
								<th> Nama Yayasan </th>
								<th> Nama Pendidikan </th>
								<th> Status </th>
								<th width="100"> Aksi </th>
							</tr>
						</tfoot>

					</table>
				</div>
			</div>
		</div>
	</div>

</div>
@endsection


@section('modal')
<div class="modal fade" id="create-modal" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form method="get" action="{{ route('permohonan_perizinan.create') }}">

				<div class="modal-header">
					<h5 class="modal-title"> 
						<i class="fa fa-plus"></i> Tambah 
					</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>

				<div class="modal-body">

					{!! Template::requiredBanner() !!}

					<div class="form-group">
						<label> Pendidikan {!! Template::required() !!} </label>
						<select class="form-control" name="id_pendidikan" required>
							<option selected disabled> - Pilih Pendidikan - </option>
							@foreach(\App\Models\Pendidikan::all() as $pendidikan)
							<option value="{{ $pendidikan->id_pendidikan }}"> {{ $pendidikan->nama_pendidikan }} ({{ $pendidikan->singkatan }}) </option>
							@endforeach
						</select>
						<span class="invalid-feedback"></span>
					</div>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal"> 
						<i class="fas fa-times mr-1"></i> Tutup 
					</button>
					<button type="submit" class="btn btn-primary"> 
						<i class="fas fa-save mr-1"></i> Buat 
					</button>
				</div>

			</form>
		</div>
	</div>
</div>
@endsection


@section('scripts')
<script>
	
	$(function(){

		$('#dataTable').DataTable({
			processing : true,
			serverSide : true,
			autoWidth : false,
			ajax : {
				url : "{{ route('permohonan_perizinan') }}"
			},
			columns : [
				{
					data : "created_at",
					name : 'created_at'
				},
				{
					data : "no_pendaftaran",
					name : 'no_pendaftaran'
				},
				{
					data : "nama_yayasan",
					name : 'nama_yayasan'
				},
				{
					data : "nama_pendidikan",
					name : 'nama_pendidikan'
				},
				{
					data : "status",
					name : 'status'
				},
				{
					data : 'pemohon_action',
					name : 'pemohon_action',
					orderable : false,
					searchable : false,
				}
			],
			drawCallback : settings => {
				renderedEvent();
			}
		})

		const reloadDT = () => {
			$('#dataTable').DataTable().ajax.reload();
		}

		const renderedEvent = () => {
			$.each($('.delete'), (i, deleteBtn) => {
				$(deleteBtn).off('click')
				$(deleteBtn).on('click', function(){
					let { deleteMessage, deleteHref } = $(this).data();
					confirmation(deleteMessage, function(){
						ajaxSetup()
						$.ajax({
							url: deleteHref,
							method: 'delete',
							dataType: 'json'
						})
						.done(response => {
							let { message } = response
							successNotification('Berhasil', message)
							reloadDT();
						})
						.fail(error => {
							ajaxErrorHandling(error);
						})
					})
				})
			})

		}

	})

</script>
@endsection