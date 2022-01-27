<template>
<section>
    <div class="container">
      <div class="row">
        <div class="col-sm-12 padding-right">
            <div class="product-details">
            <!--product-details-->
            <div class="col-sm-6">
                <div class="col-sm-4" data-spy="scroll">
                    <div v-for="($image,i) in productdetail.images" :key="i">
                        <img :src="url + $image.prodimg" alt="" height="100" width="100"/>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="view-product">
                        <img :src="url + productdetail.prod_mainimage" alt="" />
                    </div>
                </div>
            </div>
             
            <div class="col-sm-6">
                <div class="product-information">
                <!--/product-information-->
                <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                <h2>{{productdetail.prod_name}}</h2>
                <p>Web ID: {{productdetail.id}}</p>
                <img src="images/product-details/rating.png" alt="" />
                <span>
                    <span>$ {{productdetail.price}}</span>
                    <router-link
                    to="/cart"
                    @click.native="
                      addToCart(
                        productdetail.id,
                        productdetail.id,
                        productdetail.price,
                        productdetail.prod_name,
                        productdetail.prod_mainimage
                      )
                    "
                  >
                    <button type="button" class="btn btn-fefault cart">
                    <i class="fa fa-shopping-cart"></i>
                    Add to cart
                    </button></router-link>
                </span>
                <div v-for="($attrs,i) in productdetail.prod_attr" :key="i">
                    <p><b>{{$attrs.attr_name}}</b> : {{$attrs.arrt_value}}</p>
                </div>
                <div v-if="productdetail.prod_description != null">
                    <p><b>Product Describtion</b>: {{productdetail.prod_description}}</p>
                </div>
                </div>
                <!--/product-information-->
            </div>
            </div>
            <!--/category-tab-->
        </div>
        </div>
    </div>
  </section>
</template>

<script>
export default {
  name: "ProductDetail",
  props: ["id"],
 data(){
    return{ url: "http://127.0.0.1:8000/images/product/"}
},
computed:{
    productdetail(){
        console.log(this.$store.state.productdetail);
        return this.$store.state.productdetail;
    }
},
 methods: {
    addToCart(id, product_id, price, name, image_path) {
      if (localStorage.getItem("mycart") != undefined) {
        let arr = JSON.parse(localStorage.getItem("mycart"));
        let obj = {
          pro_id: id,
          quantity: 1,
          product_id: product_id,
          price: price,
          name: name,
          image_path: image_path,
        };
        const found = arr.some((el) => el.pro_id == id);
        if (found) {
          this.$swal("Product already Added to Cart",'visit cart !','info');
          this.$route.push("cart");
        } else {
          arr.push(obj);
          localStorage.setItem("mycart", JSON.stringify(arr));
          this.$store.dispatch("addToCart", arr);
          this.$swal("Product Added to Cart",'Waiting for You !','success');
          this.$route.push("cart");
        }
      } else {
        let arr = [];
        let obj = {
          pro_id: id,
          quantity: 1,
          product_id: product_id,
          price: price,
          name: name,
          image_path: image_path,
        };
        arr.push(obj);
        localStorage.setItem("mycart", JSON.stringify(arr));
        this.$store.dispatch("addToCart", arr);
        this.$swal("Product Added to Cart",'Waiting for You !','success').then(()=>{
          this.$route.push("cart");
          window.location.reload()
        });
        
      }
    },
  },
watch:{
     $route(to){
         this.params = to.params.id;
        //  console.log(this.params);
         this.$store.dispatch('getProductDetail', this.params);
     }
 },
  mounted() {
    this.$store.dispatch("getProductDetail", this.id);
  },
};
</script>

<style></style>
