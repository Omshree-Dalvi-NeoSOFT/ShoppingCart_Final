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
            <Product />
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
import Product from './Products.vue'
export default {
  name: "Home",
  components:{
     Slider,
     Sidebar,
     Product,
 }
};
</script>

<style>
</style>