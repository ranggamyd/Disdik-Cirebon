@extends('layouts.template')


@section('content')
	<div class="panel-header bg-custom-gradient">
		<div class="page-inner py-5">
			<div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
				<div>
					<h2 class="text-white pb-2 fw-bold"> Dashboard </h2>
				</div>
			</div>
		</div>
	</div>
	<div class="page-inner mt--5">
		<div class="row mt--2">
			<div class="col-lg-3 col-md-12">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row">
							<div class="col-5">
								<div class="icon-big text-center">
									<i class="flaticon-users text-primary"></i>
								</div>
							</div>
							<div class="col-7 col-stats">
								<div class="numbers">
									<p class="card-category"> Tertunda </p>
									<h4 class="card-title"> {{ \App\Models\Permohonan::where('status', 'Tertunda')->count() }} </h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-12">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row">
							<div class="col-5">
								<div class="icon-big text-center">
									<i class="flaticon-users text-success"></i>
								</div>
							</div>
							<div class="col-7 col-stats">
								<div class="numbers">
									<p class="card-category"> Diterima </p>
									<h4 class="card-title"> {{ \App\Models\Permohonan::where('status', 'Diterima')->count() }} </h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-12">
				<div class="card card-stats card-round">
					<div class="card-body">
						<div class="row">
							<div class="col-5">
								<div class="icon-big text-center">
									<i class="flaticon-users text-danger"></i>
								</div>
							</div>
							<div class="col-7 col-stats">
								<div class="numbers">
									<p class="card-category"> Ditolak </p>
									<h4 class="card-title"> {{ \App\Models\Permohonan::where('status', 'Ditolak')->count() }} </h4>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header">
						<h4 class="card-title"> 
							<span class="d-inline-block">
								Permohonan Tertunda
							</span>
							
						</h4>
					</div>

					<div class="card-body">
						<div class="table-responsive">
							<table class="table table-bordered" id="dataTable">
								
								<thead>
									<tr>
										<th> Nama Pemohon </th>
										<th> Tanggal </th>
										<th> Pendidikan </th>
										<th> Status </th>
										<th width="100"> Aksi </th>
									</tr>
								</thead>

								<tfoot>
									<tr>
										<th> Nama Pemohon </th>
										<th> Tanggal </th>
										<th> Pendidikan </th>
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
				url : "{{ route('permohonan') }}?status=Tertunda"
			},
			columns : [
				{
					data : "nama_yayasan",
					name : 'nama_yayasan'
				},
				{
					data : "created_at",
					name : 'created_at'
				},
				{
					data : "pendidikan.nama_pendidikan",
					name : 'pendidikan.nama_pendidikan'
				},
				{
					data : "status",
					name : 'status'
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