<main>
    <div class="page-header pb-10 page-header-dark bg-gradient-primary-to-secondary">
        <div class="container-fluid">
            <div class="page-header-content">
            </div>
        </div>
    </div>
    <div class="container-fluid" style="margin-top: -175px;">
    	<div class="card">
            <div class="card-header">
                <div class="col-md-12">
	            <form action="" method="post">
	                <div class="row">
	                    <input type="date" name="mulai" class="form form-control col-sm-2 mr-3 form-control-sm solid" id="mulai"> 
	                    <input type="date" name="sampai" class="form form-control col-sm-2 form-control-sm solid" id="sampai">
	                    <select class="form-control col-sm-2 ml-3 form-control-sm" name="unit" id="unit">
	                    	<option value="">Pilih</option>
	                    	<?php foreach ($unit as $u) : ?>
	                    	<option value="<?= $u['id_unit']; ?>"><?= $u['nama_unit']; ?></option>
	                    	<?php endforeach; ?>
	                    </select>
	                    <select class="form-control col-sm-2 ml-2 form-control-sm" name="kategori" id="kategori">
	                    	<option value="">Pilih</option>
	                    	<option value="ATK">ATK</option>
	                    	<option value="PRC">PRC</option>
	                    	<option value="SUP">SUP</option>
	                    	<option value="AKB">AKB</option>
	                    </select>
	                    <button class="btn btn-secondary float-left ml-3 btn-sm" type="submit" name="cari" value="0" id="caridata"><i data-feather="search"></i> &nbsp;Cari Data</button>
                      	<a id="export" target="_blank" href="<?= base_url() ?>report" class="btn btn-danger float-left ml-3 btn-sm">
                        <i data-feather="file-text"></i>&nbsp;Transaksi Hari ini</a>
	                </div>
	            </form>
	        </div>
            </div>
            <div class="card-body">
            	<table class="table table-striped" id="data-table">
		    		<thead>
		    			<tr>
			    			<th><center>No</center></th>
			    			<th>Unit</th>
			    			<th>Nama Barang</th>
			    			<th><center>Kategori</center></th>
			    			<th><center>Jumlah</center></th>
                			<th>Total</th>
			    			<th>Tanggal</th>
		    			</tr>
		    		</thead>
		    		<tbody id="show-data">
		    		<?php $no=1; foreach ($data as $d) : ?>
		    			<tr>
		    				<td><center><?= $no++ ?></center></td>
		    				<td><?= $d['nama_unit'] ?></td>
		    				<td><?= $d['nama_barang'] ?></td>
		    				<td><center><?= $d['kategori'] ?></center></td>
		    				<td><center><?= $d['jumlah_beli'] ?></center></td>
		    				<td>Rp. <?= number_format($d['total'],0,',','.'); ?></td>
                <td>
                  <?php 

                                $create = explode(' ', $d['created_at']);
                                $create2 = explode('-', $create[0]);
                                $tanggal = $create2[2];
                                $bulan = $create2[1];
                                $tahun = $create2[0];

                                $tampil_tanggal = $tanggal."-".$bulan."-".$tahun;
                                $param = $d['id_transaksi'];
                                echo $tampil_tanggal;
                    ?>
                </td>
		    			</tr>
		    		<?php endforeach; ?>
		    	</tbody>
		    	</table>
            </div>
        </div> 

    </div>   
</main>
  <script src="<?= base_url();?>material/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
  <script>

    $(document).ready(function() {
    $('#data-table').dataTable( {
        sDom: 'lrtip'
        } );
    } );

  	function rupiah(bilangan){
  		var	reverse = bilangan.toString().split('').reverse().join(''),
		ribuan 	= reverse.match(/\d{1,3}/g);
		return ribuan = ribuan.join('.').split('').reverse().join('');
  	}

	// $('#export').on('click', function(e){
	// 	// e.preventDefault();
	// 	var mulai = $('#mulai').val();

	// 	if (!mulai) {
  	// 	  Swal.fire({
    //       icon: 'error',
    //       title: 'Gagal !',
    //       text: 'Input Kosong, harap isi !',
    //     })} else {
	// 		$.ajax({
  	// 		url : 'report',
  	// 		method : 'post',
  	// 		data : {mulai: mulai},
  	// 		success: function(hasil){
  	// 			// var data = $.parseJSON(hasil);
				
	// 			// var html = '';
    //             // var i;
    //             // var no = 1;
    //             // for(i=0; i<data.length; i++){
    //             //     html += '<tr>'+
    //             //     			'<td><center>'+no+'</center></td>'+
    //             //                 '<td>'+data[i].nama_unit+'</td>'+
    //             //                 '<td>'+data[i].nama_barang+'</td>'+
    //             //                 '<td><center>'+data[i].kategori+'</center></td>'+
    //             //                 '<td><center>'+data[i].jumlah_beli+'</center></td>'+
    //             //                 '<td> Rp. '+ rupiah(data[i].total) +'</td>'+
    //             //                 '<td>'+data[i].created_at+'</td>'+

    //             //             '</tr>';
    //             //     no++;
    //             //  }

    //             // $('#show-data').html(html);
  	// 		}
  	// 	});
	// 	}
	// })

  	$('#caridata').on('click', function(e){

  		e.preventDefault();
  		var mulai = $('#mulai').val();
  		var sampai = $('#sampai').val();
  		var unit = $('#unit').val();
  		var kategori = $('#kategori').val();

  		if (!mulai && !sampai && !kategori && !unit) {
  			Swal.fire({
          icon: 'error',
          title: 'Gagal !',
          text: 'Filter Kosong, harap isi !',
        })
  		} else {
  			$.ajax({
  			url : '<?= base_url() ?>filter/filterdata',
  			method : 'post',
  			data : {mulai: mulai, sampai: sampai, unit: unit, kategori: kategori},
  			success: function(hasil){
  				var data = $.parseJSON(hasil);
				
				var html = '';
                var i;
                var no = 1;
                for(i=0; i<data.length; i++){
                    html += '<tr>'+
                    			'<td><center>'+no+'</center></td>'+
                                '<td>'+data[i].nama_unit+'</td>'+
                                '<td>'+data[i].nama_barang+'</td>'+
                                '<td><center>'+data[i].kategori+'</center></td>'+
                                '<td><center>'+data[i].jumlah_beli+'</center></td>'+
                                '<td> Rp. '+ rupiah(data[i].total) +'</td>'+
                                '<td>'+data[i].created_at+'</td>'+

                            '</tr>';
                    no++;
                 }

                $('#show-data').html(html);
  			}
  		});
  		}

  	})

  </script>