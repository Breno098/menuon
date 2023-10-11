<script setup>
    definePageMeta({
        layout: 'customer-default'
    })

    const { id } = useRoute().params

    const { data } = await useApiCustomer(`/food_sessions/${id}`);
</script>

<template>
    <div>
        <q-card-section class="q-gutter-md">
            <product-session 
                v-for="product in data.food_session?.products" 
                :key="product.id"
                :product="product"
            />
        </q-card-section>
    </div>
</template>