<!DOCTYPE html>
<html lang="en">

<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Primary Meta Tags -->
<title>@yield('title') | App</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="title" content="Volt - Free Bootstrap 5 Dashboard">

<!-- Favicon -->
<link rel="apple-touch-icon" sizes="120x120" href="{{ asset('volt/assets/img/favicon/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('volt/assets/img/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('volt/assets/img/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('volt/assets/img/favicon/site.webmanifest') }}">
<link rel="mask-icon" href="{{ asset('volt/assets/img/favicon/safari-pinned-tab.svg') }}" color="#ffffff">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<!-- Sweet Alert -->
<link type="text/css" href="{{ asset('volt/vendor/sweetalert2/dist/sweetalert2.min.css') }}" rel="stylesheet">

<!-- Notyf -->
<link type="text/css" href="{{ asset('volt/vendor/notyf/notyf.min.css') }}" rel="stylesheet">

<!-- Volt CSS -->
<link type="text/css" href="{{ asset('volt/css/volt.css') }}" rel="stylesheet">
<!-- Font awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- Styles -->
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">        
<!-- Alpine js -->
<script defer src="https://unpkg.com/alpinejs@3.10.5/dist/cdn.min.js"></script>
@stack('styles')
@livewireStyles
</head>

<body>
    <form action="{{ route('logout') }}" method="post" id="logout-form">
        @csrf    
    </form>
<nav class="navbar navbar-dark navbar-theme-primary px-4 col-12 d-lg-none">
    <a class="navbar-brand me-lg-5" href="{{ route('dashboard') }}">
        <img class="navbar-brand-dark" src="{{ asset('volt/assets/img/brand/light.svg') }}" alt="Volt logo" /> <img class="navbar-brand-light" src="{{ asset('volt/assets/img/brand/dark.svg') }}" alt="Volt logo" />
    </a>
    <div class="d-flex align-items-center">
        <button class="navbar-toggler d-lg-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

