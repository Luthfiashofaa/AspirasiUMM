<template>
  <section
    class="slider_section position-relative overflow-hidden"
    style="background-color: #f8f9fa"
  >
    <div class="container py-5">
      <div class="row align-items-center">
        
        <div class="col-md-6">
          <div class="detail-box">
            <h1 class="text-danger display-4 fw-bold">
              Buat <br />
              Pengaduan <br />
              Anda
            </h1>
            <p class="text-secondary mt-3">
              Sampaikan keluhan atau masukan Anda untuk layanan yang lebih baik,
              Kami siap membantu Anda!
            </p>
            <router-link :to="{ name: 'buat-aduan' }" class="btn custom-btn-primary btn-lg mt-3 px-4">Formulir Pengaduan</router-link>
          </div>
        </div>
        
        <div class="col-md-6">
          <img
            src="../../assets/suaraa.png"
            alt="Ilustrasi Pengaduan"
            style="animation: float 3s ease-in-out infinite"
          />
        </div>
      </div>
    </div>
    
    <div class="decorative-circle position-absolute"></div>
    <div class="decorative-circle small position-absolute"></div>

   
    <div class="particle-container">
      <div class="particle"></div>
      <div class="particle"></div>
      <div class="particle"></div>
    </div>
  </section>

  
  <div class="mt-5 mx-5">
    <h2 class="text-dark fw-bold text-center">Kategori Pengaduan</h2>
    <p class="text-muted text-center mb-4">
      Pilih kategori pengaduan yang anda ingin lihat, Setiap kategori berisikan
      pengaduan semua orang sesuai dengan permasalahannya.
    </p>

    <div class="row mt-4 mb-5">
      <div class="col-md-3 mb-2">
        <router-link
          to="/fasilitas"
          class="card text-center shadow-sm tag-card p-2"
        >
          <div class="card-body p-2 d-flex flex-column align-items-center">
            <h6 class="tag-title fw-bold">Fasilitas</h6>
          </div>
        </router-link>
      </div>
      <div class="col-md-3 mb-2">
        <router-link
          to="/layanan"
          class="card text-center shadow-sm tag-card p-2"
        >
          <div class="card-body p-2 d-flex flex-column align-items-center">
            <h6 class="tag-title fw-bold">Layanan</h6>
          </div>
        </router-link>
      </div>
      <div class="col-md-3 mb-2">
        <router-link
          to="/akademik"
          class="card text-center shadow-sm tag-card p-2"
        >
          <div class="card-body p-2 d-flex flex-column align-items-center">
            <h6 class="tag-title fw-bold">Akademik</h6>
          </div>
        </router-link>
      </div>
      <div class="col-md-3 mb-2">
        <router-link
          to="/kebersihan"
          class="card text-center shadow-sm tag-card p-2"
        >
          <div class="card-body p-2 d-flex flex-column align-items-center">
            <h6 class="tag-title fw-bold">Kebersihan</h6>
          </div>
        </router-link>
      </div>
    </div>
  </div>

  <!-- Daftar Pengaduan
  <div class="mt-5 mx-5">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="text-dark fw-bold">Daftar Pengaduan</h2>
      <div class="d-flex">
        <input
          type="text"
          class="form-control me-2"
          placeholder="Cari berdasarkan nama"
          v-model="searchQuery"
          style="width: 250px;"
        />
        <select class="form-select" v-model="selectedStatus" style="width: 200px;">
          <option value="">Semua Status</option>
          <option value="Selesai">Selesai</option>
          <option value="Dibatalkan">Dibatalkan</option>
        </select>
      </div>
    </div>

    <div class="container mt-5">
      <div class="row">
        <div
          v-for="(profile, index) in filteredProfiles"
          :key="index"
          class="col-md-4 mb-4"
        >
          <div class="card shadow-lg text-center p-4 custom-card">
            <div class="text-center mb-3">
              <img
                src="https://i0.wp.com/global.ac.id/wp-content/uploads/2015/04/speaker-3-v2.jpg?w=768&ssl=1"
                alt="Avatar"
                class="rounded-circle mb-3"
                style="width: 80px; height: 80px; object-fit: cover;"
              />
              <h5 class="fw-bold">{{ profile.name }}</h5>
              <span
                class="badge px-3 py-2 text-white"
                :class="profile.status === 'Selesai' ? 'bg-primary' : 'bg-danger'"
              >
                {{ profile.status }}
              </span>
            </div>

            <p class="text-muted small mt-3 mb-3">
              Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque.
            </p>

            <div class="d-flex justify-content-center flex-wrap mb-3">
              <span
                v-for="(area, idx) in profile.focusAreas"
                :key="idx"
                class="badge bg-light text-dark mx-1 mb-2"
              >
                {{ area }}
              </span>
            </div>

            <button class="btn custom-btn-primary btn-block mt-3">Detail Pengaduan</button>
          </div>
        </div>
      </div>
    </div>
  </div> -->
