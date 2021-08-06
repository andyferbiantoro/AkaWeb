<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Agrowisata Kebun Al-Qur'an</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="bethany_assets/img/favicon.png" rel="icon">
  <link href="bethany_assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="bethany_assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="bethany_assets/vendor/icofont/icofont.min.css" rel="stylesheet">
  <link href="bethany_assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="bethany_assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="bethany_assets/vendor/venobox/venobox.css" rel="stylesheet">
  <link href="bethany_assets/vendor/owl.carousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="bethany_assets/vendor/aos/aos.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="bethany_assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: Bethany - v2.2.1
  * Template URL: https://bootstrapmade.com/bethany-free-onepage-bootstrap-theme/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center">
    <div class="container">
      <div class="header-container d-flex align-items-center">
        <div class="logo mr-auto">
          <!-- <h1 class="text-light"><a href="index.html"><span>AKA</span></a></h1> -->
          <!-- Uncomment below if you prefer to use an image logo -->
          <img src="bethany_assets/img/logo_aka.png" style="height: 50px" alt="" class="img-fluid">
        </div>

        <nav class="nav-menu d-none d-lg-block">
          <ul>
            <li class="active"><a href="#header">Beranda</a></li>
            <li class="drop-down"><a href="#">Tentang Kami</a>
              <ul>
                <li><a href="#sejaran">Sejarah</a></li>
                <li><a href="#informasi_wisata">Informasi Wisata</a></li>
                <li><a href="#syarat">Syarat dan Ketentuan</a></li>
                <li><a href="#cara_pemesanan">Cara Pemesanan</a></li>
                <li><a href="#contact">Kontak Kami</a></li>
              </ul>
            </li>
            <li><a href="#paket">Paket Wisata</a></li>  
            <li><a href="#galeri">Galeri</a></li>
            @if(Auth::guest())
            <li><a href="{{ route('login') }}">Login</a></li>
            <li><a href="{{ route('register') }}">Register</a></li>
            @endif

            @if(!Auth::guest())
              @if(Auth::user()->role_id == 1)
              <li><a href="{{ route('pengunjung-data_pemesanan') }}">Dashboard</a></li>
              @endif
              
                @if(Auth::user()->role_id == 2)
                <li><a href="{{ route('admin-beranda') }}">Dashboard Admin</a></li>
                @endif
            @endif
            <!-- <li><a href="#contact">Contact</a></li>

              <li class="get-started"><a href="#about">Get Started</a></li> -->
            </ul>
          </nav><!-- .nav-menu -->
        </div><!-- End Header Container -->
      </div>
    </header><!-- End Header -->

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="d-flex align-items-center">
      <div class="container text-center position-relative" data-aos="fade-in" data-aos-delay="150">
        <h1>Agrowisata Kebun Al-Qur'an</h1><br><br>
        <!-- <h2>We are team of talented designers making websites with Bootstrap</h2> -->
        <a href="#paket" class="btn-get-started scrollto">Lihat Paket</a>
         <a href="#galeri" class="btn-get-started scrollto">Lihat Galeri</a>
      </div>
    </section><!-- End Hero -->

    <main id="main">



      <!-- ======= About Section ======= -->
      <section id="sejaran" class="about">
        <div class="container">

          <div class="row content">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
              <h2>SEJARAH</h2>
              <h3>Agrowisata Kebun Al-Qur'an (AKA)</h3>
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-left" style="text-align: justify;" data-aos-delay="200">
              <p>
                Agrowisata Kebun Al-Qur'an (AKA) didirikan pada tanggal 19 Oktober 2019. Agrowisata ini dengan luas lahan 2 hektare terletak di Desa Kaliploso kecamatan Cluring. Desa Kaliploso memiliki sektor pertanian sangat baik oleh karena itu Desa Kaliploso disebut sebagai Desa Hortikultural yaitu banyaknya komoditas pertanian HORTI baik dari sayur dan buah-buahan yang mengidentifikasikan diri sebagai Desa Hortikultural. Hal inilah yang menjadi potensi Desa Kaliploso untuk mendirikan Agrowisata Kebun Al-Qur'an (AKA) sebagai tempat wisata agar diketahui oleh masyarakat umum. Agrowisata Kebun Al-Qur'an (AKA) merupakan wisata yang memadukan pengembangan inovasi pertanian modern, edukasi, dan jenis-jenis tanaman yang tercantum dalam Al-Qur'an dan hadits Nabi Muhammad SAW. Tanaman yang tercantum dalam Al-Qur'an tersebut yaitu buah tin, buah kurma, buah pisang, buah delima, bidara, buah anggur, jahe, dan tanaman tambahan lainnya. Agrowisata Kebun AL-Qur'an (AKA) menyediakan keindahan alam, kuliner, kolam, dan edukasi agama. Fasilitas yang dimiliki agrowisata ini antara lain area parkir yang cukup, toilet umum, warung makan, tempat beribadah, spot foto, gazebo, taman bunga dan masih banyak lagi.
              </p>

            </div>
          </div>

        </div>
      </section><!-- End About Section -->


      <section id="informasi_wisata" class="about">
        <div class="container">

          <div class="row content">
            <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
              <h2>INFORMASI WISATA</h2>
              <h3>Agrowisata Kebun Al-Qur'an (AKA)</h3>
            </div>
            <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-left" style="text-align: justify;" data-aos-delay="200">
              <p>
                Agrowisata Kebun Al-Qur'an (AKA) terletak di Desa Kaliploso kecamatan Cluring Kabupaten Banyuwangi. Agrowisata Kebun Al-Qur'an memiliki luas 2 hektare Wisata ini menyediakan keindahan alam, kuliner, kolam dan edukasi agama.
              </p><br>
              <p>Fasilitas yang dimiliki Agrowisata ini antara lain</p>
              <ul>
                <li><i class="ri-check-double-line"></i>Area parkir yang cukup</li>
                <li><i class="ri-check-double-line"></i>Toilet umum</li>
                <li><i class="ri-check-double-line"></i>Warung makan</li>
                <li><i class="ri-check-double-line"></i>Tempat beribadah</li>
                <li><i class="ri-check-double-line"></i>Spot foto</li>
                <li><i class="ri-check-double-line"></i>Gazebo</li>
                <li><i class="ri-check-double-line"></i>Taman bunga dan masih banyak lagi</li>

              </ul>
              <p class="font-italic">
                Wisata ini buka setiap hari pukul 08.00-17.00 WIB.
              </p>
            </div>
          </div>

        </div>
      </section>

