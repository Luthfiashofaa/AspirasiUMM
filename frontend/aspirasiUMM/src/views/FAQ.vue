<template>
  <section class="bsb-faq-2 bg-light py-3 py-md-5 py-xl-8">
    <div class="container">
      <div class="row gy-5 gy-lg-0">
        <div class="col-12 col-lg-6">
          <h2 class="h1 mb-3">Punya pertanyaan? Kami punya jawabannya! hubungi tim dukungan kami untuk bantuan yang lebih spesifik</h2>
          <p class="lead fs-4 text-secondary mb-4">
            Kami di sini untuk mempermudah pengalaman Anda. Temukan solusi dari pertanyaan Anda disini
          </p>
          <a href="#!" class="btn btn-lg bsb-btn-2xl btn-primary">All FAQ</a>
        </div>
        <div class="col-12 col-lg-6">
          <div class="row justify-content-xl-end">
            <div class="col-12 col-xl-11">
              <div class="accordion" id="faqAccordion">
                <div
                  v-for="(faq, index) in faqs"
                  :key="index"
                  class="accordion-item mb-4 shadow-sm"
                >
                  <h2 class="accordion-header" :id="'heading' + index">
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
                  </h2>
                  <div
                    :id="'collapse' + index"
                    class="accordion-collapse collapse"
                    :class="{ show: activeIndex === index }"
                    :aria-labelledby="'heading' + index"
                    data-bs-parent="#faqAccordion"
                  >
                    <div class="accordion-body">
                      <p v-if="typeof faq.answer === 'string'">{{ faq.answer }}</p>
                      <ul v-else>
                        <li v-for="(step, i) in faq.answer" :key="i">{{ step }}</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
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
      activeIndex: null,
      faqs: [
        {
          question: "Apa itu platform Aspirasi Kita?",
          answer: [
            "Platform Aspirasi Kita adalah wadah bagi mahasiswa untuk menyampaikan keluhan dan aspirasi mereka kepada administrasi universitas.",
          ],
        },
        {
          question: "Bagaimana cara menyampaikan keluhan/Pengaduan?",
          answer:
            "Untuk menyampaikan keluhan, Anda perlu login ke akun Anda dan navigasi ke bagian 'My Complaint'. Di sana, Anda akan menemukan formulir untuk menyampaikan keluhan Anda",
        },
        {
          question: "Berapa lama waktu yang dibutuhkan untuk mendapatkan respon?",
          answer:
            "Kami berusaha untuk merespon semua keluhan dalam waktu 5 hari kerja. Namun, masalah yang lebih kompleks mungkin membutuhkan waktu lebih lama untuk diselesaikan.",
        },
        {
          question: "Apakah saya dapat mengedit pengaduan yang sudah diajukan?",
          answer:
            "Anda dapat mengedit pengaduan selama statusnya masih 'Belum Diproses'. Setelah diproses, pengaduan tidak dapat diubah.",
        },
        {
          question: "Apakah saya dapat melacak status pengaduan saya?",
          answer: [
            "Ya, Anda dapat melacak status pengaduan Anda dengan login ke akun Anda dan melihat bagian 'Status Pengaduan.",
          ],
        },
      ],
    };
  },
  methods: {
    toggleAccordion(index) {
      this.activeIndex = this.activeIndex === index ? null : index;
    },
  },
};
</script>

<style scoped>
.accordion-button {
  cursor: pointer;
}
</style>
