import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
      {
        path: '/home',
        name: 'add absences',
        component: () => import('../components/Home.vue')
      },
      {
        path: '/add',
        name: 'ajouter absence',
        component: () => import('../components/Add.vue')
      },
      {
          path: '/just',
          name: 'justfier absences',
          component: () => import('../components/Just.vue')
        },
        {
          path: '/detail',
          name: 'details de class',
          component: () => import('../components/Detail.vue')
        },
        {
          path: '/profile',
          name: 'Profile',
          component: () => import('../components/Profile.vue')
        },
        {
          path: '/User',
          name: 'Update users',
          component: () => import('../components/User.vue')
        },
        {
          path: '/addUser',
          name: 'add users',
          component: () => import('../components/addUser.vue')
        },
        {
          path: '/stagiaire/:id',
          name: 'Stagiaire',
          component: () => import('../components/Stagiaire.vue'),
          
        },
    ]
  })
  
  export default router