        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="page-header">
              <h1 class="h3"><?= $title; ?></h1>
              <p class="page-subtitle">Cetak laporan rekapitulasi pengaduan masyarakat</p>
            </div>
            <?php if ($laporan) : ?>
              <div class="d-flex" style="gap: 8px;">
                <a target="_blank" href="<?= base_url('Admin/LaporanController/generate_laporan') ?>" class="premium-btn premium-btn-primary">
                  <i class="fas fa-eye"></i> Preview
                </a>
                <a href="<?= base_url('Admin/LaporanController/download_laporan') ?>" class="premium-btn premium-btn-success">
                  <i class="fas fa-download"></i> Download
                </a>
              </div>
            <?php endif; ?>
          </div>

          <?php if ($laporan) : ?>
            <div class="card dashboard-card">
              <div class="card-header">
                <h6><i class="fas fa-table"></i> Data Laporan Pengaduan</h6>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="premium-table mb-0">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>Isi Laporan</th>
                        <th>Tgl Lapor</th>
                        <th>Status</th>
                        <th>Tanggapan</th>
                        <th>Tgl Tanggapi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; ?>
                      <?php foreach($laporan as $l) : ?>
                        <tr>
                          <td class="fw-bold"><?= $no++; ?></td>
                          <td><?= htmlspecialchars($l['nama'], ENT_QUOTES, 'UTF-8') ?></td>
                          <td><?= htmlspecialchars($l['nik'], ENT_QUOTES, 'UTF-8') ?></td>
                          <td style="max-width: 200px;" class="text-truncate"><?= htmlspecialchars($l['isi_laporan'], ENT_QUOTES, 'UTF-8') ?></td>
                          <td><?= date('d/m/Y', strtotime($l['tgl_pengaduan'])) ?></td>
                          <td>
                            <?php
                            if ($l['status'] == '0') :
                              echo '<span class="badge-status badge-pending">Verifikasi</span>';
                            elseif ($l['status'] == 'proses') :
                              echo '<span class="badge-status badge-proses">Proses</span>';
                            elseif ($l['status'] == 'selesai') :
                              echo '<span class="badge-status badge-selesai">Selesai</span>';
                            elseif ($l['status'] == 'tolak') :
                              echo '<span class="badge-status badge-tolak">Ditolak</span>';
                            else :
                              echo '-';
                            endif;
                            ?>
                          </td>
                          <td><?= $l['tanggapan'] == null ? '-' : htmlspecialchars($l['tanggapan'], ENT_QUOTES, 'UTF-8'); ?></td>
                          <td><?= $l['tgl_tanggapan'] == null ? '-' : date('d/m/Y', strtotime($l['tgl_tanggapan'])); ?></td>
                        </tr>
                      <?php endforeach; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          <?php else : ?>
            <div class="text-center py-5">
              <div style="font-size: 3rem; color: #cbd5e1; margin-bottom: 16px;">
                <i class="fas fa-file-excel"></i>
              </div>
              <p class="text-muted" style="font-size: .95rem;">Belum ada data laporan</p>
            </div>
          <?php endif; ?>

        </div>
      <!-- End of Main Content -->