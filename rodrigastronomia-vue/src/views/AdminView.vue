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
    <form @submit.prevent="crearCurso" class="form-curso">
  <input v-model="nombre" type="text" placeholder="Nombre del curso" required />
  <input v-model="descripcion" type="text" placeholder="Descripción" required />
  <input v-model="precio" type="number" step="0.01" placeholder="Precio" required />
  <input v-model="detalles" type="text" placeholder="Detalles del curso" required />
  <input v-model="imagen" type="text" placeholder="URL de imagen (opcional)" />
  <input v-model="modalidad" type="text" placeholder="Modalidad (Ej: Online, Presencial)" required />
  <input v-model="duracion" type="text" placeholder="Duración (Ej: 2 meses, 12 clases)" required />
  <button type="submit">Crear curso</button>
</form>


    <p v-if="mensaje" class="mensaje">{{ mensaje }}</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import api from '../axios'
import { useRouter } from 'vue-router'

const router = useRouter()
const usuario = JSON.parse(localStorage.getItem('usuario') || 'null')

if (!usuario) {
  localStorage.setItem('ruta_pendiente', router.currentRoute.value.fullPath)
  router.push('/login')
} else if (usuario.rol !== 'admin') {
  router.push('/')
}

const resumen = ref([])

onMounted(async () => {
  try {
    const res = await api.get('/compras/resumen')
    resumen.value = res.data
  } catch (err) {
    console.error('Error al obtener resumen de compras:', err)
  }
})

// Crear curso
const nombre = ref('')
const descripcion = ref('')
const precio = ref('')
const detalles = ref('')
const imagen = ref('')
const modalidad = ref('')
const duracion = ref('')
const mensaje = ref('')

const crearCurso = async () => {
  try {
    const res = await api.post('/cursos', {
      nombre: nombre.value,
      descripcion: descripcion.value,
      precio: precio.value,
      detalles: detalles.value,
      imagen: imagen.value || null,
      modalidad: modalidad.value,
      duracion: duracion.value,
    })

    mensaje.value = 'Curso creado correctamente.'
    nombre.value = descripcion.value = precio.value = detalles.value = imagen.value = modalidad.value = duracion.value = ''
  } catch (err) {
    mensaje.value = 'Error al crear el curso.'
    console.error(err)
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
  box-shadow: 0 0 10px rgba(0,0,0,0.05);
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
</style>
