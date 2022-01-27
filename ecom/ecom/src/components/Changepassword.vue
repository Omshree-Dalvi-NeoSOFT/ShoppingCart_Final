<template>
  <div class="" id="app">
    <div class="container">
      <div class="row">
        <div class="col-sm-8 offset-sm-2">
          <div>
            <h2>Change password</h2>
            <form @submit.prevent="handleSubmit">
                <div class="form-group">
                <label for="oldPassword">Old Password</label>
                <input
                  type="password"
                  v-model="user.oldPassword"
                  id="oldPassword"
                  name="oldPassword"
                  class="form-control"
                  :class="{
                    'is-invalid': submitted && $v.user.oldPassword.$error,
                  }"
                />
                <div
                  v-if="submitted && $v.user.oldPassword.$error"
                  class="invalid-feedback"
                >
                  <span v-if="!$v.user.oldPassword.required"
                    >Password is required</span
                  >
                  <span v-if="!$v.user.oldPassword.minLength"
                    >Password must be at least 6 characters</span
                  >
                </div>
              </div>
              
              <div class="form-group">
                <label for="newPassword">New Password</label>
                <input
                  type="password"
                  v-model="user.newPassword"
                  id="newPassword"
                  name="newPassword"
                  class="form-control"
                  :class="{
                    'is-invalid': submitted && $v.user.newPassword.$error,
                  }"
                />
                <div
                  v-if="submitted && $v.user.newPassword.$error"
                  class="invalid-feedback"
                >
                  <span v-if="!$v.user.newPassword.required"
                    >Password is required</span
                  >
                  <span v-if="!$v.user.newPassword.minLength"
                    >Password must be at least 6 characters</span
                  >
                </div>
              </div>
              <div class="form-group">
                <label for="confirmPassword">Confirm Password</label>
                <input
                  type="password"
                  v-model="user.confirmPassword"
                  id="confirmPassword"
                  name="confirmPassword"
                  class="form-control"
                  :class="{
                    'is-invalid': submitted && $v.user.confirmPassword.$error,
                  }"
                />
                <div
                  v-if="submitted && $v.user.confirmPassword.$error"
                  class="invalid-feedback"
                >
                  <span v-if="!$v.user.confirmPassword.required"
                    >Confirm Password is required</span
                  >
                  <span v-else-if="!$v.user.confirmPassword.sameAsPassword"
                    >Passwords must match</span
                  >
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-primary">Change Password</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
      </div>
  
</template>

<script>
import { required,minLength, sameAs } from "vuelidate/lib/validators";
import {removeToken} from '@/common/Jwttoken';
 import {changePassword} from '@/common/Service';
export default {
  name: "Changepassword",

  data() {
    return {
      user: {
        oldPassword:"",
        newPassword: "",
        confirmPassword: "",
      },
      submitted: false,
    };
  },
  validations: {
    user: {
      oldPassword: { required, minLength: minLength(6)},
      newPassword: { required, minLength: minLength(6) },
      confirmPassword: { required, sameAsPassword: sameAs("newPassword") },
    },
  },
  methods: {
    handleSubmit() {
      this.submitted = true;
      let uemail = localStorage.getItem('useremail');
         let formData={email:uemail,old_password:this.user.oldPassword,new_password:this.user.newPassword,confirm_password:this.user.confirmPassword};

      // stop here if form is invalid
      this.$v.$touch();
      if (this.$v.$invalid) {
        return;
      }
        changePassword(formData)
      .then(res=>{
             if(res.data.status==1){
               this.$swal("Password Changed",'Please Login Again','info')
               .then(
                  localStorage.removeItem('useremail'),
                  localStorage.removeItem('userId'),
                  removeToken(),
                  window.location.reload(),
                  this.$route.push("/")
               )
            }
            else{
               this.$swal("old password does not match",'Please Try Again Later','error')  
                console.log(res.data);
            }
        })
        .catch(error=>{
            console.log("Something Wrong "+error)
        })
    },
     
  },
};
</script>
 
<style>
</style>
