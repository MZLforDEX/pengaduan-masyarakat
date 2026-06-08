<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

  <!-- Main Content -->
  <div id="content">

    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

      <!-- Sidebar Toggle (Topbar) -->
      <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
      </button>


      <!-- Topbar Navbar -->
      <ul class="navbar-nav ml-auto">

        <?php
          $this->load->model('Notifikasi_m');
          $_ci =& get_instance();
          $notif_username = $this->session->userdata('username');
          $notif_level = $this->session->userdata('level');
          $unread_count = $_ci->Notifikasi_m->count_unread($notif_username, $notif_level);
          $notif_list = $_ci->Notifikasi_m->get_by_user($notif_username, $notif_level, 5);
        ?>

        <!-- Nav Item - Notifications -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-fw"></i>
            <?php if ($unread_count > 0) : ?>
              <span class="badge badge-danger badge-counter"><?= $unread_count > 9 ? '9+' : $unread_count ?></span>
            <?php endif; ?>
          </a>
          <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="notifDropdown">
            <h6 class="dropdown-header">Notifikasi</h6>
            <?php if (empty($notif_list)) : ?>
              <div class="text-center py-4 text-muted" style="font-size: .85rem;">
                <i class="fas fa-bell-slash mb-2" style="font-size: 1.5rem; display: block;"></i>
                Tidak ada notifikasi
              </div>
            <?php else : ?>
              <?php foreach ($notif_list as $n) : ?>
                <a class="dropdown-item d-flex align-items-center" href="<?= base_url('NotifikasiController/read/'.$n['id_notifikasi']) ?>">
                  <div style="width: 34px; height: 34px; border-radius: 50%; background: <?= $n['is_read'] == '0' ? 'rgba(99,102,241,0.1)' : 'rgba(148,163,184,0.1)' ?>; display: flex; align-items: center; justify-content: center; color: <?= $n['is_read'] == '0' ? '#6366f1' : '#94a3b8' ?>; flex-shrink: 0; margin-right: 12px;">
                    <i class="fas fa-bell" style="font-size: .8rem;"></i>
                  </div>
                  <div style="flex: 1; min-width: 0;">
                    <div style="font-size: .8rem; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;"><?= htmlspecialchars($n['isi']) ?></div>
                    <div style="font-size: .65rem; color: #94a3b8;"><?= date('d M H:i', strtotime($n['created_at'])) ?></div>
                  </div>
                  <?php if ($n['is_read'] == '0') : ?>
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #6366f1; flex-shrink: 0; margin-left: 8px;"></span>
                  <?php endif; ?>
                </a>
              <?php endforeach; ?>
              <a class="dropdown-item text-center small text-gray-500" href="<?= base_url('NotifikasiController') ?>">Lihat Semua Notifikasi</a>
            <?php endif; ?>
          </div>
        </li>

        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
          <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <span
              class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $this->session->userdata('username'); ?></span>
            <img class="img-profile rounded-circle" src="<?= base_url() ?>assets/profile/user.png">
          </a>
          <!-- Dropdown - User Information -->
          <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
            <a class="dropdown-item" href="<?= base_url('User/ProfileController') ?>">
              <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
              Profile
            </a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#" data-toggle="modal"
              data-target="#logoutModal">
              <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
              Logout
            </a>
          </div>
        </li>

      </ul>

    </nav>
    <!-- End of Topbar -->