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
            	<?= $judul; ?>
            </div>
            <div class="card-body">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8">
                            <form method="POST" action="">
                                <div class="form-group">
                                    <input type="hidden" name="id_inventori" value="<?= $inventori['id_inventori'] ?>">
                                    <label>Kode Barang</label>
                                    <input class="form-control" type="text" name="kode_barang" id="kodeBarangInv" autocomplete="off" onkeypress="return RestrictSpace()" onchange="get_detail(this.value, 1)" value="<?= $inventori['kode_barang'] ?>" />
                                    <small class="form-text text-danger"><?= form_error('kode_barang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" type="hidden" name="id_barang" autocomplete="off" id="idBarangInv" value="<?= $inventori['id_barang'] ?>"/>
                                    <small class="form-text text-danger"><?= form_error('id_barang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input class="form-control" type="text" name="nama_barang" autocomplete="off" value="<?= $inventori['nama_barang'] ?>" readonly id="namaBarangInv"/>
                                    <small class="form-text text-danger"><?= form_error('nama_barang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>Detail</label>
                                    <Input class="form-control" rows="4" name="detail_barang" readonly id="detailBarangInv" value="<?= $inventori['detail_barang'] ?>">
                                    <small class="form-text text-danger"><?= form_error('detail_barang'); ?></small>
                                </div>
                                <div class="form-group">
                                    <label>QTY</label>
                                    <input class="form-control" type="text" name="qty" autocomplete="off" value="<?= $inventori['qty'] ?>" id="qty"/><?= form_error('qty'); ?>

                                    <input class="form-control" type="hidden" name="qty_awal" autocomplete="off" value="<?= $inventori['qty'] ?>" id="qty"/>
                                </div>
                                <div class="form-group mt-4 pt-1">
                                    <button type="submit" class="btn btn-success tambahinv" name="tambahinv">
                                        Edit
                                    </button>
                                    <a href="<?= base_url() ?>inventori" class="btn btn-warning kembali" >
                                        Kembali
                                    </a>
                                </div>
                            </form> 
                        </div>


                        <div class="col-sm-4">
                                <img src="<?= base_url() ?>material/assets/img/drawkit/color/drawkit-charts-and-graphs.svg" style="width: 350px; transform: rotateY(180deg); margin-right: 50px; margin-top: 97px">
                        </div>

                     </div>       
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
            function RestrictSpace(){
                if(event.keyCode == 32){
                    return false;
                }
            }

            

            function get_detail(b,n){
                var nx = n+1;
                $.ajax({
                    method: 'POST',
                    url: '<?= base_url() ?>inventori/autokodebaranginv',
                    data: {kode_barang: b},
                    success: function(hasil){
                        var data = $.parseJSON(hasil)
                        console.log(data);
                        $('#idBarangInv').val(data.id_barang);
                        $('#namaBarangInv').val(data.nama_barang);
                        $('#detailBarangInv').val(data.detail_barang);
                        $('#kode_barang').focus();
                    }
                })
            }
</script>
