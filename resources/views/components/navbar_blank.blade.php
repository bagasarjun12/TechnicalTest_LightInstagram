<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="w-25">
        <a href="/dashboard" class="logo-container">
            <img src="{{ asset('images/logo_light_instagram.png') }}" alt="Instagram Logo" class="logo">
        </a>
    </div>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <div class="ml-auto d-flex align-items-center dropdown cursor_pointer" id="profileDropdown">
            <div class="d-flex align-items-center" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                <img src="{{ asset('images/' . Auth::user()->photo) }}" alt="Profile Picture" class="profile-pic">
                <span class="ml-2">{{ Auth::user()->username }}</span>
            </div>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileDropdown">
                <a class="dropdown-item" href="/account"><i class="fas fa-user-cog gradient-icon m-2"></i> Profile</a>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt gradient-icon m-2"></i> Logout</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</nav>