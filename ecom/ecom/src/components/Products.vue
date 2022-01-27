<template>
  <div>
        <div class="col-sm-4" v-for="($prod,i) in product" :key="i">
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
            <a href="javascript:void(0)" class="btn btn-default add-to-cart"
                ><i class="fa fa-shopping-cart"></i>Add to cart</a
            >
            </div>
            
                <div class="product-overlay">
                   <router-link :to="{name: 'ProductDetail', params: {id: $prod.id}}">
                        <div class="overlay-content">
                        <h1>{{$prod.prod_name}}</h1>
                        <h2>${{$prod.price}}</h2>
                        <button class="btn btn-default add-to-cart"
                        ><i class="fa fa-shopping-cart"></i>Add to cart</button>
                    </div>
                    </router-link >
                </div>
        </div>
        <div class="choose">
            <ul class="nav nav-pills nav-justified">
                <li>
                    <a @click="myWish($prod.id)" class="btn"><i class="fa fa-plus-square"></i>Add to wishlist</a>
                </li>
            </ul>
        </div>
        </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import {addToWish} from '@/common/Service';
export default {
name:"Products",
data(){
   return{
     product:null,
     uemail:undefined,
     productImage:null,
     productAttr:null,
     url: "http://127.0.0.1:8000/images/product/",
     }
 },
 mounted(){
   axios.get("http://127.0.0.1:8000/api/products").then($res=>{
     console.log($res.data);
     this.product = $res.data.Product;
     this.productImage = $res.data.ProductIimage;
     this.productAttr = $res.data.ProductAttr;
   }),
   axios.get("http://127.0.0.1:8000/api/productimage/").then($res=>{
     console.log($res.data);
   })
 },
 methods:{
     myWish(id){
         let uemail = localStorage.getItem('useremail')
         let formData = {email:uemail,pid:id}
         console.log(formData)
         addToWish(formData)
        .then($res=>{
            console.log($res.data)
            this.$swal("Product Added to Wish",'See you soon','success');
        })
     }
 }    
 
}
</script>

<style>

</style>