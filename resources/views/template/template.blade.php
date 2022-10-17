  <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
          <!-- Preloader -->
          <div class="preloader flex-column justify-content-center align-items-center">
              <img class="animation__wobble" src="
            {{ asset('template/dist/img/AdminLTELogo.png') }}"
                  alt="AdminLTELogo" height="60" width="60" />
          </div>

          <!-- Navbar -->
          @include('components.navbar')
          <!-- /.navbar -->

          <!-- Main Sidebar Container -->
          @include('components.sidebar')
          <div class="content-wrapper">
              <div class="content-header">
                  @yield('content-header')
              </div>

              <!-- Main content -->
              @yield('content-section')
              <!-- /.content -->
          </div>
          <!-- /.content-wrapper -->
          <footer class="main-footer">
              <strong>Copyright &copy; 2014-2021
                  <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
              All rights reserved.
              <div class="float-right d-none d-sm-inline-block">
                  <b>Version</b> 3.2.0
              </div>
          </footer>
      </div>
