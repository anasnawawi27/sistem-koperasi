<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content" style="margin-top: -20px;">
                <h4 class="page-header-title">
                    <div class="page-header-icon">
                        <i data-feather="package"></i>
                    </div>
                     <span>Data Inventori</span>
                </h4>
                <div class="page-header-subtitle"></div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="margin-top: -130px;">
        <div class="card mb-4">
            <div class="card-header">
                <div>
                    <a href="<?= base_url('inventori/tambah'); ?>" class="btn btn-info">Tambah Data</a>
                    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>">
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="datatable table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="5px;">No</th>
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Detail</th>
                                <th>Qty</th>
                                <th>Tanggal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($inventori as $inv) : ?>
                            <tr>
                                <td><center><?= $no++ ?></center></td>
                                <td><?= $inv['kode_barang'] ?></td>
                                <td><?= $inv['nama_barang'] ?></td>
                                <td><?= $inv['detail_barang'] ?></td>
                                <td><?= $inv['qty'] ?></td>
                                <td><?php 

                                $create = explode(' ', $inv['created_at']);
                                $create2 = explode('-', $create[0]);
                                $tanggal = $create2[2];
                                $bulan = $create2[1];
                                $tahun = $create2[0];

                                $tampil_tanggal = $tanggal."-".$bulan."-".$tahun;

                                echo $tampil_tanggal;
                                 ?></td>
                                <td>
                                    <center>
                                    <a href="<?= base_url(); ?>inventori/ubah/<?= $inv['id_inventori'] ?>" class="badge badge-info"><i data-feather="edit"></i>
                                    </a>
                                    <a href="<?= base_url() ?>inventori/hapus/<?= $inv['id_inventori'] ?>/<?= $inv['id_barang']; ?>/<?= $inv['qty'] ?>" class="badge badge-danger tombol-hapus"><i data-feather="trash-2"></i></a>
                                    </center>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
<script src="<?= base_url();?>material/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script type="text/javascript">
    $('.tombol-hapus').on('click', function(e){

    e.preventDefault();

    const href = $(this).attr('href');
    
    Swal.fire({
      title: 'Apakah anda yakin?',
      text: "Data akan dihapus!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Ya, hapus!',
      cancelButtonText: 'Batal',
    }).then((result) => {
        if(result.value){
           document.location.href = href; 
        }
    })

});
</script>