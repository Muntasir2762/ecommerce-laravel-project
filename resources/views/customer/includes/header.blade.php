<header class="header header-sticky p-0 mb-4">
    <div class="container-fluid border-bottom px-4">
        <button class="header-toggler" type="button"
            onclick="coreui.Sidebar.getInstance(document.querySelector('#sidebar')).toggle()"
            style="margin-inline-start: -14px;">
            <svg class="icon icon-lg">
                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-menu"></use>
            </svg>
        </button>

        <ul class="header-nav">
            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            <li class="nav-item dropdown">
                <button class="btn btn-link nav-link py-2 px-2 d-flex align-items-center" type="button"
                    aria-expanded="false" data-coreui-toggle="dropdown">
                    <svg class="icon icon-lg theme-icon-active">
                        <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>
                    </svg>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" style="--cui-dropdown-min-width: 8rem;">
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button"
                            data-coreui-theme-value="light">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-sun"></use>
                            </svg>Light
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center" type="button"
                            data-coreui-theme-value="dark">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-moon"></use>
                            </svg>Dark
                        </button>
                    </li>
                    <li>
                        <button class="dropdown-item d-flex align-items-center active" type="button"
                            data-coreui-theme-value="auto">
                            <svg class="icon icon-lg me-3">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-contrast"></use>
                            </svg>Auto
                        </button>
                    </li>
                </ul>
            </li>
            <li class="nav-item py-1">
                <div class="vr h-100 mx-2 text-body text-opacity-75"></div>
            </li>
            @php
                $authUserImage = Auth::user()->image;
            @endphp
            <li class="nav-item dropdown"><a class="nav-link py-0 pe-0" data-coreui-toggle="dropdown" href="#"
                    role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="avatar avatar-md">
                        @if ($authUserImage != null)
                            <img class="avatar-img" src="{{ $authUserImage }}" alt="profile_image">
                        @else
                            <img class="avatar-img" src="{{ asset('customer/user/avatar.jfif') }}" alt="profile_image">
                        @endif
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end pt-0">
                    <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold rounded-top mb-2">

                        <div class="dropdown-header bg-body-tertiary text-body-secondary fw-semibold my-2">
                        </div><a class="dropdown-item" href="{{ url('/customer/profile-view') }}">
                            <svg class="icon me-2">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-user"></use>
                            </svg> Profile</a>

                        <a class="dropdown-item" href="{{ url('/customer/view-credentials') }}">
                            <svg class="icon me-2">
                                <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-settings"></use>
                            </svg> Credential Settings</a><a class="dropdown-item" href="">

                            <div class="dropdown-divider"></div><a class="dropdown-item"
                                href="{{ url('customer/logout') }}">
                                <svg class="icon me-2">
                                    <use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-account-logout"></use>
                                </svg> Logout</a>
                    </div>
            </li>
        </ul>
    </div>
    {{-- <div class="container-fluid px-4">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb my-0">
              <li class="breadcrumb-item"><a href="{{url('/')}}">Home</a>
              </li>
              <li class="breadcrumb-item active"><span>Dashboard</span>
              </li>
            </ol>
          </nav>
        </div> --}}
</header>
