<template>
  <section class="bsb-faq-2 bg-light py-3 py-md-5 py-xl-8">
    <div class="container">
      <div class="row gy-5 gy-lg-0">
        <div class="col-12 col-lg-6">
          <h2 class="h1 mb-3">Punya pertanyaan? Kami punya jawabannya! hubungi tim dukungan kami untuk bantuan yang lebih spesifik</h2>
          <p class="lead fs-4 text-secondary mb-4">
            Kami di sini untuk mempermudah pengalaman Anda. Temukan solusi dari pertanyaan Anda disini
          </p>
          <button 
            v-if="isAdmin"
            @click="openAddModal"
            class="btn btn-primary mb-4"
          >
            Tambah FAQ Baru
          </button>
        </div>
        <div class="col-12 col-lg-6">
          <div class="row justify-content-xl-end">
            <div class="col-12 col-xl-11">
              <div class="accordion" id="faqAccordion">
                <div
                  v-for="(faq, index) in faqsList"
                  :key="faq.id"
                  class="accordion-item mb-4 shadow-sm"
                >
                  <h2 class="accordion-header" :id="'heading' + index">
                    <div class="d-flex justify-content-between align-items-center">
                      <button
                        class="accordion-button bg-transparent fw-bold"
                        :class="{ collapsed: activeIndex !== index }"
                        type="button"
                        @click="toggleAccordion(index)"
                        :aria-expanded="activeIndex === index"
                        :aria-controls="'collapse' + index"
                      >
                        {{ faq.question }}
                      </button>
                      <div v-if="isAdmin" class="me-3 d-flex gap-2">
                        <button 
                          @click.stop="handleEdit(faq)"
                          class="btn btn-sm btn-link text-warning border-0"
                          title="Edit"
                        >
                          <i class="fas fa-pencil-alt"></i>
                        </button>
                        <button 
                          @click.stop="handleDelete(faq.id)"
                          class="btn btn-sm btn-link text-danger border-0"
                          title="Hapus"
                        >
                          <i class="fas fa-trash"></i>
                        </button>
                      </div>
                    </div>
                  </h2>
                  <div
                    :id="'collapse' + index"
                    class="accordion-collapse collapse"
                    :class="{ show: activeIndex === index }"
                    :aria-labelledby="'heading' + index"
                    data-bs-parent="#faqAccordion"
                  >
                    <div class="accordion-body">
                      <p style="color: black;">
                        {{ faq.answer }}
                      </p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>


    <div v-if="isAddingNew" class="modal d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Tambah FAQ Baru</h5>
            <button type="button" class="btn-close" @click="closeAddModal"></button>
          </div>
          <form @submit.prevent="handleSaveNew">
            <div class="modal-body">
              <div class="mb-3">
                <label class="form-label">Pertanyaan:</label>
                <input
                  type="text"
                  class="form-control"
                  v-model="newFaq.question"
                  placeholder="Masukkan pertanyaan"
                />
              </div>
              <div class="mb-3">
                <label class="form-label">Jawaban:</label>
                <textarea
                  class="form-control"
                  v-model="newFaq.answer"
                  rows="3"
                  placeholder="Masukkan jawaban"
                ></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" @click="closeAddModal">Batal</button>
              <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>

  
    <div v-if="isEditing && editingFaq" class="modal d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5)">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit FAQ</h5>
            <button type="button" class="btn-close" @click="closeEditModal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Pertanyaan:</label>
              <input
                type="text"
                class="form-control"
                v-model="editingFaq.question"
              />
            </div>
            <div class="mb-3">
              <label class="form-label">Jawaban:</label>
              <textarea
                class="form-control"
                v-model="editingFaq.answer"
                rows="3"
              ></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" @click="closeEditModal">Batal</button>
            <button type="button" class="btn btn-primary" @click="handleSave">Simpan</button>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { ref } from "vue";
import api from "../api";

export default {
  name: 'FAQSection',
  data() {
    return {
      activeIndex: null,
      isEditing: false,
      isAddingNew: false,
      editingFaq: null,
      userRole: null,
      currentUser: null,
      faqsList: [],
      newFaq: {
        question: '',
        answer: ''
      },
      errors: []
    };
  },
  computed: {
    isAdmin() {
      return this.userRole === 'admin';
    }
  },
  async created() {
    await this.getCurrentUser();
    await this.getFaqs();
  },
  methods: {
    async getFaqs() {
      try {
        const response = await api.get('/api/faq');
  
        this.faqsList = response.data.data.data;
      } catch (error) {
        console.error('Error fetching FAQs:', error);
      }
    },
    async getCurrentUser() {
      try {
        const token = localStorage.getItem("token");
        if (!token) throw new Error("Token not found");

        const response = await api.get("/api/user", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        if (response.data) {
          this.currentUser = response.data;
          this.userId = response.data.nim || response.data.id;
          this.userRole = response.data.role;
        }
      } catch (error) {
        console.error("Error fetching user data:", error);
        this.error = "Failed to load user data";
      }
    },
    toggleAccordion(index) {
      this.activeIndex = this.activeIndex === index ? null : index;
    },
    openAddModal() {
      this.isAddingNew = true;
      this.newFaq = {
        question: '',
        answer: ''
      };
    },
    closeAddModal() {
      this.isAddingNew = false;
      this.newFaq = {
        question: '',
        answer: ''
      };
    },
    async handleSaveNew() {
      try {
        const response = await api.post('/api/faq', this.newFaq);
        await this.getFaqs(); 
        this.closeAddModal();
      } catch (error) {
        console.error('Error adding FAQ:', error);
        alert('Gagal menambahkan FAQ');
      }
    },
    async handleEdit(faq) {
      this.editingFaq = { ...faq };
      this.isEditing = true;
    },
    async handleSave() {
      if (!this.editingFaq) return;

      try {
        await api.put(`/api/faq/${this.editingFaq.id}`, this.editingFaq);
        await this.getFaqs(); 
        this.closeEditModal();
      } catch (error) {
        console.error('Error updating FAQ:', error);
        alert('Gagal menyimpan perubahan');
      }
    },
    async handleDelete(id) {
      if (confirm('Apakah Anda yakin ingin menghapus FAQ ini?')) {
        try {
          await api.delete(`/api/faq/${id}`);
          await this.getFaqs(); 
        } catch (error) {
          console.error('Error deleting FAQ:', error);
          alert('Gagal menghapus FAQ');
        }
      }
    },
    closeEditModal() {
      this.isEditing = false;
      this.editingFaq = null;
    }
  }
};
</script>

<style scoped>
.accordion-button {
  cursor: pointer;
}

.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  z-index: 1050;
}
</style>