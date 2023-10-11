import { defineStore } from 'pinia';

export const useShopingCart = defineStore('shoping_cart', () => {
    const products = ref([]);

    function addProduct(product) {
      products.value.push(product);
    }

    function popProduct(productId) {
    }

    return { products, addProduct, popProduct };
  })