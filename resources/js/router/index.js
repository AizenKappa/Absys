import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(),
    routes: [
      {
        path: '/home',
        name: 'add-absences',
        component: () => import('../components/Add.vue')
      },
      {
          path: '/just',
          name: 'justfier-absences',
          component: () => import('../components/Just.vue')
        },
        {
          path: '/detail',
          name: 'class-details',
          component: () => import('../components/detail.vue')
        },
    ]
  })
  
  export default router