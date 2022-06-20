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
    ]
  })
  
  export default router