<!--  -->
      <!-- ======= Why Us Section ======= -->
      <section id="syarat" class="why-us">
        <div class="container">

          <div class="row">
            <div class="col-lg-4 d-flex align-items-stretch" data-aos="fade-right">
              <div class="content">
                <h3>SYARAT DAN KETENTUAN</h3>
                <p>
                  Agrowisata Kebun Al-Qur'an (AKA)
                </p>
              <!-- <div class="text-center">
                <a href="#" class="more-btn">Learn More <i class="bx bx-chevron-right"></i></a>
              </div> -->
            </div>
          </div>
          <div class="col-lg-8 d-flex align-items-stretch">
            <div class="icon-boxes d-flex flex-column justify-content-center">
              <div class="row">
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                  <div class="icon-box mt-4 mt-xl-0" >
                    <!-- <i class="bx bx-user"></i> -->
                    <h2>1</h2>
                    <p style="text-align: center;">Untuk umur pengunjung diatas 5 tahun keatas maka harga tiket sama dengan harga tiket dewasa.</p>
                    
                  </div>
                </div>
                <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
                  <div class="icon-box mt-4 mt-xl-0">
                   <!--  <i class="bx bx-cube-alt"></i> -->
                   <h2>2</h2>
                   <p style="text-align: center;">Apabila dalam pemesanan jumlah pengunjung tidak sesuai dengan jumlah yang dipesan maka harga akan tetap sama.</p>

                 </div>
               </div>
               <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box mt-4 mt-xl-0">
                  <!-- <i class="bx bx-images"></i> -->
                  <h2>3</h2>
                  <p style="text-align: center;">Pengunjung yang memesan paket harus berjumlah 5 orang.</p>
                </div>
              </div>


              <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                <div class="icon-box mt-4 mt-xl-0">
                  <!-- <i class="bx bx-user"></i> -->
                  <h2>4</h2>
                  <p style="text-align: center;">Pengunjung yang tidak ingin didampingi oleh guide maka memesan regular.</p>
                </div>
              </div>
              <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
                <div class="icon-box mt-4 mt-xl-0">
                  <!-- <i class="bx bx-cube-alt"></i> -->
                  <h2>5</h2>
                  <p style="text-align: center;">Pengunjung yang telah memesan diwajibkan untuk memperlihatkan konfirmasi pemesanan.</p>
                </div>
              </div>
              <div class="col-xl-4 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box mt-4 mt-xl-0">
                  <!-- <i class="bx bx-images"></i> -->
                  <h2>6</h2>
                  <p style="text-align: center;">Pemesanan diatas 10 pengunjung akan mendapatkan diskon sebesar 10%.</p>
                </div>
              </div>

            </div>
          </div><!-- End .content-->
        </div>
      </div>

    </div>
  </section><!-- End Why Us Section -->


  <section id="cara_pemesanan" class="about">
    <div class="container">

      <div class="row content">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
          <h2>CARA PEMESANAN</h2>
          <h3>Agrowisata Kebun Al-Qur'an (AKA)</h3>
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0" data-aos="fade-left" style="text-align: justify;" data-aos-delay="200">
          <p>
            Cara pemesanan dikategorikan menjadi dua macam yaitu bagi calon pengunjung dan bagi pengelola.
          </p>
          <p>Pemesanan bagi calon pengunjung yaitu pemesanan yang dilakukan sendiri oleh calon pengunjung sedangkan,
          Pemesanan bagi pengelola yaitu pemesanan yang dilakukan apabila calon pengunjung datang ke lokasi tanpa melakukan pemesanan terlebih dahulu.</p>

        </div>
      </div>

    </div>
  </section> 


  <!-- ======= Cta Section ======= -->
  <section id="cta" class="cta">
    <div class="container">

      <div class="text-center" data-aos="zoom-in">
        <h3>Agrowisata Kebun Al-Qur'an (AKA)</h3>
        <br><br>
        <a class="cta-btn scrollto" href="#paket">Lihat Paket</a>
      </div>

    </div>
  </section><!-- End Cta Section -->

