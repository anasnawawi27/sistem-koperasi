<main class="bg-gradient-primary-to-secondary pb-5">
<div class="container-fluid mt-5">
    <div class="container-fluid">
        <div class="card">
          <div class="card-header">
                    <div class="container pr-0">
                       <div class="flash-data" data-flashdata="<?= $this->session->flashdata('flash'); ?>">
                        </div>
                    Tambah Transaksi
                    </div>
          </div>
            <div class="container p-3">
              <form action="<?= base_url() ?>transaksi/simpandata" method="post" id="SimpanData">
                <select class="form-control kode_unit mb-3" name="kode_unit" id="unit">
                    <option hidden>Pilih unit</option>
                        <?php foreach ($option as $opt) : ?>
                            <option value="<?= $opt['id_unit'] ?>"><?= $opt['nama_unit'] ?></option>
                        <?php endforeach; ?>
                </select>
                <select class="form-control mb-3" name="cara_bayar" id="cara_bayar">
                    <option hidden>Cara Bayar</option>
                    <option value="1">Cash</option>
                    <option value="0">Kredit</option>
                </select>
                <select class="form-control mb-3" name="status_bayar" id="status_bayar">
                    <option hidden>Status Bayar</option>
                    <option value="1">Lunas</option>
                    <option value="0">Belum lunas</option>
                </select>
                <select class="form-control mb-3" name="status_pengambilan"id="status_pengambilan">
                    <option hidden>Pengambilan Barang</option>
                    <option value="1">Diambil</option>
                    <option value="0">Belum diambil</option>
                </select>
                <table class="table table-striped mt-3" id="tableLoop">
                  <thead>
                      <tr>
                        <th class="text-center">#</th>
                        <th style="width: 150px">Kode</th>
                        <th>Barang</th>
                        <th style="width: 140px">Harga</th>
                        <th style="width: 100px">Jumlah</th>
                        <th style="width: 150px">Total</th>
                        <th><button class="btn btn-success btn-block btn-sm" id="BarisBaru"><i class="fa fa-plus"></i> Baris Baru</button></th>
                      </tr>
                  </thead>
                  <tbody></tbody>
                   <tfoot>
                    <tr>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td colspan="2">&nbsp;</td>
                        <td>Total</td>
                        <td><input type="text" class="form-control form-control-sm" id="getTotal"></td>
                        <td><button type="submit" class="btn btn-primary btn-sm btn-block"><i class="fa fa-check" name="simpan"></i> Simpan</button></td>
                    </tr>
                </tfoot>
                </table>
            </div>
          </form>
        </div>
    </div>
</div>
</main>
  <script src="<?= base_url()?>material/js/sweetalert2.all.min.js"></script>
  <script src="<?= base_url();?>material/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
