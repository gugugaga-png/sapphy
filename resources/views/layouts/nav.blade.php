<header class="navbar navbar-expand-md d-print-none">
  <div class="container-fluid container-xl d-flex justify-content-between align-items-center">
    <a href="/questions" class="navbar-brand navbar-brand-autodark me-3">
      <img src="{{ asset('image/logo.svg') }}" alt="My Image" width="110" height="32">
    </a>

    @if(auth()->check() && auth()->user()->role->name === 'admin')
    <ul class="navbar-nav d-none d-md-flex me-auto">
      <li class="nav-item">
        <a class="nav-link" href="{{ route('questions.index') }}">Questions</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('categories.index') }}">Categories</a>
      </li>
    </ul>
    @endif

    @if(Route::currentRouteName() === 'questions.index')
    <form action="#" class="me-3 d-flex" style="width:40%;" data-bs-toggle="modal" data-bs-target="#searchModal">
      <div class="input-group">
        <input type="text" class="form-control" placeholder="Cari pertanyaan..." readonly>
        <button class="btn btn-dark" type="button">
          <i class="bi bi-search"></i>
        </button>
      </div>
    </form>
    @endif

    <div class="d-flex align-items-center">
      <button class="navbar-toggler d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-nav flex-row order-md-last d-none d-md-flex">
        @auth
        <div class="nav-item dropdown">
          <a href="#" class="nav-link d-flex lh-1 text-reset" data-bs-toggle="dropdown" aria-label="User menu">
            <div style="width: 40px; height: 40px; overflow: hidden; border-radius: 50%;">
              @if(auth()->user()->profile_photo)
              <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil" style="width: 100%; height: 100%; object-fit: cover;">
              @else
              <img src="{{ asset('image/default-avatar.jpg') }}" alt="Default Avatar" style="width: 100%; height: 100%; object-fit: cover;">
              @endif
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <a href="/profile" class="dropdown-item">Edit Profile</a>
            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              @csrf
            </form>
          </div>
        </div>
        @endauth

        @guest
        <ul class="navbar-nav flex-row">
          <li class="nav-item me-2">
            <a class="nav-link" href="{{ route('login') }}">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('register') }}">Register</a>
          </li>
        </ul>
        @endguest
      </div>
    </div>
  </div>
</header>

<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasMenuLabel">Menu</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    @auth
    <div class="d-flex align-items-center mb-4">
      <div class="me-3">
        @if(auth()->check() && auth()->user()->profile_photo)
        <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" alt="Foto Profil" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
        @else
        <img src="{{ asset('image/default-avatar.jpg') }}" alt="Default Avatar"
                  style="width: 100%; height: 100%; object-fit: cover;">
        @endif
      </div>
      <div>
        <span>Hi, {{ auth()->user()->name }}</span>
      </div>
    </div>
    @endauth

    <ul class="navbar-nav">
      @if(auth()->check())
      @if(auth()->user()->role->name === 'admin')
      <li class="list-item fs-3">
        <a class="nav-link p-2 d-flex align-items-center" href="/questions">
          <i class="bi bi-question-circle me-2"></i> Questions
        </a>
      </li>
      <li class="list-item fs-3">
        <a class="nav-link p-2 d-flex align-items-center" href="/categories">
          <i class="bi bi-tags me-2"></i> Categories
        </a>
      </li>
      @else
      <li class="list-item fs-3">
        <a class="nav-link p-2 d-flex align-items-center" href="/questions">
          <i class="bi bi-house-door-fill me-2"></i> Home
        </a>
      </li>
      @endif
      <li class="list-item fs-3">
        <a class="nav-link p-2 d-flex align-items-center" href="/profile">
          <i class="bi bi-person-circle me-2"></i> Edit Profile
        </a>
      </li>
      <li class="list-item fs-3">
        <a class="nav-link p-2 d-flex align-items-center text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="bi bi-box-arrow-right me-2 "></i> Logout
        </a>
      </li>
      
      
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
      </form>
      @else
      <li class="list-item fs-3 ">
        <a class="nav-link" href="{{ route('login') }}">Login</a>
      </li>
      <li class="list-item fs-3 ">
        <a class="nav-link" href="{{ route('register') }}">Register</a>
      </li>
      @endif
    </ul>
  </div>
</div>

<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="searchModalLabel">Pencarian Pertanyaan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="GET" action="{{ route('questions.index') }}">
          <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
            <button class="btn btn-light" type="submit"><i class="bi bi-search"></i></button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
