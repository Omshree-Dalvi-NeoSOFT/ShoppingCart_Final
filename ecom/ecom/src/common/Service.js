import axios from 'axios';
import { MAIN_URL } from '@/common/Url';
export function userLogin(data)
{
    return axios.post(`${MAIN_URL}login`,data)
}
export function userRegister(data)
{
    return axios.post(`${MAIN_URL}register`,data)
}
export function contactUs(data){
    return axios.post(`${MAIN_URL}contactus`,data)
}
export function changePassword(data)
{
    var token = localStorage.getItem('access_token');
    return axios.post(`${MAIN_URL}changepass`,data, { headers: { "Authorization": `Bearer ${token}` } })
}
export function profile()
{
    var token = localStorage.getItem('access_token');
    var uemail = localStorage.getItem('useremail');
    return axios.get(`${MAIN_URL}profile/`+uemail, { headers: { "Authorization": `Bearer ${token}` } })
}
export function profiledit(data)
{
    var token = localStorage.getItem('access_token');
    return axios.post(`${MAIN_URL}updateprofile`,data, { headers: { "Authorization": `Bearer ${token}` } })
}

export function servicesCMS(){
    return axios.get(`${MAIN_URL}services`);
}

export function userCheckout(data){
    var token = localStorage.getItem('access_token');
    return axios.post(`${MAIN_URL}checkout`,data,{ headers: { "Authorization": `Bearer ${token}` } });
}

export function addToWish(data){
    return axios.post(`${MAIN_URL}addwish`,data);
}

export function getWish(){
    let userId = localStorage.getItem('userId');
    return axios.get(`${MAIN_URL}getwish/`+userId);
}

export function removeWish(id){
    return axios.get(`${MAIN_URL}delwish/`+id);
}

export function newsLetter(data){
    return axios.post(`${MAIN_URL}newsletter`,data)
}
export default {userLogin,userRegister,contactUs,changePassword,profile,profiledit,servicesCMS,userCheckout,addToWish,getWish,removeWish,newsLetter};