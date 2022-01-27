<template>
  <header id="header">
    <!--header-->
    <div class="header_top">
      <!--header_top-->
      <div class="container">
        <div class="row">
          <div class="col-sm-6">
            <div class="contactinfo">
              <ul class="nav nav-pills">
                <li>
                  <a href="#"><i class="fa fa-phone"></i> +2 95 01 88 821</a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-envelope"></i> info@domain.com</a>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="social-icons pull-right">
              <ul class="nav navbar-nav">
                <li>
                  <a href="#"><i class="fa fa-facebook"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-twitter"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-linkedin"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-dribbble"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-google-plus"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/header_top-->

    <div class="header-middle">
      <!--header-middle-->
      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <div class="logo pull-left">
              <router-link to="/"><img src="images/home/logo.png" alt="" /></router-link>
            </div>
            <div class="btn-group pull-right">
              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-default dropdown-toggle usa"
                  data-toggle="dropdown"
                >
                  India
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="#">Canada</a></li>
                  <li><a href="#">UK</a></li>
                </ul>
              </div>

              <div class="btn-group">
                <button
                  type="button"
                  class="btn btn-default dropdown-toggle usa"
                  data-toggle="dropdown"
                >
                  Doller
                  <span class="caret"></span>
                </button>
                <ul class="dropdown-menu">
                  <li><a href="#">Canadian Dollar</a></li>
                  <li><a href="#">Pound</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-sm-8">
            <div class="shop-menu pull-right">
              <ul class="nav navbar-nav">
                <li>
                  <router-link to="/profile"  v-if="uemail"><i class="fa fa-user"></i> Account : <b>{{uemail}}</b></router-link> 
                </li>
                <li>
                  <router-link to="/wishlist"  v-if="uemail"><i class="fa fa-star"></i> Wishlist</router-link>
                </li>
                <li>
                  <router-link to="/myorder"  v-if="uemail"><i class="fa fa-circle" ></i> My Order</router-link>
                </li>
                <li>
                  <router-link to="/checkout"  v-if="uemail"
                    ><i class="fa fa-crosshairs"></i> Checkout</router-link
                  >
                </li>
                <li>
                  <router-link to="/cart"
                    ><span class="badge badge-secondary"> ( {{numInCart}} )</span><i class="fa fa-shopping-cart"></i> Cart</router-link>
                </li>
                <li>
                  <router-link v-if="!uemail" to="/login"><i class="fa fa-lock"></i> Login</router-link>
                  <a v-if="uemail" v-on:click="Logout()" class="btn"><i class="fa fa-unlock"></i> Logout</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/header-middle-->

    <div class="header-bottom">
      <!--header-bottom-->
      <div class="container">
        <div class="row">
          <div class="col-sm-9">
            <div class="navbar-header">
              <button
                type="button"
                class="navbar-toggle"
                data-toggle="collapse"
                data-target=".navbar-collapse"
              >
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>
            <div class="mainmenu pull-left">
              <ul class="nav navbar-nav collapse navbar-collapse">
                <li>
                  <router-link to="/" class="active">Home</router-link>
                </li>
                <li class="dropdown">
                  <a href="javascript:void(0)">Shop<i class="fa fa-angle-down"></i></a>
                  <ul role="menu" class="sub-menu">
                    <li><router-link to="/">Products</router-link></li>
                    <!-- <li><a href="product-details.html">Product Details</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                    <li><a href="cart.html">Cart</a></li> -->
                    <li> <router-link v-if="!uemail" to="/login"><i class="fa fa-lock"></i> Login</router-link>
                  <a v-if="uemail" v-on:click="Logout()" class="btn"><i class="fa fa-unlock"></i> Logout</a>
                </li>
                  </ul>
                </li>
                <li class="dropdown">
                  <a href="javascript:void(0)">Services<i class="fa fa-angle-down"></i></a>
                  <ul role="menu" class="sub-menu">
                    <li  v-for="(service,i) in services" :key="i"><router-link :to="{name: 'Cms', params: {id: service.id,image:service.image,title:service.title,desc:service.description}}">{{service.title}}</router-link></li>
                  </ul>
                </li>
                <li>
                  <router-link to="/contact">Contact</router-link>
                </li>
              </ul>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="search_box pull-right">
              <input type="text" placeholder="Search" />
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--/header-bottom-->
  </header>
  <!--/header-->
</template>

<script>
import {removeToken} from '@/common/Jwttoken';
import {servicesCMS} from '@/common/Service';
export default {
  name: "Header",
  data(){
    return{
      uemail: null,
      services: null
    }
  },
created(){
    this.viewCart();
},
  methods:{
    viewCart(){
          if(localStorage.getItem('carts')){
            this.carts = JSON.parse(localStorage.getItem('carts'));
            this.badge = this.carts.length;
            this.totalprice = this.carts.reduce((total,item)=>{
                return total = this.quantity * item.price;
            },0);
          }
      },
    Logout(){
      this.$swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Loggout !'
        }).then((result) => {
          if (result.isConfirmed) {
            localStorage.removeItem('useremail');
                localStorage.removeItem('userId');
                removeToken()
                // window.location.reload()
            this.$swal.fire(
              'Logged out!',
              'Your are successfully Logged out. Visit Again !',
              'success'
            ).then(()=>{
              window.location.reload()
              this.$route.push("/");
            })
          }
        })
      // if(confirm("Do you want to logout ?")){
        
      // }
      
    },
    
  },
  mounted(){
    if(localStorage.getItem('useremail')){
     this.uemail=localStorage.getItem('useremail'); 
    }
    servicesCMS().then(res=>{
      this.services = res.data.services;
      console.log(this.services)
    })
  },
  computed:{
    inCart(){
      return this.$store.getters.inCart;
    },
    numInCart() { return this.inCart.length},
  }
};
</script>

<style>
</style>