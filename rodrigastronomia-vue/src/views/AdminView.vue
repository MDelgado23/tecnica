<template>
  <div class="admin-container">
    <h2>Resumen de Compras</h2>

    <div v-if="resumen.length">
      <table class="resumen-table">
        <thead>
          <tr>
            <th>Curso</th>
            <th>Total de Compras</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="item in resumen" :key="item.nombre">
            <td>{{ item.nombre }}</td>
            <td>{{ item.total_compras }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <p v-else class="loading">Cargando resumen...</p>

    <hr class="divider" />

    <h2>Agregar Nuevo Curso</h2>

    <div v-if="cursoCreado">
      <p class="mensaje">Curso creado correctamente.</p>
      <button @click="reiniciarFormulario" class="boton-nuevo-curso">Agregar otro curso</button>
    </div>

    <form v-else @submit.prevent="crearCurso" class="form-curso">
      <input v-model="nombre" type="text" placeholder="Nombre del curso" required />
      <input v-model="descripcion" type="text" placeholder="Descripción" required />
      <input v-model="precio" type="number" step="0.01" placeholder="Precio" required />
      <input v-model="detalles" type="text" placeholder="Detalles del curso" required />
      <input v-model="imagen" type="text" placeholder="URL de imagen (opcional)" />
      <input v-model="modalidad" type="text" placeholder="Modalidad (Ej: Online, Presencial)" required />
      <input v-model="duracion" type="text" placeholder="Duración (Ej: 2 meses, 12 clases)" required />
      <button type="submit">Crear curso</button>
    </form>

    <hr class="divider" />
    <h2>Gestión de Cursos</h2>

    <table class="tabla-cursos">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Descripción</th>
          <th>Precio</th>
          <th>Detalles</th>
          <th>Imagen</th>
          <th>Modalidad</th>
          <th>Duración</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="curso in cursos" :key="curso.id_curso">
          <template v-if="editandoId === curso.id_curso">
            <td>{{ curso.id_curso }}</td>
            <td><input v-model="cursoEditado.nombre" /></td>
            <td><input v-model="cursoEditado.descripcion" /></td>
            <td><input v-model="cursoEditado.precio" type="number" /></td>
            <td><input v-model="cursoEditado.detalles" /></td>
            <td><input v-model="cursoEditado.imagen" /></td>
            <td><input v-model="cursoEditado.modalidad" /></td>
            <td><input v-model="cursoEditado.duracion" /></td>
            <td>
              <button @click="guardarEdicion">💾</button>
              <button @click="editandoId = null">❌</button>
            </td>
          </template>
          <template v-else>
            <td>{{ curso.id_curso }}</td>
            <td>{{ curso.nombre }}</td>
            <td>{{ curso.descripcion }}</td>
            <td>${{ curso.precio }}</td>
            <td>{{ curso.detalles }}</td>
            <td>{{ curso.imagen }}</td>
            <td>{{ curso.modalidad }}</td>
            <td>{{ curso.duracion }}</td>
            <td>
              <button @click="comenzarEdicion(curso)">✏️</button>
              <button @click="eliminarCurso(curso.id_curso)">🗑</button>
            </td>
          </template>
        </tr>
      </tbody>
    </table>

    <div class="paginacion" v-if="totalPaginas > 1">
      <button :disabled="paginaActual === 1" @click="paginaActual--">Anterior</button>
      <button
        v-for="n in totalPaginas"
        :key="n"
        :class="{ activo: paginaActual === n }"
        @click="paginaActual = n"
      >
        {{ n }}
      </button>
      <button :disabled="paginaActual === totalPaginas" @click="paginaActual++">Siguiente</button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'
import { useRouter } from 'vue-router'
import api from '../axios'

const router = useRouter()
const usuario = JSON.parse(localStorage.getItem('usuario') || 'null')

if (!usuario) {
  localStorage.setItem('ruta_pendiente', router.currentRoute.value.fullPath)
  router.push('/login')
} else if (usuario.rol !== 'admin') {
  router.push('/')
}

// --- CURSOS Y RESUMEN
const resumen = ref([])
const cursos = ref([])
const editandoId = ref(null)
const cursoEditado = ref({})
const cursoCreado = ref(false)

// --- NUEVO CURSO
const nombre = ref('')
const descripcion = ref('')
const precio = ref('')
const detalles = ref('')
const imagen = ref('')
const modalidad = ref('')
const duracion = ref('')

// --- PAGINACIÓN
const paginaActual = ref(1)
const totalPaginas = ref(1)
const porPagina = ref(3)

const fetchResumen = async () => {
  try {
    const res = await api.get('/compras/resumen')
    resumen.value = res.data
  } catch (err) {
    console.error('Error al obtener resumen de compras:', err)
  }
}

const fetchCursos = async () => {
  try {
    const res = await api.get(`/cursos?page=${paginaActual.value}&limit=${porPagina.value}`)
    cursos.value = res.data.cursos
    totalPaginas.value = res.data.totalPaginas
  } catch (err) {
    console.error('Error al obtener cursos:', err)
  }
}

onMounted(() => {
  fetchResumen()
  fetchCursos()
})

watch(paginaActual, fetchCursos)

// --- CREAR
const crearCurso = async () => {
  try {
    await api.post('/cursos', {
      nombre: nombre.value,
      descripcion: descripcion.value,
      precio: precio.value,
      detalles: detalles.value,
      imagen: imagen.value || null,
      modalidad: modalidad.value,
      duracion: duracion.value,
    })
    cursoCreado.value = true
    limpiarCampos()
    fetchCursos()
  } catch (err) {
    console.error('Error al crear el curso', err)
  }
}

const limpiarCampos = () => {
  nombre.value = ''
  descripcion.value = ''
  precio.value = ''
  detalles.value = ''
  imagen.value = ''
  modalidad.value = ''
  duracion.value = ''
}

const reiniciarFormulario = () => {
  cursoCreado.value = false
}

// --- EDITAR
const comenzarEdicion = (curso) => {
  editandoId.value = curso.id_curso
  cursoEditado.value = { ...curso }
}

const guardarEdicion = async () => {
  try {
    await api.put(`/cursos/${editandoId.value}`, cursoEditado.value)
    editandoId.value = null
    fetchCursos()
  } catch (err) {
    console.error('Error al editar curso:', err)
  }
}

// --- ELIMINAR
const eliminarCurso = async (id) => {
  if (confirm('¿Estás seguro de eliminar este curso?')) {
    try {
      await api.delete(`/cursos/${id}`)
      fetchCursos()
    } catch (err) {
      console.error('Error al eliminar curso:', err)
    }
  }
}
</script>

<style scoped>
.admin-container {
  max-width: 800px;
  margin: auto;
  padding: 2rem;
}

h2 {
  text-align: center;
  margin-bottom: 1.5rem;
}

.resumen-table {
  width: 100%;
  border-collapse: collapse;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
  background: white;
  margin-bottom: 2rem;
}

.resumen-table th {
  background-color: #f4f4f4;
  padding: 0.75rem;
  text-align: left;
  font-weight: bold;
  color: #555;
  border-bottom: 2px solid #ddd;
}

.resumen-table td {
  padding: 0.75rem;
  border-bottom: 1px solid #eee;
  color: #444;
}

.loading {
  text-align: center;
  color: #42b983;
  font-weight: bold;
  margin-top: 2rem;
}

.divider {
  margin: 3rem 0 2rem;
  border: none;
  border-top: 2px solid #ccc;
}

.form-curso {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 1rem;
}

.form-curso input {
  padding: 0.6rem;
  border: 1px solid #ccc;
  border-radius: 5px;
}

.form-curso button {
  background-color: #42b983;
  color: white;
  border: none;
  padding: 0.6rem;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}

.form-curso button:hover {
  background-color: #369f6a;
}

.mensaje {
  margin-top: 1rem;
  font-weight: bold;
  color: #2d6a4f;
}

.boton-nuevo-curso {
  margin-top: 1rem;
  padding: 0.6rem 1rem;
  background-color: #42b983;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-weight: bold;
}

.boton-nuevo-curso:hover {
  background-color: #369f6a;
}

.tabla-cursos {
  width: 100%;
  max-width: 1000px;
  margin: 2rem auto;
  border-collapse: collapse;
  background: white;
  box-shadow: 0 0 8px rgba(0, 0, 0, 0.05);
  table-layout: fixed;
  color: #555;
}

.tabla-cursos td:last-child {
  display: flex;
  gap: 0.4rem;
  justify-content: center;
  align-items: center;
  padding: 0.5rem;
  width: 90px;
  box-sizing: border-box;
}
.tabla-cursos th,
.tabla-cursos td {
  padding: 0.6rem;
  border: 1px solid #ddd;
  text-align: left;
  vertical-align: top;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  
}

.tabla-cursos th {
  background-color: #f9f9f9;
  font-weight: bold;
  color: #333;
}
.tabla-cursos td:nth-child(2),
.tabla-cursos td:nth-child(3),
.tabla-cursos td:nth-child(5),
.tabla-cursos td:nth-child(7)
 {
  max-width: 200px;
}

.tabla-cursos input {
  width: 100%;
  padding: 0.3rem;
  border: 1px solid #ccc;
  border-radius: 4px;
}
.tabla-cursos button {
  width: 30px;
  height: 30px;
  border: none;
  border-radius: 4px;
  background-color: #42b983;
  color: white;
  font-size: 1rem;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}
.tabla-cursos button:hover {
  background-color: #36976e;
}
.paginacion {
  margin-top: 1rem;
  display: flex;
  gap: 0.5rem;
  justify-content: center;
}
.paginacion button {
  padding: 0.4rem 0.8rem;
  border: none;
  background-color: #42b983;
  color: white;
  border-radius: 5px;
  cursor: pointer;
}
.paginacion button.activo {
  background-color: #2f855a;
}
.paginacion button:disabled {
  background-color: #ccc;
  cursor: default;
}
</style>
