<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="short icon" href="<?= base_url()?>material/assets/img/favicon.png" />
    <!-- <link href="material/bootstrap/css/bootstrap.css" rel="stylesheet" /> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"> -->
    <title>Laporan</title>
</head>
<body>
        <div class="row">
            <div class="col-md-4">
                <img height="50px;" src="<?= base_url() ?>material/assets/img/icon.png" alt="">
            </div>
            <div class="col-md-4" style="margin-bottom:-30px"> 
                <center>
                <h1><?= $judul ?></h1>
                <h1 style="margin-top:-10px">KOPERASI BRI</h1>
                <p>Jalan A. Yani No.16, Dawuan Tengah, Cikampek, Cikampek Sel., Kec. Cikampek, Kabupaten Karawang, Jawa Barat 41373</p>
                <hr>
                </center>
               <p><b>TANGGAL : <?= $tanggal_hari_ini?></b></p>             
            </div>
        </div>

    <?php
    $iteration = 1;
    $total2 = [];
    foreach ($unit as $u) : ?>
        <p style="margin-top: 20px"><?= $iteration++ .'.)' ?> UNIT <?= $u['nama_unit'] ?></p>
        <table border="1"  style="padding:0px; margin-bottom:70px; width:700px" class="table table-sm" cellpadding="3" cellspacing="0">
            <thead class="thead-dark">
                <tr>
                <th scope="col"><center>#</center></th>
                <th scope="col">Nama Barang</th>
                <th scope="col"><center>Satuan</center></th>
                <th scope="col"><center>QTY<</center></th>
                <th scope="col"><center>Harga</center></th>
                <th scope="col"><center>Jumlah</center></th>
                <th scope="col"><center>Total</center></th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $i = 0;
                    while(count($kategori) > $i) :?>
                    <tr>
                        <td>
                        <?php
                        if ($kategori[$i] == "ATK"){
                            echo "<center><b> A. </b></center>";
                        } elseif ($kategori[$i] == "PRJ") {
                            echo "<center><b> B. </b></center>";
                        } elseif ($kategori[$i] == "SUP") {
                            echo "<center><b> C. </b></center>";
                        } else {
                            echo "<center><b> D. </b></center>";
                        
                        }?>
                        </td>
                        <td colspan="6">
                        <?php
                        if ($kategori[$i] == "ATK"){
                            echo "<b> ALAT TULIS KANTOR </b>";
                        } elseif ($kategori[$i] == "PRJ") {
                            echo "<b> PERCETAKAN </b>";
                        } elseif ($kategori[$i] == "SUP") {
                            echo "<b> SUPPLAIS </b>";
                        } else {
                            echo "<b> ALAT KEBERSIHAN </b>";
                        
                        }?>
                        </td>
                    </tr>
                    <?php

                    $id_unit = $u['id_unit'];
                    $data = $this->db->query("SELECT * FROM tb_detailtransaksi join tb_transaksi on tb_transaksi.id_transaksi = tb_detailtransaksi.id_transaksi join tb_unit on tb_unit.id_unit = tb_transaksi.id_transaksi join tb_barang on tb_barang.id_barang = tb_detailtransaksi.id_barang WHERE tb_transaksi.id_unit = $id_unit AND tb_barang.kategori = '$kategori[$i]'")->result_array();
                    // $data = $this->db->query("SELECT * FROM tb_transaksi WHERE id_unit = $id_unit")->result_array();
                    $nomer = 1;
                    ?>

                    <?php if (!$data) :?>
                    <tr>
                        <td colspan="7"><i>Tidak Ada Transaksi<i></td>
                    </tr>
                    <?php else:?>
                    <?php
                        $total = [];
                        foreach ($data as $d) : ?>
                    <tr>
                        <td><center><?= $nomer++.'.' ?></center></td>
                        <td><?= $d['nama_barang'] ?></td>
                        <td><center><?= $d['satuan'] ?></center></td>
                        <td><center><?= $d['jumlah_beli'] ?></center></td>
                        <td style="text-align: right;"><?= "Rp. " . number_format($d['harga_jual'],0,',','.') ?></td>
                        <td style="text-align: right;"><?= "Rp. " . number_format($d['total'],0,',','.') ?></td>
                        <td><?php $total[] = $d['total']?></td>
                    </tr>
                    <?php endforeach;?>
                    <tr>
                        <td colspan="6"></td>
                        <td style="text-align: right;"><?= "Rp. " . number_format(array_sum($total),0,',','.') ?></td>
                        <?php
                        $total2[] = array_sum($total);  ?>
                    </tr>
                    <?php endif;?>

                <?php 
                    $i++;
                endwhile; ?>
                <tr>
                    <td colspan="6"><center><b>GRAND TOTAL</b></center></td>
                    <td style="text-align: right;"><b><?= "Rp. " . number_format(array_sum($total2),0,',','.')?></b></td>
                    <?php $total2 = [];?>
                </tr>
            </tbody>
            </table>
    <?php endforeach;?>
</body>
</html>

