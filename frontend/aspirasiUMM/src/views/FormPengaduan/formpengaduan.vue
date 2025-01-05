<template>
  <section class="pengaduan-section py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          <div class="card shadow-timbul">
            <div class="card-body">
              <!-- Judul dan Deskripsi -->
              <div class="text-center mb-5 pt-4">
                <h1 class="fw-bold">Formulir Pengaduan</h1>
                <p class="text-muted">Isi formulir berikut untuk menyampaikan pengaduan Anda kepada kami.</p>
              </div>

              <form>
                <!-- Input Judul -->
                <div class="mb-3">
                  <label for="judul" class="form-label fw-bold">Judul Pengaduan</label>
                  <input
                    type="text"
                    class="form-control"
                    id="judul"
                    v-model="judul"
                    placeholder="Masukkan judul pengaduan"
                  />
                </div>

                <!-- Textarea Deskripsi -->
                <div class="mb-4">
                  <label for="deskripsi" class="form-label fw-bold">Deskripsi Pengaduan</label>
                  <textarea
                    class="form-control"
                    id="deskripsi"
                    rows="5"
                    v-model="deskripsi"
                    placeholder="Jelaskan masalah atau keluhan Anda secara detail..."
                  ></textarea>
                </div>

                <!-- Dropdown Kategori -->
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

                <!-- Tombol Submit -->
                <div class="text-center">
                  <button
                    type="button"
                    class="btn btn-primary btn-lg px-5"
                    @click="submitPengaduan"
                  >
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

<script>
export default {
  data() {
    return {
      judul: "",
      kategori: "",
      deskripsi: "",
    };
  },
  methods: {
    submitPengaduan() {
      if (this.judul === "" || this.kategori === "" || this.deskripsi === "") {
        alert("Harap isi semua kolom sebelum mengirim pengaduan.");
        return;
      }
      alert(
        `Pengaduan Anda berhasil dikirim!\n\nJudul: ${this.judul}\nKategori: ${this.kategori}\nDeskripsi: ${this.deskripsi}`
      );
      // Reset form
      this.judul = "";
      this.kategori = "";
      this.deskripsi = "";
    },
  },
};
</script>

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

/* Penyesuaian untuk teks agar sedikit lebih ke atas */
.card-body .text-center {
  padding-top: 20px;  /* Memberikan jarak atas */
}

.card-body .text-center h1 {
  margin-top: 0;  /* Menghilangkan margin atas dari judul */
}

.card-body .text-center p {
  margin-top: 0;  /* Menghilangkan margin atas dari deskripsi */
}
</style>
