import { createRouter, createWebHistory } from 'vue-router';
import CursosView from '../views/CursosView.vue';
import MisCursosView from '../views/MisCursosView.vue';
import AdminView from '../views/AdminView.vue';
import Login from '../views/Login.vue'
import CursoDetalle from '../views/CursoDetalle.vue'

const routes = [
  { path: '/', component: CursosView },
   {path: '/curso/:id', component: CursoDetalle},
 // { path: '/comprar', component: ComprarView },
  { path: '/mis-cursos', component: MisCursosView },
  { path: '/admin', component: AdminView },
  { path: '/login', component: Login }

];

export default createRouter({
  history: createWebHistory(),
  routes
});
