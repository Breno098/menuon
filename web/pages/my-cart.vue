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

  const CEPIsValidated = ref(false)
  const CEPIsnotValidated = computed(() => !CEPIsValidated.value)

  const addressIsNotCompleted = computed(() => CEPIsnotValidated.value || !address.value.number)

  async function checkCEP() {
    const cep = address.value.cep.replace(/\D/g, '');

    if (cep.length < 8) {
      CEPIsValidated.value = false;

      address.value.street = null;
      address.value.number = null;
      address.value.district = null;
      address.value.complement = null;
      address.value.city = null;
      address.value.state = null;

      return;
    }

    const url = `https://viacep.com.br/ws/${cep}/json`;

    const { data } = await useFetch(url)

    if (! data.value) {
      return;
    }

    CEPIsValidated.value = true;

    address.value.street = data.value.logradouro;
    address.value.district = data.value.bairro;
    address.value.complement = data.value.complemento;
    address.value.city = data.value.localidade;
    address.value.state = data.value.uf;
  }

  const paymentMethod = ref(null)

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
        <q-card flat>
          <q-card-section>
            <div class="row q-col-gutter-md">
              <div class="col-12 text-h6 text-weight-bolder">
                Endereço de entrega
              </div>

              <div class="col-12 col-md-4">
                  <q-input
                      outlined
                      v-model="address.cep"
                      label="CEP"
                      dense
                      mask="##.###-###"
                      @update:model-value="checkCEP"
                  >
                    <template v-slot:append>
                      <q-icon
                        name="check"
                        size="sm"
                        color="green"
                        v-if="CEPIsValidated"
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
                      :disable="CEPIsnotValidated"
                  >
                  </q-input>
              </div>

              <div class="col-12 col-md-2">
                  <q-input
                      outlined
                      v-model="address.number"
                      label="Número"
                      dense
                      :disable="CEPIsnotValidated"
                  >
                  </q-input>
              </div>

              <div class="col-12 col-md-4">
                  <q-input
                      outlined
                      v-model="address.district"
                      label="Bairro"
                      dense
                      :disable="CEPIsnotValidated"
                  >
                  </q-input>
              </div>

              <div class="col-12 col-md-4">
                  <q-input
                      outlined
                      v-model="address.city"
                      label="Cidade"
                      dense
                      :disable="CEPIsnotValidated"
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
                      :disable="CEPIsnotValidated"
                  >
                  </q-input>
              </div>

              <div class="col-12 col-md-8">
                  <q-input
                      outlined
                      v-model="address.complement"
                      label="Complemento"
                      dense
                      :disable="CEPIsnotValidated"
                  >
                  </q-input>
              </div>
            </div>
          </q-card-section>
        </q-card>
      </q-step>

      <q-step
        :name="3"
        title="Pagamento"
        icon="credit_card"
      >
        <q-card flat>
            <q-card-section>
              <div class="text-h6 text-weight-bolder">
                  Forma de pagamento
              </div>

              <q-list>
                <q-item tag="label" v-ripple>
                  <q-item-section avatar>
                    <q-radio 
                      v-model="paymentMethod" 
                      val="cash" 
                      color="green" 
                      checked-icon="task_alt"
                    />
                  </q-item-section>

                  <q-item-section>
                    <q-item-label>Dinheiro</q-item-label>
                  </q-item-section>
                </q-item>

                <q-item tag="label" v-ripple>
                  <q-item-section avatar>
                    <q-radio 
                      v-model="paymentMethod" 
                      val="credit_card" 
                      color="green" 
                      checked-icon="task_alt"
                    />
                  </q-item-section>
                  
                  <q-item-section>
                    <q-item-label>Cartão de crédito/débito</q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>

            </q-card-section>
        </q-card>
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
                :disable="addressIsNotCompleted"
            >
                <q-icon name="location_on" size="xs" class="q-mr-xs"/>
                
                Confirmar endereço de entrega
            </q-btn>
        </q-card-actions>
      </q-card>
    </q-footer> 
  </div>
</template>
