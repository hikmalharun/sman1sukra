<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title><?php echo $title; ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="<?php echo base_url(); ?>assets/img/logo_sman1sukra.png" rel="icon">
    <link href="<?php echo base_url(); ?>assets/img/logo_sman1sukra.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/custom.css" rel="stylesheet">

    <!-- =======================================================
  * Template Name: BizLand
  * Template URL: https://bootstrapmade.com/bizland-bootstrap-business-template/
  * Updated: Aug 07 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a href="mailto:info@sman1sukra.sch.id">info@sman1sukra.sch.id</a></i>
                    <i class="bi bi-telephone d-flex align-items-center ms-4"><span>(0234) 7150464</span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div><!-- End Top Bar -->

        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="<?php echo base_url(); ?>" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <!-- <img src="<?php echo base_url(); ?>assets/img/brand_smantura.png" alt="logo"> -->
                    <h1 class="sitename">SMAN 1 SUKRA</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="#home" class="active">Home</a></li>
                        <li><a href="#profile">Profile</a></li>
                        <li><a href="#spmb">SPMB</a></li>
                        <li><a href="#tanya_spmb">Tanya Seputar SPMB</a></li>
                        <li><a href="#contact">Hubungi Kami</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

            </div>

        </div>

    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="home" class="hero section light-background">

            <div class="container">
                <div class="row gy-4 d-flex">
                    <div class="col-lg-2 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                        <img src="<?php echo base_url('assets/img/logo_sman1sukra.png'); ?>" alt="brand" style="width: 200px;">
                    </div>
                    <div class="col-lg-10 order-2 order-lg-1 d-flex flex-column justify-content-center" data-aos="zoom-out">
                        <h1>Selamat Datang di <span>SMAN 1 SUKRA</span></h1>
                        <p>Gerbang Menuju Masa Depan Yang Gemilang</p>
                    </div>
                </div>
            </div>

        </section>
        <!-- /Hero Section -->

        <!-- Featured Services Section -->
        <section id="featured-services" class="featured-services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <p><span>Sambutan Kepala</span> <span class="description-title">SMAN 1 SUKRA</span></p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row kepsek">
                    <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                        <div class="card" style="border: none;">
                            <div class="card-body">
                                <img src="<?php echo base_url('assets/img/kepsek.png'); ?>" alt="kepsek" style="width: 80%;">
                                <p>H. MAMAN RACHMAN, S.Pd., M.Pmat.</p>
                            </div>
                        </div>
                    </div>
                    <!-- End Service Item -->
                    <div class="col-md-8" data-aos="fade-up" data-aos-delay="100">
                        <div class="card" style="border: none;">
                            <div class="card-body" style="text-align: justify;">
                                Puji syukur kami panjatkan ke hadirat Tuhan Yang Maha Esa atas karunia dan hidayah-Nya, sehingga kita semua dapat membaktikan segala hal yang kita miliki untuk kemajuan dunia pendidikan. Apapun bentuk dan sumbangsih yang kita berikan, jika dilandasi niat yang tulus tanpa memandang imbalan apapun akan menghasilkan mahakarya yang agung untuk bekal kita dan generasi setelah kita. Pendidikan adalah harga mati untuk menjadi pondasi bangsa dan negara dalam menghadapi perkembangan zaman. Hal ini seiring dengan penguasaan teknologi untuk dimanfaatkan sebaik mungkin, sehingga menciptakan iklim kondusif dalam ranah keilmuan. Dengan konsep yang kontekstual dan efektif, kami mengejewantahkan nilai-nilai pendidikan yang tertuang dalam visi misi SMA NEGERI 1 SUKRA, sebagai panduan hukum dalam menjabarkan tujuan hakiki pendidikan.
                                <br>
                                Dalam sebuah sistem ketata kelolaan Sekolah Berbasis Manajemen, kami berusaha terus meningkatkan kinerja dan profesionalisme demi terwujudnya pelayanan prima dalam cakupan Lembaga Pendidikan terutama di SMA NEGERI 1 SUKRA ini. Kami sudah mulai menerapkan sistem Teknologi Komputerisasi agar transparansi pengelolaan pendidikan terjaga optimalisasinya. Sebuah sistem akan bermanfaat dan berdaya guna tinggi jika didukung dan direalisasikan oleh semua komponen yang berkompeten di SMA NEGERI 1 SUKRA baik sistem manajerial, akademik, pelayanan publik, prestasi,moralitas dan semua hal yang berinteraksi di dalamnya. Alhamdulilah peningkatan tersebut dapat dilihat dari data-data kepegawaian dan karya-karya nyata yang telah dihasilkan walaupun masih ada kelemahan yang terus kami treatment dengan menyeimbangkan hasil kinerja dan prize yang diberikan. Mudah-mudahan semua yang kita berikan untuk kemajuan dan keajegan nilai-nilai pendidikan dapat terus meningkat.
                                <br>
                                Secara pribadi saya mohon maaf, jika pemenuhan tuntutan dan kinerja yang saya lakukan masih ada kelemahan. Oleh karena itu, bantuan dan kerjasama dari berbagai pihak untuk optimalisasi mutu dan kualitas pendidikan sangat saya harapkan. Mudah-mudahan dalam tiap langkah dan nafas kita menciptakan nilai jual yang tinggi bagi keilmuan dan nilai hakiki di hadapan Tuhan Yang Maha Esa. Demikian sambutan ini saya sampaikan, ditutup dengan pesan moral dan keilmuan bagi kita semua.
                            </div>
                        </div>
                    </div>
                    <!-- End Service Item -->
                </div>
            </div>

        </section><!-- /Featured Services Section -->

        <!-- About Section -->
        <section id="profile" class="about section light-background">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Profile</h2>
                <p><span>Selayang Pandang</span> <span class="description-title">SMAN 1 SUKRA</span></p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-3">

                    <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <img src="<?php echo base_url(); ?>assets/img/about-x.jpg" alt="" class="img-fluid">
                    </div>

                    <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
                        <div class="about-content ps-0 ps-lg-3">
                            <h3>Profile Singkat SMA Negeri 1 Sukra</h3>
                            <p style="text-align: justify;">
                                SMA Negeri 1 Sukra adalah sebuah Sekolah Menengah Atas Negeri yang berada di Jalan Raya Sukra - Ujung Gebang Km. 0,5 Desa Sukra Kecamatan Sukra Kabupaten Indramayu. Sekolah ini didirikan berdasarkan Keputusan Pemerintah Daerah Kabupaten Indramayu nomor : 004/PAN-USB/VII/2016 pada tanggal 21 Juli 2016.
                                Berikut secara rinci profile SMA Negeri 1 Sukra :
                            </p>
                            <ul>
                                <div class="row">
                                    <div class="col-md-6">
                                        <li>
                                            <i class="bi bi-textarea-resize"></i>
                                            <div>
                                                <h4>Luas Tanah</h4>
                                                <p>8.141 meter pesegi</p>
                                            </div>
                                        </li>
                                    </div>
                                    <div class="col-md-6">
                                        <li>
                                            <i class="bi bi-houses"></i>
                                            <div>
                                                <h4>Luas Bangunan</h4>
                                                <p>1.920 meter persegi</p>
                                            </div>
                                        </li>
                                    </div>
                                    <div class="col-md-6">
                                        <li>
                                            <i class="bi bi-houses"></i>
                                            <div>
                                                <h4>Ruang Kelas</h4>
                                                <p>12 rombel</p>
                                            </div>
                                        </li>
                                    </div>
                                    <div class="col-md-6">
                                        <li>
                                            <i class="bi bi-door-closed"></i>
                                            <div>
                                                <h4>Toilet Siswa</h4>
                                                <p>14 ruang</p>
                                            </div>
                                        </li>
                                    </div>
                                    <div class="col-md-6">
                                        <li>
                                            <i class="bi bi-easel2"></i>
                                            <div>
                                                <h4>Ruang Laboratorium</h4>
                                                <p>3 ruang</p>
                                            </div>
                                        </li>
                                    </div>
                                    <div class="col-md-6">
                                        <li>
                                            <i class="bi bi-easel2"></i>
                                            <div>
                                                <h4>Jumlah PTK</h4>
                                                <p>24 pegawai</p>
                                            </div>
                                        </li>
                                    </div>
                                </div>
                            </ul>
                        </div>

                    </div>
                </div>

            </div>

        </section><!-- /About Section -->

        <!-- Stats Section -->
        <section id="stats" class="stats section">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-person-lines-fill"></i>
                        <div class="stats-item">
                            <div class="d-flex" style="padding-left: 33%;">
                                <span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter"></span>
                                <span>%</span>
                            </div>
                            <p>Penerimaan Murid Baru</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-mortarboard"></i>
                        <div class="stats-item">
                            <div class="d-flex" style="padding-left: 33%;">
                                <span data-purecounter-start="0" data-purecounter-end="100" data-purecounter-duration="1" class="purecounter"></span>
                                <span>%</span>
                            </div>
                            <p>Jumlah Murid Lulus</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-palette2"></i>
                        <div class="stats-item">
                            <div class="d-flex" style="padding-left: 36%;">
                                <span data-purecounter-start="0" data-purecounter-end="35" data-purecounter-duration="1" class="purecounter"></span>
                                <span>%</span>
                            </div>
                            <p>Melanjutkan Perguruan Tinggi</p>
                        </div>
                    </div><!-- End Stats Item -->

                    <div class="col-lg-3 col-md-6 d-flex flex-column align-items-center">
                        <i class="bi bi-people"></i>
                        <div class="stats-item">
                            <div class="d-flex" style="padding-left: 36%;">
                                <span data-purecounter-start="0" data-purecounter-end="65" data-purecounter-duration="1" class="purecounter"></span>
                                <span>%</span>
                            </div>
                            <p>Melanjutkan Dunia Kerja</p>
                        </div>
                    </div><!-- End Stats Item -->

                </div>

            </div>

        </section><!-- /Stats Section -->

        <!-- Services Section -->
        <section id="spmb" class="services section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Penerimaan Murid Baru</h2>
                <p><span>Tahun Pelajaran</span> <span class="description-title">2025/2026</span></p>
            </div><!-- End Section Title -->

            <div class="container">

                <div class="row gy-4">

                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/spmb.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/spmb.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-6 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/brosur.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/brosur.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/dayatampung.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/dayatampung.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/tahap1.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/tahap1.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/tahap2.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/tahap2.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/domisili.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/domisili.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/afirmasi.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/afirmasi.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/mutasi.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/mutasi.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/nilairapor.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/nilairapor.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/kejuaraan.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/kejuaraan.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/syaratumum.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/syaratumum.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/syaratkhusus1.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/syaratkhusus1.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/syaratkhusus2.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/syaratkhusus2.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/syaratkhusus3.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/syaratkhusus3.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/syaratketm.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/syaratketm.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/syaratpdbk.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/syaratpdbk.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/syaratmutasi.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/syaratmutasi.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/syaratprestasi.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/syaratprestasi.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/jadwaltahap1.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/jadwaltahap1.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->
                    <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item position-relative">
                            <a href="<?php echo base_url('assets/img/spmb/jadwaltahap2.png'); ?>" data-gallery="portfolio-gallery-app" class="glightbox preview-link">
                                <img src="<?php echo base_url('assets/img/spmb/jadwaltahap2.png') ?>" alt="spmb" style="width: 100%; margin-top: -60px; margin-bottom: -60px;">
                            </a>
                        </div>
                    </div><!-- End Service Item -->

                </div>

            </div>

        </section><!-- /Services Section -->

        <!-- Testimonials Section -->
        <section id="tanya_spmb" class="testimonials section dark-background">

            <img src="<?php echo base_url('assets/img/header-bg.jpg'); ?>" class="testimonials-bg" alt="">

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="container section-title" data-aos="fade-up">
                    <h2 style="color: #ffffff;">Tanya Seputar SPMB</h2>
                    <p><span>Tahun Pelajaran</span> <span class="description-title">2025/2026</span></p>
                </div><!-- End Section Title -->
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <form action="<?php echo base_url('forms/tanya_spmb'); ?>" method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" class="form-control" name="nama" id="nama" style="background-color: transparent; color: #ffffff;" required>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <input type="text" class="form-control" name="alamat" id="alamat" style="background-color: transparent; color: #ffffff;" required>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <div class="form-group">
                                        <label for="pesan">Pesan</label>
                                        <textarea class="form-control" name="pesan" id="pesan" style="background-color: transparent; color: #ffffff;" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-outline-primary float-end" style="color: #ffffff; border: 1px solid #ffffff;"><i class="bi bi-send-plus"></i> Kirim</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-2"></div>
                </div>

            </div>

        </section><!-- /Testimonials Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Contact</h2>
                <p><span>Perlu Bantuan?</span> <span class="description-title">Hubungi Kami</span></p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">

                <div class="row gy-4">

                    <div class="col-lg-12">

                        <div class="info-wrap">
                            <div class="d-flex row">
                                <div class="col-sm-6 info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                                    <i class="bi bi-geo-alt flex-shrink-0"></i>
                                    <div>
                                        <h3>Alamat</h3>
                                        <p>Jln. Raya Sukra-Ujunggebang Km. 0,5 Desa Sukra, Kec. Sukra, Kabupaten Indramayu, Jawa Barat 45257</p>
                                    </div>
                                </div><!-- End Info Item -->

                                <div class="col-sm-3 info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                    <i class="bi bi-telephone flex-shrink-0"></i>
                                    <div>
                                        <h3>Telp.</h3>
                                        <p><a href="https://wa.me/6282317622332">0823-1762-2332</a></p>
                                    </div>
                                </div><!-- End Info Item -->

                                <div class="col-sm-3 info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                    <i class="bi bi-envelope flex-shrink-0"></i>
                                    <div>
                                        <h3>Email</h3>
                                        <p><a href="mailto:info@sman1sukra.sch.id">info@sman1sukra.sch.id</a></p>
                                    </div>
                                </div><!-- End Info Item -->
                            </div>

                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d589.511060634765!2d107.93551306825529!3d-6.2976084492983695!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e694e68dc6e125d%3A0xcf99d28362db9300!2sSMA%20Negeri%201%20Sukra!5e0!3m2!1sid!2sid!4v1748832468486!5m2!1sid!2sid" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer">

        <div class="footer-newsletter">
            <div class="container">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-6">

                    </div>
                </div>
            </div>
        </div>

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-6 col-md-6 footer-about">
                    <a href="<?php echo base_url(); ?>" class="d-flex align-items-center">
                        <span class="sitename">
                            <img src="<?php echo base_url('assets/img/brand_smantura.png'); ?>" alt="brand" style="width: 120px;">
                        </span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jln. Raya Sukra-Ujung Gebang Km. 0,5 Sukra Kecamatan Sukra</p>
                        <p>Kabupaten Indramayu Provinsi Jawa Barat Kode Pos 45256</p>
                        <p class="mt-3"><strong><i class="bi bi-phone"></i></strong> <span>0823-1762-2332</span></p>
                        <p><strong><i class="bi bi-envelope"></i></strong> <span>info@sman1sukra.sch.id</span></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-3 footer-links">
                    <h4>Useful Links</h4>
                    <ul>
                        <li><i class="bi bi-chevron-right"></i> <a href="#home">Home</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#profile">Profile</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#spmb">SPMB</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#tanya_spmb">Tanya Seputar SPMB</a></li>
                        <li><i class="bi bi-chevron-right"></i> <a href="#contact">Hubungi Kami</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12">
                    <h4>Follow Us</h4>
                    <p>Cras fermentum odio eu feugiat lide par naso tierra videa magna derita valies</p>
                    <div class="social-links d-flex">
                        <a href="https://facebook.com/sman1sukra" target="_blank"><i class="bi bi-facebook"></i></a>
                        <a href="https://intagram.com/sman1sukra" target="_blank"><i class="bi bi-instagram"></i></a>
                        <a href="https://youtube.com/sman1sukra" target="_blank"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright <?php echo date('Y'); ?></span> <strong class="px-1 sitename">SMA Negeri 1 Sukra</strong> <span>All Rights Reserved</span></p>
            <div class="credits">
                Designed by <a href="#">Didi Rasidi</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
    </div>

    <!-- Vendor JS Files -->
    <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/php-email-form/validate.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/aos/aos.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>

    <!-- Main JS File -->
    <script src="<?php echo base_url(); ?>assets/js/main.js"></script>

</body>

</html>