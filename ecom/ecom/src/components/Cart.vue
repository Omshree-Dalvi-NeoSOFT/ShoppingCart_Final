<template>
  <div>
    <section id="cart_items">
      <div class="container">
        <div class="breadcrumbs">
          <ol class="breadcrumb">
            <li><a href="#">Home</a></li>
            <li class="active">Shopping Cart</li>
          </ol>
        </div>
        <div class="table-responsive cart_info">
          <table class="table table-condensed">
            <thead>
              <tr class="cart_menu">
                <td class="image">Item</td>
                <td class="description"></td>
                <td class="price">Price</td>
                <td class="quantity">Quantity</td>
                <td class="total">Total</td>
                <td></td>
              </tr>
            </thead>
            <tbody>
              <tr class="cart-menu" v-for="cart in details" :key="cart.id">
                <td class="cart_product">
                  <img
                    :src="url + cart.image_path"
                    alt=""
                    width="100px"
                    height="100px"
                  />
                </td>
                <td class="cart_description">
                  <h4>
                    <a href="">{{ cart.name }}</a>
                  </h4>
                  <p>Web ID: {{ cart.product_id }}</p>
                </td>
                <td class="cart_price">
                  <p>$ {{ cart.price }}</p>
                </td>
                <!-- <td class="cart_quantity">
                  <div class="cart_quantity_button">
                    <button class="cart_quantity_down" @click="addQty(cart)">
                      +
                    </button>
                    <input
                      class="cart_quantity_input"
                      type="text"
                      name="quantity"
                      v-model="cart.quantity"
                      autocomplete="off"
                      size="2"
                    />
                    <button class="cart_quantity_down" @click="subQty(cart)">
                      -
                    </button>
                  </div>
                </td> -->
                <td class="cart_quantity">
								<div class="cart_quantity_button">
									<!-- <a class="cart_quantity_up" href=""> + </a> -->
                    <a class="cart_quantity_up  " @click="addQty(cart)">
                      +
                    </a>
									<input class="cart_quantity_input" type="text" name="quantity"   v-model="cart.quantity" autocomplete="off" size="2">
									<!-- <a class="cart_quantity_down" href=""> - </a> -->
                   <a class="cart_quantity_down" @click="subQty(cart)">
                      -
                    </a>
								</div>
							</td>
                <td class="cart_total">
                  <p class="cart_total_price">
                   $ {{ parseInt(cart.price) * parseInt(cart.quantity) }}
                  </p>
                  <p class="hidden">{{totalprice.push(cart.price * cart.quantity) }}</p>
                </td>
                <td class="cart_delete">
                  <button class="cart_quantity_delete" @click="delItem(cart)">
                    <i class="fa fa-times"></i>
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>
    <!--/#cart_items-->
    <section id="do_action">
      <div class="container">
        <div class="heading">
          <h3>What would you like to do next?</h3>
          <p>
            Choose if you have a discount code or reward points you want to use
            or would like to estimate your delivery cost.
          </p>
        </div>
        <div class="row">
          <div class="col-sm-6">
            <div class="total_area">
              <ul>
                <li>Cart Sub Total <span >${{grandtotal()}}</span></li>
                <li>Shipping Cost 
                <span v-if="finalTotal() >= 500">Free</span>
                <span v-if="finalTotal() < 500">$50</span>
                </li>
                <li>Total <span>${{finalTotal()}}</span></li>
              </ul>

              <router-link class="btn btn-default check_out" to="/checkout">Check Out</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from 'axios'
export default {
name:"Cart",

data(){
    return{url: "http://127.0.0.1:8000/images/product/", totalprice:[],cartprice:[], uemail:undefined,details:undefined}
},
created(){
    this.viewCart();
},
  methods: {
    addQty(cart) {
      Object.assign(cart, {
        quantity: parseInt(cart.quantity) + 1,
      });
      localStorage.setItem("mycart", JSON.stringify(this.details));
    },
    subQty(cart) {
      Object.assign(cart, {
        quantity: parseInt(cart.quantity) - 1,
      });
      localStorage.setItem("mycart", JSON.stringify(this.details));
    },
    delItem(cart) {
      this.$swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Remove !'
        }).then((result) => {
          if (result.isConfirmed) {
            let item = this.details.indexOf(cart);
            //console.log(item);
            this.details.splice(item, 1);
            // console.log(this.details);
            localStorage.setItem("mycart", JSON.stringify(this.details));
                // window.location.reload()
            this.$swal.fire(
              'Product Removed!',
              '',
              'success'
            ).then(()=>{
              window.location.reload()
              this.$route.push("/");
            })
          }
        })
    },
    grandtotal(){
      const item = JSON.parse(localStorage.getItem('mycart'));
      var sum = 0;
      item.forEach(element => {
        sum =  sum + element.price * element.quantity;
      });
      return sum;
    },
    finalTotal(){
      const price = this.grandtotal();
      if(price > 500){
        return price;
      }
      else{
        return price + 50;
      }
    },
  },
computed: {
    inCart() { 
        //console.log(this.$store.inCart)
        return this.$store.getters.inCart
        },
    numInCart() { return this.inCart.length},
    

},
mounted(){
   axios.get("http://127.0.0.1:8000/api/products").then($res=>{
     //console.log($res.data);
     this.product = $res.data.Product;
   });

  

	this.details = JSON.parse(localStorage.getItem("mycart"));
    // console.log(localStorage.getItem("mycart"));
    console.log(this.details);
 }
}
</script>

<style>

</style>