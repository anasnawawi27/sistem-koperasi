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
            	<?= $judul ?>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <label>Nama Unit</label>
                                    <input class="form-control" type="text" name="nama_unit" autocomplete="off" value="<?= set_value('nama_unit') ?>" />
                                    <small class="form-text text-danger"><?= form_error('nama_unit'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>No telp</label>
                                    <input class="form-control" type="number" name="no_telp" autocomplete="off" value="<?= set_value('no_telp') ?>"/>
                                    <small class="form-text text-danger"><?= form_error('no_telp'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>Nama PIC</label>
                                    <input class="form-control" type="text" name="nama_pic" autocomplete="off" value="<?= set_value('nama_pic') ?>"/>
                                    <small class="form-text text-danger"><?= form_error('nama_pic'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>Telp PIC</label>
                                    <input class="form-control" type="number" name="no_telp_pic" autocomplete="off" value="<?= set_value('no_telp_pic') ?>"/>
                                    <small class="form-text text-danger"><?= form_error('no_telp_pic'); ?></small>
                                </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                    <label>No Rek</label>
                                    <input class="form-control" type="number" name="no_rek" autocomplete="off" value="<?= set_value('no_rek') ?>"/>
                                    <small class="form-text text-danger"><?= form_error('no_rek'); ?></small>
                            </div>
                            <div class="form-group">
                                <label>Alamat</label>
                                    <textarea class="form-control" rows="6" name="alamat"></textarea>
                                    <small class="form-text text-danger"><?= form_error('alamat'); ?></small>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">
                                    Tambah
                                </button>
                                <a href="<?= base_url() ?>unit" class="btn btn-warning kembali" >
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
