<template>
  <section id="slider">
    <!--slider-->
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div id="slider-carousel" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
              <li
                data-target="#slider-carousel"
                data-slide-to="0"
                class="active"
              ></li>
              <li data-target="#slider-carousel" data-slide-to="1"></li>
              <li data-target="#slider-carousel" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
              <div class="item active" >
                <div class="col-sm-6">
                  <h1>{{defaultbann.heading}}</h1>
                  
                  <p>
                    {{defaultbann.description}}
                  </p>
                  <button type="button" class="btn btn-default get">
                    Get it now
                  </button>
                </div>
                <div class="col-sm-6">
                  <img
                        class="img-responsive"
                        :src="url + defaultbann.banner_image"
                        height="600"
                        alt="Banner Image"
                      />
                  <img :src="urltag + defaultbann.price_tag" class="pricing" alt="" />
                </div>
              </div>

              <div class="item" v-for="($ban,index) in banner" :key="index">
                <div class="col-sm-6">
                  <h1>{{$ban.heading}}</h1>
                  <p>
                    {{$ban.description}}
                  </p>
                  <button type="button" class="btn btn-default get">
                    Get it now
                  </button>
                </div>
                <div class="col-sm-6">
                  <img
                        class="img-responsive"
                        :src="url + $ban.banner_image"
                        height="600"
                        alt="Banner Image"
                      />
                  <img :src="urltag + $ban.price_tag" class="pricing" alt="" />
                </div>
              </div>
            </div>

            <a
              href="#slider-carousel"
              class="left control-carousel hidden-xs"
              data-slide="prev"
            >
              <i class="fa fa-angle-left"></i>
            </a>
            <a
              href="#slider-carousel"
              class="right control-carousel hidden-xs"
              data-slide="next"
            >
              <i class="fa fa-angle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!--/slider-->
</template>

<script>
import axios from 'axios'
export default {
  name: "Slider",
  data(){
    return{
      banner:null,
      defaultbann:null,
      url: "http://127.0.0.1:8000/images/banner/",
      urltag: "http://127.0.0.1:8000/images/bannertags/"
      }
  },
  mounted(){
    axios.get("http://127.0.0.1:8000/api/banerdetail").then($res=>{
      //console.log($res.data);
      this.banner=$res.data.banner.slice(1);
      this.defaultbann=$res.data.banner[0];
      //console.log(this.defaultbann)
    });
  }
};
</script>

<style>
</style>