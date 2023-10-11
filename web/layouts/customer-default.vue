<script lang="ts" setup>
  import { useAuthStore } from '~/stores/useAuthStore';
  import { useShopingCart } from '~/stores/useShopingCart';

  const auth = useAuthStore();
  const shopingCart = useShopingCart();

  async function handleLogout() {
    await auth.logout();
  }

  const userName = computed(() => auth.user ? auth.user.name : null);

  const countProductsInCard = computed(() => shopingCart.products.length)

  function showShoppingCard() {
    alert('TODO navigate to shopping cart')
  }
</script>

<template>
   <q-layout view="lhh lpR lFf">
    <q-header class="bg-green">
      <q-toolbar>
        <q-toolbar-title class="text-black row items-center">
          MenuOn
        </q-toolbar-title>

        {{ userName }}

        <q-btn round dense flat @click="handleLogout">
          <q-icon name="logout" color="black" size="xs"/>
          <q-tooltip>Sair</q-tooltip>
        </q-btn>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <q-page>
        <slot />
      </q-page>
    </q-page-container>

    <q-footer 
      bordered 
      class="transparent text-black q-px-lg q-py-md flex justify-end"
    >
        <q-btn 
          round  
          icon="shopping_cart"
          @click="showShoppingCard"
        >
          <q-badge color="orange" floating>
            {{ countProductsInCard }}
          </q-badge>
        </q-btn>
    </q-footer>
   </q-layout>
</template>
