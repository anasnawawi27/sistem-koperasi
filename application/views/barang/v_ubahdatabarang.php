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
            	Ubah Data Barang
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <form method="POST" action="">
                                <input class="form-control" type="hidden" name="id_barang" value="<?= $ubah['id_barang'] ?>"/>
                                    <?= form_error('kode_barang'); ?>
                                <div class="form-group">
                                    <label>Kode Barang</label>
                                    <input class="form-control" type="text" name="kode_barang" value="<?= $ubah['kode_barang'] ?>"/>
                                    <?= form_error('kode_barang'); ?>
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input class="form-control" type="text" name="nama_barang" value="<?= $ubah['nama_barang'] ?>"/>
                                </div>
                                <div class="form-group">
                                    <label>Detail</label>
                                    <textarea class="form-control" rows="3" name="detail_barang"><?= $ubah['detail_barang'] ?></textarea>
                                </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Satuan</label>
								<select class="form-control" name="satuan">
                                    <option hidden>--Pilih satuan--</option>
                                    <?php foreach ($satuan as $stn) : ?>
                                        <?php if ($stn == $ubah['satuan']) : ?>
                                            <option value="<?=$stn ?>" selected><?=$stn ?></option>
                                        <?php else : ?>
                                            <option value="<?=$stn ?>"><?=$stn ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kategori</label>
								<select class="form-control" name="kategori">
                                    <option hidden>--Pilih kategori--</option>
                                    <?php foreach ($kategori as $ktgr) : ?>
                                        <?php if ($ktgr == $ubah['kategori']) : ?>
                                            <option value="<?=$ktgr ?>" selected><?=$ktgr ?></option>
                                        <?php else : ?>
                                            <option value="<?=$ktgr ?>"><?=$ktgr ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">
                                    Edit
                                </button>
                                <a href="<?= base_url('barang'); ?>" class="btn btn-warning kembali">
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
