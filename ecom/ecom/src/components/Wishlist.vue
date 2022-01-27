<template>
<div class="container">
  <div class="table-responsive cart_info">
    <table class="table table-condensed">
      <thead>
        <tr class="cart_menu">
          <td class="image">Item</td>
          <td class="description">Name</td>
          <td class="price">Price</td>
          <td class="quantity">Action</td>
          <td></td>
        </tr>
      </thead>
      <tbody>
        <tr class="cart-menu" v-for="(w,i) in wish" :key="i">
          <td class="cart_image">
            <img
              :src="url + w.prod_mainimage"
              alt=""
              width="100px"
              height="100px"
            />
          </td>
          <td class="cart_description">
            <h5>{{w.prod_name}}</h5>
          </td>
          <td class="cart_price">
            <h5>$ {{w.price}}</h5>
          </td>
          <td class="cart_delete">
            <button class="cart_quantity_delete" @click="delWish(w.id)">
              <i class="fa fa-times"></i>
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
</template>

<script>
import axios from 'axios'
import {getWish} from '@/common/Service';
import {removeWish} from '@/common/Service';
export default {
name:"Wishlist",
data(){
    return{url: "http://127.0.0.1:8000/images/product/",wish:undefined}
},
created(){
this.myWish()
},
methods:{
  myWish(){
    getWish()
   .then(res=>{
     this.wish = res.data.wish;
     console.log(this.wish);
   })
  },
  delWish(id){
    removeWish(id)
    .then(res=>{
      console.log(res.data.msg);
      this.$swal(res.data.msg,'','success').then(()=>{
        window.location.reload()
      });
    })
  }
   
},
mounted(){
  this.userId = localStorage.getItem('userId');
   axios.get("http://127.0.0.1:8000/api/products").then($res=>{
    // console.log($res.data);
     this.product = $res.data.Product;
   });
  }

}
</script>

<style>

</style>