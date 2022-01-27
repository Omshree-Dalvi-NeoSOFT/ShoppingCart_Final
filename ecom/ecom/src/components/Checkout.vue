<template>
  <div> <Paypal />
      <section id="cart_items">
		<div class="container">
			<div class="breadcrumbs">
				<ol class="breadcrumb">
                <li><router-link to="/">Home</router-link></li>
                <li class="active">Check out</li>
				</ol>
			</div><!--/breadcrums-->

			<div class="step-one">
				<h2 class="heading">Step1</h2>
			</div>

			<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-8 clearfix">
						<div class="bill-to">
							<p>Bill To</p>
							<div class="form-one">
								<form @submit.prevent="handleCheckout">
									<input type="email" placeholder="Email*" v-model="billing.email">
									<div v-if="submitted && !$v.billing.email.required" class="invalid-feedback text-danger">Email is required</div>
									<div v-if="submitted && !$v.billing.email.email" class="invalid-feedback text-danger">Please Provide Correct Mail id</div>

									<input type="text" placeholder="First Name *" v-model="billing.firstname">
									<div v-if="submitted && !$v.billing.firstname.required" class="invalid-feedback text-danger">First Name is required</div>

									<input type="text" placeholder="Middle Name" v-model="billing.middename">

									<input type="text" placeholder="Last Name *" v-model="billing.lastname">
									<div v-if="submitted && !$v.billing.lastname.required" class="invalid-feedback text-danger">Last Name is required</div>

									<textarea name="address" placeholder="Address *" cols="30" rows="5" v-model="billing.address1"></textarea>
									<div v-if="submitted && !$v.billing.address1.required" class="invalid-feedback text-danger">Address is required</div>

								</form>
							</div>
							<div class="form-two">
								<form @submit.prevent="handleCheckout">
									<input type="number" max="6" placeholder="Zip / Postal Code *" v-model="billing.zip">
									<div v-if="submitted && !$v.billing.zip.required" class="invalid-feedback text-danger">Zip / Postal Code is required</div>

									<input type="number" max="10" placeholder="Phone *" v-model="billing.phone">
									<div v-if="submitted && !$v.billing.phone.required" class="invalid-feedback text-danger">Phone is required</div>

								</form>
							</div>
						</div>
					</div>
					<div class="col-sm-4">
						<div class="order-message">
							<p>Special Notes</p>
							<form @submit.prevent="handleCheckout">
							<textarea name="message"  placeholder="Notes about your order, Special Notes for Delivery" rows="16" v-model="billing.shipping"></textarea>
							</form>
						</div>	
					</div>					
				</div>
			</div>
			<div class="step-one">
				<h2 class="heading">Step2</h2>
			</div>
			<div class="review-payment">
				<h2>Review & Payment</h2>
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
				<td class="cart_quantity">
					<p>{{cart.quantity}}</p>
				</td>
                <td class="cart_total">
                  <p class="cart_total_price">
                   $ {{ parseInt(cart.price) * parseInt(cart.quantity) }}
                  </p>
                </td>
              </tr>
            </tbody>
          </table>
		<div class="mb-4">
            <div class="chose_area">
              <ul class="user_option">
                <li id="ccheck">
                  <input type="checkbox" v-model="checked" @click="Coupon()"/>
                  <label>Use Coupon Code</label>
                  <select v-model="selected" v-if="checked" >
                    <option disabled selected value="">Please select one</option>
                    <option v-for="(code,i) in coupon" :key="i" :value="code.value">{{code.code}}</option>
                  </select>
                </li>
              </ul>
              <p class="hidden">{{couponValue = selected}}</p>
            </div>
          </div>
        </div>
		<div class="payment-options">
            <div class="total_area">
              <ul>
                <li>Cart Sub Total <span >${{grandtotal}}</span></li>
				<li v-if="couponValue != undefined && checked == true">Coupon <span >${{couponValue}}</span></li>
                <li>Shipping Cost 
					<span v-if="grandtotal >= 500">Free</span>
					<span v-if="grandtotal < 500">$50</span>
				</li>
                <li>Total <span>${{finalTotal}}</span></li>
              </ul>
            </div>
          </div>
		<div class="step-one">
			<h2 class="heading">Step3</h2>
		</div>
		<div class="payment-options">
				<span>
					<label><input type="checkbox"> Cash on Delivery</label>
				</span>
				<span id="ccheck">
					<label><input type="checkbox" v-model="check" @click="paymentPay()"> Paypal Payment</label>
					<div v-if="check == true">
						<Paypal/>
					</div>
				</span>
				<div class="shopper-informations">
				<div class="row">
					<div class="col-sm-10">
						<div v-if="loading" class="spiner-border spiner-border-sm"><h2><i class="fa fa-spiner"></i>Please Wait...</h2></div>
					</div>
					<div class="col-sm-2">
						<form @submit.prevent="handleCheckout">
						<button class="btn btn-default check_out" type="submit">Place Order</button>
						</form>
					</div>	
				</div>
			</div>
		</div>
			
	</div>		
	</section> <!--/#cart_items-->
	
  </div>
