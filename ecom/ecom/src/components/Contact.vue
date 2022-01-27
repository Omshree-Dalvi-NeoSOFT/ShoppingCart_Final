<template>
  <div id="contact-page" class="container">
    <div class="bg">
      <div class="row">
        <div class="col-sm-12">
          <h2 class="title text-center">Contact <strong>Us</strong></h2>
          <!-- <div id="gmap" class="contact-map"></div> -->
        </div>
      </div>
      <div class="row">
        <div class="col-sm-8">
          <div class="contact-form">
            <h2 class="title text-center">Get In Touch</h2>
            <div class="status alert alert-success" style="display: none"></div>
            <form
              id="main-contact-form"
              class="contact-form row"
              @submit.prevent="postContact()"
            >
              <div class="form-group col-md-6">
                <input
                  type="text"
                  v-model="name"
                  class="form-control"
                  required="required"
                  placeholder="Name"
                />
              </div>
              <div class="form-group col-md-6">
                <input
                  type="email"
                  v-model="email"
                  class="form-control"
                  required="required"
                  placeholder="Email"
                />
              </div>
              <div class="form-group col-md-12">
                <input
                  type="text"
                  v-model="subject"
                  class="form-control"
                  required="required"
                  placeholder="Subject"
                />
              </div>
              <div class="form-group col-md-12">
                <textarea
                  v-model="message"
                  id="message"
                  required="required"
                  class="form-control"
                  rows="8"
                  placeholder="Your Message Here"
                ></textarea>
              </div>
              <div class="form-group col-md-12">
                <input
                  type="submit"
                  name="submit"
                  class="btn btn-primary pull-right"
                  value="Submit"
                />
              </div>
            </form>
          </div>
        </div>
        <div class="col-sm-4">
          <div class="contact-info">
            <h2 class="title text-center">Contact Info</h2>
            <address>
              <p>E-Shopper Inc.</p>
              <p>935 W. Webster Ave New Streets Chicago, IL 60614, NY</p>
              <p>Newyork USA</p>
              <p>Mobile: +2346 17 38 93</p>
              <p>Fax: 1-714-252-0026</p>
              <p>Email: info@e-shopper.com</p>
            </address>
            <div class="social-networks">
              <h2 class="title text-center">Social Networking</h2>
              <ul>
                <li>
                  <a href="#"><i class="fa fa-facebook"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-twitter"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-google-plus"></i></a>
                </li>
                <li>
                  <a href="#"><i class="fa fa-youtube"></i></a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--/#contact-page-->
</template>

<script>
import {contactUs} from '@/common/Service';
export default {
  name: "Contact",
  data(){
    return{
      name: null,
      email: null,
      subject: null,
      message: null,
    };
  },
  methods:{
    postContact(){
      let formData = {name:this.name,email:this.email,subject:this.subject,message:this.message};
      contactUs(formData)
      .then(res=>{
        if(res){
              //saveToken(res.data.access_token);
              this.$swal('Thankyou ! ','meet you soon','success').then(()=>{
                    window.location.reload()
                  });
             // this.$router.push('/');
            //  alert(res.data)
          }
            if(res.data.err==1){
              this.$swal(res.data.msg,'','error')
          }
      })
      .catch(err=>{
            console.log("Something Wrong "+err)
        })
    }
  }
};

</script>
<style>
</style>