<div class="sidebar sidebar-style-2">
  <div class="sidebar-wrapper scrollbar scrollbar-inner">
    <div class="sidebar-content">
      <div class="user">
        <div class="avatar-sm float-left mr-2">
          <img src="<?php echo base_url()?>/assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
        </div>
        <div class="info">
          <a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
            <span>
              Hizrian
              <span class="user-level">Administrator</span>
              <span class="caret"></span>
            </span>
          </a>
          <div class="clearfix"></div>

          <div class="collapse in" id="collapseExample">
            <ul class="nav">
                <a href="#edit">
                  <span class="link-collapse">Edit Profile</span>
                </a>
              </li>
              <li>
                <a href="#logout">
                  <span class="link-collapse">Log Out</span>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <ul class="nav nav-primary">
        <li class="nav-item">
          <a href="<?php echo site_url('dashboard') ?>" class="collapsed" aria-expanded="false">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section">KELOLAH DATA</h4>
        </li>
        <li class="nav-item">
          <a href="<?php echo site_url('Produk') ?>">
            <i class="fas fa-layer-group"></i>
            <p>Produk Skincare</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo site_url('Barangmasuk') ?>">
            <i class="fas fa-angle-double-right"></i>
            <p>Barang Masuk</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo site_url('Ramal') ?>">
            <i class="fas fa-chart-line"></i>
            <p>Ramalan Produk Skincare</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>
