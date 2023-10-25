<script setup>
  definePageMeta({
    middleware: ['auth'],
  })

  import { useShopingCart } from '~/stores/useShopingCart';

  const shopingCart = useShopingCart();

  const { data } = await useApiCustomer('/food_sessions');

  const countProductsInCart = computed(() => shopingCart.products.length)

  function showSession(session) {
    navigateTo(`/session/${session.id}`)
  }

  function showShoppingCard() {
    navigateTo(`/my-cart`)
  }

  function showOrders() {
    navigateTo(`/my-orders`)
  }
  
</script>

<template>
  <div>
    <div class="row q-col-gutter-md q-pa-md">
      <div
        class="col-6 cursor-pointer"
        v-for="session in data.food_sessions" 
        :key="session.id"
      >
        <q-card 
          flat
          @click="showSession(session)"
        >
          <q-img 
            :src="session.image"
            height="200px"
          >
            <div class="absolute-bottom text-center">
              <div class="text-bold text-uppercase">{{ session.title }}</div>
            </div>
          </q-img>
        </q-card>
      </div>
    </div>

    <q-footer class="transparent text-black">
      <q-card flat>
        <q-card-actions>
            <q-btn 
                v-if="countProductsInCart"
                color="black"
                class="fit"
                no-caps
                @click="showShoppingCard"
            >
              <q-badge color="orange" floating>
                {{ countProductsInCart }}
              </q-badge>

                <q-icon name="shopping_cart" size="sm" class="q-mr-sm"/>
                
                Concluir pedido
            </q-btn>
        </q-card-actions>

        <q-card-actions>
            <q-btn 
                color="black"
                no-caps
                @click="showOrders"
            >
                <q-icon name="file_copy" size="sm" class="q-mr-sm"/>
                
                Meus pedidos
            </q-btn>
        </q-card-actions>
      </q-card>
    </q-footer> 
  </div>
</template>
