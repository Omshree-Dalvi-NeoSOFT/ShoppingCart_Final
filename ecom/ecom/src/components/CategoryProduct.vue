<template>
<section>
      <Slider />
    <div class="container">
      <div class="row">
          <Sidebar/>
        <div class="col-sm-9 padding-right">
          <div class="features_items">
            <!--features_items-->
            <h2 class="title text-center">Features Items</h2>
            <div>
                <div class="col-sm-4" v-for="($prod,i) in product.Product" :key="i">
                <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <img
                        class="card-img-top"
                        :src="url + $prod.prod_mainimage"
                        width="200"
                        height="150"
                        alt="Card image cap"
                        />                    
                    <h2>${{$prod.price}}</h2>
                    <p>{{$prod.prod_name}}</p>
                    <a href="#" class="btn btn-default add-to-cart"
                        ><i class="fa fa-shopping-cart"></i>Add to cart</a
                    >
                    </div>
                    
                        <div class="product-overlay">
                           <router-link :to="{name: 'ProductDetail', params: {id: $prod.id}}"> <div class="overlay-content">
                                <h1>{{$prod.prod_name}}</h1>
                                <h2>${{$prod.price}}</h2>
                                <a href="#" class="btn btn-default add-to-cart"
                                ><i class="fa fa-shopping-cart"></i>Add to cart</a
                                >
                            </div></router-link >
                        </div>
                    
                </div>
                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                    <li>
                        <a @click="myWish($prod.id)" class="btn"
                        ><i class="fa fa-plus-square"></i>Add to wishlist</a
                        >
                    </li>
                    </ul>
                </div>
                </div>
                </div>
            </div>
          </div>
          <!--features_items-->         
          <!--/recommended_items-->
        </div>
      </div>
    </div>
  </section>
  
</template>

<script>
import Slider from './includes/Slider.vue'
import Sidebar from './includes/Sidebar.vue'
import {addToWish} from '@/common/Service';
export default {
name:"CategoryProduct",
props:['id'],
data(){
    return{ url: "http://127.0.0.1:8000/images/product/"}
},
computed:{
    product(){
        // console.log(this.$store.state.product);
        return this.$store.state.product;
    }
},
methods:{
    myWish(id){
         let uemail = localStorage.getItem('useremail')
         let formData = {email:uemail,pid:id}
         //console.log(formData)
         addToWish(formData)
        .then($res=>{
            console.log($res.data)
            this.$swal("Product Added to Wish !",'Get Back Soon !!','success');
        })
     }
},
watch:{
     $route(to){
         this.params = to.params.id;
        //  console.log(this.params);
         this.$store.dispatch('getProduct', this.params);
     }
 },
components:{
     Slider,
     Sidebar,
 },
 mounted(){
     this.$store.dispatch('getProduct', this.id);
     
 }
}
</script>

<style>

</style>