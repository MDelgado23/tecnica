<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../axios'
import CompraModal from '../components/CompraModal.vue'

const route = useRoute()
const curso = computed(() =>
  store.cursos.find(c => c.id_curso === Number(route.params.id))
)
const mostrarModal = ref(false)

onMounted(async () => {
  const res = await api.get('/cursos')
  curso.value = res.data.find(c => c.id_curso == route.params.id)
})

const abrirModal = () => {
  mostrarModal.value = true
}
</script>

<template>
  <div v-if="curso" class="detalle-container">
    <h1>{{ curso.nombre }}</h1>
    <img :src="curso.imagen" alt="Imagen del curso" />
    <p><strong>Descripción:</strong> {{ curso.descripcion }}</p>
    <p><strong>Precio:</strong> ${{ curso.precio }}</p>
    <p><strong>Modalidad:</strong> Online (a tu ritmo)</p>
    <p><strong>Duración:</strong> 4 semanas</p>

    <button class="btn-comprar" @click="abrirModal">Comprar este curso</button>

    <CompraModal
      v-if="mostrarModal"
      :curso="curso"
      :mostrar="mostrarModal"
      @cerrar="mostrarModal = false"
    />
  </div>
</template>

<style scoped>
.detalle-container {
  max-width: 700px;
  margin: auto;
  padding: 2rem;
  background: white;
  border-radius: 10px;
}
img {
  width: 100%;
  max-height: 300px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 1rem;
}
p {
  margin: 0.5rem 0;
}
.btn-comprar {
  background-color: #42b983;
  color: white;
  border: none;
  padding: 0.6rem 1rem;
  margin-top: 1rem;
  border-radius: 5px;
  cursor: pointer;
}
</style>
