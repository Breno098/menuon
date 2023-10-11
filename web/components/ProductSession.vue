<script setup>
    import { useShopingCart } from '~/stores/useShopingCart';

    const shopingCart = useShopingCart();

    const props = defineProps({
        product: Object
    });


    const mainProductCount = ref(0);

    const additional = ref(
        props.product.additional.map(add => {
            add.count = 0;
            return add;
        })
    )

    const totalPrice = computed(() => {
        let total = props.product.price;
        
        additional.value.forEach(add => total += add.price * add.count);

        total *= mainProductCount.value;

        return total.toFixed(2);
    })


    function addToShoppingCart() {
        const addParse = additional.value.filter(add => add.count > 0);

        const parseToShoppingCart = {
            product: props.product,
            count: mainProductCount.value,
            additional: addParse,
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
</script>

<template>
    <q-card>
        <q-card-section>
            <div class="text-h6">
                {{ product.name }} - (R$ {{ product.price }})
            </div>

            <q-btn-group outline>
                <q-btn 
                    @click="decrementMainProduct"
                    icon="remove" 
                    outline 
                    :disabled="mainProductCount === 0"
                />

                <q-btn :label="mainProductCount" outline/>

                <q-btn 
                    @click="incrementMainProduct"
                    icon="add" 
                    outline 
                />
            </q-btn-group>

            <q-list bordered separator>
                <q-item-label header>Adicionais</q-item-label>

                <q-item 
                    clickable 
                    v-ripple  
                    v-for="additionalOne in additional"
                    class="bg-grey-3"
                >
                    <q-item-section>
                        <q-item-label>{{  additionalOne.name  }}</q-item-label>
                        <q-item-label caption>
                            R$ {{  additionalOne.price  }}
                        </q-item-label>
                    </q-item-section>

                    <q-item-section side >
                        <q-btn-group outline>
                            <q-btn 
                                @click="decrementAddition(additionalOne)"
                                icon="remove" 
                                outline 
                                :disabled="additionalOne.count === 0"
                            />

                            <q-btn :label="additionalOne.count" outline/>

                            <q-btn 
                                @click="incrementAddition(additionalOne)"
                                icon="add" 
                                outline 
                            />
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
                @click="addToShoppingCart"
                color="green"
            >
                Adicionar ao carrinho
            </q-btn>
        </q-card-actions>
    </q-card>
</template>