<nav id="sidebarMenu" class="sidebar d-lg-block bg-gray-800 text-white collapse" data-simplebar>
  <div class="sidebar-inner px-4 pt-3">
    <div class="user-card d-flex d-md-none align-items-center justify-content-between justify-content-md-center pb-4">
      <div class="d-flex align-items-center">
        <div class="avatar-lg me-4">
          <img src="{{ asset('volt/assets/img/team/profile-picture-3.jpg') }}" class="card-img-top rounded-circle border-white"
            alt="Bonnie Green">
        </div>
        <div class="d-block">
            <h2 class="h5 mb-3">Hi, {{ auth()->user()->name }}</h2>
            <a type="submit" href="" class="btn btn-secondary btn-sm d-inline-flex align-items-center logout-button">
                <svg class="icon icon-xxs me-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>            
                Sign Out
            </a>
        </div>
      </div>
      <div class="collapse-close d-md-none">
        <a href="#sidebarMenu" data-bs-toggle="collapse"
            data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="true"
            aria-label="Toggle navigation">
            <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
          </a>
      </div>
    </div>
    <ul class="nav flex-column pt-3 pt-md-0">
      <li class="nav-item">
        <a href="javascript::void(0)" class="nav-link d-flex align-items-center disabled">
          <span class="sidebar-icon">
            <img src="{{ asset('volt/assets/img/brand/light.svg') }}" height="20" width="20" alt="Volt Logo">
          </span>
          <span class="mt-1 ms-1 sidebar-text">Backup App</span>
        </a>
      </li>

      <li class="nav-item  {{ (Str::contains(Route::currentRouteName(), 'dashboard')) ? 'active':''}} ">
        <a href="{{route('dashboard')}}" class="nav-link">
          <span class="sidebar-icon">
            <i class="fas fa-dashboard"></i>
          </span> 
          <span class="sidebar-text">Dashboard</span>
        </a>
      </li>

        @foreach($sideMenu as $menuKey => $menu)
            @if (Arr::exists($menu, 'sub_menu'))
                @canany($menu['permissions'])
                <li class="nav-item">
                    <span
                      class="nav-link  d-flex justify-content-between align-items-center {{ (Str::contains(Route::currentRouteName(), $menuKey)) ? '':'collapsed'}}"
                      data-bs-toggle="collapse" data-bs-target="#submenu-app" aria-expanded="{{ (Str::contains(Route::currentRouteName(), $menuKey)) ? 'true':'false'}}">
                      <span>
                        <span class="sidebar-icon">
                          <i class="{{$menu['icon']}}"></i>
                        </span> 
                        <span class="sidebar-text">{{$menu['title']}}</span>
                      </span>
                      <span class="link-arrow">
                        <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                      </span>
                    </span>
                    <div class="multi-level collapse {{ (Str::contains(Route::currentRouteName(), $menuKey)) ? 'show':''}}"
                      role="list" id="submenu-app" aria-expanded="false">
                      <ul class="flex-column nav">
                        @foreach($menu['sub_menu'] as $subMenuKey => $subMenu)
                            <!-- Permission Check -->
                            @canany($subMenu['permissions'])
                            <li class="nav-item {{ (Str::contains(Route::currentRouteName(), $subMenuKey)) ? 'active':''}}">
                                <a class="nav-link" href="{{route($subMenu['route_name'])}}">
                                  <span class="sidebar-text">{{$subMenu['title']}}</span>
                                </a>
                            </li>
                            @endcanany
                        @endforeach  
                      </ul>
                    </div>
                </li>
                @endcanany
            @else
                <!-- Permission Check -->
                @canany($menu['permissions'])
                <li class="nav-item  {{ (Str::contains(Route::currentRouteName(), $menuKey)) ? 'active':''}} ">
                    <a href="{{route($menu['route_name'])}}" class="nav-link">
                      <span class="sidebar-icon">
                        <i class="{{$menu['icon']}}"></i>
                      </span> 
                      <span class="sidebar-text">{{$menu['title']}}</span>
                    </a>
                  </li>
                @endcanany
            @endif
        @endforeach
      
      <li role="separator" class="dropdown-divider mt-4 mb-3 border-gray-700"></li>
      <li class="nav-item"> 
        <a href="#"
          class="nav-link d-flex align-items-center logout-button">
          <span class="sidebar-icon">
            <i class="fa-sign-out-alt fas text-danger"></i>
          </span>
          <span class="sidebar-text">Logout <span class="badge badge-sm bg-secondary ms-1 text-gray-800 d-none">v1.4</span></span>
        </a>
      </li>
      <li class="nav-item d-none">
        <a href="{{ asset('volt/index.html') }}"
          class="btn btn-secondary d-flex align-items-center justify-content-center btn-upgrade-pro">
          <span class="sidebar-icon d-inline-flex align-items-center justify-content-center">
            <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.214.33-.403.713-.57 1.116-.334.804-.614 1.768-.84 2.734a31.365 31.365 0 00-.613 3.58 2.64 2.64 0 01-.945-1.067c-.328-.68-.398-1.534-.398-2.654A1 1 0 005.05 6.05 6.981 6.981 0 003 11a7 7 0 1011.95-4.95c-.592-.591-.98-.985-1.348-1.467-.363-.476-.724-1.063-1.207-2.03zM12.12 15.12A3 3 0 017 13s.879.5 2.5.5c0-1 .5-4 1.25-4.5.5 1 .786 1.293 1.371 1.879A2.99 2.99 0 0113 13a2.99 2.99 0 01-.879 2.121z" clip-rule="evenodd"></path></svg>
          </span> 
          <span>Upgrade to Pro</span>
        </a>
      </li>
    </ul>
  </div>
</nav>
    
