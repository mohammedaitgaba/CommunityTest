import {createRouter,createWebHistory} from 'vue-router'


import Posts from '../Pages/Posts.vue'
import Login from '../Pages/Login.vue'
import Register from '../Pages/Register.vue'
import NotFound from '../Pages/NotFound.vue'

const routes = [
    {
        path:'/',
        component:Posts
    },
    {
        path:'/Login',
        component:Login
    },
    {
        path:'/Register',
        component:Register
    },
    {
        path:'/:pathMatch(.*)*',
        component:NotFound
    },
]

const router = createRouter({
    history:createWebHistory(),
    routes
})
export default router