<!-- ==================================================  SECTION PAKET WISATA  ========================================================-->

  <section id="paket" class="portfolio">
    <div class="container">
      <div class="section-title" data-aos="fade-left">
        <h2>Paket Wisata</h2>
        <p>Temukan beragam paket wisata dengan harga, fasilitas terbaik, layanan bergengsi serta program paket yang paling menarik</p>
      </div>
      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">

        @foreach($paket_wisata as $paket)
        <div class="col-lg-4 col-md-6 portfolio-item">
          <div class="portfolio-wrap">
            <img src="{{asset('uploads/foto_paket_wisata/'.$paket->photo)}}"  class="img-fluid" alt="">
            <div class="portfolio-info">
              <h4>{{$paket->nama_paket}}</h4>
              <p>{{$paket->deskripsi_paket}}</p>
              <div class="portfolio-links">
                <a href="{{asset('uploads/foto_paket_wisata/'.$paket->photo)}}"  data-gall="portfolioGallery" class="venobox" title="App 1"><i class="bx bx-show"></i></a>
                <a href="{{route('pengunjung-data_pemesanan')}}" title="Pesan Paket"><i class="bx bx-task"></i></a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>



  <!-- ======= Galeri Section ======= -->
  <section id="galeri" class="portfolio">
    <div class="container">

      <div class="section-title" data-aos="fade-left">
        <h2>Galeri</h2>
        <p>Menampilkan Beberapa spot foto yang berada di taman AKA</p>
      </div>

    

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
         @foreach($data_galeri as $galeri)
        <div class="col-lg-4 col-md-6 portfolio-item filter-app">
          <div class="portfolio-wrap">
            <img src="{{asset('uploads/foto_galeri/'.$galeri->photo)}}" class="img-fluid" alt="">
            <div class="portfolio-info">
              <div class="portfolio-links">
                <a href="{{asset('uploads/foto_galeri/'.$galeri->photo)}}"  data-gall="portfolioGallery" class="venobox" ><i class="bx bx-show"></i></a>
              </div>
            </div>
          </div>
        </div>
        @endforeach

      </div>

    </div>
  </section><!-- End Portfolio Section -->



  <!-- ======= Contact Section ======= -->
  <section id="contact" class="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-4" data-aos="fade-right">
          <div class="section-title">
            <h2>Kontak Kami</h2>
            <p>Agrowisata Kebun Al-Qur'an (AKA)</p>
          </div>
        </div>

        <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
         <!--  <iframe style="border:0; width: 100%; height: 270px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12097.433213460943!2d-74.0062269!3d40.7101282!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xb89d1fe6bc499443!2sDowntown+Conference+Center!5e0!3m2!1smk!2sbg!4v1539943755621" frameborder="0" allowfullscreen></iframe> -->
        
        <div class="row">
          <div class="col-lg-6 mt-4">
            <div class="info">
              <i class="icofont-envelope"></i>
              <h4>Email:</h4>
              <p><a href="#">agrowisatakebun@gmail.com</a></p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="info w-100 mt-4">
              <i class="icofont-phone"></i>
              <h4>Telepon :</h4>
              <p>+6281335680001</p>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-lg-6 mt-4">
            <div class="info">
              <i class="icofont-instagram"></i>
              <h4>Instagram:</h4>
              <p><a href="#">@Agrowisata Kebun Al-Qur'an</a></p>
            </div>
          </div>
          <div class="col-lg-6">
            <div class="info w-100 mt-4">
              <i class="icofont-facebook"></i>
              <h4>Facebook :</h4>
              <p><a href="#"> Agrowisata Kebun Al-Qur'an</a></p>
            </div>
          </div>
        </div>

        <!-- <form action="forms/contact.php" method="post" role="form" class="php-email-form mt-4">
          <div class="form-row">
            <div class="col-md-6 form-group">
              <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" data-rule="minlen:4" data-msg="Please enter at least 4 chars" />
              <div class="validate"></div>
            </div>
            <div class="col-md-6 form-group">
              <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" data-rule="email" data-msg="Please enter a valid email" />
              <div class="validate"></div>
            </div>
          </div>
          <div class="form-group">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject" data-rule="minlen:4" data-msg="Please enter at least 8 chars of subject" />
            <div class="validate"></div>
          </div>
          <div class="form-group">
            <textarea class="form-control" name="message" rows="5" data-rule="required" data-msg="Please write something for us" placeholder="Message"></textarea>
            <div class="validate"></div>
          </div>
          <div class="mb-3">
            <div class="loading">Loading</div>
            <div class="error-message"></div>
            <div class="sent-message">Your message has been sent. Thank you!</div>
          </div>
          <div class="text-center"><button type="submit">Send Message</button></div>
        </form> -->
      </div>
    </div>

  </div>
