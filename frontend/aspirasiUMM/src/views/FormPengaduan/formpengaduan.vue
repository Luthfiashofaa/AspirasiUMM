<script setup>
import { ref, onMounted } from "vue";
import { useRouter } from 'vue-router';
import api from "../../api";


const router = useRouter();


const judul = ref("");
const deskripsi = ref("");
const kategori = ref("");
const errors = ref([]);
const userId = ref(null); 
const isAuthenticated = ref(false);

const checkAuth = async () => {
  const token = localStorage.getItem('token');
  if (!token) {
    router.push({
      name: 'login',
      query: { redirect: router.currentRoute.value.fullPath }
    });
    return;
  }

  try {
    await getUserData();
    isAuthenticated.value = true;
  } catch (error) {
    console.error('Authentication check failed:', error);
    localStorage.removeItem('token');
    router.push({
      name: 'login',
      query: { redirect: router.currentRoute.value.fullPath }
    });
  }
};

const getUserData = async () => {
    try {
        const token = localStorage.getItem('token');
        const response = await api.get('/api/user', {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });
       
        userId.value = response.data.nim || response.data.id;
    } catch (error) {
        console.error('Error fetching user data:', error);
    }
};


onMounted(() => {
    getUserData();
});


const validateForm = () => {
    if (judul.value === "" || kategori.value === "" || deskripsi.value === "") {
        alert("Harap isi semua kolom sebelum mengirim pengaduan.");
        return false;
    }
    if (!userId.value) {
        alert("Data user tidak ditemukan. Silakan login kembali.");
        return false;
    }
    return true;
};

const storePost = async () => {
    if (!validateForm()) return;

    let formData = new FormData();

 
    formData.append("judul", judul.value);
    formData.append("deskripsi", deskripsi.value);
    formData.append("kategori", kategori.value);
    formData.append("status", "unanswered");
    formData.append("user_id", userId.value); 
    
    try {
        const token = localStorage.getItem('token');
        
     
        const config = {
            headers: {
                'Authorization': `Bearer ${token}`
            }
        };

    
        await api.post('/api/complaint', formData, config);
        
        alert(`Pengaduan Anda berhasil dikirim!\n\nJudul: ${judul.value}\nKategori: ${kategori.value}\nDeskripsi: ${deskripsi.value}`);
        
      
        judul.value = "";
        kategori.value = "";
        deskripsi.value = "";
        
        
        router.push({ path: "/aduan-saya" });
    } catch (error) {
        
        errors.value = error.response.data;
    }
};
</script>

<template>
  <section class="pengaduan-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card shadow-timbul">
            <div class="card-body">
            
              <div class="text-center mb-5 pt-4">
                <h1 class="fw-bold">Formulir Pengaduan</h1>
                <p class="text-muted">Isi formulir berikut untuk menyampaikan pengaduan Anda kepada kami.</p>
              </div>

              <form @submit.prevent="storePost">
                
                <div class="mb-3">
                  <label for="judul" class="form-label fw-bold">Judul Pengaduan</label>
                  <input
                    type="text"
                    class="form-control"
                    id="judul"
                    v-model="judul"
                    placeholder="Masukkan judul pengaduan"
                  />
                  <div v-if="errors.judul" class="alert alert-danger mt-2">
                    <span>{{ errors.judul[0] }}</span>
                  </div>
                </div>

                
                <div class="mb-4">
                  <label for="deskripsi" class="form-label fw-bold">Deskripsi Pengaduan</label>
                  <textarea
                    class="form-control"
                    id="deskripsi"
                    rows="5"
                    v-model="deskripsi"
                    placeholder="Jelaskan masalah atau keluhan Anda secara detail..."
                  ></textarea>
                  <div v-if="errors.deskripsi" class="alert alert-danger mt-2">
                    <span>{{ errors.deskripsi[0] }}</span>
                  </div>
                </div>

              
                <div class="mb-5 d-flex align-items-center kategori-wrapper">
                  <label for="kategori" class="form-label fw-bold me-3">Kategori Aduan</label>
                  <select class="form-select" id="kategori" v-model="kategori" style="width: 50%;">
                    <option value="" disabled>Pilih kategori</option>
                    <option value="Layanan">Layanan</option>
                    <option value="Kebersihan">Kebersihan</option>
                    <option value="Fasilitas">Fasilitas</option>
                    <option value="Akademik">Akademik</option>
                  </select>
                </div>

                
                <div class="text-center">
                  <button type="submit" class="btn btn-primary btn-lg px-5">
                    Submit Pengaduan
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<style scoped>

.pengaduan-section {
  background-color: #f8f9fa;
}

.card {
  border-radius: 10px;
  padding: 3.5rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.shadow-timbul {
  box-shadow: 0 12px 20px rgba(0, 0, 0, 0.2), 0 16px 40px rgba(0, 0, 0, 0.15);
  transform: translateY(-10px);
}

.shadow-timbul:hover {
  box-shadow: 0 16px 30px rgba(0, 0, 0, 0.3), 0 20px 50px rgba(0, 0, 0, 0.2);
  transform: translateY(-20px);
}

.card-body {
  padding: 2.5rem;
}

.col-md-10 {
  max-width: 900px;
}

.mb-3,
.mb-4,
.mb-5 {
  margin-bottom: 2rem !important;
}

.kategori-wrapper {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.form-label {
  font-weight: bold;
  margin-bottom: 0;
}

textarea {
  resize: none;
}

select.form-select {
  width: 50%;
}

.btn-primary {
  background-color: #0a0f42;
  border: none;
  transition: background-color 0.3s ease;
}

.btn-primary:hover {
  background-color: #081030;
}

.card-body .text-center {
  padding-top: 20px;
}

.card-body .text-center h1 {
  margin-top: 0;
}

.card-body .text-center p {
  margin-top: 0;
}
</style>