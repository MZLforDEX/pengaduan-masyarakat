        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="page-header-row">
            <div class="d-flex align-items-center" style="gap: 14px;">
              <a href="<?= base_url('Masyarakat/PengaduanController') ?>" class="back-link">
                <i class="fas fa-arrow-left"></i> Kembali
              </a>
              <div class="page-header" style="margin: 0;">
                <h1 class="h3">Edit Pengaduan</h1>
                <p class="page-subtitle">Ubah laporan pengaduan Anda</p>
              </div>
            </div>
          </div>

          <?= validation_errors('<div class="alert alert-danger premium-alert alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>') ?>
          <?= $this->session->flashdata('msg'); ?>

          <div class="row">
            <div class="col-lg-7">
              <div class="card dashboard-card">
                <div class="card-header">
                  <h6><i class="fas fa-edit"></i> Edit Laporan</h6>
                </div>
                <div class="card-body">
                  <?= form_open_multipart('Masyarakat/PengaduanController/edit/'.$pengaduan['id_pengaduan'], 'class="premium-form"'); ?>
                    <div class="form-group">
                      <label for="isi_laporan">Isi Laporan</label>
                      <textarea name="isi_laporan" id="isi_laporan" cols="30" rows="6" class="form-control"><?= htmlspecialchars($pengaduan['isi_laporan']) ?></textarea>
                    </div>
                    <div class="form-group">
                      <label for="foto">Ganti Foto (opsional)</label>
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="foto" name="foto">
                        <label class="custom-file-label" for="foto">Pilih file</label>
                      </div>
                      <small class="text-muted" style="font-size: .72rem;">Format: jpg, jpeg, png. Maks: 2MB. Kosongkan jika tidak ingin mengganti foto.</small>
                    </div>
                    <button type="submit" class="btn-submit">
                      <i class="fas fa-save"></i> Simpan Perubahan
                    </button>
                  <?php form_close(); ?>
                </div>
              </div>
            </div>
          </div>

        </div>
      <!-- End of Main Content -->