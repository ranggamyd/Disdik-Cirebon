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

					<a class="btn btn-primary float-right" href="{{ route('persyaratan.create') }}">
						<i class="fa fa-plus"></i> Tambah
					</a>
					
				</h4>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered" id="dataTable">
						
						<thead>
							<tr>
								<th> Nama Persyaratan </th>
								<th> Pendidikan </th>
								<th> Status </th>
								<th> Tipe Input </th>
								<th width="100"> Aksi </th>
							</tr>
						</thead>

						<tfoot>
							<tr>
								<th> Nama Persyaratan </th>
								<th> Pendidikan </th>
								<th> Status </th>
								<th> Tipe Input </th>
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


@section('scripts')
<script>
	
	$(function(){

		$('#dataTable').DataTable({
			processing : true,
			serverSide : true,
			autoWidth : false,
			ajax : {
				url : "{{ route('persyaratan') }}"
			},
			columns : [
				{
					data : "nama_persyaratan",
					name : 'persyaratan.nama_persyaratan'
				},
				{
					data : "pendidikan.nama_pendidikan",
					name : 'pendidikan.nama_pendidikan'
				},
				{
					data : "status",
					name : 'status',
					orderable : false,
					searchable : false,
				},
				{
					data : "tipe_input",
					name : 'persyaratan.tipe_input'
				},
				{
					data : 'action',
					name : 'action',
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