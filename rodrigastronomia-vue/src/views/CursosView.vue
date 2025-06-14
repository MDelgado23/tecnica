<template>
  <div class="container">
    <h1>Cursos Gastronómicos</h1>
    <div class="cursos">
      <CursoCard v-for="curso in cursos" :key="curso.id_curso" :curso="curso" @comprar="abrirModal" />
    </div>
    <!-- Paginación -->
    <div class="paginacion-wrapper" v-if="totalPages > 1">
      <div class="paginacion">
        <button :disabled="currentPage === 1" @click="cambiarPagina(currentPage - 1)">Anterior</button>
        <button v-for="page in totalPages" :key="page" :class="{ activo: currentPage === page }"
          @click="cambiarPagina(page)">
          {{ page }}
        </button>
        <button :disabled="currentPage === totalPages" @click="cambiarPagina(currentPage + 1)">Siguiente</button>
      </div>
      <!-- Selector de cantidad por pagina -->
      <div class="limite-selector">
        <label for="limite">Mostrar</label>
        <select id="limite" v-model="limit">
          <option :value="3">3</option>
          <option :value="6">6</option>
          <option :value="9">9</option>
          <option :value="12">12</option>
        </select>
        <span>por página</span>
      </div>
    </div>
    <CompraModal v-if="mostrarModal" :curso="cursoSeleccionado" :mostrar="mostrarModal"
      @cerrar="mostrarModal = false" />
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useUsuarioStore } from '../stores/usuario'
import api from '../axios'
import CursoCard from '../components/CursoCard.vue'
import CompraModal from '../components/CompraModal.vue'

const store = useUsuarioStore()
// Manejo de estados de cursos y paginacion
const cursos = ref([])
const currentPage = ref(1)
const totalPages = ref(1)
const limit = ref(6)
// Modal de compra
const mostrarModal = ref(false)
const cursoSeleccionado = ref({})

// Traigo todos los cursos con datos para la paginacion tambien
const fetchCursos = async () => {
  try {
    const res = await api.get(`/cursos?page=${currentPage.value}&limit=${limit.value}`)
    cursos.value = res.data.cursos
    totalPages.value = res.data.totalPaginas
  } catch (error) {
    console.error('Error al cargar cursos:', error)
  }
}

const abrirModal = (curso) => {
  cursoSeleccionado.value = curso
  mostrarModal.value = true
}

const cambiarPagina = (pagina) => {
  if (pagina >= 1 && pagina <= totalPages.value) {
    currentPage.value = pagina
  }
}

onMounted(fetchCursos)

watch([currentPage, limit], fetchCursos)
</script>

<style scoped>
.container {
  padding: 2rem;
  max-width: 1200px;
  margin: auto;
  color: #333;
  background-color: #fff;
  transition: background 0.3s, color 0.3s;
}

body.dark-mode .container {
  background-color: #121212;
  color: #eee;
}

h1 {
  text-align: center;
  margin-bottom: 1.5rem;
}

h1.dark-mode {
  color: white;
}

.cursos {
  display: flex;
  flex-wrap: wrap;
  gap: 1.5rem;
  justify-content: center;
}

.paginacion-wrapper {
  margin-top: 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  gap: 1rem;
}

.paginacion {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

.paginacion button {
  padding: 0.4rem 0.8rem;
  border: none;
  background-color: #42b983;
  border-radius: 5px;
  cursor: pointer;
  font-weight: 500;
  color: white;
  transition: background-color 0.2s;
}

body.dark-mode .paginacion button {
  background-color: #2e7d32;
}

body.dark-mode .paginacion button:hover {
  background-color: #1b5e20;
}

.paginacion button.activo {
  background-color: #4268b9;
}

.paginacion button:disabled {
  background-color: #ccc;
  color: #555;
  cursor: default;
}

body.dark-mode .paginacion button:disabled {
  background-color: #444;
  color: #999;
}

body.dark-mode .paginacion button.activo {
  background-color: #4268b9;
  color: white;
}

.limite-selector {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.95rem;
}

.limite-selector select {
  padding: 0.3rem 0.5rem;
  border-radius: 5px;
  border: 1px solid #ccc;
}

body.dark-mode .limite-selector select {
  background-color: #2a2a2a;
  color: #eee;
  border: 1px solid #555;
}
</style>
