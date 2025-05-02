@php($user = auth()->guard('admin')->user())

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Panel</title>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href={{ asset("/plugins/fontawesome-free/css/all.min.css") }}>
    <link rel="stylesheet" href={{ asset("/plugins/summernote/summernote-bs4.css") }}>
    <link rel="stylesheet" href={{ asset("/dist/css/adminlte.min.css") }}>
    <link rel="stylesheet" href={{ asset("/assets/admin.css") }}>
    <link rel="stylesheet" href={{ asset("/assets/colorbox.css") }}>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link rel="stylesheet" href={{ asset("/plugins/daterangepicker/daterangepicker.css") }}>
</head>
<body
    class="hold-transition sidebar-mini layout-fixed @if(auth()->guard('admin')->user()->theme === 'dark') dark-mode @endif">
<div class="wrapper">
    <nav
        class="main-header navbar navbar-expand @if(auth()->guard('admin')->user()->theme === 'dark') navbar-black navbar-dark @else navbar-white navbar-light @endif">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <a class="nav-link" href="#"
               onclick="event.preventDefault(); document.getElementById('cache-redis-clear-form').submit();">
                Очистить кеш Redis
            </a>
            <form id="cache-redis-clear-form" action="#" method="POST"
                  class="d-none">
                @csrf
            </form>
            <li class="nav-item">
                <a href="{{ route('user.index') }}" class="nav-link">Управление пользователями</a>
            </li>
            <li class="nav-item">
                <a href="{{ route('settings.show') }}" class="nav-link">
                    <p>Настройки сайта<i class="right fas"></i></p>
                </a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="{{ route('admin.home') }}" class="brand-link">
            <span> Admin Panel </span>
        </a>
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="info">
                    <a href="{{ route('user.profile_edit', auth()->guard('admin')->user()->id) }}"
                       class="d-block">{{ auth()->guard('admin')->user()->name }}</a>
                    <a  href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                       document.getElementById('logout-form').submit();">Выйти
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    <br />
                </div>
            </div>
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    @if($user->role === 'admin'|| $user->role === 'seo')
                        <li class="nav-item">
                            <a href="{{ route('seo.show') }}" class="nav-link">
                                <i class="nav-icon fas  fa-solid fa-list" style="color: #63E6BE;"></i>
                                <p>Общее SEO<i class="right fas"></i></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('seo.individual.common') }}" class="nav-link">
                                <i class="nav-icon fas fa-globe" style="color: #63E6BE;"></i>
                                <p>Индивидуальное SEO<i class="right fas"></i></p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('abuse.common') }}" class="nav-link">
                                <i class="nav-icon fas fa-solid fa-lock" style="color: #63E6BE;"></i>
                                <p>Заблокировать<i class="right fas"></i></p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>
    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-lg-12">
                        <h1 class="m-0">@yield('h1')</h1>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i>{{ session('success') }}</h4>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                        @foreach($errors->all() as $error)
                            <h4>{{ $error }}<h4/>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </section>
    </div>
    <aside class="control-sidebar control-sidebar-dark">
    </aside>
</div>
<script src={{ asset("/plugins/jquery/jquery.min.js") }}></script>
<script src={{ asset("/plugins/jquery-ui/jquery-ui.min.js") }}></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src={{ asset("/plugins/bootstrap/js/bootstrap.bundle.min.js") }} />
<script src={{ asset("/plugins/jquery-knob/jquery.knob.min.js") }} />
<script src={{ asset("/plugins/daterangepicker/daterangepicker.js") }} />
<script src={{ asset("/plugins/summernote/summernote-bs4.js") }} />
<script src={{ asset("/dist/js/adminlte.js") }} />
<script src={{ asset("/assets/admin.js") }} />
<script src={{ asset("/assets/jquery.colorbox-min.js") }} />
<script type="text/javascript" src={{ asset("/packages/barryvdh/elfinder/js/standalonepopup.js") }} />
<script src={{ asset("/dist/js/pages/dashboard.js") }} />
</body>
</html>
