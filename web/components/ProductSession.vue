<script setup>
    const props = defineProps({
        product: Object
    });

    const wallpaper = computed(() => props.product?.images[0].path)
</script>

<template>
    <q-card>
        <q-img :src="wallpaper"/>

        <q-card-section>
            <div class="text-h6 text-weight-bolder q-mb-sm">
                {{ product.name }}
            </div>

            <div class="text-caption text-grey-9">
                {{ product.description }}
            </div>
        </q-card-section>
    </q-card>
</template>

