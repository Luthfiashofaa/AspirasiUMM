<template>
  <div class="mt-5 mx-5">
    <div class="d-flex justify-content-between align-items-center">
      <h2 class="text-dark fw-bold">
        Daftar Pengaduan
        <span class="text-danger">Kebersihan</span> 
      </h2>
      <div class="d-flex">
        <input
          type="text"
          class="form-control me-2"
          placeholder="Cari berdasarkan nama"
          v-model="searchQuery"
          style="width: 250px;"
        />
        <select class="form-select" v-model="selectedStatus" style="width: 200px;">
          <option value="">All status</option>
          <option value="Selesai">Answered</option>
          <option value="Dibatalkan">Unanswered</option>
        </select>
      </div>
    </div>

    <div class="container mt-5">
  <div class="row">
    <div v-for="(complaint, index) in filteredComplaints" :key="complaint.id" class="col-md-4 mb-4">
      <div class="card shadow-lg text-center p-4 custom-card">
        <!-- Menampilkan Avatar dan Nama Pengguna -->
        <div class="text-center mb-3">
          <img
            v-if="complaint.user" :src="complaint.user.image"
            alt="Avatar"
            class="rounded-circle mb-3"
            style="width: 80px; height: 80px; object-fit: cover;"
          />
          <h5 class="fw-bold">{{ complaint.user ? complaint.user.name : 'User not found' }}</h5>
          <span
            class="badge px-3 py-2 text-white"
            :class="complaint.status === 'answered' ? 'bg-primary' : 'bg-danger'"
          >
            {{ complaint.status }}
          </span>
        </div>

        <!-- Menampilkan Deskripsi Pengaduan -->
        <p class="text-muted small mt-3 mb-3">
          {{ complaint.deskripsi }}
        </p>

        <!-- Menampilkan Kategori Pengaduan -->
        <div class="d-flex justify-content-center flex-wrap mb-3">
          <span class="badge bg-light text-dark mx-1 mb-2">
            {{ complaint.kategori }}
          </span>
        </div>

        <!-- Tombol Detail Pengaduan -->
        <button class="btn custom-btn-primary btn-block mt-3">Detail Pengaduan</button>
      </div>
    </div>
  </div>
</div>

  </div>
</template>

<script>
import { ref, onMounted } from "vue";
import api from "../../api";

export default {
  data() {
    return {
      searchQuery: "",
      selectedStatus: "",
      profiles: [
        { name: "Michael Spitz", status: "Selesai", focusAreas: ["Fasilitas"] },
        { name: "Marco Coppeto", status: "Dibatalkan", focusAreas: ["Fasilitas"] },
        { name: "Gene Ross", status: "Selesai", focusAreas: ["Fasilitas"] },
      ],
      users: ref([]),
      complaints: ref([]),
      editedOffer: ref(null),
      isEditing: ref(false),
    };
  },
  computed: {
    filteredProfiles() {
      return this.profiles.filter((profiles) => {
        const matchesName = profiles.name.toLowerCase().includes(this.searchQuery.toLowerCase());
        const matchesStatus = !this.selectedStatus || profiles.status === this.selectedStatus;
        return matchesName && matchesStatus;
      });
    },

    filteredComplaints() {
    return this.complaints.filter((complaint) => {
      const matchesName = complaint.user ? complaint.user.name.toLowerCase().includes(this.searchQuery.toLowerCase()) : true;
      const matchesStatus = !this.selectedStatus || complaint.status.toLowerCase() === this.selectedStatus.toLowerCase();
      const matchesCategory = complaint.kategori.toLowerCase() === "kebersihan"; // Filter kategori Fasilitas
      return matchesName && matchesStatus && matchesCategory;
    });
  },
  },
  methods: {
    async fetchDataUser() {
      const response = await api.get("/api/get-user");
      this.users= response.data.data.data || [];
    },
    async fetchDataComplaint() {
      const response = await api.get("/api/complaint");
      this.complaints = response.data.data.data || [];
    },
  },
  mounted() {
    this.fetchDataUser();
    this.fetchDataComplaint();
    
  },
};
</script>


<style>
.custom-btn-primary {
  background-color: #0a0f42;
  color: #fff;
  border: none;
  transition: background-color 0.3s ease;
}

.custom-btn-primary:hover {
  background-color: #081030;
}
</style>