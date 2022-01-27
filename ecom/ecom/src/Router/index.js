import Vue from 'vue';
import Router from 'vue-router';
Vue.use(Router);
import Home from '../components/Home';
import Contact from '../components/Contact';
import Login from '../components/Login';
import CategoryProduct from '../components/CategoryProduct';
import ProductDetail from '../components/ProductDetail';
import Cart from '../components/Cart.vue';
import Checkout from '../components/Checkout.vue';
import Changepassword from '../components/Changepassword.vue';
import Profile from '../components/Profile.vue';
import Profileview from '../components/Profileview.vue';
import Cms from '../components/Cms.vue';
import Wishlist from '../components/Wishlist.vue';
import Myorder from '../components/Myorders.vue'

function myguard(to,from,next){
    let isAuthenticated=false;
    if(localStorage.getItem('useremail') != undefined){
        isAuthenticated = true;
    }
    else{
        isAuthenticated = false;
    }

    if(isAuthenticated){
        next();
    }
    else{
        alert("Please Login First !");
        next('/login');
    }
}


export default new Router({
    routes:[
    {
        path:'/',
        name:'Home',
        component:Home
    },
    {
        path:'/contact',
        name:'Contact',
        component:Contact
    },
    {
        path:'/login',
        name:'Login',
        component:Login
    },
    {
        path:'/categoryproduct/:id',
        name:'CategoryProduct',
        component:CategoryProduct,
        props:true
    },
    {
        path:'/productdetail/:id',
        name:'ProductDetail',
        component:ProductDetail,
        props:true
    },
    {
        path:'/cart',
        name:'Cart',
        component:Cart
    },
    {
        path:'/checkout',
        name:'Checkout',
        beforeEnter:myguard,
        component:Checkout
    },
    {
        path:'/changepassword',
        name:'Changepassword',
        beforeEnter:myguard,
        component:Changepassword
    },
    {
        path:'/profile',
        name:'Profile',
        beforeEnter:myguard,
        component:Profile
    },
    {
        path:'/profileedit',
        name:'Profileview',
        beforeEnter:myguard,
        component:Profileview
    },
    {
        path:'/Cms/:id',
        name:'Cms',
        component:Cms,
        props:true
    },
    {
        path:'/wishlist',
        name:'Wishlist',
        beforeEnter:myguard,
        component:Wishlist,
    },
    {
        path:'/myorder',
        name:'Myorder',
        beforeEnter:myguard,
        component:Myorder,
    },
],
mode : 'history'
})