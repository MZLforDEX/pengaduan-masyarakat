        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <div>
              <h1 class="h3 mb-1 text-gray-800">Dashboard</h1>
              <p class="text-muted small mb-0">Overview sistem pengaduan masyarakat</p>
            </div>
            <a href="<?= base_url('Admin/LaporanController') ?>" class="d-none d-sm-inline-block btn btn-primary shadow-sm px-4 py-2" style="border-radius: 12px; font-weight: 600;">
              <i class="fas fa-file-pdf fa-sm me-1"></i> Generate Laporan
            </a>
          </div>

          <!-- Welcome Hero Banner -->
          <div class="row">
            <div class="col-12 mb-4">
              <div class="card text-white border-0 shadow-sm overflow-hidden" style="border-radius: 20px; background: linear-gradient(135deg, #6366f1 0%, #3b82f6 100%) !important;">
                <div class="card-body p-4 position-relative" style="z-index: 1;">
                  <div class="row align-items-center">
                    <div class="col-lg-8">
                      <h4 class="font-weight-bold mb-2 text-white">Selamat Datang Kembali, <?= ucfirst($this->session->userdata('username')); ?>! 👋</h4>
                      <p class="mb-0 text-white-50 opacity-90" style="font-size: 0.95rem; line-height: 1.6;">Selamat bekerja! Mari kita pantau, verifikasi, dan tindak lanjuti setiap laporan keluhan dari masyarakat secara cepat, tepat, dan transparan.</p>
                    </div>
                    <div class="col-lg-4 text-right d-none d-lg-block pr-4">
                      <i class="fas fa-user-shield fa-5x text-white" style="opacity: 0.15; font-size: 4.5rem;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Stat Cards Row -->
          <div class="row">

            <!-- Total Petugas -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="stat-card stat-card-indigo">
                <div class="stat-card-body">
                  <div class="stat-card-content">
                    <div class="stat-card-label">Total Petugas</div>
                    <div class="stat-card-value" data-count="<?= $petugas ?>">0</div>
                  </div>
                  <div class="stat-card-icon">
                    <i class="fas fa-users"></i>
                  </div>
                </div>
                <div class="stat-card-footer">
                  <span><i class="fas fa-user-shield"></i> Admin & Petugas</span>
                </div>
              </div>
            </div>

            <!-- Total Pengaduan -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="stat-card stat-card-blue">
                <div class="stat-card-body">
                  <div class="stat-card-content">
                    <div class="stat-card-label">Total Pengaduan</div>
                    <div class="stat-card-value" data-count="<?= $pengaduan ?>">0</div>
                  </div>
                  <div class="stat-card-icon">
                    <i class="fas fa-file-alt"></i>
                  </div>
                </div>
                <div class="stat-card-footer">
                  <span><i class="fas fa-inbox"></i> Semua laporan masuk</span>
                </div>
              </div>
            </div>

            <!-- Sedang Diproses -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="stat-card stat-card-amber">
                <div class="stat-card-body">
                  <div class="stat-card-content">
                    <div class="stat-card-label">Sedang Diproses</div>
                    <div class="stat-card-value" data-count="<?= $pengaduan_proses ?>">0</div>
                  </div>
                  <div class="stat-card-icon">
                    <i class="fas fa-spinner"></i>
                  </div>
                </div>
                <div class="stat-card-footer">
                  <span><i class="fas fa-clock"></i> Menunggu tindak lanjut</span>
                </div>
              </div>
            </div>

            <!-- Selesai -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="stat-card stat-card-emerald">
                <div class="stat-card-body">
                  <div class="stat-card-content">
                    <div class="stat-card-label">Selesai</div>
                    <div class="stat-card-value" data-count="<?= $pengaduan_selesai ?>">0</div>
                  </div>
                  <div class="stat-card-icon">
                    <i class="fas fa-check-circle"></i>
                  </div>
                </div>
                <div class="stat-card-footer">
                  <span><i class="fas fa-flag-checkered"></i> Terselesaikan</span>
                </div>
              </div>
            </div>

          </div>

          <!-- Charts & Recent Activity Row -->
          <div class="row">

            <!-- Chart Section -->
            <div class="col-xl-6 col-lg-6 mb-4">
              <div class="card dashboard-card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold">Statistik Pengaduan</h6>
                  <div class="dropdown">
                    <button class="btn btn-sm btn-outline-secondary rounded-pill px-3 dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-size: .75rem;">
                      Bulan Ini
                    </button>
                    <div class="dropdown-menu dropdown-menu-right shadow-sm" aria-labelledby="dropdownMenuButton">
                      <a class="dropdown-item" href="#">Minggu Ini</a>
                      <a class="dropdown-item" href="#">Bulan Ini</a>
                      <a class="dropdown-item" href="#">Tahun Ini</a>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <canvas id="complaintChart" width="400" height="180"></canvas>
                </div>
              </div>
            </div>

            <!-- Progress Summary -->
            <div class="col-xl-3 col-lg-3 mb-4">
              <div class="card dashboard-card h-100">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold">Progress</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center">
                  <?php 
                    $total = max($pengaduan, 1);
                    $selesai_pct = round(($pengaduan_selesai / $total) * 100);
                    $proses_pct  = round(($pengaduan_proses / $total) * 100);
                    $pending_pct = round(($pengaduan_pending / $total) * 100);
                    $tolak_pct   = round(($pengaduan_tolak / $total) * 100);
                  ?>
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="stat-progress-label"><i class="fas fa-check-circle text-success mr-1"></i> Selesai</span>
                      <span class="stat-progress-value"><?= $selesai_pct ?>%</span>
                    </div>
                    <div class="progress stat-progress-bar" style="height: 6px;">
                      <div class="progress-bar bg-success" role="progressbar" style="width: <?= $selesai_pct ?>%; border-radius: 10px;"></div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="stat-progress-label"><i class="fas fa-spinner text-warning mr-1"></i> Diproses</span>
                      <span class="stat-progress-value"><?= $proses_pct ?>%</span>
                    </div>
                    <div class="progress stat-progress-bar" style="height: 6px;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $proses_pct ?>%; border-radius: 10px;"></div>
                    </div>
                  </div>
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="stat-progress-label"><i class="fas fa-hourglass-half text-secondary mr-1"></i> Pending</span>
                      <span class="stat-progress-value"><?= $pending_pct ?>%</span>
                    </div>
                    <div class="progress stat-progress-bar" style="height: 6px;">
                      <div class="progress-bar bg-secondary" role="progressbar" style="width: <?= $pending_pct ?>%; border-radius: 10px;"></div>
                    </div>
                  </div>
                  <div class="mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                      <span class="stat-progress-label"><i class="fas fa-times-circle text-danger mr-1"></i> Ditolak</span>
                      <span class="stat-progress-value"><?= $tolak_pct ?>%</span>
                    </div>
                    <div class="progress stat-progress-bar" style="height: 6px;">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $tolak_pct ?>%; border-radius: 10px;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Quick Actions -->
            <div class="col-xl-3 col-lg-3 mb-4">
              <div class="card dashboard-card h-100">
                <div class="card-header">
                  <h6 class="m-0 font-weight-bold">Aksi Cepat</h6>
                </div>
                <div class="card-body d-flex flex-column justify-content-center gap-3">
                  <a href="<?= base_url('Admin/TanggapanController') ?>" class="quick-action-btn">
                    <span class="quick-action-icon" style="background: rgba(99,102,241,0.12); color: #6366f1;">
                      <i class="fas fa-inbox"></i>
                    </span>
                    <span class="quick-action-text">Pengaduan Masuk</span>
                    <i class="fas fa-chevron-right quick-action-arrow"></i>
                  </a>
                  <a href="<?= base_url('Admin/TanggapanController/tanggapan_proses') ?>" class="quick-action-btn">
                    <span class="quick-action-icon" style="background: rgba(245,158,11,0.12); color: #f59e0b;">
                      <i class="fas fa-tasks"></i>
                    </span>
                    <span class="quick-action-text">Sedang Diproses</span>
                    <i class="fas fa-chevron-right quick-action-arrow"></i>
                  </a>
                  <a href="<?= base_url('Admin/LaporanController') ?>" class="quick-action-btn">
                    <span class="quick-action-icon" style="background: rgba(16,185,129,0.12); color: #10b981;">
                      <i class="fas fa-file-pdf"></i>
                    </span>
                    <span class="quick-action-text">Generate Laporan</span>
                    <i class="fas fa-chevron-right quick-action-arrow"></i>
                  </a>
                  <?php if ($this->session->userdata('level') == 'admin') : ?>
                  <a href="<?= base_url('Admin/PetugasController') ?>" class="quick-action-btn">
                    <span class="quick-action-icon" style="background: rgba(236,72,153,0.12); color: #ec4899;">
                      <i class="fas fa-user-plus"></i>
                    </span>
                    <span class="quick-action-text">Tambah Petugas</span>
                    <i class="fas fa-chevron-right quick-action-arrow"></i>
                  </a>
                  <?php endif; ?>
                </div>
              </div>
            </div>

          </div>

          <!-- Recent Complaints Table -->
          <div class="card dashboard-card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
              <h6 class="m-0 font-weight-bold">Pengaduan Terbaru</h6>
              <a href="<?= base_url('Admin/TanggapanController') ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3" style="font-size: .75rem;">
                Lihat Semua <i class="fas fa-arrow-right ms-1"></i>
              </a>
            </div>
            <div class="card-body p-0">
              <div class="table-responsive">
                <table class="table table-borderless mb-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Tanggal</th>
                      <th>Isi Laporan</th>
                      <th>Status</th>
                      <th class="text-center">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (empty($recent_complaints)) : ?>
                      <tr>
                        <td colspan="5" class="text-center text-muted py-4">Belum ada pengaduan</td>
                      </tr>
                    <?php else : ?>
                      <?php foreach ($recent_complaints as $r) : 
                        $status_label = '';
                        $status_class = '';
                        if ($r['status'] == '0') {
                          $status_label = 'Pending';
                          $status_class = 'badge-pending';
                        } elseif ($r['status'] == 'proses') {
                          $status_label = 'Diproses';
                          $status_class = 'badge-proses';
                        } elseif ($r['status'] == 'selesai') {
                          $status_label = 'Selesai';
                          $status_class = 'badge-selesai';
                        } elseif ($r['status'] == 'tolak') {
                          $status_label = 'Ditolak';
                          $status_class = 'badge-tolak';
                        }
                      ?>
                      <tr>
                        <td class="fw-bold">#<?= $r['id_pengaduan'] ?></td>
                        <td class="text-muted"><?= date('d M Y', strtotime($r['tgl_pengaduan'])) ?></td>
                        <td class="text-truncate" style="max-width: 240px;"><?= htmlspecialchars($r['isi_laporan']) ?></td>
                        <td><span class="badge-status <?= $status_class ?>"><?= $status_label ?></span></td>
                        <td class="text-center">
                          <a href="<?= base_url('Admin/TanggapanController/tanggapan_detail/'.$r['id_pengaduan']) ?>" class="premium-btn premium-btn-outline premium-btn-sm">
                            Detail
                          </a>
                        </td>
                      </tr>
                      <?php endforeach; ?>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->

