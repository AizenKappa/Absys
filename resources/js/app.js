

import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(fas)

import { createApp } from 'vue';
import { RouterLink , RouterView } from 'vue-router';
import router from './router'

import cards from './components/contents/cards.vue'
import dashboard from './components/contents/dashboard.vue'



createApp({})
.component('cards', cards)
.component('dashboard', dashboard)
.component('fas', FontAwesomeIcon )
.use(router)
.mount('#app')






