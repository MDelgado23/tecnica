<template>
  <div class="container">
    <h2>Iniciar sesión</h2>
    <!-- Form / input del login -->
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Tu email" required />
      <button type="submit">Ingresar</button>
    </form>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useUsuarioStore } from '../stores/usuario'
import api from '../axios'

const email = ref('')
const error = ref('')

const router = useRouter()
const store = useUsuarioStore()

// Metodo del login
const login = async () => {
  try {
    const res = await api.get(`/usuarios/email?email=${email.value}`)

    store.setUsuario(res.data)

    router.push('/')
  } catch (err) {
    console.error(err)
    error.value = 'Usuario no encontrado'
  }
}
</script>

<style scoped>
.container {
  max-width: 400px;
  margin: auto;
  padding: 2rem;
}
input {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 1rem;
}
button {
  padding: 0.5rem 1rem;
}
.error {
  color: red;
  margin-top: 1rem;
}
</style>