<script>

              $(document).ready(function() {
                 for(B=1; B<=1; B++){
                  Barisbaru();
                 }

                 $('#BarisBaru').click(function(e) {
                     e.preventDefault();
                     Barisbaru();
                 });

                 $("tableLoop tbody").find('input[type=text]').filter(':visible:first').focus();

              });

              function Barisbaru() {
                  $(document).ready(function() {
                      $("[data-toggle='tooltip']").tooltip(); 
                  });
                  var Nomor = $("#tableLoop tbody tr").length + 1;
                  var Baris = '<tr>';
                          Baris += '<td class="text-center">'+Nomor+'</td>';
                          Baris += '<td>';
                              Baris += '<input type="text" id="kode_barang_'+Nomor+'" class="form-control form-control-sm" onkeypress="return RestrictSpace()" onchange="get_detail_kode(this.value,'+Nomor+')" name="kode_barang[]" required autocomplete="off"/>';
                          Baris += '</td>';
                          Baris += '<td>';
                              Baris += '<select id="id_barang_'+Nomor+'" class="form-control form-control-sm" name="id_barang[]" onchange="get_detail_name(this.value,'+Nomor+')" required><option hidden>Pilih Barang</option><?php foreach ($barang as $brg) : ?><option value="<?= $brg['id_barang'] ?>"><?= $brg['nama_barang'] ?></option><?php endforeach; ?></select>';
                          Baris += '</td>';
                          Baris += '<td>';
                              Baris += '<input type="number" id="harga_barang_'+Nomor+'" class="form-control form-control-sm" readonly name="harga_barang[]" required/>';
                          Baris += '</td>';
                          Baris += '<td>';
                              Baris += '<input type="number" id="jumlah_'+Nomor+'" class="form-control form-control-sm jumlahBeli" name="jumlah[]" onkeyup="calculate_price(this.value, '+Nomor+');" onchange="cek_stok('+Nomor+')" required/>';
                          Baris += '</td>';
                          Baris += '<td>';
                              Baris += '<input type="number" id="total_'+Nomor+'" class="form-control form-control-sm" name="total[]" required/>';
                          Baris += '</td>';
                          Baris += '<td class="text-center">';
                              Baris += '<a class="btn btn-sm btn-danger text-white" data-toggle="tooltip" title="Hapus Baris" id="HapusBaris"><i class="fa fa-times"></i></a>';
                          Baris += '</td>';
                      Baris += '</tr>';

                  $("#tableLoop tbody").append(Baris);
                  $("#tableLoop tbody tr").each(function () {
                     $(this).find('td:nth-child(2) input').focus(); 
                  });

              }

              $(document).on('click', '#HapusBaris', function(e) {
                 e.preventDefault();
                 var Nomor = 1;
                 $(this).parent().parent().remove();
                 $('tableLoop tbody tr').each(function() {
                     $(this).find('td:nth-child(1)').html(Nomor);
                     Nomor++;
                 });
              });

              function RestrictSpace() {
                  if (event.keyCode == 13) {
                      return false;
                  }
              }

              function get_detail_kode(nilai, n){
                var nx = n+1;

                var kode = nilai;

                $.ajax({
                    method: 'POST',
                    url: '<?= base_url() ?>transaksi/autokodebarangtrk',
                    data: {kode:kode},
                    success: function(hasil){
                        var data = $.parseJSON(hasil);

                        //Check Duplicate Value
                        var cek_kode = document.querySelectorAll("input[name='kode_barang[]']");
                        for(key=0; key < cek_kode.length - 1; key++)  {
                            if(cek_kode[key].value == data.kode_barang){

                                Swal.fire({
                                  icon: 'warning',
                                  title: 'Gagal!',
                                  text: 'Data sudah diinputkan!'
                                })
                                document.getElementById('kode_barang_'+n).value = '';
                                document.getElementById('kode_barang_'+n).focus();
                                return false;
                            }                   
                        }
                        
                        if (data.stok_barang <= 0) {
                          Swal.fire({
                                  icon: 'warning',
                                  text: 'Stok Barang tidak cukup!'
                                })
                          document.getElementById('kode_barang_'+n).value = '';
                          document.getElementById('kode_barang_'+n).focus();
                        } else {
                          document.getElementById('id_barang_'+n).value = data.id_barang;
                          $('#harga_barang_'+n).val(data.harga_barang);
                        }
                        
                    },
                })

            }

            function cek_stok(a){
              var id_barang = document.getElementById('id_barang_'+a).value;
              var jumlah = document.getElementById('jumlah_'+a).value;
              var total = document.getElementById('total_'+a).value;

                $.ajax({
                    method: 'POST',
                    url: '<?= base_url() ?>transaksi/autoidbarangtrk',
                    data: {kode:id_barang},
                    success: function(hasil){
                        var data = $.parseJSON(hasil);

                        if (parseInt(jumlah) > parseInt(data.stok_barang)) {
                          Swal.fire({
                                  icon: 'warning',
                                  title: 'Jumlah stok ' + data.stok_barang,
                                  text: 'Stok barang tidak cukup!'
                          })
                          document.getElementById('jumlah_'+a).value = "";
                          document.getElementById('total_'+a).value = "";
                          document.getElementById('getTotal').value = "";
                          document.getElementById('jumlah_'+a).focus();
                        }

                        
                    }
                });

            }
            function get_detail_name(nilai, n){
                var nx = n+1;

                var kode = nilai;

                $.ajax({
                    method: 'POST',
                    url: '<?= base_url() ?>transaksi/autoidbarangtrk',
                    data: {kode:kode},
                    success: function(hasil){
                        var data = $.parseJSON(hasil);
                        //Check Duplicate Value
                        var cek_id = document.querySelectorAll("select[name='id_barang[]']");
                        for(key=0; key < cek_id.length - 1; key++)  {
                            if(cek_id[key].value == data.id_barang){

                                Swal.fire({
                                  icon: 'warning',
                                  title: 'Gagal!',
                                  text: 'Data sudah diinputkan!'
                                });
                                
                                document.getElementById('kode_barang_'+n).value = '';
                                document.getElementById('kode_barang_'+n).focus();
                                return false;
                            }                   
                        }
                        
                        document.getElementById('kode_barang_'+n).value = data.kode_barang
                        $('#harga_barang_'+n).val(data.harga_barang);
                    }
                })

            }

            function calculate_price(q,n){

                var harga = document.getElementById('harga_barang_'+n).value;

                var get_total = document.getElementById('total_'+n).value = (harga * q).toFixed(0);
                
                
                var totalbanyak = document.querySelectorAll("input[name='total[]']");

                var newA = [];
                for(key=0; key < totalbanyak.length ; key++)  {
                    if(totalbanyak[key].value != ''){
                        newA.push(parseFloat(totalbanyak[key].value));
                    }
                }
                
                //alert(newA);
                var aac = newA.reduce(getSum);
                document.getElementById('getTotal').value = Math.round(parseFloat(aac));

            }

            function getSum(total, num) {
              return parseFloat(total + num);
            }

            function remove_data(r){
                $('#'+r).remove();
                //Get Value For Total
                var totalbanyak = document.querySelectorAll("input[name='total[]']");

                var newA = [];
                for(key=0; key < totalbanyak.length ; key++)  {
                    if(totalbanyak[key].value != ''){
                        newA.push(parseFloat(totalbanyak[key].value));
                    }
                }
                
                //alert(newA);
                var aac = newA.reduce(getSum);
                document.getElementById('getTotal').value = Math.round(parseFloat(aac));
                
            }

             
                 $('#SimpanData').submit(function(e) {
                     e.preventDefault();

                      var unit = $('#unit').val();
                      var caraBayar = $('#cara_bayar').val();
                      var statusBayar = $('#status_bayar').val();
                      var statusPengambilan = $('#status_pengambilan').val();

                      if (unit == "Pilih unit" || caraBayar == "Cara Bayar" || statusBayar == "Status Bayar" || statusPengambilan == "Pengambilan Barang") {

                        Swal.fire({
                            icon: 'warning',
                            title: 'Ada data kosong!',
                            text: 'Harap isi dengan lengkap!'
                        })

                      } else {
                        simpandata();
                      }

                 });

              function simpandata() {
                  $.ajax({
                    url: '<?= base_url() ?>transaksi/simpandata',
                    type: 'post',
                    data: $("#SimpanData").serialize(),
                    success: function(){
                          window.location = 'transaksi/data';
                    }
                  })
              }

</script>