<template>
  <div>
    <header class="navbar">
      <RouterLink to="/" class="logo">Rodri Gastronomía</RouterLink>

      <nav :class="['nav-links', { 'center-only': !usuario }]">
        <RouterLink to="/" class="nav-link">Cursos</RouterLink>
        <RouterLink v-if="usuario" to="/mis-cursos" class="nav-link">Mis Cursos</RouterLink>
        <RouterLink v-if="usuario?.rol === 'admin'" to="/admin" class="nav-link">Admin</RouterLink>
      </nav>

      <div class="auth-section">
        <span v-if="usuario">👤 {{ usuario.nombre }}</span>
        <button v-if="usuario" @click="logout" class="logout-button">Cerrar sesión</button>
        <RouterLink v-else to="/login" class="login-button">Login</RouterLink>
      </div>

      <button @click="toggleDarkMode" class="darkmode-button">🌓</button>
    </header>

    <main class="contenido">
      <RouterView />
    </main>
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import { toggleDarkMode, applyInitialTheme } from './utils/theme'
import { useUsuarioStore } from './stores/usuario'
import { storeToRefs } from 'pinia'
import { useRouter } from 'vue-router'

const router = useRouter()
const store = useUsuarioStore()
const { usuario } = storeToRefs(store)

const logout = () => {
  store.logout()
  router.push('/')
}

onMounted(() => {
  applyInitialTheme()
})
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #42b983;
  padding: 0 2rem;
  height: 60px;
  color: white;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  flex-wrap: wrap;
}

body.dark-mode .navbar {
  background-color: #1e1e1e;
}

.logo {
  font-size: 1.5rem;
  font-weight: bold;
  color: white;
  text-decoration: none;
}

.nav-links {
  display: flex;
  align-items: stretch;
  height: 100%;
}

.nav-links.center-only {
  margin: 0 auto;
}

.nav-link {
  display: flex;
  align-items: center;
  padding: 0 1rem;
  color: white;
  text-decoration: none;
  border-left: 1px solid rgba(255, 255, 255, 0.3);
  transition: background-color 0.2s;
}

.nav-link:first-child {
  border-left: none;
}

.nav-link:hover {
  background-color: rgba(255, 255, 255, 0.1);
}

.nav-link.router-link-active {
  font-weight: bold;
  background-color: rgba(255, 255, 255, 0.15);
}

.auth-section {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.logout-button {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 0.4rem 0.8rem;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 600;
}

body.dark-mode .logout-button {
  background-color: #e53935;
}

.logout-button:hover {
  background-color: #d32f2f;
}

.login-button {
  background-color: white;
  color: #42b983;
  padding: 0.4rem 0.8rem;
  border-radius: 4px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.2s;
}


.login-button:hover {
  background-color: #f0f0f0;
  color: #2e8b6e;
}

.contenido {
  padding: 2rem;
}

.darkmode-button {
  background: transparent;
  border: none;
  font-size: 1.2rem;
  cursor: pointer;
  color: white;
}

</style>
