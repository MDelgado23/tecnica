<template>
  <div class="mis-cursos-container">
    <h2>Mis cursos comprados</h2>

    <div v-if="cargando" class="loading">Cargando cursos...</div>

    <div v-else-if="cursos.length" class="mis-cursos-grid">
      <div v-for="curso in cursos" :key="curso.id_compra" class="curso-card animate-fade">
        <img :src="curso.imagen || defaultImagen" alt="Imagen del curso" />
        <div class="curso-info">
          <h3>{{ curso.nombre }}</h3>
          <p> {{ formatearFecha(curso.fecha_compra) }}</p>
        </div>
      </div>
    </div>

    <p v-else class="no-resultado">No se encontraron cursos comprados.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useUsuarioStore } from '../stores/usuario'
import { useRouter } from 'vue-router'
import api from '../axios'

const router = useRouter()
const store = useUsuarioStore()

const cursos = ref([])
const cargando = ref(true)
const defaultImagen = '/default-curso.jpg'

onMounted(async () => {
  if (!store.usuario) {
    localStorage.setItem('ruta_pendiente', router.currentRoute.value.fullPath)
    router.push('/login')
    return
  }

  try {
    if (Array.isArray(store.cursosComprados) && store.cursosComprados.length > 0) {
      cursos.value = store.cursosComprados
    } else {
      const res = await api.get(`/compras/cliente?email=${store.usuario.email}`)
      cursos.value = res.data
      store.setCursosComprados(res.data)
    }
  } catch (err) {
    console.error('Error al cargar cursos:', err)
  } finally {
    cargando.value = false
  }
})

const formatearFecha = (fechaISO) => {
  const fecha = new Date(fechaISO)
  return fecha.toLocaleString('es-AR', {
    day: '2-digit',
    month: 'long',
    year: 'numeric',
    hour: '2-digit',
    minute: '2-digit',
  })
}
</script>

<style scoped>
.mis-cursos-container {
  max-width: 1200px;
  margin: auto;
  padding: 2rem;
}

h2 {
  text-align: center;
  margin-bottom: 2rem;
}

.mis-cursos-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  justify-content: center;
}

.curso-card {
  width: 300px;
  background-color: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  opacity: 0;
  transform: translateY(20px);
  animation: fadeUp 0.5s ease forwards;
}

.curso-card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
}

@keyframes fadeUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.curso-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.curso-card:hover img {
  transform: scale(1.05);
}

.curso-info {
  padding: 1rem;
  text-align: center;
}

.curso-info h3 {
  margin: 0 0 0.5rem 0;
  font-size: 1.2rem;
  color: #333;
}

.curso-info p {
  margin: 0;
  color: #555;
  font-size: 0.95rem;
}

.loading {
  text-align: center;
  color: #42b983;
  font-weight: bold;
  margin-top: 2rem;
}

.no-resultado {
  text-align: center;
  color: #999;
  margin-top: 2rem;
}
</style>
