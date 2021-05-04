<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
                
            </div>
        </div>
    </div>
     <div class="container-fluid" style="margin-top: -175px;">
        <div class="card mb-4 ml-3 mr-3">
            <div class="card-header"> 
            	<div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>">
            	</div>
            	Tambah Data Barang
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label>Kode Barang</label>
                                    <input class="form-control" type="text" name="kode_barang" autocomplete="off" value="<?= set_value('kode_barang') ?>" />
                                    <small class="form-text text-danger"><?= form_error('kode_barang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input class="form-control" type="text" name="nama_barang" autocomplete="off" value="<?= set_value('nama_barang') ?>"/>
                                    <small class="form-text text-danger"><?= form_error('nama_barang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>Detail</label>
                                    <Input class="form-control" rows="3" name="detail_barang" autocomplete="off">
                                    <small class="form-text text-danger"><?= form_error('detail_barang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>Harga Beli</label>
                                    <input class="form-control" type="number" name="harga_beli" autocomplete="off" value="<?= set_value('harga_beli') ?>" onkeyup="hitung()" id="harga_beli"/>
                                    <small class="form-text text-danger"><?= form_error('harga_beli'); ?></small>
                                </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                    <label>Harga Jual</label>
                                    <input class="form-control" type="number" name="harga_jual" autocomplete="off" value="<?= set_value('harga_jual') ?>" id="harga_jual"/>
                                    <small class="form-text text-danger"><?= form_error('harga_jual'); ?></small>
                            </div>
                            <div class="form-group">
                                <label>Satuan</label>
								<select class="form-control" name="satuan">
                                    <option hidden>--Pilih satuan--</option>
                                    <option>PCS</option>
                                    <option>RIM</option>
                                    <option>DUS</option>
                                    <option>PAK</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
								<select class="form-control" name="kategori">
                                    <option hidden>--Pilih kategori--</option>
                                    <option>ATK</option>
                                    <option>PRC</option>
                                    <option>SUP</option>
                                    <option>AKB</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">
                                    Tambah
                                </button>
                                <a href="<?= base_url() ?>barang" class="btn btn-warning kembali" >
                                    Kembali
                                </a>
                            </div>
                            </form> 
                        </div>
                     </div>       
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
    function hitung(){
        var harga_beli = Number(document.getElementById('harga_beli').value);
        var total = Math.round(harga_beli * 0.2);

        document.getElementById('harga_jual').value = total + harga_beli;
    }
</script>
