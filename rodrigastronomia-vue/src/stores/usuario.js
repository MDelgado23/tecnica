import { defineStore } from 'pinia'

export const useUsuarioStore = defineStore('usuario', {
  state: () => ({
    usuario: JSON.parse(localStorage.getItem('usuario')) || null,
    cursos: [] // guardar cursos en el store
  }),
  actions: {
    setUsuario(data) {
      this.usuario = data
      localStorage.setItem('usuario', JSON.stringify(data))
    },
    logout() {
      this.usuario = null
      this.cursosComprados = []
      localStorage.removeItem('usuario')
    },
    setCursos(lista) {
      this.cursos = lista
    }
  }
})