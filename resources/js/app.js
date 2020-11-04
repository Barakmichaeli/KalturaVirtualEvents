import Vue from 'vue'
import 'vue-loaders/dist/vue-loaders.css';
import VueLoaders from 'vue-loaders';
import Axios from 'axios'
import App from './pages/Entries'

Vue.use(VueLoaders);
Vue.use({
    install (Vue) {
        Vue.prototype.$axios = Axios.create({
            baseURL: process.env.MIX_APP_URL
        })
    }
})

const app = new Vue({
    el: '#app',
    components: { App }
})