</template>

<script>
import axios from 'axios';
import {userCheckout} from '@/common/Service';
import { required, email } from "vuelidate/lib/validators";
import Paypal from "../components/Paypal.vue";
export default {
name:"Checkout",
components:{
	Paypal
},
data(){
	return{
		loading: false,
		url: "http://127.0.0.1:8000/images/product/",
		details:undefined,
		uemail:undefined,
		coupon:undefined,
		billing:{
			email:undefined,
			firstname:undefined,
			middename:undefined,
			lastname:undefined,
			address1:undefined,
			address2:undefined,
			zip:undefined,
			phone:undefined,
			mobilephone:undefined,
			shipping:undefined
		},
	submitted:false,
	couponValue:undefined,
	selected:undefined,
	el: '#ccheck',
      checked:false,
		check:false,
	}	
},
validations:{
    billing:{
			email:{required,email},
			firstname:{required},
			lastname:{required},
			address1:{required},
			zip:{required},
			phone:{required},
		},
  },
  methods:{
	paymentPay(){
		localStorage.setItem('amount',this.finalTotal);
	},
	handleCheckout(){
		this.submitted = true;
		this.$v.billing.$touch();
		if (this.$v.billing.$invalid) {
            return;
        }else{
			this.loading = true
			this.uemail=localStorage.getItem('useremail'); 
			let formData ={email:this.billing.email,firstname:this.billing.firstname,middename:this.billing.middename,lastname:this.billing.lastname,address1:this.billing.address1,address2:this.billing.address2,zip:this.billing.zip,phone:this.billing.phone,mobilephone:this.billing.mobilephone,shipping:this.billing.shipping,cart:this.details,uemail:this.uemail,grandtotal:this.grandtotal,finalTotal:this.finalTotal,coupon:this.coupon};
			console.log(formData);
			userCheckout(formData)
			.then(res=>{
				//console.log(res.data);
				localStorage.removeItem('mycart');
				this.$swal(res.data.msg,'Waiting for you !!','success');
				this.$router.push('/');
			})
			.catch(err=>{
              this.$swal("Unauthorized User",'Try Again Later !','error')
              console.log("Something Wrong "+err)
          })
		.finally(() => (this.loading = false))
		}
	},
	Coupon(){
     axios.get("http://127.0.0.1:8000/api/coupons").then($res=>{
      console.log($res.data); 
      this.coupon = $res.data.coupons;
   })
  }
  },
created(){
    this.viewCart();
},
mounted(){
	axios.get("http://127.0.0.1:8000/api/products").then($res=>{
     console.log($res.data);
     this.product = $res.data.Product;
   });
	this.details = JSON.parse(localStorage.getItem("mycart"));
    // console.log(localStorage.getItem("mycart"));
    console.log(this.details);
},
computed:{
	grandtotal(){
		const item = JSON.parse(localStorage.getItem('mycart'));
		var sum = 0;
		item.forEach(element => {
		sum =  sum + element.price * element.quantity;
		});
		return sum;
	},
    finalTotal(){
      const price = this.grandtotal;
	if(this.couponValue && this.checked == true){
		return price - this.couponValue;
		}
      if(price > 500){
        return price;
      }
      else{
        return price + 50;
      }
	
    },
	
	}
}
</script>

<style>

</style>