</section><!-- End Contact Section -->

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer">

  

  <div class="container d-md-flex py-4">

    <div class="mr-md-auto text-center text-md-left">
      <div class="copyright">
        &copy; Copyright <strong><span>Bethany</span></strong>. All Rights Reserved
      </div>
      <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/bethany-free-onepage-bootstrap-theme/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      </div>
    </div>
    <div class="social-links text-center text-md-right pt-3 pt-md-0">
      <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
      <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
      <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
      <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
      <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
    </div>
  </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

<!-- Vendor JS Files -->
<script src="bethany_assets/vendor/jquery/jquery.min.js"></script>
<script src="bethany_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bethany_assets/vendor/jquery.easing/jquery.easing.min.js"></script>
<script src="bethany_assets/vendor/php-email-form/validate.js"></script>
<script src="bethany_assets/vendor/waypoints/jquery.waypoints.min.js"></script>
<script src="bethany_assets/vendor/counterup/counterup.min.js"></script>
<script src="bethany_assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="bethany_assets/vendor/venobox/venobox.min.js"></script>
<script src="bethany_assets/vendor/owl.carousel/owl.carousel.min.js"></script>
<script src="bethany_assets/vendor/aos/aos.js"></script>

<!-- Template Main JS File -->
<script src="bethany_assets/js/main.js"></script>

</body>

</html>