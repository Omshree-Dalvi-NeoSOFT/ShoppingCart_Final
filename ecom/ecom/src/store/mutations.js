export const SET_PRODUCT = (state , product) => {
    state.product = product;
}
export const SET_PRODUCTDETAIL = (state , productdetail) => {
    state.productdetail = productdetail;
}
export const ADD_TO_CART = (state , id) =>{
    state.inCart.push(id)
}
export const DEL_ITEM = (state, id) =>{
    state.inCart.splice(id, 1)
}
