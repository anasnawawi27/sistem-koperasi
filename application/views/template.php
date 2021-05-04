<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sistem Koperasi</title>
        <link href="<?= base_url()?>material/css/styles.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/1.10.20/css/dataTables.bootstrap4.min.css" rel="stylesheet" crossorigin="anonymous" />
        <link rel="icon" type="image/x-icon" href="<?= base_url()?>material/assets/img/icon.png" />
        <script data-search-pseudo-elements defer src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.min.js" crossorigin="anonymous"></script>
        <script src="<?= base_url()?>material/js/feather.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="nav-fixed">
        <nav class="topnav navbar navbar-expand shadow navbar-light bg-white" id="sidenavAccordion">
            <a class="navbar-brand d-none d-sm-block" href="<?= base_url('dashboard'); ?>">
                <img src="<?= base_url()?>material/assets/img/logo-koperasi.png" style="height: 35px; margin-right: 10px;">KOPERASI BRIWANTI  
            </a><button class="btn btn-icon btn-transparent-dark order-1 order-lg-0 mr-lg-2" id="sidebarToggle" href="#"><i data-feather="menu"></i></button>
            <ul class="navbar-nav align-items-center ml-auto">
                <li class="nav-item dropdown no-caret mr-3 dropdown-user">
                    <a class="btn btn-icon btn-transparent-dark dropdown-toggle" id="navbarDropdownUserImage" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img class="img-fluid" src="<?= base_url() ?>material/image/user.png"/></a>
                    <div class="dropdown-menu dropdown-menu-right border-0 shadow animated--fade-in-up" aria-labelledby="navbarDropdownUserImage">
                        <h6 class="dropdown-header d-flex align-items-center">
                            <img class="dropdown-user-img" src="<?= base_url() ?>material/image/user.png" />
                            <div class="dropdown-user-details">
                                <div class="dropdown-user-details-name"><?= $this->session->userdata('nama_lengkap'); ?></div>
                                <div class="dropdown-user-details-email"><?= $this->session->userdata('username'); ?></div>
                            </div>
                        </h6>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#!"
                            ><div class="dropdown-item-icon"><i data-feather="settings"></i></div>
                            Account</a
                        >
                        <a class="dropdown-item tombol-logout" href="<?= base_url('auth/logout') ?>">
                        <div class="dropdown-item-icon"><i data-feather="log-out"></i></div>
                            Logout</a
                        >
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sidenav shadow-right sidenav-light">
                    <div class="sidenav-menu">
                        <div class="nav accordion" id="accordionSidenav">
                            <div class="sidenav-menu-heading">Landing</div>
                            <a class="nav-link collapsed" href="<?= base_url('dashboard')?>">
                            <div class="nav-link-icon text bold"><i data-feather="activity"></i></div>
                                Dashboards
                                </a>
                            <div class="sidenav-menu-heading">Master</div>
                            <a class="nav-link <?php active("barang"); ?>" href="<?= base_url('barang')?>">
                            <div class="nav-link-icon"><i data-feather="layout"></i></div>
                                Data Barang</a>
                            <a class="nav-link <?php active("unit"); ?>" href="<?= base_url('unit')?>">
                            <div class="nav-link-icon"><i data-feather="home"></i></div>
                                Data Unit</a>
                            <div class="sidenav-menu-heading">Transaction</div>
                            <a class="nav-link <?php active("inventori"); ?>" href="<?= base_url('inventori') ?>"
                                ><div class="nav-link-icon"><i data-feather="package"></i></div>
                                Data Inventori</a>
                            <a class="nav-link <?php active("transaksi"); ?>" href="<?= base_url('transaksi/data') ?>"
                                ><div class="nav-link-icon"><i data-feather="bar-chart"></i></div>
                                Data Transaksi</a>
                            <div class="sidenav-menu-heading">Report</div>
                            <a class="nav-link" href="<?= base_url('filter') ?>"
                                ><div class="nav-link-icon"><i data-feather="filter"></i></div>
                                Filter</a>
                            <a class="nav-link" href="<?= base_url('laporan') ?>"
                                ><div class="nav-link-icon"><i data-feather="file"></i></div>
                                Laporan</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <div class="login" data-login="<?= $this->session->flashdata('login'); ?>">
                </div>
                <?= $content ?>
                <footer class="footer mt-auto footer-light">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6 small">Copyright &copy; Naz Codes <?= date('Y')?></div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
        <script src="<?= base_url();?>material/js/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
        <script src="<?= base_url();?>material/js/jautocalc.js"></script>
        <script src="<?= base_url();?>material/js/datatables.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="<?= base_url()?>material/js/scripts.js"></script>
        <script src="<?= base_url()?>material/js/sweetalert2.all.min.js"></script>
        <script src="<?= base_url()?>material/js/myscript2.js"></script>
        <script src="<?= base_url()?>material/assets/demo/datatables-demo.js"></script>
        <script>
            const login = $('.login').data('login');

                    if (login) {

                        Swal.fire(
                          'Login Berhasil !',
                          'Selamat Datang',
                          'success'
                        );
             }

             $('.tombol-logout').on('click', function(e){

                e.preventDefault();

                const href = $(this).attr('href');
                
                Swal.fire({
                  title: 'Logout ?',
                  text: "Anda akan keluar dari sistem",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Ya, logout!',
                  cancelButtonText: 'Batal',
                }).then((result) => {
                    if(result.value){
                       document.location.href = href; 
                    }
                })

            });
        </script>

    </body>
</html>
