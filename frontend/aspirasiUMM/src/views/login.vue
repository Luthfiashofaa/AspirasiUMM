<template>
  <div class="login">
    <div class="loginBox">
      <img class="user" src="/images/user.png" height="100px" width="100px">
      <h3>Sign in here</h3>
      <form @submit.prevent="handleLogin">
        <div class="inputBox">
          <input 
            id="uname" 
            v-model="formData.nim" 
            type="text" 
            name="nim" 
            placeholder="NIM"
            required
          >
          <input 
            id="pass" 
            v-model="formData.password" 
            type="password" 
            name="password" 
            placeholder="Password"
            required
          >
        </div>
        <div v-if="error" class="error-message" style="color: red; margin-bottom: 10px;">
          {{ error }}
        </div>
        <input type="submit" :value="loading ? 'Loading...' : 'Login'" :disabled="loading">
      </form>

      <a href="#" @click.prevent="forgotPassword">Forget Password<br></a>
      <div class="text-center">
        <p style="color: #C70039;">Sign-Up</p>
      </div>
    </div>
  </div>
</template>


<script>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

// Update axios configuration
axios.defaults.baseURL = 'http://localhost:8000'
axios.defaults.withCredentials = true
axios.defaults.headers.common['Accept'] = 'application/json'
axios.defaults.headers.common['Content-Type'] = 'application/json'

export default {
  name: 'LoginView',
  setup() {
    const router = useRouter()
    const loading = ref(false)
    const error = ref('')
    axios.defaults.withCredentials = true;
    const formData = ref({
      nim: '',
      password: ''
    })

    const handleLogin = async () => {
  try {
    loading.value = true
    error.value = ''
    
    await axios.get('/sanctum/csrf-cookie')
    
    const response = await axios.post('/api/login', {
      nim: formData.value.nim,
      password: formData.value.password
    })
    
    const userData = response.data.user
    localStorage.setItem('user', JSON.stringify(userData)) 
    localStorage.setItem('token', response.data.token)     
    
    axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`
    
    router.push('/')  // Arahkan ke halaman utama setelah login
  } catch (err) {
    if (err.response?.status === 500) {
      error.value = 'A server error occurred. Please try again later.'
    } else {
      error.value = err.response?.data?.message || 'Login failed. Please try again.'
    }
  } finally {
    loading.value = false
  }
}


    const forgotPassword = () => {
      router.push('/forgot-password')
    }

    const logout = async () => {
      try {
        await axios.post('/api/logout')
        localStorage.removeItem('user')
        localStorage.removeItem('token')
        delete axios.defaults.headers.common['Authorization']
        router.push('/login')
      } catch (err) {
        console.error('Logout error:', err)
      }
    }

    return {
      formData,
      loading,
      error,
      handleLogin,
      forgotPassword,
      logout
    }
  }
}
</script>

<style scoped>
/* Styles remain the same */
</style>