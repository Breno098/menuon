<script setup>
  import { useShopingCart } from '~/stores/useShopingCart';
  import { useAuthStore } from '~/stores/useAuthStore';

  const shopingCart = useShopingCart();
  const auth = useAuthStore();

  const products = computed(() => shopingCart.products)

  const step = ref(1);

  const address = ref({
    cep: null,
    street: null,
    number: null,
    district: null,
    complement: null,
    city: null,
    state: null,
  });

  const CEPisValidated = ref(false)
1
  const disableFields = computed(() => !CEPisValidated.value)

  function checkCEP() {
    
  }

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
      flat
    >
      <q-step
        :name="1"
        title="Pedido"
        icon="receipt_long"
        :done="step > 1"
      >
        <q-card 
          v-for="product in products" 
          :key="product.id"
          flat
        >
          <q-card-section>
              <div class="text-h6 text-weight-bolder">
                  {{ product.count }} un. {{ product.product.name }}
              </div>

              <div class="text-caption text-grey-10"  v-if="product.additional.length">
                  Adicionais: {{ product.additional.map(add => `+${add.count} ${add.name}`).join(' | ') }}
              </div>

              <div class="text-caption text-grey-9">
                  Total: R$ {{ product.totalPrice }}
              </div>
          </q-card-section>
        </q-card>
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
                  dense
                  mask="##.###-###"
              >
                <template v-slot:append>
                  <q-spinner
                    color="primary"
                    size="xs"
                  />
                </template>
              </q-input>
          </div>

          <div class="col-12 col-md-6">
              <q-input
                  outlined
                  v-model="address.street"
                  label="Rua"
                  dense
                  :disable="disableFields"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-2">
              <q-input
                  outlined
                  v-model="address.number"
                  label="Número"
                  dense
                  :disable="disableFields"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-4">
              <q-input
                  outlined
                  v-model="address.district"
                  label="Bairro"
                  dense
                  :disable="disableFields"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-4">
              <q-input
                  outlined
                  v-model="address.city"
                  label="Cidade"
                  dense
                  :disable="disableFields"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-4">
              <q-input
                  outlined
                  v-model="address.state"
                  label="UF"
                  maxlength="2"
                  dense
                  :disable="disableFields"
              >
              </q-input>
          </div>

          <div class="col-12 col-md-8">
              <q-input
                  outlined
                  v-model="address.complement"
                  label="Complemento"
                  dense
                  :disable="disableFields"
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
    </q-stepper>

    <q-footer class="transparent text-black">
      <q-card flat>
        <q-card-actions class="row">
            <q-btn 
              v-if="step > 1" 
              flat 
              color="primary" 
              @click="$refs.stepper.previous()" 
              label="Voltar" 
              class="col-3" 
            />

            <q-btn 
                v-if="step === 1"
                @click="$refs.stepper.next()" 
                color="black"
                class="col"
                no-caps
            >
                <q-icon name="check" size="xs" class="q-mr-xs"/>
                
                Adicionar endereço
            </q-btn>

            <q-btn 
                v-if="step === 2"
                @click="$refs.stepper.next()" 
                color="black"
                class="col"
                no-caps
                :disable="disableFields"
            >
                <q-icon name="location_on" size="xs" class="q-mr-xs"/>
                
                Confirmar endereço de entrega
            </q-btn>
        </q-card-actions>
      </q-card>
    </q-footer> 

    
 
  </div>
</template>
