<script>
import OwlCarousel from 'vue-owl-carousel'
export default {
  mounted() {
    if (typeof window.jQuery !== 'undefined') {
      $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
          loop: true,
          margin: 10,
          nav: true,
          responsive: {
            0: {
              items: 1
            },
            600: {
              items: 2
            },
            1000: {
              items: 2
            }
          }
        });
      });
    }
  }
}
</script>
<template>
    <section class="slider_section " style="background-color: #FFF5E0;">
      <div class="container " >
        <div class="row" >
          <div class="col-md-6 " >
            <div class="detail-box" >
              <h1>
                Layanan  <br>
                Pengaduan <br>
                Mahasiswa 
              </h1>
              <p>
                Platform bagi mahasiswa untuk mengajukan pengaduan terkait berbagai masalah di kampus. Setiap pengaduan akan ditangani dengan serius untuk menciptakan lingkungan kampus yang lebih baik.
              </p>
              <a href="">
                Kirim Pengaduan
              </a>
            </div>
          </div>
          <div class="col-md-6">
            <div class="img-box">
              <img style="width: 600pt; margin-left: -150pt;" src="/images/student.png" alt="">
            </div>
          </div>
        </div>
      </div>
    </section>

  <!-- feature section -->
  <section class="feature_section">
    <div class="container">
      <div class="feature_container">
        <router-link to="/pengaduan" class="box">
          <div class="img-box">
            <img src="/images/complain.png" alt="">
          </div>
          <h5 class="name">
             Pengaduan
          </h5>
        </router-link>
        <router-link to="/statistik" class="box">
          <div class="img-box">
            <img src="/images/statistik.png" alt="">
          </div>
          <h5 class="name">
            Laporan Statistik Pengaduan
          </h5>
        </router-link>
        </div>
      </div>
  </section>

  <!-- end feature section -->

  <!-- about section -->

  <section class="about_section layout_padding-bottom" id="about">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-md-6">
          <div class="detail-box">
            <h2>
              Tentang Kami
            </h2>
            <p>
              Kami adalah platform pengaduan mahasiswa yang berkomitmen untuk memberikan wadah bagi mahasiswa dalam menyampaikan berbagai keluhan, masukan, dan masalah yang dihadapi di kampus. Tujuan utama kami adalah menciptakan lingkungan kampus yang lebih baik melalui transparansi dan responsifitas terhadap setiap pengaduan yang diajukan. Kami menyediakan sistem pengaduan yang mudah digunakan dan dapat diakses kapan saja oleh seluruh mahasiswa. Setiap pengaduan yang diterima akan ditangani oleh pihak yang berwenang dengan profesional dan cepat, untuk memastikan solusi yang tepat dan efektif. Kami percaya bahwa suara mahasiswa sangat penting untuk kemajuan dan kenyamanan bersama di kampus.
            </p>
          </div>
        </div>
        <div class="col-lg-7 col-md-6">
          <div class="img-box">
            <img src="/images/home.jpeg" alt="">
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end about section -->


  <!-- professional section -->

  <section class="professional_section layout_padding" style="background-color: #FFF5E0;">
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <div class="img-box">
            <img src="/images/professional-img.png" alt="">
          </div>
        </div>
        <div class="col-md-6 ">
          <div class="detail-box">
            <h2>
              Kami Menyediakan<br>
              Layanan Pengaduan Mahasiswa
            </h2>
            <p>
              Kami hadir untuk membantu mahasiswa dalam menyampaikan keluhan terkait lingkungan kampus. Layanan ini dirancang untuk memastikan semua masalah yang dilaporkan dapat ditangani dengan cepat dan transparan. Jika Anda ingin melaporkan fasilitas yang bermasalah, layanan yang kurang memadai, atau isu lainnya, sistem kami siap mendukung Anda.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- end professional section -->

  <!-- service section -->

  <section class="service_section layout_padding" id="service">
    <div class="container ">
      <div class="heading_container heading_center">
        <h2> Our Services </h2>
      </div>
      <div class="row">
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box ">
            <div class="img-box">
              <img src="/images/form.png" alt="" />
            </div>
            <div class="detail-box">
              <h5>
                Formulir Pengaduan Online
              </h5>
              <p>
                Formulir dapat mencakup pilihan kategori masalah dan deskripsi pengaduan,serta status pengaduan
              </p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box ">
            <div class="img-box">
              <img src="/images/integration.png" alt="" />
            </div>
            <div class="detail-box">
              <h5>
                Integrasi dengan Semua Unit Kampus
              </h5>
              <p>
                Pengaduan dapat langsung diteruskan ke unit yang bertanggung jawab 
              </p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-md-4 mx-auto">
          <div class="box ">
            <div class="img-box">
              <img src="/images/report.png" alt="" />
            </div>
            <div class="detail-box">
              <h5>
                Statistik dan Laporan
              </h5>
              <p>
                Layanan pengaduan yang transparan. Setiap laporan yang masuk akan diproses dan dapat dipantau statusnya secara real-time. 
              </p>
            </div>
          </div>
        </div>
      </div>
      <div class="btn-box">
        <a href="">
          View More
        </a>
      </div>
    </div>
  </section>

  <!-- end service section -->

  <!-- client section -->

  <section class="client_section ">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          What Students Say
        </h2>
      </div>
      <owl-carousel :items="2" :nav="true" :loop="true">
      <div class="carousel-wrap layout_padding2-top ">
        <div class="owl-carousel">
          <div class="item">
            <div class="box">
              <div class="client_id">
                <div class="img-box">
                  <img src="/images/lisa.jpg" alt="">
                </div>
                <div class="client_detail">
                  <div class="client_info">
                    <h6>
                      Krishnaliza Zulfasha
                    </h6>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </div>
                  <i class="fa fa-quote-left" aria-hidden="true"></i>
                </div>
              </div>
              <div class="client_text">
                <p>
                  Layanan pengaduan ini sangat membantu! Saya bisa melaporkan masalah fasilitas dengan mudah, dan responnya cepat
                </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="client_id">
                <div class="img-box">
                  <img src="/images/nara.jpg" alt="">
                </div>
                <div class="client_detail">
                  <div class="client_info">
                    <h6>
                      Nadhira Ulya Nisa
                    </h6>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </div>
                  <i class="fa fa-quote-left" aria-hidden="true"></i>
                </div>
              </div>
              <div class="client_text">
                <p>
                  Proses pelacakan pengaduan sangat transparan, jadi saya tahu laporan saya sedang diproses
                </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="client_id">
                <div class="img-box">
                  <img src="/images/lika.jpg" alt="">
                </div>
                <div class="client_detail">
                  <div class="client_info">
                    <h6>
                      Lika Anjelina
                    </h6>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </div>
                  <i class="fa fa-quote-left" aria-hidden="true"></i>
                </div>
              </div>
              <div class="client_text">
                <p>
                  Awalnya ragu, tapi ternyata pengaduan saya tentang internet kampus langsung ditangani dalam waktu singkat. Terima kasih!
                </p>
              </div>
            </div>
          </div>
          <div class="item">
            <div class="box">
              <div class="client_id">
                <div class="img-box">
                  <img src="/images/fia.jpg" alt="">
                </div>
                <div class="client_detail">
                  <div class="client_info">
                    <h6>
                      Luthfia Shofa Dewi
                    </h6>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                  </div>
                  <i class="fa fa-quote-left" aria-hidden="true"></i>
                </div>
              </div>
              <div class="client_text">
                <p>
                  "Sistemnya mudah digunakan, dan ada banyak kategori pengaduan yang jelas. Saya sangat puas!"
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </owl-carousel>
    </div>
  </section>
</template>