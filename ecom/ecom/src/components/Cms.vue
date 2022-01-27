<template>
  <section>
    <div class="container">
      <div class="row">
        <div class="col-sm-12 padding-right">
            <div class="product-details">
            <!--product-details-->
            <div class="col-sm-6">
                <div class="col-sm-12">
                    <div class="view-product">
                        <img :src="url + image" alt="" />
                    </div>
                </div>
            </div>
             
            <div class="col-sm-6">
                <div class="product-information">
                <!--/product-information-->
               <h1>{{title}}</h1>
               <p>{{desc}}</p>
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
name:"Cms",
props:['id','image','title','desc'],
data(){
    return{url: "http://127.0.0.1:8000/images/cms/"}
}
}
</script>

<style>

</style>