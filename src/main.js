import Vue from 'vue'
import App from './App.vue'
import Multiselect from 'vue-multiselect'

//adding multiselect component global
Vue.component('multiselect', Multiselect)

//init new vue instance
new Vue({
    el: '#app',
    render: h => h(App)
})