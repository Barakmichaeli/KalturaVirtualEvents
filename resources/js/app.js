import Vue from 'vue'
import 'vue-loaders/dist/vue-loaders.css';
import VueLoaders from 'vue-loaders';
import Axios from 'axios'
import App from './pages/Entries'

Vue.use(VueLoaders);
Vue.use({
    install (Vue) {
        Vue.prototype.$axios = Axios.create({
            baseURL: process.env.ENV === "production" ? "http://kaltura-home-assignment.herokuapp.com/api/" :
                                                         "http://localhost/kaltura/public/api/"
        })
    }
})

if (process.env.NODE_ENV === 'production') {
    Vue.config.devtools = false
    Vue.config.debug = false
    Vue.config.silent = true
}

const app = new Vue({
    el: '#app',
    components: { App }
})