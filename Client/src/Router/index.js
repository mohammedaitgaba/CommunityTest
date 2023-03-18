import {createRouter,createWebHistory} from 'vue-router'


import Home from '../Pages/Home.vue'
import Login from '../Pages/Login.vue'
import Register from '../Pages/Register.vue'
import AddPost from '../Pages/AddPost.vue'
import NotFound from '../Pages/NotFound.vue'

const routes = [
    {
        path:'/',
        component:Home
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
        path:'/AddPost',
        component:AddPost
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