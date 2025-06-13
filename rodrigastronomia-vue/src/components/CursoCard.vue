<template>
  <div class="card">
    <img :src="curso.imagen" alt="Imagen del curso" class="card-img" />
    <div class="card-content">
      <h2>{{ curso.nombre }}</h2>
      <p>{{ curso.descripcion }}</p>
      <p class="precio"><strong>${{ curso.precio }}</strong></p>
      <div class="card-actions">
        <RouterLink :to="`/curso/${curso.id_curso}`" class="btn btn-detalle">Ver Detalle</RouterLink>
        <button class="btn btn-comprar" @click="$emit('comprar', curso)">Comprar</button>
      </div>
    </div>
  </div>
</template>

<script setup>
defineProps({
  curso: Object
})
</script>

<style scoped>
.card {
  width: 300px;
  background-color: #fff;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
  animation: fadeUp 0.5s ease forwards;
  opacity: 0;
  transform: translateY(20px);
}

.card:hover {
  transform: translateY(-6px);
  box-shadow: 0 10px 24px rgba(0, 0, 0, 0.15);
}

@keyframes fadeUp {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.card-img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.card:hover .card-img {
  transform: scale(1.05);
}

.card-content {
  padding: 1rem;
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

h2 {
  font-size: 1.25rem;
  margin-bottom: 0.4rem;
  color: #333;
}

p {
  font-size: 0.95rem;
  color: #555;
  margin-bottom: 0.4rem;
}

.precio {
  font-size: 1.1rem;
  color: #2c3e50;
  font-weight: bold;
}

.card-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 1rem;
  gap: 0.5rem;
}

.btn {
  flex: 1;
  padding: 0.45rem 0.6rem;
  border: none;
  border-radius: 6px;
  font-weight: 600;
  cursor: pointer;
  text-align: center;
  text-decoration: none;
  transition: transform 0.2s ease, background-color 0.2s ease;
}

.btn:hover {
  transform: scale(1.05);
}

.btn:active {
  transform: scale(0.95);
}

.btn-detalle {
  background-color: #eee;
  color: #333;
}

.btn-detalle:hover {
  background-color: #ddd;
}

.btn-comprar {
  background-color: #42b983;
  color: white;
}

.btn-comprar:hover {
  background-color: #36976e;
}
</style>
