
<main>
    <?php 
        $query = "SELECT * FROM tb_unit WHERE nama_unit LIKE '%cikampek%'";
        $ckp = $this->db->query($query)->row();
        $query = "SELECT * FROM tb_unit WHERE nama_unit LIKE '%kosambi%'";
        $ksb = $this->db->query($query)->row();
    ?>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
            </div>
        </div>
    </div>
    <div class="container-fluid" style="margin-top: -175px;">
        <div class="row">
          <div class="col-md-6">
           <div class="card mb-4 ">
            <div class="card-header">
                <div>
                    Report Transaksi Cabang
                </div>
                <div class="flash-dataa" data-flashdataa="<?= $this->session->flashdata('fail'); ?>">
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url() ?>laporan/exportCabangBulan" method="post">
                    <div class="form-group">
                        <select class="form-control" name="cabang" id="cabang" required>
                            <option hidden>Pilih Cabang</option>
                            <option value="<?= $ckp->id_unit ?>"><?= $ckp->nama_unit ?></option>
                            <option value="<?= $ksb->id_unit ?>"><?= $ksb->nama_unit ?></option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="bulan_cabang" id="bulan_cabang" required>
                            <option hidden>Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="tahun_cabang" id="tahun_cabang" class="form-control">
                            <option hidden>Pilih Tahun</option>
                            <?php foreach ($tahun as $t) : ?>
                                <option value="<?= $t ?>"><?= $t ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-success float-right btn-sm" id="export1"><i class="fa fa-download"></i>&nbsp;Export Excel</button>
                </form>
            </div>
        </div> 
        </div>

        <div class="col-md-6 float-left">
           <div class="card mb-4 ">
            <div class="card-header">
                <div>
                    Report Debet
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url() ?>laporan/exportDebetKategori" method="post">
                    <div class="form-group">
                        <select class="form-control" name="kategori_debet" id="kategori_debet" required>
                            <option hidden>Pilih Kategori</option>
                            <option value="ATK">Alat Tulis Kantor</option>
                            <option value="PRC">Percetakan</option>
                            <option value="SUP">Supplais</option>
                            <option value="AKB">Alat Kebersihan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="bulan_debet" id="bulan_debet" required>
                            <option hidden>Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="tahun_debet" id="tahun_debet" class="form-control">
                            <option hidden>Pilih Tahun</option>
                            <?php foreach ($tahun as $t) :?>
                                <option value="<?= $t ?>"><?= $t ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-success float-right btn-sm" id="export1"><i class="fa fa-download"></i>&nbsp;Export Excel</button>
                </form>
            </div>
        </div> 
        </div>    
        </div>
        <div class="row">
        <div class="col-md-12">
           <div class="card mb-4 ">
            <div class="card-header">
                <div>
                    Report Transaksi Unit - <strong>By Month</strong>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url() ?>laporan/exportUnitBulan" method="POST">
                    <div class="form-group">
                        <select class="form-control" name="bulan_unit" required>
                            <option hidden>Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="tahun_unit" id="tahun_unit" class="form-control">
                            <option hidden>Pilih Tahun</option>
                            <?php foreach ($tahun as $t) : ?>
                            <option value="<?= $t ?>"><?= $t ?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                    <button class="btn btn-success float-right btn-sm"><i class="fa fa-download"></i>&nbsp;Export Excel</button>
                </form>
            </div>
        </div> 
        </div>

 
          <div class="col-md-12">
           <div class="card mb-4 ">
            <div class="card-header">
                <div>
                    Report Transaksi Unit - <strong>By Category</strong>
                </div>
            </div>
            <div class="card-body">
                <form action="<?= base_url() ?>laporan/exportKategoriBulan" method="post">
                    <div class="form-group">
                        <select class="form-control" name="kategori" id="kategori" required>
                            <option hidden>Pilih Kategori</option>
                            <option value="ATK">Alat Tulis Kantor</option>
                            <option value="PRC">Percetakan</option>
                            <option value="SUP">Supplais</option>
                            <option value="AKB">Alat Kebersihan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select class="form-control" name="bulan_kategori" id="bulan_kategori" required>
                            <option hidden>Pilih Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="tahun_kategori" id="tahun_kategori" class="form-control">
                            <option hidden>Pilih Tahun</option>
                            <?php foreach ($tahun as $t) : ?>
                            <option value="<?= $t ?>"><?= $t ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button class="btn btn-success float-right btn-sm" id="export1"><i class="fa fa-download"></i>&nbsp;Export Excel</button>
                </form>
            </div>
        </div> 
        </div>
      </div>
    </div>
</main>
<script src="<?= base_url()?>material/js/sweetalert2.all.min.js"></script>
<script src="<?= base_url();?>material/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script>
    const flashdata2 = $('.flash-dataa').data('flashdataa');

    if (flashdata2 == "Gagal") {

        Swal.fire({
            icon: 'warning',
            text: 'Input Kosong! Silahkan isi!',
        });

    }
</script>