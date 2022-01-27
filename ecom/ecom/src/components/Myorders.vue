<template>
  <div class="container">
    <table class="table" >
        <thead>
            <tr>
            <th scope="col">Product</th>
            <th scope="col">Order Amount</th>
            <th scope="col">Order Amount (Coupon)</th>
            <th scope="col">Order Status</th>
            </tr>
        </thead>
        <tbody v-for="(userdetail,i) in userdetails" :key="i">
                <tr v-for="(orderdtl,j) in orderdetails" :key="j">
                    <td v-if="(orderdtl.userdetail_id == userdetail.id)">
                       <table>
                           <tbody v-for="(ord,j) in orders" :key="j">
                               <tr v-if="ord.userdetail_id == orderdtl.userdetail_id">
                                    <td v-for="prod in product" :key="prod">
                                       <b v-if="prod.id == ord.product_id"><img
                                            :src="url + prod.prod_mainimage"
                                            alt=""
                                            width="100px"
                                            height="100px"
                                            class="mb-2"
                                        />
                                        </b>
                                    </td>
                                    <td v-for="prod in product" :key="prod">
                                       
                                           <b v-if="prod.id == ord.product_id">{{prod.prod_name}}</b>
                                        
                                    </td>
                                </tr>
                           </tbody>
                        </table> 
                    </td>
                    <td v-if="(orderdtl.userdetail_id == userdetail.id)">
                        {{orderdtl.grandtotal}}
                    </td>
                    <td v-if="(orderdtl.userdetail_id == userdetail.id)">
                        {{orderdtl.finalTotal}}
                    </td>
                    <td v-if="(orderdtl.userdetail_id == userdetail.id)">
                        <b>{{orderdtl.status}}</b>
                    </td>
                </tr>
        </tbody>
    </table>
    </div>
</template>

<script>
import axios from 'axios';
export default {
name:"Myorders",
data(){
    return{url: "http://127.0.0.1:8000/images/product/",userid:null,product:undefined,orderdetails:undefined,orders:undefined,userdetails:undefined}
},
mounted(){
	axios.get("http://127.0.0.1:8000/api/products").then($res=>{
     console.log($res.data);
     this.product = $res.data.Product;
   }),
   this.userid = localStorage.getItem('userId');
   axios.get(`http://127.0.0.1:8000/api/myorders/${this.userid}`).then($res=>{
    this.orderdetails = $res.data.orderdetail;
    this.orders =$res.data.orders;
    this.userdetails=$res.data.userdetail;
     console.log(this.userdetails);
   });
}
}
</script>

<style>

</style>