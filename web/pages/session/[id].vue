<script setup>
    definePageMeta({
        layout: 'customer-default'
    })

    import { useShopingCart } from '~/stores/useShopingCart';

    const shopingCart = useShopingCart();
    
    const { id } = useRoute().params

    const { data } = await useApiCustomer(`/food_sessions/${id}`);

    const totalPrice = computed(() => 10)

    function addToShoppingCart(product) {
        shopingCart.addProduct(product)
    }
</script>

<template>
    <div>
        <q-card-section class="q-gutter-md">
            <q-card 
                v-for="product in data.food_session?.products" 
                :key="product.id"
            >
                <q-card-section>
                    <div class="text-h6">
                        {{ product.name }}
                    </div>

                    <q-list bordered separator>
                        <q-item-label header>Adicionais</q-item-label>

                        <q-item 
                            clickable 
                            v-ripple  
                            v-for="additional in product.additional"
                            class="bg-grey-3"
                        >
                            <q-item-section>
                                <q-item-label>{{  additional.name  }}</q-item-label>
                                <q-item-label caption>
                                    R$ {{  additional.price  }}
                                </q-item-label>
                            </q-item-section>

                            <q-item-section side >
                                <q-btn-group outline>
                                    <q-btn icon="delete" outline/>

                                    <q-btn label="0" outline/>

                                    <q-btn icon="add" outline/>
                                </q-btn-group>
                            </q-item-section>
                        </q-item>
                    </q-list>
                </q-card-section>

                <q-card-section>
                    Total: R$ {{ totalPrice }}
                </q-card-section>

                <q-card-actions>
                    <q-btn 
                        color="green"
                        @click="addToShoppingCart(product)"
                    >
                        Adicionar ao carrinho
                    </q-btn>
                </q-card-actions>
            </q-card>
        </q-card-section>
    </div>
</template>