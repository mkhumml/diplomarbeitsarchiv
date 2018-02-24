import Vue from 'vue'
import App from './App.vue'
import VueClip from 'vue-clip'
Vue.use(VueClip)


new Vue({
    el: '#app',
    render: h => h(App)
})
/*
* v-bind: dynamic output
*
* */
