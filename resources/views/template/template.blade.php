  <body class="hold-transition sidebar-mini layout-fixed">
      <div class="wrapper">
          <!-- Preloader -->
          <div class="preloader flex-column justify-content-center align-items-center">
              <img class="animation__shake" src="
            {{ asset('template/img/logo.png') }}" alt="Logo"
                  height="150" width="150" />
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
              <strong>Copyright &copy; 2022-2023
                  <a href="https://portofolio-2a917.web.app/">BellukStudio</a>.</strong>
              All rights reserved.
              <div class="float-right d-none d-sm-inline-block">
                  <b>Version</b> 1.0.0
              </div>
          </footer>
      </div>