<main class="content">

    <nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
        <div class="container-fluid px-0">
            <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
            <div class="d-flex align-items-center">
                <p>Backup App</p>
                <!-- Search form -->
                <!-- <form class="navbar-search form-inline" id="navbar-search-main">
                <div class="input-group input-group-merge search-bar">
                    <span class="input-group-text" id="topbar-addon">
                        <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                        </svg>
                    </span>
                    <input type="text" class="form-control" id="topbarInputIconLeft" placeholder="Search" aria-label="Search" aria-describedby="topbar-addon">
                </div>
                </form> -->
                <!-- / Search form -->
            </div>
            <!-- Navbar links -->
            <ul class="navbar-nav align-items-center">
                <li class="nav-item dropdown">
                <a class="nav-link text-dark notification-bell unread dropdown-toggle" data-unread-notifications="true" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                    <svg class="icon icon-sm text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path></svg>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-center mt-2 py-0">
                    <div class="list-group list-group-flush">
                    <a href="#" class="text-center text-primary fw-bold border-bottom border-light py-3">Notifications</a>
                    <a href="#" class="list-group-item list-group-item-action border-bottom">
                        <div class="row align-items-center">
                            <div class="col-auto">
                            <!-- Avatar -->
                            <img alt="Image placeholder" src="volt/assets/img/team/profile-picture-1.jpg" class="avatar-md rounded">
                            </div>
                            <div class="col ps-0 ms-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="h6 mb-0 text-small">Jose Leos</h4>
                                </div>
                                <div class="text-end">
                                    <small class="text-danger">a few moments ago</small>
                                </div>
                            </div>
                            <p class="font-small mt-1 mb-0">Added you to an event "Project stand-up" tomorrow at 12:30 AM.</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-bottom">
                        <div class="row align-items-center">
                            <div class="col-auto">
                            <!-- Avatar -->
                            <img alt="Image placeholder" src="volt/assets/img/team/profile-picture-2.jpg" class="avatar-md rounded">
                            </div>
                            <div class="col ps-0 ms-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="h6 mb-0 text-small">Neil Sims</h4>
                                </div>
                                <div class="text-end">
                                    <small class="text-danger">2 hrs ago</small>
                                </div>
                            </div>
                            <p class="font-small mt-1 mb-0">You've been assigned a task for "Awesome new project".</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-bottom">
                        <div class="row align-items-center">
                            <div class="col-auto">
                            <!-- Avatar -->
                            <img alt="Image placeholder" src="volt/assets/img/team/profile-picture-3.jpg" class="avatar-md rounded">
                            </div>
                            <div class="col ps-0 m-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="h6 mb-0 text-small">Roberta Casas</h4>
                                </div>
                                <div class="text-end">
                                    <small>5 hrs ago</small>
                                </div>
                            </div>
                            <p class="font-small mt-1 mb-0">Tagged you in a document called "Financial plans",</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-bottom">
                        <div class="row align-items-center">
                            <div class="col-auto">
                            <!-- Avatar -->
                            <img alt="Image placeholder" src="volt/assets/img/team/profile-picture-4.jpg" class="avatar-md rounded">
                            </div>
                            <div class="col ps-0 ms-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="h6 mb-0 text-small">Joseph Garth</h4>
                                </div>
                                <div class="text-end">
                                    <small>1 d ago</small>
                                </div>
                            </div>
                            <p class="font-small mt-1 mb-0">New message: "Hey, what's up? All set for the presentation?"</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action border-bottom">
                        <div class="row align-items-center">
                            <div class="col-auto">
                            <!-- Avatar -->
                            <img alt="Image placeholder" src="volt/assets/img/team/profile-picture-5.jpg" class="avatar-md rounded">
                            </div>
                            <div class="col ps-0 ms-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="h6 mb-0 text-small">Bonnie Green</h4>
                                </div>
                                <div class="text-end">
                                    <small>2 hrs ago</small>
                                </div>
                            </div>
                            <p class="font-small mt-1 mb-0">New message: "We need to improve the UI/UX for the landing page."</p>
                            </div>
                        </div>
                    </a>
                    <a href="#" class="dropdown-item text-center fw-bold rounded-bottom py-3">
                        <svg class="icon icon-xxs text-gray-400 me-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"></path></svg>
                        View all
                    </a>
                    </div>
                </div>
                </li>
                <li class="nav-item dropdown ms-lg-3">
                <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="media d-flex align-items-center">
                    <img class="avatar rounded-circle" alt="Image placeholder" src="volt/assets/img/team/profile-picture-3.jpg">
                    <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                        <span class="mb-0 font-small fw-bold text-gray-900">{{ auth()->user()->name }}</span>
                    </div>
                    </div>
                </a>
                <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                    <a class="dropdown-item d-flex align-items-center" href="#">
                        <span class="badge bg-gray-900 w-100">
                            @forelse(auth()->user()->getRoleNames() as $role)
                                {{ $role }} @if(!$loop->last) <br> @endif
                            @empty
                                No Role
                            @endforelse
                        </span>
                        </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                    <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z" clip-rule="evenodd"></path></svg>
                    My Profile
                    </a>
                    <a class="dropdown-item d-flex align-items-center" href="#">
                    <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                    Settings
                    </a>
                    <div role="separator" class="dropdown-divider my-1"></div>
                    <a class="dropdown-item d-flex align-items-center logout-button" type="submit" href="#">
                        <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>                
                        Logout
                    </a>
                    
                </div>
                </li>
            </ul>
            </div>
        </div>
    </nav>




    <div class="py-4">
        <!-- <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
            <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
                <li class="breadcrumb-item">
                    <a href="#">
                        <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    </a>
                </li>
                <li class="breadcrumb-item"><a href="#">Volt</a></li>
                <li class="breadcrumb-item active" aria-current="page">Transactions</li>
            </ol>
        </nav> -->
        <div class="" style="min-height: 58vh;">
            @yield('content')
        </div>
    </div>

            
            
            
    <div class="theme-settings card bg-gray-800 pt-2 collapse" id="theme-settings">
        <div class="card-body bg-gray-800 text-white pt-4">
            <button type="button" class="btn-close theme-settings-close" aria-label="Close" data-bs-toggle="collapse"
                href="#theme-settings" role="button" aria-expanded="false" aria-controls="theme-settings"></button>
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="m-0 mb-1 me-4 fs-7">Open source <span role="img" aria-label="gratitude">💛</span></p>
                <a class="github-button" href="https://github.com/themesberg/volt-bootstrap-5-dashboard"
                    data-color-scheme="no-preference: dark; light: light; dark: light;" data-icon="octicon-star"
                    data-size="large" data-show-count="true"
                    aria-label="Star themesberg/volt-bootstrap-5-dashboard on GitHub">Star</a>
            </div>
            <a href="https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard" target="_blank"
                class="btn btn-secondary d-inline-flex align-items-center justify-content-center mb-3 w-100">
                Download 
                <svg class="icon icon-xs ms-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2 9.5A3.5 3.5 0 005.5 13H9v2.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 15.586V13h2.5a4.5 4.5 0 10-.616-8.958 4.002 4.002 0 10-7.753 1.977A3.5 3.5 0 002 9.5zm9 3.5H9V8a1 1 0 012 0v5z" clip-rule="evenodd"></path></svg>
            </a>
            <p class="fs-7 text-gray-300 text-center">Available in the following technologies:</p>
            <div class="d-flex justify-content-center">
                <a class="me-3" href="https://themesberg.com/product/admin-dashboard/volt-bootstrap-5-dashboard"
                    target="_blank">
                    <img src="{{ asset('volt/assets/img/technologies/bootstrap-5-logo.svg') }}" class="image image-xs">
                </a>
                <a href="https://demo.themesberg.com/volt-react-dashboard/#/" target="_blank">
                    <img src="{{ asset('volt/assets/img/technologies/react-logo.svg') }}" class="image image-xs">
                </a>
            </div>
        </div>
    </div>

    <div class="card theme-settings bg-gray-800 theme-settings-expand" id="theme-settings-expand">
        <div class="card-body bg-gray-800 text-white rounded-top p-3 py-2">
            <span class="fw-bold d-inline-flex align-items-center h6">
                <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path></svg>
                Settings
            </span>
        </div>
    </div>

    <footer class="bg-white rounded shadow p-5 mb-4 mt-4 d-none">
        <div class="row">
            <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
                <p class="mb-0 text-center text-lg-start">©<span class="current-year"></span> <a class="text-primary fw-normal" href="javascript::void(0)">Themesberg</a></p>
            </div>
            <div class="col-12 col-md-8 col-xl-6 text-center text-lg-start">
                <!-- List -->
                <ul class="list-inline list-group-flush list-group-borderless text-md-end mb-0">
                    <!-- <li class="list-inline-item px-0 px-sm-2">
                        <a href="https://themesberg.com/about">About</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </footer>
