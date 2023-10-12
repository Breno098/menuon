<script setup>
  definePageMeta({
    layout: 'customer-default'
  })

  import { useShopingCart } from '~/stores/useShopingCart';
  import { useAuthStore } from '~/stores/useAuthStore';

  const shopingCart = useShopingCart();
  const auth = useAuthStore();

  const products = computed(() => shopingCart.products)

  const step = ref(1);

  const labelBtn = computed(() => {
    if (step.value === 1) {
      return 'Fazer pedido'
    }

    return 'Continuar';
  })

  const address = ref({
    cep: null,
    street: null,
    number: null,
    district: null,
    complement: null,
    city: null,
    state: null,
    country: null,
  });


  function finishOrder() {
    // if (! auth.isLoggedIn) {
    //   return alert('Modal de LOGIN');
    // }

    alert('Send to API');
  }
</script>

<template>
  <div>
    <q-stepper
      v-model="step"
      ref="stepper"
      color="primary"
      animated
    >
      <q-step
        :name="1"
        title="Pedido"
        icon="receipt_long"
        :done="step > 1"
      >
        <div class="row q-col-gutter-lg">
          <div
            class="col-12 cursor-pointer"
            v-for="product in products" 
            :key="product.id"
          >
            <q-card flat>
                <q-card-section class="row">
                  <div class="text-h5 q-mr-sm">
                    {{ product.count }} un. {{ product.product.name }}
                  </div>
                  <div class="text-h6 q-mr-sm" v-if="product.additional.length">
                    -- Add.: {{ product.additional.map(add => `+${add.count} ${add.name}`).join(' | ') }}
                  </div>
                  <div class="text-h6">
                    -- Total: R$ {{ product.totalPrice }}
                  </div>
                </q-card-section>
            </q-card>
          </div>
        </div>
      </q-step>

      <q-step
        :name="2"
        title="Entrega"
        icon="location_on"
        :done="step > 2"
      >
        <div class="row q-col-gutter-md">
          <div class="col-12 col-md-4">
              <q-input
                  outlined
                  v-model="address.cep"
                  label="CEP"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-6">
              <q-input
                  outlined
                  v-model="address.street"
                  label="Rua"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-2">
              <q-input
                  outlined
                  v-model="address.number"
                  label="Número"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-4">
              <q-input
                  outlined
                  v-model="address.district"
                  label="Bairro"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-4">
              <q-input
                  outlined
                  v-model="address.city"
                  label="Cidade"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-4">
              <q-input
                  outlined
                  v-model="address.state"
                  label="UF"
                  maxlength="2"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-8">
              <q-input
                  outlined
                  v-model="address.complement"
                  label="Complemento"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-4">
              <q-input
                  outlined
                  v-model="address.country"
                  label="País"
              >
              </q-input>
          </div>
        </div>
      </q-step>

      <q-step
        :name="3"
        title="Pagamento"
        icon="credit_card"
      >
        This step won't show up because it is disabled.
      </q-step>

      <template v-slot:navigation>
        <q-stepper-navigation>
          <q-btn 
            @click="$refs.stepper.next()" 
            color="primary" 
            :label="labelBtn" 
          />

          <q-btn 
            v-if="step > 1" 
            flat 
            color="primary" 
            @click="$refs.stepper.previous()" 
            label="Voltar" 
            class="q-ml-sm" 
          />
        </q-stepper-navigation>
      </template>
    </q-stepper>

    
 
  </div>
</template>
