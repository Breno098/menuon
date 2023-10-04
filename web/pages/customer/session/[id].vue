<script setup>
    definePageMeta({
        layout: 'customer-default'
    })
    
    const { id } = useRoute().params

    const { data } = await useApiCustomer(`/food_sessions/${id}`);

    const totalPrice = computed(() => 10)

    function addToShoppingCart(product) {
        alert('TODO');
    }
</script>

<template>
    <div>
        <q-card-section class="q-gutter-md">
            <q-card 
                v-for="product in data.food_session?.products" 
                :key="product.id"
            >
                <q-card-section class="text-h6">
                    {{ product.name }}
                </q-card-section>

                <q-card-section>
                    <div class="text-h6 q-mb-md">
                        Adicionais
                    </div>

                    <div 
                        v-for="additional in product.additional"
                        :key="additional.id"
                    >
                        {{  additional.name  }}
                        R$ {{  additional.price  }}
                    </div>
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