<script>
document.addEventListener("DOMContentLoaded", function() {
    var ctx = document.getElementById('complaintChart').getContext('2d');
    var complaintChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Diproses', 'Selesai', 'Ditolak'],
            datasets: [{
                data: [
                    <?= $pengaduan_pending ?>,
                    <?= $pengaduan_proses ?>,
                    <?= $pengaduan_selesai ?>,
                    <?= $pengaduan_tolak ?>
                ],
                backgroundColor: ['#94a3b8', '#f59e0b', '#10b981', '#ef4444'],
                borderWidth: 0,
                hoverBackgroundColor: ['#94a3b8', '#f59e0b', '#10b981', '#ef4444']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutoutPercentage: 70,
            legend: {
                position: 'bottom',
                labels: {
                    padding: 16,
                    usePointStyle: true,
                    fontFamily: "'Plus Jakarta Sans', sans-serif",
                    fontSize: 11,
                    fontStyle: '600',
                    fontColor: '#475569'
                }
            },
            tooltips: {
                backgroundColor: '#1e293b',
                titleFontFamily: "'Plus Jakarta Sans', sans-serif",
                bodyFontFamily: "'Plus Jakarta Sans', sans-serif",
                bodyFontSize: 12,
                cornerRadius: 8,
                xPadding: 12,
                yPadding: 10
            }
        }
    });

    // Animated Counter
    function animateCounters() {
        document.querySelectorAll('.stat-card-value[data-count]').forEach(function(el) {
            var target = parseInt(el.getAttribute('data-count'));
            if (target === 0) { el.textContent = '0'; return; }
            var current = 0;
            var increment = Math.max(1, Math.floor(target / 30));
            var timer = setInterval(function() {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                el.textContent = current.toLocaleString();
            }, 40);
        });
    }

    animateCounters();
});
</script>