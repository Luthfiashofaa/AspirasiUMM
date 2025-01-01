<template>
    <div class="text-center">
      <div class="bg-hero text-white py-5">
        <h1 class="fw-bold">JUMLAH PENGADUAN SEKARANG</h1>
        <h2 class="display-3">{{ totalReports.toLocaleString() }}</h2>
      </div>
      <div class="container py-5">
        <h3 class="fw-bold mb-4">TOTAL PENGADUAN SETIAP KATEGORI</h3>
        <div class="row g-3">
  <div class="col-md-3">
    <div class="text-center py-4 rounded shadow-sm text-white" :style="{ backgroundColor: '#00689a' }">
      <h1 class="fw-bold">{{ services }}</h1>
      <p class="text-white">Layanan</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="text-center py-4 rounded shadow-sm text-white" :style="{ backgroundColor: '#ff6969' }">
      <h1 class="fw-bold">{{ cleanliness }}</h1>
      <p class="text-white">Kebersihan</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="text-center py-4 rounded shadow-sm text-white" :style="{ backgroundColor: '#C70039' }">
      <h1 class="fw-bold">{{ facilities }}</h1>
      <p class="text-white">Fasilitas</p>
    </div>
  </div>
  <div class="col-md-3">
    <div class="text-center py-4 rounded shadow-sm text-white" :style="{ backgroundColor: '#141E46' }">
      <h1 class="fw-bold">{{ security }}</h1>
      <p class="text-white">Keamanan</p>
    </div>
  </div>
</div>

      </div>

    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        totalReports: 959139,
        services: 1200,
        cleanliness: 800,
        facilities: 950,
        security: 700,
      };
    },
    methods: {
      viewDetails() {
        alert("Navigasi ke halaman detail belum diimplementasikan.");
      },
    },
  };
  </script>
  
  <style scoped>
  .bg-hero {
    background-color: #141E46 !important;
  }
  
  .container {
    max-width: 900px;
    margin: 0 auto;
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
  </style>