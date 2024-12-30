<script>
export default {
  data() {
    return {
      isLoggedIn: false,
      role: null,
      username: null,
      name: null,
      isDropdownOpen: false,
    };
  },
  computed: {
    isLoginPage() {
      return this.$route.name === 'login';
    },
  },
  watch: {
    '$route': {
      handler() {
        this.checkLoginStatus();
      },
      immediate: true
    }
  },
  methods: {
    async checkLoginStatus() {
      const token = localStorage.getItem('token');
      if (token) {
        this.isLoggedIn = true;
        try {
          const response = await fetch('http://127.0.0.1:8000/api/user', {
            method: 'GET',
            headers: {
              'Authorization': `Bearer ${token}`,
            },
          });

          if (response.ok) {
            const userData = await response.json();
            this.role = userData.role;
            this.username = userData.username;
            this.name = userData.name;
            localStorage.setItem('role', this.role);
            return true;
          } else {
            throw new Error('Failed to fetch user data');
          }
        } catch (error) {
          console.error(error);
          this.logout();
          return false;
        }
      } else {
        this.isLoggedIn = false;
        this.role = null;
        this.username = null;
        this.name = null;
        return false;
      }
    },
    toggleDropdown(event) {
      event.stopPropagation();
      this.isDropdownOpen = !this.isDropdownOpen;
    },
    closeDropdown() {
      this.isDropdownOpen = false;
    },
    goToLogin() {
      this.$router.push({ name: 'login' });
    },
    confirmLogout() {
      if (confirm('Are you sure you want to logout?')) {
        this.logout();
      }
    },
    logout() {
      localStorage.removeItem('token');
      localStorage.removeItem('role');
      this.isLoggedIn = false;
      this.role = null;
      this.username = null;
      this.name = null;
      this.isDropdownOpen = false;
      this.$router.push({ name: 'home' });
    },
    scrollToAbout(e) {
      e.preventDefault();
      const element = document.getElementById('about');
      element.scrollIntoView({ behavior: 'smooth' });
    },
    scrollToService(e) {
      e.preventDefault();
      const element = document.getElementById('service');
      element.scrollIntoView({ behavior: 'smooth' });
    },
    scrollToContact(e) {
      e.preventDefault();
      const element = document.getElementById('contact');
      element.scrollIntoView({ behavior: 'smooth' });
    },
  },
  mounted() {
    this.checkLoginStatus();
    document.addEventListener('click', (e) => {
      if (!e.target.closest('.dropdown-container') && this.isDropdownOpen) {
        this.closeDropdown();
      }
    });
  },
};
</script>

<template>
  <div class="hero_area" v-if="!isLoginPage">
    <!-- header section starts -->
    <header class="header_section">
      <div class="header_top">
        <div class="container-fluid">
          <div class="contact_nav">
            <a href="">
              <i class="fa fa-phone" aria-hidden="true"></i>
              <span> Call : 0341-712899 </span>
            </a>
            <a href="">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span> Email : aspirasikita.umm@webmail.umm.ac.id </span>
            </a>
          </div>
        </div>
      </div>
      <div class="header_bottom">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container">
            <img style="width: 100pt;" src="/images/logo.png" alt="" />

            <button
              class="navbar-toggler"
              type="button"
              data-toggle="collapse"
              data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span class=""> </span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <router-link :to="{ name: 'home' }" class="nav-link" active-class="nav-item active">Home</router-link>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#about" @click="scrollToAbout">About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#service" @click="scrollToService">Service</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#contact" @click="scrollToContact">Contact Us</a>
                </li>
                <!-- Menambahkan menu untuk role admin atau mahasiswa -->
                <li v-if="isLoggedIn && role === 'admin'" class="nav-item">
                  <router-link :to="{ name: 'admin-dashboard' }" class="nav-link">Admin Dashboard</router-link>
                </li>
                <li v-if="isLoggedIn && role === 'mahasiswa'" class="nav-item">
                  <router-link :to="{ name: 'my-complaint' }" class="nav-link">My Complaint</router-link>
                </li>
                <!-- Tombol login/logout -->
                <li class="nav-item dropdown-container" v-if="isLoggedIn">
                  <button 
                    @click="toggleDropdown" 
                    class="nav-link user-button"
                  >
                    <span class="user-name">{{ name }}</span>
                    <i 
                      class="fa fa-chevron-down dropdown-icon"
                      :class="{ 'rotated': isDropdownOpen }"
                    ></i>
                  </button>
                  
                  <!-- Dropdown Menu -->
                  <div 
                    v-if="isDropdownOpen" 
                    class="dropdown-menu"
                  >
                    <button 
                      @click="confirmLogout"
                      class="dropdown-item"
                    >
                      <i class="fa fa-sign-out"></i>
                      Logout
                    </button>
                  </div>
                </li>
                <li class="nav-item" v-else>
                  <button @click="goToLogin" class="nav-link user-button">
                    <i class="fa fa-sign-in"></i>
                    Login
                  </button>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>
    <!-- end header section -->

    <!-- Konten utama halaman bisa diletakkan di sini -->
    <div class="main-content">
      <!-- Konten lainnya -->
    </div>
  </div>

  <router-view></router-view>

  <!-- Footer Section (Get In Touch) -->
  <footer class="footer_section" id="contact" v-if="!isLoginPage">
    <section class="info_section">
      <div class="container">
        <h4>Get In Touch</h4>
        <div class="row">
          <div class="col-lg-10 mx-auto">
            <div class="info_items">
              <div class="row">
                <div class="col-md-4">
                  <a href="">
                    <div class="item">
                      <div class="img-box">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                      </div>
                      <p>
                        Jl. Raya Tlogomas No.246, Babatan, Tegalgondo, Kec.
                        Lowokwaru, Kota Malang, Jawa Timur 65144
                      </p>
                    </div>
                  </a>
                </div>
                <div class="col-md-4">
                  <a href="">
                    <div class="item">
                      <div class="img-box">
                        <i class="fa fa-phone" aria-hidden="true"></i>
                      </div>
                      <p>0341-712899</p>
                    </div>
                  </a>
                </div>
                <div class="col-md-4">
                  <a href="">
                    <div class="item">
                      <div class="img-box">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                      </div>
                      <p>aspirasikita.umm@webmail.umm.ac.id</p>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </footer>
</template>

<style scoped>
.dropdown-container {
  position: relative;
  display: inline-block;
}
.user-button {
  display: flex;
  align-items: center;
  gap: 8px;
  background-color: #0355cc;
  color: white !important;
  padding: 8px 16px !important;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
}

.user-button:hover {
  background-color: #45a049;
}

.user-name {
  font-weight: 500;
  margin-right: 4px;
}

.dropdown-icon {
  font-size: 12px;
  transition: transform 0.3s ease;
}

.dropdown-icon.rotated {
  transform: rotate(180deg);
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  right: 0;
  background-color: white;
  border: 1px solid #ddd;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  min-width: 160px;
  z-index: 9999;
  margin-top: 5px;
  display: block;
}

.dropdown-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 10px 15px;
  width: 100%;
  border: none;
  background: none;
  text-align: left;
  cursor: pointer;
  color: #333;
  transition: background-color 0.3s;
}

.dropdown-item:hover {
  background-color: #f5f5f5;
  color: #4CAF50;
}

.dropdown-item i {
  font-size: 16px;
  width: 20px;
}

@media (max-width: 768px) {
  .dropdown-menu {
    position: static;
    box-shadow: none;
    border: none;
    background-color: #f9f9f9;
    margin-top: 0;
  }
  
  .user-button {
    width: 100%;
    justify-content: space-between;
  }
}
</style>