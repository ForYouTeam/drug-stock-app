<div id="sidebar" class="active">
  <div class="sidebar-wrapper active">
      <div class="sidebar-header">
          <div class="d-flex justify-content-between">
              <div class="logo">
                  <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
              </div>
              <div class="toggler">
                  <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
              </div>
          </div>
      </div>
      <div class="sidebar-menu">
          <ul class="menu">
              <li class="sidebar-title">Menu</li>

              <li class="sidebar-item {{ (request()->is('/')) ? 'active' : '' }} ">
                  <a href="{{'/'}}" class='sidebar-link'>
                      <i class="bi bi-grid-fill"></i>
                      <span>Dashboard</span>
                  </a>
              </li>

              <li class="sidebar-title">Data</li>

              <li class="sidebar-item {{ (request()->is('warehouses')) ? 'active' : '' }} ">
                  <a href="{{route('warehouse')}}" class='sidebar-link'>
                    <i class="bi-house-door-fill mt-1"></i>
                      <span>Gudang</span>
                  </a>
              </li>

              <li class="sidebar-item {{ (request()->is('receiver')) ? 'active' : '' }} ">
                <a href="{{route('receiver')}}" class='sidebar-link'>
                  <i class="bi-house-door-fill mt-1"></i>
                    <span>Penerima</span>
                </a>
            </li>

              <li class="sidebar-item {{ (request()->is('drugs')) ? 'active' : '' }} ">
                  <a href="{{route('drugs')}}" class='sidebar-link'>
                      <i class="bi bi-droplet-fill mt-1"></i>
                      <span>Obat</span>
                  </a>
              </li>

              <li class="sidebar-item {{ (request()->is('staff')) ? 'active' : '' }} ">
                  <a href="{{route('staff')}}" class='sidebar-link'>
                    <i class="bi-person-fill mt-1"></i>
                      <span>Staff</span>
                  </a>
              </li>

              <li class="sidebar-item  {{ (request()->is('transaction')) ? 'active' : '' }} ">
                <a href="{{route('transaction')}}" class='sidebar-link'>
                    <i class="bi-arrow-down-up mt-1"></i>
                    <span>Transaksi</span>
                </a>
              </li>

              <li class="sidebar-title">Settings</li>

              <li class="sidebar-item {{ (request()->is('akun')) ? 'active' : '' }} ">
                <a href="{{'/akun'}}" class='sidebar-link'>
                    <i class="bi-person-plus-fill mt-1"></i>
                    <span>Manajemen Akun</span>
                </a>
              </li>
          </ul>
      </div>
      <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
  </div>
</div>