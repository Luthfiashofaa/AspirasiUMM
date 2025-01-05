<template>
  <div class="container py-5">
    <!-- Judul Halaman -->
    <h2 class="text-center text-dark fw-bold mb-4">Pengaduan Anda</h2>
    <p class="text-center text-muted mb-4">Lihat semua pengaduan yang telah Anda buat.</p>

    <!-- Form Pencarian dan Filter -->
    <div class="row mb-4">
      <div class="col-md-8 mb-3 mb-md-0">
        <input
          type="text"
          class="form-control"
          placeholder="Cari berdasarkan judul..."
          v-model="searchQuery"
        />
      </div>
      <div class="col-md-4">
        <select class="form-select custom-dropdown" v-model="selectedCategory">
          <option value="">Semua Kategori</option>
          <option value="Layanan">Layanan</option>
          <option value="Kebersihan">Kebersihan</option>
          <option value="Fasilitas">Fasilitas</option>
          <option value="Akademik">Akademik</option>
        </select>
      </div>
    </div>

    <!-- Grid Card Pengaduan -->
    <div class="row g-3">
      <div
        class="col-md-4 d-flex mb-4"
        v-for="(aduan, index) in filteredAduan"
        :key="index"
      >
        <div
          class="card shadow-sm p-4 d-flex flex-column w-100 rounded-3"
          @mouseover="onCardHover(true, index)"
          @mouseleave="onCardHover(false, index)"
          :class="{
            'bg-blue': aduan.hovered,
            'transform-scale': aduan.hovered,
          }"
        >
          <!-- Judul Pengaduan -->
          <h5 class="fw-bold mb-3">{{ aduan.judul }}</h5>

          <!-- Detail Kategori dan Status -->
          <div class="mb-3 d-flex align-items-center">
            <span class="text-secondary fw-bold me-2"><strong>Kategori:</strong></span>
            <span>{{ aduan.kategori }}</span>
          </div>
          <div class="mb-3 d-flex align-items-center">
            <span class="text-secondary fw-bold me-2"><strong>Status:</strong></span>
            <span
              class="badge px-3 py-1"
              :class="statusClass(aduan.status)"
            >
              {{ aduan.status }}
            </span>
          </div>

          <!-- Deskripsi -->
          <p class="text-muted mb-3">{{ aduan.deskripsi }}</p>

          <!-- Icon Detail dan Edit dengan jarak yang tepat -->
          <div class="d-flex justify-content-between mt-auto">
            <button
              class="btn btn-sm custom-btn-detail px-4 py-2"
              @click="lihatDetail(aduan)"
            >
              Detail
            </button>
            <div class="d-flex align-items-center">
              <!-- Icon Pensil untuk Edit -->
              <i
                class="fas fa-pencil-alt text-primary me-3"
                @click="editAduan(aduan)"
                style="cursor: pointer;"
              ></i>
              <!-- Icon Tong Sampah untuk Hapus -->
              <i
                class="fas fa-trash-alt text-danger delete-icon"
                @click="deleteAduan(aduan)"
                style="cursor: pointer;"
              ></i>
            </div>
          </div>
        </div>
      </div>

      <!-- Jika Tidak Ada Data -->
      <div v-if="filteredAduan.length === 0" class="text-center text-muted">
        <p>Tidak ada pengaduan yang sesuai dengan pencarian atau filter Anda.</p>
      </div>
    </div>

    <!-- Modal Detail Pengaduan -->
    <div
      v-if="showDetailCard"
      class="modal-detail p-4"
      @click.self="showDetailCard = false"
    >
      <div class="card detail-card w-100 p-4 position-relative rounded-3">
        <!-- Close Button -->
        <span class="close-btn" @click="showDetailCard = false">&times;</span>
        
        <!-- Judul dan Kategori -->
        <h5 class="fw-bold">{{ selectedAduan.judul }}</h5>
        <div class="mb-3">
          <span class="text-secondary fw-bold">Kategori:</span> {{ selectedAduan.kategori }}
        </div>

        <!-- Deskripsi Pengaduan -->
        <p>{{ selectedAduan.deskripsi }}</p>

        <!-- Status -->
        <div class="mb-3">
          <span class="text-secondary fw-bold">Status:</span>
          <span class="badge px-3 py-1" :class="statusClass(selectedAduan.status)">
            {{ selectedAduan.status }}
          </span>
        </div>

        <!-- Form untuk Update -->
        <div v-if="isEditing" class="d-flex justify-content-center mt-4">
          <div class="form-group w-100">
            <label for="judul">Judul</label>
            <input type="text" id="judul" v-model="selectedAduan.judul" class="form-control mb-2" />

            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" v-model="selectedAduan.deskripsi" class="form-control mb-2"></textarea>

            <label for="kategori">Kategori</label>
            <select id="kategori" v-model="selectedAduan.kategori" class="form-control mb-2">
              <option value="Layanan">Layanan</option>
              <option value="Kebersihan">Kebersihan</option>
              <option value="Fasilitas">Fasilitas</option>
              <option value="Akademik">Akademik</option>
            </select>

            <button class="btn btn-primary mx-2" @click="updateAduan">Update</button>
          </div>
        </div>
        <div v-else>
          <div class="d-flex justify-content-center mt-4">
            <button class="btn btn-primary mx-2" @click="toggleEditMode">Edit</button>
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
      searchQuery: "",
      selectedCategory: "",
      aduanList: [
        {
          judul: "Lampu Jalan Rusak di Depan Gedung A",
          kategori: "Fasilitas",
          deskripsi:
            "Lampu jalan yang berada di depan Gedung A sudah tidak menyala selama 3 hari.",
          status: "Diproses",
          hovered: false,
        },
        {
          judul: "Kebersihan Toilet Umum",
          kategori: "Kebersihan",
          deskripsi:
            "Toilet umum di Gedung B sangat kotor dan tidak ada sabun cuci tangan.",
          status: "Selesai",
          hovered: false,
        },
        {
          judul: "AC Tidak Berfungsi",
          kategori: "Fasilitas",
          deskripsi:
            "AC di ruang rapat tidak berfungsi sehingga ruangan terasa sangat panas.",
          status: "Dibatalkan",
          hovered: false,
        },
        {
          judul: "Layanan Pengurusan KRS",
          kategori: "Layanan",
          deskripsi: "Pengurusan KRS mengalami kendala saat proses login.",
          status: "Diproses",
          hovered: false,
        },
        {
          judul: "Jadwal Kuliah Tidak Sesuai",
          kategori: "Akademik",
          deskripsi: "Jadwal kuliah tidak sesuai dengan pengumuman sebelumnya.",
          status: "Selesai",
          hovered: false,
        },
      ],
      showDetailCard: false,
      selectedAduan: null,
      isEditing: false,
    };
  },
  computed: {
    filteredAduan() {
      return this.aduanList.filter((aduan) => {
        const matchesSearch =
          this.searchQuery === "" ||
          aduan.judul.toLowerCase().includes(this.searchQuery.toLowerCase());
        const matchesCategory =
          this.selectedCategory === "" || aduan.kategori === this.selectedCategory;
        return matchesSearch && matchesCategory;
      });
    },
  },
  methods: {
    statusClass(status) {
      switch (status) {
        case "Selesai":
          return "bg-success text-white";
        case "Diproses":
          return "bg-warning text-dark";
        case "Dibatalkan":
          return "bg-danger text-white";
        default:
          return "bg-secondary text-white";
      }
    },
    lihatDetail(aduan) {
      this.selectedAduan = aduan;
      this.showDetailCard = true;
    },
    editAduan(aduan) {
      this.selectedAduan = aduan;
      this.isEditing = true;
      this.showDetailCard = true;
    },
    updateAduan() {
      alert(`Mengupdate pengaduan: ${this.selectedAduan.judul}`);
      this.isEditing = false;
    },
    deleteAduan(aduan) {
      const index = this.aduanList.indexOf(aduan);
      if (index !== -1) {
        this.aduanList.splice(index, 1);
      }
    },
    toggleEditMode() {
      this.isEditing = !this.isEditing;
    },
    onCardHover(hover, index) {
      this.aduanList[index].hovered = hover;
    },
  },
};
</script>

