export default {
    product: null,
    productdetail:null,
    inCart: JSON.parse(localStorage.getItem('mycart')) ? JSON.parse(localStorage.getItem('mycart')) : []
}