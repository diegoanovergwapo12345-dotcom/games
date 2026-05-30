<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
/* 🎮 CYBERPUNK NAVBAR */
.navbar-glass {
    background: rgba(5, 5, 5, 0.75);
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);

    border-bottom: 1px solid rgba(88,101,242,0.4);

    height: 70px;

    box-shadow:
        0 0 15px rgba(88,101,242,0.2),
        0 0 25px rgba(255,46,99,0.1);
}

/* prevent overlap */
body {
    padding-top: 80px;
    background: #0B0F19;
}

/* Logo */
.navbar-brand img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
}

/* Brand text */
.navbar-brand span {
    font-size: 18px;
    letter-spacing: 1px;
    color: #ffffff;
}

/* Nav buttons (gaming style) */
.navbar-glass .btn {
    transition: 0.3s;
    border-radius: 8px;
}

/* Login/Register buttons */
.navbar-glass .btn-outline-light {
    border: 1px solid #08F7FE;
    color: #08F7FE;
}

.navbar-glass .btn-outline-light:hover {
    background: #08F7FE;
    color: #000;
    box-shadow: 0 0 10px #08F7FE;
}

.navbar-glass .btn-light {
    background: linear-gradient(135deg, #FF2E63, #08F7FE);
    border: none;
    color: #000;
}

.navbar-glass .btn-light:hover {
    box-shadow: 0 0 15px rgba(255,46,99,0.4);
    transform: scale(1.05);
}

/* toggler */
.navbar-toggler {
    border: none;
}

.navbar-toggler:focus {
    box-shadow: none;
}

/* Profile dropdown */
.profile-dropdown-toggle {
    display: flex;
    align-items: center;
    gap: 10px;
    background: rgba(255, 255, 255, 0.05);
    border: 1px solid rgba(88, 101, 242, 0.3);
    border-radius: 40px;
    padding: 5px 14px 5px 5px;
    cursor: pointer;
    transition: all 0.25s ease;
    text-decoration: none;
    color: #fff;
}

.profile-dropdown-toggle:hover {
    background: rgba(88, 101, 242, 0.15);
    border-color: rgba(88, 101, 242, 0.6);
    box-shadow: 0 0 12px rgba(88, 101, 242, 0.25);
    color: #fff;
}

.profile-dropdown-toggle img {
    width: 34px;
    height: 34px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(88, 101, 242, 0.5);
}

.profile-dropdown-toggle .profile-name {
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 0.2px;
    max-width: 120px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}

.profile-dropdown-toggle .profile-caret {
    font-size: 0.7rem;
    opacity: 0.6;
    margin-left: 2px;
}

.profile-dropdown-menu {
    background: rgba(10, 14, 26, 0.97);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(88, 101, 242, 0.3);
    border-radius: 14px;
    box-shadow:
        0 8px 32px rgba(0, 0, 0, 0.5),
        0 0 20px rgba(88, 101, 242, 0.1);
    min-width: 200px;
    padding: 8px;
    margin-top: 8px !important;
}

.profile-dropdown-menu .dropdown-header {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 12px 14px;
    border-bottom: 1px solid rgba(255, 255, 255, 0.07);
    margin-bottom: 6px;
}

.profile-dropdown-menu .dropdown-header img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(88, 101, 242, 0.5);
    flex-shrink: 0;
}

.profile-dropdown-menu .dropdown-header .dh-name {
    font-size: 0.88rem;
    font-weight: 700;
    color: #fff;
    line-height: 1.2;
}

.profile-dropdown-menu .dropdown-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 12px;
    border-radius: 10px;
    color: rgba(255, 255, 255, 0.75);
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.2s ease;
    text-decoration: none;
}

.profile-dropdown-menu .dropdown-item i {
    font-size: 1rem;
    width: 18px;
    text-align: center;
    flex-shrink: 0;
}

.profile-dropdown-menu .dropdown-item:hover {
    background: rgba(88, 101, 242, 0.15);
    color: #fff;
}

.profile-dropdown-menu .dropdown-item.logout-item:hover {
    background: rgba(255, 46, 99, 0.15);
    color: #FF2E63;
}

.profile-dropdown-menu .dropdown-divider {
    border-color: rgba(255, 255, 255, 0.07);
    margin: 6px 0;
}

/* mobile fix */
@media (max-width: 992px) {
    .navbar-glass {
        height: auto;
    }

    body {
        padding-top: 90px;
    }

    .profile-name {
        display: none;
    }
}
</style>

<nav class="navbar navbar-expand-lg navbar-glass shadow-sm fixed-top">

    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-2" href="/">
            <img src="{{ asset('images/44444444444444.png') }}" alt="Logo">
            <span class="fw-bold">Pixel Forge</span>
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler text-white" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">

            <div class="ms-auto d-flex gap-2 align-items-center flex-column flex-lg-row mt-3 mt-lg-0">

                @auth
                    <!-- Profile Dropdown -->
                    <div class="dropdown">
                        <a class="profile-dropdown-toggle dropdown-toggle"
                           href="#"
                           id="profileDropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                            <span class="profile-name">{{ auth()->user()->name }}</span>
                            <i class="bi bi-chevron-down profile-caret"></i>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end profile-dropdown-menu" aria-labelledby="profileDropdown">
                            <li>
                                <div class="dropdown-header">
                                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}">
                                    <div class="dh-name">{{ auth()->user()->name }}</div>
                                </div>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="bi bi-person-fill"></i>
                                    My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item logout-item" href="#"
                                   onclick="event.preventDefault(); document.getElementById('navbar-logout-form').submit();">
                                    <i class="bi bi-box-arrow-left"></i>
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </div>

                    <form id="navbar-logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-sm">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-light btn-sm">Register</a>
                @endauth

            </div>

        </div>

    </div>

</nav>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>