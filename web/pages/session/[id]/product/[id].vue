<script setup>
    import { useShopingCart } from '~/stores/useShopingCart';

    const shopingCart = useShopingCart();

    const { id } = useRoute().params

    const { data: product } = await useApiCustomer(`/product/${id}`);

    const mainProductCount = ref(1);

    const notes = ref(null);

    const additional = ref(
        product.value.additional.map(add => {
            add.count = 0;
            return add;
        })
    )

    const totalPrice = computed(() => {
        let total = product.value.price;
        
        additional.value.forEach(add => total += add.price * add.count);

        total *= mainProductCount.value;

        return total.toFixed(2);
    })


    function addToShoppingCart() {
        const addParse = additional.value.filter(add => add.count > 0);

        const parseToShoppingCart = {
            product: product.value,
            count: mainProductCount.value,
            additional: addParse,
            notes: notes.value,
            totalPrice: totalPrice.value
        };

        shopingCart.addProduct(parseToShoppingCart)

        // mainProductCount.value = 0;
        // additional.value.map(add => {
        //     add.count = 0;
        //     return add;
        // });
    }

    function decrementMainProduct() {
        mainProductCount.value--;
    }

    function incrementMainProduct() {
        mainProductCount.value++;
    }

    function decrementAddition(additional) {
        additional.count--;
    }

    function incrementAddition(additional) {
        additional.count++;
    }

    const wallpaper = computed(() => product.value?.images[0].path)
</script>

<template>
    <div>
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

            <q-expansion-item
                v-if="additional.length > 0"
                expand-separator
                label="Adicionais"
            >
                <q-card>
                    <q-card-section>
                        <q-list separator>
                            <q-item v-for="additionalOne in additional">
                                <q-item-section>
                                    <q-item-label>{{  additionalOne.name  }}</q-item-label>
                                    <q-item-label caption>
                                        R$ {{  additionalOne.price  }}
                                    </q-item-label>
                                </q-item-section>

                                <q-item-section side >
                                    <q-btn-group flat>
                                        <q-btn 
                                            @click="decrementAddition(additionalOne)"
                                            icon="remove" 
                                            flat 
                                            :disabled="additionalOne.count === 0"
                                            size="sm"
                                            padding="5px"
                                        />

                                        <q-btn :label="additionalOne.count" flat size="sm"/>

                                        <q-btn 
                                            @click="incrementAddition(additionalOne)"
                                            icon="add" 
                                            flat 
                                            size="sm"
                                            padding="5px"
                                        />
                                    </q-btn-group>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </q-card-section>
                </q-card>
            </q-expansion-item>

            <q-card-section>
                <q-input
                    v-model="notes"
                    outlined
                    autogrow
                    placeholder="Observações (tirar cebola por exemplo)"
                    dense
                />
            </q-card-section>

            <q-card-section class="row justify-between items-center">
                <div class="text-weight-bolder">
                    R$ {{ totalPrice }}
                </div>

                <q-btn-group flat>
                    <q-btn 
                        @click="decrementMainProduct"
                        icon="remove" 
                        :disabled="mainProductCount <= 1"
                        size="sm"
                        flat
                        padding="5px"
                    />

                    <q-btn :label="mainProductCount" flat size="sm"/>

                    <q-btn 
                        @click="incrementMainProduct"
                        icon="add" 
                        size="sm"
                        flat 
                        padding="5px"
                    />
                </q-btn-group>
            </q-card-section>

            <q-card-actions>
                <q-btn 
                    @click="addToShoppingCart"
                    color="black"
                    class="fit"
                    no-caps
                >
                    <q-icon name="add_shopping_cart" size="sm" class="q-mr-sm"/>
                    
                    Adicionar ao carrinho
                </q-btn>
            </q-card-actions>
        </q-card>
    </div>
</template>