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

	<div class="col-lg-4">

		<div class="card card-profile">

			<div class="card-header" style="background-image: url({{ url('img/bg.jpg') }})">
				<div class="profile-picture">
					<div class="avatar avatar-xl">
						<img src="{{ auth()->user()->avatarLink() }}" alt="..." class="avatar-img rounded-circle">
					</div>
				</div>
			</div>

			<div class="card-body">
				<div class="user-profile text-center">
					<div class="name"> {{ auth()->user()->name }} </div>
					<div class="job"> {{ auth()->user()->roleText() }} </div>
					<div class="email">
						@if(!empty(auth()->user()->email))
						<a href="mailto:{{ auth()->user()->email }}"> [{{ auth()->user()->email }}] </a>
						@else
						<span> No have email </span>
						@endif
					</div>
					<div class="phone">
						@if(!empty(auth()->user()->phone_number))
						<a href="tel:{{ auth()->user()->phone_number }}"> {{ auth()->user()->phone_number }} </a>
						@else
						<span> No have phone number </span>
						@endif
					</div>
					<br>
					<div class="view-profile">
						<a href="{{ route('profile.edit') }}" class="btn btn-secondary btn-block">
							Edit Profil
						</a>
					</div>
				</div>
			</div>
		</div>

	</div>

	<div class="col-lg-8">
		<div class="card">
			
			<div class="card-header">
				<h4 class="card-title"> 
					<span class="d-inline-block">
						Log Aktivitas
					</span>
				</h4>
			</div>

			<div class="card-body">
				<div class="table-responsive">
					
					<table class="table table-striped table-hover" id="dataTable">
						<thead>
							<tr>
								<th> No </th>
								<th> Tanggal </th>
								<th> Jam </th>
								<th> Aktivitas </th>
							</tr>
						</thead>

						<tbody>
							@foreach(auth()->user()->logs as $log)
							<tr>
								<td> {{ $loop->iteration }} </td>
								<td> {{ $log->dateText() }} </td>
								<td> {{ $log->timeText() }} </td>
								<td> {!! $log->activityHtml() !!} </td>
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


@section('scripts')
<script>
	
	$(function(){

		$('#dataTable').DataTable()

	})

</script>
@endsection