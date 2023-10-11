<script setup>
  definePageMeta({
    layout: 'customer-default'
  })

  import { useShopingCart } from '~/stores/useShopingCart';

  const shopingCart = useShopingCart();

  const products = computed(() => shopingCart.products)
</script>

<template>
  <div>
    <div class="row q-col-gutter-lg">
      <div
        class="col-12 cursor-pointer"
        v-for="product in products" 
        :key="product.id"
      >
        <q-card 
          flat
          class="row"
        >
            <div class="text-h5 q-mr-sm">
              {{ product.count }} un. {{ product.product.name }}
            </div>
            <div class="text-h6 q-mr-sm" v-if="product.additional.length">
              -- Add.: {{ product.additional.map(add => `+${add.count} ${add.name}`).join(' | ') }}
            </div>
            <div class="text-h6">
              -- Total: R$ {{ product.totalPrice }}
            </div>
        </q-card>
      </div>
    </div>
 
  </div>
</template>
