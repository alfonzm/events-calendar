import Vue from 'vue'
import router from './router'
import App from './components/App'
import store from './store'

// plugins
import VCalendar from 'v-calendar'
import Notifications from 'vue-notification'

require('./bootstrap');

Vue.use(VCalendar)
Vue.use(Notifications)

const app = new Vue({
    el: '#app',
    components: {
        App,
    },
    router,
    store,
});
