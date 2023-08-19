<li class="nav-item">
	<a href="{{ route('dashboard') }}">
		<i class="fas fa-home"></i>
		<p>Dashboard</p>
	</a>
</li>

@if(auth()->user()->role == 'Admin')
<li class="nav-section">
	<span class="sidebar-mini-icon">
		<i class="fa fa-ellipsis-h"></i>
	</span>
	<h4 class="text-section"> Master Data </h4>
</li>

<li class="nav-item">
	<a href="{{ route('user') }}">
		<i class="fas fa-user"></i>
		<p> User </p>
	</a>
</li>

<li class="nav-item">
	<a href="{{ route('kategori_pendidikan') }}">
		<i class="fas fa-list-alt"></i>
		<p> Kategori Pendidikan </p>
	</a>
</li>

<li class="nav-item">
	<a href="{{ route('pendidikan') }}">
		<i class="fas fa-school"></i>
		<p> Pendidikan </p>
	</a>
</li>

<li class="nav-item">
	<a href="{{ route('persyaratan') }}">
		<i class="fas fa-check-square"></i>
		<p> Persyaratan </p>
	</a>
</li>


<li class="nav-section">
	<span class="sidebar-mini-icon">
		<i class="fa fa-ellipsis-h"></i>
	</span>
	<h4 class="text-section"> Data Permohonan </h4>
</li>

<li class="nav-item">
	<a href="{{ route('permohonan') }}">
		<i class="fas fa-users"></i>
		<p> Permohonan </p>
	</a>
</li>

@else

<li class="nav-section">
	<span class="sidebar-mini-icon">
		<i class="fa fa-ellipsis-h"></i>
	</span>
	<h4 class="text-section"> Permohonan </h4>
</li>

<li class="nav-item">
	<a href="{{ route('permohonan_perizinan') }}">
		<i class="fas fa-users"></i>
		<p> Permohonan Perizinan </p>
	</a>
</li>
@endif


<li class="nav-section">
	<span class="sidebar-mini-icon">
		<i class="fa fa-ellipsis-h"></i>
	</span>
	<h4 class="text-section"> Konfigurasi </h4>
</li>

<li class="nav-item">
	<a data-toggle="collapse" href="#menu-setting">
		<i class="fas fa-wrench"></i>
		<p> Pengaturan </p>
		<span class="caret"></span>
	</a>
	<div class="collapse" id="menu-setting">
		<ul class="nav nav-collapse">
			<li>
				<a href="{{ route('setting.change_password') }}">
					<i class="fas fa-key"></i>
					<p> Ganti Password </p>
				</a>
			</li>
		</ul>
	</div>
</li>