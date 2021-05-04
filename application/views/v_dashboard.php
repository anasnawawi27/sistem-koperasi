
<main>
    <?php 

    $barang = $this->db->get('tb_barang')->result_array();
    $unit = $this->db->get('tb_unit')->result_array();
    $detail_transaksi = $this->db->get('tb_detailtransaksi')->result_array();
    $inventori = $this->db->get('tb_inventori')->result_array();

    $data_barang = count($barang);
    $data_unit = count($unit);
    $data_detail_transaksi = count($detail_transaksi);
    $data_inventori = count($inventori);

    date_default_timezone_set("Asia/Jakarta");

     ?>
               <div class="container-fluid mt-5">
                        <div class="d-flex justify-content-between align-items-sm-center flex-column flex-sm-row mb-4">
                            <div class="mr-4 mb-3 mb-sm-0">
                                <h1 class="mb-0">Dashboard</h1>
                                <div class="small"><span class="font-weight-500 text-primary"><?= hari();?></span> <?= $tanggal = date('d') . " " . bulan() . " " . date('Y') ?> &middot; <span id="jam" class="badge badge-teal p-2" style="font-size: 13px; font-weight: bold"></span></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-blue h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small font-weight-bold text-blue mb-1">Barang</div>
                                                <div class="h5"><?= $data_barang ?></div>
                                            </div>
                                            <div class="ml-2"><i class="fab fa-dropbox fa-2x text-gray-200"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-purple h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small font-weight-bold text-purple mb-1">Unit</div>
                                                <div class="h5"><?= $data_unit; ?></div>
                                            </div>
                                            <div class="ml-2"><i class="fas fa-tag fa-2x text-gray-200"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-green h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small font-weight-bold text-green mb-1">Transaksi</div>
                                                <div class="h5"><?= $data_detail_transaksi; ?></div>
                                            </div>
                                            <div class="ml-2"><i class="fas fa-mouse-pointer fa-2x text-gray-200"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-top-0 border-bottom-0 border-right-0 border-left-lg border-yellow h-100">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-grow-1">
                                                <div class="small font-weight-bold text-yellow mb-1">Inventori</div>
                                                <div class="h5"><?= $data_inventori; ?></div>
                                            </div>
                                            <div class="ml-2"><i class="fas fa-percentage fa-2x text-gray-200"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="alert alert-primary border-0 mb-4 mt-3 px-md-5">
                            <div class="position-relative">
                                <div class="row align-items-center justify-content-between">
                                    <div class="col position-relative">
                                        <h2 class="text-primary">Selamat Datang, <?= $this->session->userdata('nama_lengkap') ?> !</h2>
                                        <p class="text-gray-700">Sudah siap bekerja hari ini ?</p>
                                        <a class="btn btn-teal" href="<?= base_url('transaksi') ?>">Transaksi<i class="ml-1" data-feather="arrow-right"></i></a>
                                    </div>
                                    <div class="col d-none d-md-block text-right pt-3"><img class="img-fluid mt-n5" src="<?= base_url()?>material/assets/img/drawkit/color/drawkit-content-man-alt.svg" style="max-width: 25rem;" /></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            <script>

             window.onload = function() { jam(); }

             function jam() {
              var e = document.getElementById('jam'),
              d = new Date(), h, m, s;
              h = d.getHours();
              m = set(d.getMinutes());
              s = set(d.getSeconds());

              e.innerHTML = h +' : '+ m +' : '+ s;

              setTimeout('jam()', 1000);
             }

             function set(e) {
              e = e < 10 ? '0'+ e : e;
              return e;
             }
            </script>