      <nav class="main-header navbar navbar-expand navbar-white navbar-light">
          <!-- Left navbar links -->
          <ul class="navbar-nav">
              <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
              </li>
          </ul>

          <!-- Right navbar links -->
          <ul class="navbar-nav ml-auto">
              <li class="nav-item">
                  <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                      <i class="fas fa-expand-arrows-alt"></i>
                  </a>
              </li>
              <li class="nav-item dropdown">
                  <a class="nav-link" data-toggle="dropdown" href="#">
                      <i class="far fa-user-circle"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">
                          <div class="form-inline">
                              <p class="float-right text-sm">{{ Auth::user()->email }}</p>
                          </div>
                      </a>
                      <div class="dropdown-divider"></div>
                      <a href="#" class="dropdown-item">
                          <div class="form-inline">
                              <i class="fas fa-sign-out-alt mr-2"></i>
                              <form action="{{ route('logout') }}" method="post" class="text-sm">
                                  @csrf
                                  <button type="submit" class="btn btn-lg btn-danger text-sm">Keluar</button>
                              </form>
                          </div>
                      </a>
                  </div>
              </li>
          </ul>
      </nav>
