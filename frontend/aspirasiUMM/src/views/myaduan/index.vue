<script setup>
import { ref, computed, onMounted } from "vue";
import api from "../../api";
import { useRouter } from 'vue-router';

const router = useRouter();
const complaints = ref([]);
const searchQuery = ref("");
const selectedCategory = ref("");
const userId = ref(null);
const currentUser = ref(null);
const isEditing = ref(false);
const selectedAduan = ref(null);
const isLoading = ref(false);

const categories = [
  { id: "Layanan", name: "Layanan" },
  { id: "Kebersihan", name: "Kebersihan" },
  { id: "Fasilitas", name: "Fasilitas" },
  { id: "Akademik", name: "Akademik" },
];

const getUserData = async () => {
  try {
    const token = localStorage.getItem("token");
    const response = await api.get("/api/user", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    currentUser.value = response.data;
    userId.value = response.data.nim || response.data.id;
    await fetchDataPosts();
  } catch (error) {
    console.error("Error fetching user data:", error);
    alert("Gagal memuat data pengguna. Silakan coba lagi.");
  }
};

const fetchDataPosts = async () => {
  isLoading.value = true;
  try {
    const token = localStorage.getItem("token");
    const response = await api.get("/api/complaint", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    complaints.value = response.data.data.data.filter(
      (complaint) => complaint.user_id === userId.value
    );
  } catch (error) {
    console.error("Error fetching complaints:", error);
    alert("Gagal memuat daftar pengaduan. Silakan coba lagi.");
  } finally {
    isLoading.value = false;
  }
};

const filteredComplaints = computed(() => {
  return complaints.value.filter((complaint) => {
    const matchesSearch =
      !searchQuery.value ||
      complaint.judul.toLowerCase().includes(searchQuery.value.toLowerCase());
    const matchesCategory =
      !selectedCategory.value ||
      complaint.kategori.toLowerCase() === selectedCategory.value.toLowerCase();
    return matchesSearch && matchesCategory;
  });
});

const statusClass = (status) => {
  const statusLower = status.toLowerCase();
  switch (statusLower) {
    case "answered":
      return "bg-success text-white";
    case "unanswered":
      return "bg-secondary text-white";
    default:
      return "bg-secondary text-white";
  }
};

const editAduan = (complaint) => {
  selectedAduan.value = { ...complaint };
  isEditing.value = true;
};

const updateAduan = async () => {
  if (!selectedAduan.value.judul || !selectedAduan.value.deskripsi || !selectedAduan.value.kategori) {
    alert("Mohon lengkapi semua field yang diperlukan.");
    return;
  }

  isLoading.value = true;
  try {
    const token = localStorage.getItem("token");
    await api.put(`/api/complaint/${selectedAduan.value.id}`, selectedAduan.value, {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
    
    await fetchDataPosts();
    isEditing.value = false;
    selectedAduan.value = null;
    alert("Pengaduan berhasil diperbarui!");
  } catch (error) {
    console.error("Error updating complaint:", error);
    alert("Gagal memperbarui pengaduan. Silakan coba lagi.");
  } finally {
    isLoading.value = false;
  }
};

const cancelEdit = () => {
  if (confirm("Apakah Anda yakin ingin membatalkan perubahan?")) {
    isEditing.value = false;
    selectedAduan.value = null;
  }
};

const deleteAduan = async (complaint) => {
  if (complaint.user_id !== userId.value) {
    alert("Anda tidak memiliki izin untuk menghapus pengaduan ini.");
    return;
  }

  if (confirm("Apakah Anda yakin ingin menghapus pengaduan ini?")) {
    isLoading.value = true;
    try {
      const token = localStorage.getItem("token");
      await api.delete(`/api/complaint/${complaint.id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      await fetchDataPosts();
      alert("Pengaduan berhasil dihapus!");
    } catch (error) {
      console.error("Error deleting complaint:", error);
      alert("Gagal menghapus pengaduan. Silakan coba lagi.");
    } finally {
      isLoading.value = false;
    }
  }
};

const resetFilters = () => {
  searchQuery.value = "";
  selectedCategory.value = "";
};

const lihatDetail = (complaint) => {
  router.push({ name: 'comment', params: { id: complaint.id }});
};

onMounted(() => {
  getUserData();
});
</script>

<template>
  <div class="container py-5">
    <h2 class="text-center text-dark fw-bold mb-4">Pengaduan Anda</h2>
    <p class="text-center text-muted mb-4">
      Lihat semua pengaduan yang telah Anda buat.
    </p>

  
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
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </div>
    </div>

    <div class="row mb-4">
      <div class="col-12 text-end">
        <button class="btn btn-outline-secondary" @click="resetFilters">
          Reset Filter
        </button>
      </div>
    </div>


    <div v-if="isLoading" class="text-center my-4">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>


    <div class="row g-3" v-else>
    
      <template v-if="!isEditing">
        <div
          class="col-md-4 d-flex mb-4"
          v-for="complaint in filteredComplaints"
          :key="complaint.id"
        >
          <div class="card shadow-sm p-4 d-flex flex-column w-100 rounded-3">
            <h5 class="fw-bold mb-3">{{ complaint.judul }}</h5>

            <div class="mb-3 d-flex align-items-center">
              <span class="text-secondary fw-bold me-2">Kategori:</span>
              <span>{{ complaint.kategori }}</span>
            </div>
            <div class="mb-3 d-flex align-items-center">
              <span class="text-secondary fw-bold me-2">Status:</span>
              <span
                class="badge px-3 py-1"
                :class="statusClass(complaint.status)"
              >
                {{ complaint.status }}
              </span>
            </div>

            <p class="text-muted mb-3">{{ complaint.deskripsi }}</p>

            <div class="d-flex justify-content-between mt-auto">
              <button
                class="btn btn-sm custom-btn-detail px-4 py-2"
                @click="lihatDetail(complaint)"
              >
                Detail
              </button>
              <div class="d-flex align-items-center">
                <i
                  class="fas fa-pencil-alt text-primary me-3"
                  @click="editAduan(complaint)"
                  style="cursor: pointer;"
                ></i>
                <i
                  class="fas fa-trash-alt text-danger delete-icon"
                  @click="deleteAduan(complaint)"
                  style="cursor: pointer;"
                ></i>
              </div>
            </div>
          </div>
        </div>


        <div
          v-if="filteredComplaints.length === 0"
          class="col-12 text-center text-muted"
        >
          <p>
            Tidak ada pengaduan yang sesuai dengan pencarian atau filter Anda.
          </p>
        </div>
      </template>

      
      <div v-else class="col-12">
        <div class="card shadow-sm p-4">
          <h4 class="mb-4">Edit Pengaduan</h4>
          <div class="form-group">
            <label for="judul" class="form-label">Judul</label>
            <input 
              type="text" 
              id="judul" 
              v-model="selectedAduan.judul" 
              class="form-control mb-3"
              required
            />

            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea 
              id="deskripsi" 
              v-model="selectedAduan.deskripsi" 
              class="form-control mb-3"
              rows="4"
              required
            ></textarea>

            <label for="kategori" class="form-label">Kategori</label>
            <select 
              id="kategori" 
              v-model="selectedAduan.kategori" 
              class="form-control mb-4" style="height: 35pt;"
              required
            >
              <option value="">Pilih Kategori</option>
              <option v-for="category in categories" 
                      :key="category.id" 
                      :value="category.id">
                {{ category.name }}
              </option>
            </select>

            <div class="d-flex justify-content-end gap-2">
              <button 
                class="btn btn-secondary" 
                @click="cancelEdit"
                :disabled="isLoading"
              >
                Batal
              </button>
              <button 
                class="btn btn-primary" 
                @click="updateAduan"
                :disabled="isLoading"
              >
                <span v-if="isLoading" class="spinner-border spinner-border-sm me-2"></span>
                {{ isLoading ? 'Menyimpan...' : 'Simpan Perubahan' }}
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.custom-btn-detail {
  background-color: #143672;
  color: white;
  border-radius: 25px;
  padding: 10px 20px;
  border: none;
  transition: background-color 0.3s ease;
}

.custom-btn-detail:hover {
  background-color: #0a2a48;
  cursor: pointer;
}

.custom-dropdown {
  border-radius: 20px;
  padding: 10px;
  border: 1px solid #ddd;
}

.card {
  border-radius: 15px;
  transition: transform 0.3s ease-in-out;
  border: none;
}

.card:hover {
  transform: scale(1.02);
}

.form-control, .form-select {
  border-radius: 10px;
  border: 1px solid #ddd;
  padding: 0.75rem;
}

.form-control:focus, .form-select:focus {
  border-color: #143672;
  box-shadow: 0 0 0 0.2rem rgba(20, 54, 114, 0.25);
}

.form-group {
  margin-bottom: 15px;
}

.form-select {
  height: 42px;
  padding: 0.375rem 2.25rem 0.375rem 0.75rem;
}

.delete-icon {
  font-size: 1.25rem;
  transition: color 0.3s ease;
}

.delete-icon:hover {
  color: #dc3545;
}

.text-primary {
  color: #143672 !important;
}

.form-label {
  font-weight: 500;
  margin-bottom: 0.5rem;
  color: #333;
}

.gap-2 {
  gap: 0.5rem;
}

.btn {
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  font-weight: 500;
}

.btn:disabled {
  cursor: not-allowed;
  opacity: 0.7;
}

.spinner-border {
  width: 1.5rem;
  height: 1.5rem;
}
</style>