</main>

<script src="https://code.jquery.com/jquery-3.6.1.slim.min.js" integrity="sha256-w8CvhFs7iHNVUtnSP0YKEg00p9Ih13rlL9zGqvLdePA=" crossorigin="anonymous"></script>

    <!-- Core -->
<script src="{{ asset('volt/vendor/@popperjs/core/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('volt/vendor/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- Vendor JS -->
<script src="{{ asset('volt/vendor/onscreen/dist/on-screen.umd.min.js') }}"></script>

<!-- Slider -->
<script src="{{ asset('volt/vendor/nouislider/distribute/nouislider.min.js') }}"></script>

<!-- Smooth scroll -->
<script src="{{ asset('volt/vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js') }}"></script>

<!-- Charts -->
<script src="{{ asset('volt/vendor/chartist/dist/chartist.min.js') }}"></script>
<script src="{{ asset('volt/vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js') }}"></script>

<!-- Datepicker -->
<script src="{{ asset('volt/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>

<!-- Sweet Alerts 2 -->
<script src="{{ asset('volt/vendor/sweetalert2/dist/sweetalert2.all.min.js') }}"></script>

<!-- Moment JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

<!-- Vanilla JS Datepicker -->
<script src="{{ asset('volt/vendor/vanillajs-datepicker/dist/js/datepicker.min.js') }}"></script>

