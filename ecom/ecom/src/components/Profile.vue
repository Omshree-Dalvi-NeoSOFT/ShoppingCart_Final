<template>
  <div class="container">
      <h1>My Profile</h1>
      <table class="table table-dark">
  <thead>
    <tr>
      <th scope="col">First Name</th>
      <th scope="col">Last Name</th>
      <th scope="col">Email ID</th>
      <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>{{first_name}}</td>
      <td>{{lastName}}</td>
      <td>{{email}}</td>
      <td><router-link to="/changepassword" class="btn btn-default">Change Password</router-link></td>
      <td><router-link to="/profileedit" class="btn btn-default">Edit Profile</router-link></td>
    </tr>
  </tbody>
</table>
  </div>
</template>

<script>
import {profile} from '@/common/Service';
export default {
name:"Profile",
 data() {
    return {
        first_name: "",
        last_name: "",
        email: "",
    }
 },
 mounted(){
     profile().then(res=>{
         this.first_name=res.data.profile.firstname;
         this.lastName=res.data.profile.lastname;
         this.email=res.data.profile.email;
         console.log(res.data.profile);
     })
        .catch(error=>{
            console.log("Something Wrong "+error)
        })
 }

};
</script>

<style>

</style>