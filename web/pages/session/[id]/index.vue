<script setup>
    const { id } = useRoute().params

    const { data } = await useApiCustomer(`/food_sessions/${id}`);

    function show(product) {
        navigateTo(`/session/${id}/product/${product.id}`)
    }
</script>

<template>
    <div>
        <q-card-section class="q-gutter-md">
            <product-session 
                v-for="product in data.food_session?.products" 
                :key="product.id"
                :product="product"
                @click="show(product)"
            />
        </q-card-section>
    </div>
</template>