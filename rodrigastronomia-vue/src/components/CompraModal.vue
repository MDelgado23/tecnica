<!-- src/components/CompraModal.vue -->
<template>
  <div class="modal-overlay" @click.self="cerrar">
    <div class="modal">
      <button class="cerrar-modal" @click="cerrar">×</button>
      <h3>Comprar: {{ curso.nombre }}</h3>

      <form v-if="!mensaje" @submit.prevent="comprar">
        <input v-model="form.nombre" placeholder="Tu nombre" :readonly="!!usuario" required />
        <input v-model="form.email" type="email" placeholder="Email" :readonly="!!usuario" required />
        <input v-model="form.celnum" placeholder="Celular" :readonly="!!usuario" required />

        <button type="submit" class="btn-confirmar">Confirmar compra</button>
        <button type="button" class="btn-cancelar" @click="cerrar">Cancelar</button>

        <button
          v-if="usuario"
          type="button"
          class="logout-button"
          @click="logout"
        >
          ¿No sos vos? Cerrar sesión
        </button>
      </form>

      <p v-if="mensaje" class="mensaje">{{ mensaje }}</p>

      <button
        v-if="mensaje.includes('inicie sesión')"
        @click="redirigirALogin"
        class="login-button"
      >
        Iniciar sesión
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useUsuarioStore } from '../stores/usuario'
import { useRouter } from 'vue-router'
import api from '../axios'

const props = defineProps({
  curso: Object,
  mostrar: Boolean,
})

const emit = defineEmits(['cerrar', 'comprado'])

const router = useRouter()
const store = useUsuarioStore()
const usuario = computed(() => store.usuario)

const form = ref({
  nombre: '',
  email: '',
  celnum: '',
  id_curso: ''
})
const mensaje = ref('')

const cerrar = () => {
  emit('cerrar')
  mensaje.value = ''
}

const logout = () => {
  store.logout()
  cerrar()
}

const redirigirALogin = () => {
  cerrar()
  localStorage.setItem('ruta_pendiente', router.currentRoute.value.fullPath)
  router.push('/login')
}

const comprar = async () => {
  try {
    form.value.id_curso = props.curso.id_curso

    if (usuario.value) {
      form.value.nombre = usuario.value.nombre
      form.value.email = usuario.value.email
      form.value.celnum = usuario.value.celnum
    }

    // Verificar datos repetidos si no está logueado
    if (!usuario.value) {
      const checkEmail = await api.get(`/usuarios?email=${form.value.email}`).catch(() => null)
      const checkCel = await api.get(`/usuarios/celular?celnum=${form.value.celnum}`).catch(() => null)

      if (checkEmail?.data || checkCel?.data) {
        mensaje.value = 'Ya existe una cuenta con estos datos. Si es usted, inicie sesión.'
        return
      }
    }

    await api.post('/compras', form.value)
    mensaje.value = '¡Compra realizada con éxito!'
    emit('comprado')
  } catch (err) {
    console.error(err)
    mensaje.value = 'Error al realizar la compra'
  }
}
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.6);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 999;
}
.modal {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  max-width: 400px;
  width: 100%;
  position: relative;
}
input {
  width: 100%;
  margin-bottom: 0.5rem;
  padding: 0.5rem;
}
button {
  margin-right: 0.5rem;
  margin-top: 0.5rem;
}
.btn-confirmar {
  background: #42b983;
  color: white;
  border: none;
  padding: 0.4rem 0.7rem;
  border-radius: 4px;
  cursor: pointer;
}
.btn-cancelar {
  background: #ccc;
  color: black;
  border: none;
  padding: 0.4rem 0.7rem;
  border-radius: 4px;
  cursor: pointer;
}
.logout-button {
  background: #f44336;
  color: white;
  border: none;
  padding: 0.4rem 0.7rem;
  border-radius: 4px;
  cursor: pointer;
}
.login-button {
  background: #42b983;
  color: white;
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 5px;
  margin-top: 1rem;
  cursor: pointer;
}
.mensaje {
  font-weight: bold;
  margin-top: 1rem;
}
.cerrar-modal {
  position: absolute;
  top: 10px;
  right: 15px;
  background: transparent;
  border: none;
  font-size: 1.5rem;
  cursor: pointer;
  color: #888;
}
</style>
