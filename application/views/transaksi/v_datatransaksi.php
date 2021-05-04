<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content" style="margin-top: -20px;">
                <h4 class="page-header-title">
                    <div class="page-header-icon">
                        <i data-feather="bar-chart"></i>
                    </div>
                     <span>Data Transaksi</span>
                </h4>
                <div class="page-header-subtitle"></div>
            </div>
        </div>
    </div>
    <div class="container-fluid" style="margin-top: -130px;">
        <div class="card mb-4">
            <div class="card-header">
                <div>
                    <a href="<?= base_url('transaksi'); ?>" class="btn btn-info">Tambah Data</a>
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
                                <th>Unit</th>
                                <th>Cara Bayar</th>
                                <th>Status Bayar</th>
                                <th>Pengambilan</th>
                                <th>Tanggal</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $no = 1; foreach ($data as $d) : ?>
                            <tr>
                                <td><center><?= $no++; ?></center></td>
                                <td><?= $d['nama_unit'] ?></td>
                                <td>
                                    <?php if ($d['cara_bayar'] == 1) {
                                        echo "<h6><span class='badge badge-primary' style='border-radius: 20px; padding: 6px;'>&nbsp;&nbsp;&nbsp;Dibayar Cash&nbsp;&nbsp;&nbsp;</span><h6>";
                                    } else {
                                       echo "<h6><span class='badge badge-indigo' style='border-radius: 20px; padding: 6px;'>&nbsp;&nbsp;&nbsp;Dibayar Kredit&nbsp;&nbsp;&nbsp;</span><h6>";
                                    } ?>
                                </td>
                                <td>
                                    <?php if ($d['status_bayar'] == 1) {
                                        echo "<h6><span class='badge badge-success' style='border-radius: 20px; padding: 6px;'>&nbsp;&nbsp;&nbsp;Sudah Lunas&nbsp;&nbsp;&nbsp;</span><h6>";
                                    } else {
                                        echo "<h6><span class='badge badge-danger' style='border-radius: 20px; padding: 6px;'>&nbsp;&nbsp;&nbsp;Belum Lunas&nbsp;&nbsp;&nbsp;</span><h6>";
                                    } ?>
                                </td>
                                <td>
                                    <?php if ($d['status_pengambilan'] == 1) {
                                         echo "<h6><span class='badge badge-info' style='border-radius: 20px; padding: 6px;'>&nbsp;&nbsp;&nbsp;Sudah Diambil&nbsp;&nbsp;&nbsp;</span><h6>";
                                    } else {
                                        echo "<h6><span class='badge badge-danger' style='border-radius: 20px; padding: 6px;'>&nbsp;&nbsp;&nbsp;Belum Diambil&nbsp;&nbsp;&nbsp;</span><h6>";
                                    } ?>
                                </td>
                                <td><?php 

                                $create = explode(' ', $d['created_at']);
                                $create2 = explode('-', $create[0]);
                                $tanggal = $create2[2];
                                $bulan = $create2[1];
                                $tahun = $create2[0];

                                $tampil_tanggal = $tanggal."-".$bulan."-".$tahun;
                                $param = $d['id_transaksi'];
                                echo $tampil_tanggal;
                                 ?></td>
                                <td>
                                    <center>
                                    <a href="" class="badge badge-primary detail" data-toggle="modal" data-target="#exampleModalLg" data-parameter="<?= $d['id_transaksi']; ?>"><i data-feather="eye"></i>
                                    </a>
                                    <a href="<?= base_url('transaksi/ubahtransaksi') ?>/<?= $d['id_transaksi']; ?>" class="badge badge-info"><i data-feather="edit"></i></a>
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

    <!-- Large modal -->
<div class="modal fade" id="exampleModalLg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
            <div class="modal-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">No</th>
                      <th scope="col">Nama Barang</th>
                      <th scope="col"><center>Kategori</center></th>
                      <th scope="col">Harga</th>
                      <th scope="col"><center>Jumlah</center></th>
                      <th scope="col">Total</th>
                    </tr>
                  </thead>
                  <tbody id="detail_transaksi">
                  </tbody>
                </table>
            </div>
            <div class="modal-footer" id="footer-modal">
            </div>
        </div>
    </div>
</div>



</main>
<script src="<?= base_url();?>material/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script src="<?= base_url()?>material/js/sweetalert2.all.min.js"></script>

    <?php 
        if (isset($_POST['simpan'])) {
            if (empty($_POST['mulai'])) {
                echo "<script> Swal.fire('Gagal', 'Tanggal tidak boleh', 'warning'); </script>";
            } elseif (empty($_POST['sampai'])) {
               echo "<script> alert('Tanggal sampai tidak boleh kosong !') </script>";
            }
        }

     ?>
<script type="text/javascript">
    $('.tombol-hapus').on('click', function(e){
        
    e.preventDefault();

    const href = $(this).attr('href');

    Swal.fire(
        'Yakin mau menghapus ?',
        "Data akan dihapus !",
        'warning',
        true,
        'Ya, Hapus',
        'Tidak, Batal !',
        true).then((result) => {
        if(result.value){
           document.location.href = href; 
        }
    })

});
    $('.detail').on('click', function(e){

        var param = $(this).data('parameter');

        $.ajax({
            url: '<?= base_url() ?>transaksi/getdetailtransaksi',
            method: 'post',
            dataType: 'json',
            data: {id:param},
            success: function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        no = i+1;
                        html += '<tr>'+
                                '<td>'+ no +'</td>'+
                                '<td>'+data[i].nama_barang+'</td>'+
                                '<td> <center>'+data[i].kategori+'<center></td>'+
                                '<td> Rp. '+rubah(data[i].harga_jual)+'</td>'+
                                '<td> <center>'+data[i].jumlah_beli+'<center></td>'+
                                '<td> Rp. '+ rubah(data[i].total)+'</td>'+
                                '</tr>';
                        no++;
                    }
                    $('#detail_transaksi').html(html);

                    // if (data[0]['status_bayar'] == 0) {
                    //     $('#footer-modal').html("<button class='btn btn-danger' type='button' data-dismiss='modal'>Hapus</button>");
                    // }
                    
            }
        })
    })

     function rubah(angka){
       var reverse = angka.toString().split('').reverse().join(''),
       ribuan = reverse.match(/\d{1,3}/g);
       ribuan = ribuan.join('.').split('').reverse().join('');
       return ribuan;
     }




    $('#cari').submit(function(e){

        var mulai = $('#mulai').val();
        var sampai = $('#sampai').val();

        $.ajax({
            url: '<?= base_url() ?>transaksi/carilaporan',
            method: 'post',
            data: {mulai: mulai, sampai:sampai},
            success: function(e){
                var hasil = $.parseJSON(e);
                var_dump(hasil);
            }
        });
    });
</script>