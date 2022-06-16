import { library } from '@fortawesome/fontawesome-svg-core'
import { fas } from '@fortawesome/free-solid-svg-icons'

import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
library.add(fas)
import LoginRoot from "./components/LoginRoot";
import { createApp } from 'vue';

createApp(LoginRoot)
.component('fas', FontAwesomeIcon )
.mount('#login')