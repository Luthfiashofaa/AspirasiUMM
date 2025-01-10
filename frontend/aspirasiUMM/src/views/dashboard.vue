<template>
  <main class="main users chart-page" id="skip-target">
    <div class="container">
      <h2 class="main-title">Dashboard</h2>
      <div class="row stat-cards">
        <div v-for="(stat, index) in stats" :key="index" class="col-md-6 col-xl-3">
          <article class="stat-cards-item">
            <div :class="['stat-cards-icon', stat.iconClass]">
              <i :data-feather="stat.icon" aria-hidden="true"></i>
            </div>
            <div class="stat-cards-info">
              <p class="stat-cards-info__num">{{ stat.totalVisits }}</p>
              <p class="stat-cards-info__title">{{ stat.title }}</p>
              <p class="stat-cards-info__progress">
                <span :class="['stat-cards-info__profit', stat.progressClass]">
                  <i data-feather="trending-up" aria-hidden="true"></i>{{ stat.progress }}%
                </span>
                Last month
              </p>
            </div>
          </article>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="users-table table-wrapper">
            <table class="posts-table">
              <thead>
                <tr class="users-table-info">
                  <th>Pengaduan</th>
                  <th>Mahasiswa</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(post, index) in posts" :key="index">
                  <td>{{ post.title }}</td>
                  <td>{{ post.author.name }}</td>
                  <td><span :class="['badge', post.statusClass]">{{ post.status }}</span></td>
                  <td>{{ post.date }}</td>
                  <td>
                    <span class="p-relative">
                      <button class="dropdown-btn transparent-btn" type="button" title="More info">
                        <div class="sr-only">More info</div>
                        <i data-feather="more-horizontal" aria-hidden="true"></i>
                      </button>
                      <ul class="users-item-dropdown dropdown">
                        <li><a href="##">Edit</a></li>
                        <li><a href="##">Quick edit</a></li>
                        <li><a href="##">Trash</a></li>
                      </ul>
                      <button class="btn btn-empty"></button> <!-- Tombol kosong -->
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
export default {
  data() {
    return {
      stats: [
        { icon: 'file', iconClass: 'primary', totalVisits: '95', title: 'Akademik', progress: '10', progressClass: 'success' },
        { icon: 'file', iconClass: 'warning', totalVisits: '15', title: 'Fasilitas', progress: '20', progressClass: 'success' },
        { icon: 'file', iconClass: 'purple', totalVisits: '5', title: 'Kebersihan', progress: '-5', progressClass: 'danger' },
        { icon: 'file', iconClass: 'success', totalVisits: '100', title: 'Layanan', progress: '5', progressClass: 'warning' }
      ],
      posts: [
        {
          title: 'Lampu jalan yang berada di depan Gedung A sudah tidak menyala selama 3 hari.',
          author: { name: 'Krishnaliza Zulfasha' },
          status: 'Pending',
          statusClass: 'badge-pending',
          date: '17.04.2024'
        },
        {
          title: 'Toilet umum di Gedung B sangat kotor dan tidak ada sabun cuci tangan.',
          author: { name: 'Nadhira' },
          status: 'Success',
          statusClass: 'badge-success',
          date: '18.04.2024'
        },
        {
          title: 'AC di ruang rapat tidak berfungsi sehingga ruangan terasa sangat panas.',
          author: { name: 'Luthfia Shofa Dewi' },
          status: 'Active',
          statusClass: 'badge-active',
          date: '19.04.2025'
        },
        {
          title: 'Pengurusan KRS mengalami kendala saat proses login.',
          author: { name: 'Lika Anjelina' },
          status: 'Active',
          statusClass: 'badge-active',
          date: '20.04.2025'
        }
      ]
    };
  }
};
</script>

<style scoped>
/* Tambahkan gaya khusus untuk tombol kosong */
.btn-empty {
  background-color: green;
  border: none;
  width: 40px;
  height: 20px;
  display: inline-block;
  cursor: pointer;
}
</style>
