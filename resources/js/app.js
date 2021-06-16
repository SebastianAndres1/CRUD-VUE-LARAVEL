require('./bootstrap');

import Vue from 'vue'
import Home from './components/Home'

const vue = new Vue({
    el:'#app',
    components:{
        Home
    }
})