<!-- Notyf -->
<script src="{{ asset('volt/vendor/notyf/notyf.min.js') }}"></script>

<!-- Simplebar -->
<script src="{{ asset('volt/vendor/simplebar/dist/simplebar.min.js') }}"></script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Volt JS -->
<script src="{{ asset('volt/assets/js/volt.js') }}"></script>
<script>
    $('.logout-button').on('click',function(e){
        e.preventDefault();
        submitLogoutForm();
    });
    function submitLogoutForm()
    {
        Swal.fire({
            title: 'Are you sure?',
            text: "You will be logged out of the system!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Log out!'
          }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById("logout-form").submit();
            }
          })
        
    }
</script>

<script>

    var toastMixin = Swal.mixin({
        toast: true,
        icon: 'success',
        title: 'General Title',
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
    });

    window.addEventListener('success-notification', event => {
        toastMixin.fire({
            title: event.detail.message,
            icon:'success'
        });
    })

    window.addEventListener('info-notification', event => {
        toastMixin.fire({
            title: event.detail.message,
            icon:'info'
        });
    })
    window.addEventListener('error-notification', event => {
        toastMixin.fire({
            title: event.detail.message,
            icon:'error'
        });
    })
    window.addEventListener('warning-notification', event => {
        toastMixin.fire({
            title: event.detail.message,
            icon:'warning'
        });
    })

    window.addEventListener('success-prompt', event => {
        Swal.fire(
            'Success!',
            event.detail.message,
            'success'
        )
    })

    window.addEventListener('error-prompt', event => {
        Swal.fire(
            'Error!',
            event.detail.message,
            'error'
        )
    })
</script>
@stack('scripts')
@livewireScripts
</body>

</html>
