<div class="container">

  <!-- Outer Row -->
  <div class="row justify-content-center">

    <div class="col-lg-6">

      <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
          <!-- Nested Row within Card Body -->
          <div class="row">
            <div class="col-lg-12">
              <div class="p-5">
                 <div class="text-center">
                   <h1 class="h4 text-gray-900 mb-1 font-weight-bold">Portal Petugas & Admin</h1>
                   <p class="text-muted small mb-4">Silakan login untuk memproses pengaduan dan mengelola tanggapan masyarakat.</p>
                 </div>

                 <?= validation_errors('<div class="alert alert-danger alert-dismissible fade show" role="alert">','<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                 </div>') ?>

                 <?= $this->session->flashdata('msg'); ?>
                 
                 <?= form_open('Auth/LoginPetugasController', 'class="user"'); ?>
                   <div class="form-group">
                     <label class="small font-weight-semibold text-gray-700 pl-1" for="username">Username Petugas</label>
                     <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="Masukkan Username..." autofocus value="<?= set_value('username') ?>">
                   </div>
                   <div class="form-group">
                     <label class="small font-weight-semibold text-gray-700 pl-1" for="password">Password</label>
                     <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Masukkan Password...">
                   </div>
                   <button type="submit" class="btn btn-primary btn-user btn-block mt-4">Login Ke Dashboard</button>
                 </form>
                 <hr>
                 <div class="text-center">
                   <a class="small text-info font-weight-bold" href="<?= base_url('Auth/LoginController') ?>">
                     <i class="fas fa-arrow-left mr-1"></i> Kembali ke Portal Warga
                   </a>
                 </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

</div>
