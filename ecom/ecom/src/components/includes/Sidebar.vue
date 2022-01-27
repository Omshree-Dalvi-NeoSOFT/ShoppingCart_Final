<template>
  <div class="col-sm-3">
    <div class="left-sidebar">
      <h2>Category</h2>
      <div class="panel-group category-products" id="accordian">
        <!--category-productsr-->
        <div class="panel panel-default" v-for="($cat,index) in category" :key="index">
            <div class="panel-heading">
              <h4 class="panel-title">
                <router-link data-toggle="collapse" data-parent="#accordian" :to="`#`+index">
                  <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                  {{$cat.cat_name}}
                </router-link>
              </h4>
            </div>
            <div :id="index" class="panel-collapse collapse" >
              <div v-for="($sub,i) in subcat" :key="i" v-bind:href="$sub.id">

              <div class="panel-body" v-if="$sub.category_id == $cat.id">
                <ul>
                  <li><router-link :to="{name: 'CategoryProduct', params: {id: $sub.id}}">{{$sub.subcat_name }}</router-link></li>
                </ul>
              </div>
              </div>
            </div>
        </div>
        <!-- <div class="panel panel-default" v-for="($cat,index) in category" :key="index" >
          <div class="panel-heading">
            <h4 class="panel-title">
              <a> <span class="badge pull-right"><i class="fa fa-plus"></i></span>
                {{$cat.cat_name}}
              </a>
            </h4>
          </div>
          <div>
            <div v-for="($sub,i) in subcat" :key="i" v-bind:href="$sub.id">
              <div class="panel-body" v-if="$sub.category_id == $cat.id">
                <ul>
                  <li><router-link :to="{name: 'CategoryProduct', params: {id: $sub.id}}">{{$sub.subcat_name }}</router-link></li>
                </ul>
              </div>
            </div>
          </div>
        </div> -->
        
      </div>
      <!--/category-products-->

      

      <div class="price-range">
        <!--price-range-->
        <h2>Price Range</h2>
        <div class="well text-center">
          <input
            type="text"
            class="span2"
            value=""
            data-slider-min="0"
            data-slider-max="600"
            data-slider-step="5"
            data-slider-value="[250,450]"
            id="sl2"
          /><br />
          <b class="pull-left">$ 0</b> <b class="pull-right">$ 600</b>
        </div>
      </div>
      <!--/price-range-->

      <div class="shipping text-center">
        <!--shipping-->
        <img src="images/home/shipping.jpg" alt="" />
      </div>
      <!--/shipping-->
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: "Sidebar",
  data(){
    return{
      category:null,
      subcat:null
    }
  },
  mounted(){
    axios.get("http://127.0.0.1:8000/api/category").then($res=>{
      // console.log($res.data);
      this.category=$res.data.category;
      // console.log(this.category);
      
    }),
    axios.get("http://127.0.0.1:8000/api/subcategory").then($res=>{
      // console.log($res.data);
      this.subcat=$res.data.subcategory;
      //console.log(this.subcat);
      
    })
  }
};
</script>

<style>
</style>