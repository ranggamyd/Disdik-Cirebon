<li><a class="nav-link" href="{{ url('/') }}"> Home </a></li>
<li><a class="nav-link" href="{{ url('pilih-satuan-pendidikan') }}"> Buat Permohonan </a></li>
<li><a class="nav-link" href="{{ url('cek-permohonan') }}"> Cek Permohonan </a></li>
<li><a class="nav-link " href="{{ url('tentang') }}"> Tentang </a></li>

@if (auth()->guest())
    <li><a class="nav-link" href="{{ route('login') }}"> Login </a></li>
@else
    <li class="dropdown">
        <a href="#"><span> <i class="bi bi-user"></i> {{ auth()->user()->nama }} </span> <i
                class="bi bi-chevron-down"></i></a>
        <ul>
            <li><a href="{{ url('dashboard') }}"> Dashboard </a></li>
            <li><a href="{{ url('logout') }}"> Logout </a></li>
        </ul>
    </li>
@endif
