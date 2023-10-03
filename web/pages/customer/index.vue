<script setup>
  definePageMeta({
    layout: 'customer-default'
  })

  const products = ref([]);
  
  async function getProducts() {
    const { data } = await useApiCustomer('/products');

    products.value = data.value.products;
  }
  
</script>

<template>
  <div>
    <div v-for="product in products" :key="product.id">
      {{ product.name }}
    </div>

    <q-btn
        color="blue"
        label="getProducts"
        @click="getProducts"
        class="full-width"
        no-caps
    />
  </div>
</template>

<style scoped></style>