</template>

<script>
export default {
  name: 'pengaduan',
  data() {
    return {
      searchQuery: "",
      selectedStatus: "",
      totalReports: 959139,
      services: 1200,
      cleanliness: 800,
      facilities: 950,
      security: 700,
      profiles: [
        { name: "Michael Spitz", status: "Selesai", focusAreas: ["Fasilitas"] },
        {
          name: "Marco Coppeto",
          status: "Dibatalkan",
          focusAreas: ["Layanan"],
        },
        { name: "Gene Ross", status: "Selesai", focusAreas: ["Akademik"] },
      ],
      categories: [
        {
          name: "Fasilitas",
          icon: "bi bi-gear-fill",
          description: "Keluhan terkait fasilitas umum.",
        },
        {
          name: "Layanan",
          icon: "bi bi-people-fill",
          description: "Keluhan terkait pelayanan.",
        },
        {
          name: "Akademik",
          icon: "bi bi-shield-fill",
          description: "Keluhan terkait Akademik.",
        },
        {
          name: "Kebersihan",
          icon: "bi bi-trash-fill",
          description: "Keluhan terkait kebersihan.",
        },
      ],
    };
  },

  created() {
    
    this.checkAuth()
  },
  computed: {
    filteredProfiles() {
      return this.profiles.filter((profile) => {
        const matchesName = profile.name
          .toLowerCase()
          .includes(this.searchQuery.toLowerCase());
        const matchesStatus =
          !this.selectedStatus || profile.status === this.selectedStatus;
        return matchesName && matchesStatus;
      });
    },
  },
  methods: {
    viewDetails() {
      alert("Navigasi ke halaman detail belum diimplementasikan.");
    },

    checkAuth() {
      const token = localStorage.getItem('token')
      if (!token) {
        this.$router.push({ 
          name: 'login',
          query: { redirect: this.$route.fullPath }
        })
      }
    },
  },
};
</script>

<style scoped>

.decorative-circle {
  position: absolute;
  background-color: #0a0f42;
  border-radius: 50%;
  opacity: 0.1;
  animation: float 6s ease-in-out infinite;
}
.decorative-circle.small {
  width: 150px;
  height: 150px;
  bottom: 10%;
  right: 5%;
}
.decorative-circle {
  width: 300px;
  height: 300px;
  top: -10%;
  left: -10%;
}

.particle-container {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  overflow: hidden;
  pointer-events: none;
}

.particle {
  position: absolute;
  width: 10px;
  height: 10px;
  background-color: rgba(0, 123, 255, 0.3);
  border-radius: 50%;
  animation: particle-float 6s infinite ease-in-out;
}

.particle:nth-child(1) {
  top: 20%;
  left: 30%;
  animation-delay: 0s;
}

.particle:nth-child(2) {
  top: 50%;
  left: 60%;
  animation-delay: 2s;
}

.particle:nth-child(3) {
  top: 80%;
  left: 20%;
  animation-delay: 4s;
}

@keyframes particle-float {
  0% {
    transform: translateY(0) translateX(0);
    opacity: 1;
  }
  50% {
    transform: translateY(-50px) translateX(20px);
    opacity: 0.5;
  }
  100% {
    transform: translateY(0) translateX(0);
    opacity: 1;
  }
}


.custom-btn-primary {
  background-color: #0a0f42;
  color: #fff;
  border: none;
  transition: background-color 0.3s ease;
}

.custom-btn-primary:hover {
  background-color: #081030;
}


.custom-card {
  border: 1px solid rgba(0, 0, 0, 0.1);
  border-radius: 10px;
}


.text-center {
  text-align: center;
}

.fw-bold {
  font-weight: bold;
}

.py-5 {
  padding-top: 3rem;
  padding-bottom: 3rem;
}

.mt-4 {
  margin-top: 1.5rem;
}

.mb-4 {
  margin-bottom: 1.5rem;
}

.tag-card {
  border: 2px solid #dc3545; 
  color: #dc3545; 
  background-color: #fff;
  transition: all 0.3s ease-in-out;
}

.tag-card:hover {
  background-color: #dc3545;
  color: #fff;
  border-color: #dc3545; 
}

.tag-card:hover .card-title,
.tag-card:hover i {
  color: #fff;
}
</style>
