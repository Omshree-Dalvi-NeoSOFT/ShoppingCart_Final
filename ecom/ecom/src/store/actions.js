import axios from 'axios'
export const getProduct = ({ commit}, productId) =>{
    axios.get(`http://127.0.0.1:8000/api/subcatproducts/${productId}`)
    .then(res => {
        commit('SET_PRODUCT',res.data);
    })
}
export const getProductDetail = ({ commit}, productId) =>{
    axios.get(`http://127.0.0.1:8000/api/productsdetail/${productId}`)
    .then(res => {
        commit('SET_PRODUCTDETAIL',res.data);
    })
}

export const addToCart = (context, id)=>{
      context.commit('ADD_TO_CART', id) 
    }

export const remItem = (context, id) => {
     context.commit('DEL_ITEM', id) 
    }