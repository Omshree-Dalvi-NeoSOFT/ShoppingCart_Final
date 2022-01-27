<template>
  <section id="form">
    <!--form-->
    <div class="container">
      <div class="row">
        <div class="col-sm-4 col-sm-offset-1">
          <div class="login-form">
            <!--login form-->
            <h2>Login to your account</h2>
            
              <form @submit.prevent="handlelogin">
              <div class="form-group">
                <input type="email" class="form-control" :class="{ 'is-invalid': submit && $v.logg.email.$error }"  placeholder="Email Address" v-model="logg.email"/>
                <div v-if="submit && !$v.logg.email.required" class="invalid-feedback text-danger">Email is required</div>
              </div>
              
              <div class="form-group">
              <input type="password" class="form-control" :class="{ 'is-invalid': submit && $v.logg.password.$error }"   placeholder="Password" v-model="logg.password" />
              <div v-if="submit && !$v.logg.email.required" class="invalid-feedback text-danger">Password is required</div>
              </div>

              <span>
                <input type="checkbox" class="checkbox" />
                Keep me signed in
              </span>
              <button type="submit" class="btn btn-default">Login</button>
            </form>
            
            
          </div>
          <!--/login form-->
        </div>
        <div class="col-sm-1">
          <h2 class="or">OR</h2>
        </div>
        
        <div class="col-sm-4">

          <div class="signup-form">
            <!--sign up form-->
            <h2>New User Signup!</h2>
            <form @submit.prevent="handleRegister">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="First Name" v-model="user.ufname"/>
                <div v-if="submitted && !$v.user.ufname.required" class="invalid-feedback text-danger">First Name is required</div>
              </div>  
              <div class="form-group">
                <input type="text" placeholder="Last Name" v-model="user.ulname"/>  
                <div v-if="submitted && !$v.user.ulname.required" class="invalid-feedback text-danger">Last Name is required</div>
              </div>       
              
              <div class="form-group">
                <input type="email" placeholder="Email Address" v-model="user.uemail"/>
                <div v-if="submitted && !$v.user.uemail.required" class="invalid-feedback text-danger">Email is required</div>
              </div>
              
              <div>
                <input type="password" placeholder="Password" v-model="user.upassword"/>
                <div v-if="submitted && !$v.user.upassword.required" class="invalid-feedback text-danger">Password is required</div>
              </div>

              <div>
                <input type="password" placeholder="Confirm Password" v-model="user.ucpassword"/>
                <div v-if="submitted && !$v.user.ucpassword.required" class="invalid-feedback text-danger">Confirm is required</div>
                <div v-if="submitted && !$v.user.ucpassword.sameAsupassword" class="invalid-feedback text-danger">Confirm not match</div>
              </div>
              
              <button type="submit" class="btn btn-default">Register</button>
              <div v-if="loading" class="spiner-border spiner-border-sm"><h2><i class="fa fa-spiner"></i>Please Wait...</h2></div>
            </form>
          </div>
          <!--/sign up form-->
        </div>
      </div>
    </div>
  </section>
  <!--/form-->
</template>

<script>
import {userLogin} from '@/common/Service';
import {userRegister} from '@/common/Service';
import {saveToken} from '@/common/Jwttoken';
import { required, email, sameAs } from "vuelidate/lib/validators";


export default {
  name: "Login",
  data(){
    return{
      loading: false,
      user:{
        ufname: "",
        ulname: "",
        uemail: "",
        upassword: "",
        ucpassword: "",        
      },
      submit:false,
      logg:{
        email: "",
        password: "",
      },
       submitted: false,
       useremail:null,
    };
  },
  validations:{
    user:{
        ufname: { required },
        ulname: { required},
        uemail: { required , email},
        upassword: { required},
        ucpassword: { required , sameAsupassword: sameAs("upassword")},        
      },
      logg:{
        email: {required , email},
        password: {required},
      }
  },
  methods:{
    handlelogin(){
      this.submit = true;
        // stop here if form is invalid
        this.$v.logg.$touch();
        if (this.$v.logg.$invalid) {
            return;
        }else{
          let formData={email:this.logg.email,password:this.logg.password};
          //console.log(formData);
          userLogin(formData)
          .then(res=>{
              if(res.data.access_token==true){
                  saveToken(res.data.access_token);
                  this.useremail=res.data.user.email;
                  localStorage.setItem('useremail',this.useremail);
                  localStorage.setItem('userId',res.data.user.id);
                  this.$swal('Successfully Logged In !','Welcome Shop now ','success').then(()=>{
                    this.$router.push('/');
                    window.location.reload()
                  });
              }
              if(res.data.access_token==false){
                  this.$swal("Invalid User",'Something went Wrong','error');
              }
          })
          .catch(err=>{
              this.$swal("Unauthorized User",'Please try again later','error')
              console.log("Something Wrong "+err)
          })
          
        }
    },
    handleRegister(){
      this.submitted = true;
        // stop here if form is invalid
        this.$v.user.$touch();
        if (this.$v.user.$invalid) {
            return;
        }else{
            this.loading = true
            let formData={ufname:this.user.ufname,ulname:this.user.ulname,uemail:this.user.uemail,upassword:this.user.upassword,ucpassword:this.user.ucpassword};
            userRegister(formData)
            .then(res=>{
              if(res){
                this.$swal('User Registered Successfully ! Please Login to continue','','success').then(()=>{
                    window.location.reload()
                  });
              }
              if(res.data.err==1){
                      this.$swal(res.data.message,'','error')
                  }
            })
            .finally(() => (this.loading = false))
          }
    }
  }
};
</script>

<style>
</style>