<style scoped>
/* Styling untuk tombol detail */
.custom-btn-detail {
  background-color: #143672;
  color: white;
  border-radius: 25px;
  padding: 10px 20px;
  border: none;
}

.custom-btn-detail:hover {
  background-color: #0a2a48;
  cursor: pointer;
}

/* Styling untuk dropdown kategori */
.custom-dropdown {
  border-radius: 20px;
  padding: 10px;
  border: 1px solid #ddd;
}

/* Styling untuk card */
.card {
  border-radius: 15px;
  transition: transform 0.3s ease-in-out;
}

.card:hover {
  transform: scale(1.05);
}

.bg-blue {
  background-color: #e6f4ff;
}

/* Styling untuk modal detail pengaduan */
.modal-detail {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1050;
}

.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 30px;
  color: #333;
  cursor: pointer;
}

/* Styling untuk card detail pengaduan */
.detail-card {
  background-color: white;
  width: 80%;
  max-width: 600px;
}

.form-control {
  border-radius: 10px;
}

.form-group {
  margin-bottom: 15px;
}

.delete-icon {
  font-size: 20px;
  margin-left: 10px;
}

.text-primary {
  color: #143672;
}

.transform-scale {
  transform: scale(1.05);
}

.text-muted {
  color: #6c757d !important;
}
</style>
