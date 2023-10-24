<script setup>
  import { useShopingCart } from '~/stores/useShopingCart';
  import { useAuthStore } from '~/stores/useAuthStore';

  const shopingCart = useShopingCart();
  const auth = useAuthStore();

  const authUser = computed(() => auth.user ? auth.user : {});

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

  const personData = ref({
    name: authUser.value.name,
    cellphone: authUser.value.cellphone,
  });

  const paymentMethod = ref(null)
  const paymentMethodComputed =  computed(() => {
    switch (paymentMethod.value) {
      case 'cash': return "Dinheiro";
      case 'credit_card': return "Cartão de crédito/débito";
      default: return null
    }
  })
  const CEPIsValidated = ref(false)
  const CEPIsnotValidated = computed(() => !CEPIsValidated.value)
  const addressIsNotCompleted = computed(() => CEPIsnotValidated.value || !address.value.number)
  const cellphoneIsValidated = computed(() => personData.value.cellphone && personData.value.cellphone.replace(/\D/g, '').length === 11)
  const cannotFinish = computed(() => !personData.value.name || !cellphoneIsValidated.value || !paymentMethod.value)

  const textButtonAdrees = computed(() => {
    if (CEPIsnotValidated.value) {
      return 'Informe o CEP'
    }

    if (!address.value.number) {
      return 'Informe o número'
    }

    return 'Confirmar endereço de entrega'
  })

  const textButtonPaymentMethodAndContact = computed(() => {
    if (cannotFinish.value) {
      return 'Informe os dados para contato';
    }

    if (!paymentMethod.value) {
      return 'Adicione a forma de pagamento';
    }

    return 'Finalizar pedido'
  })

  const totalOrderPrice = computed(() => {
    let totalResult = 0;

    products.value.forEach(product => {
      totalResult += parseFloat(product.totalPrice);
    });

    return totalResult;
  })

  function changeStatusCep(valid, data = {}) {
    CEPIsValidated.value = valid  && !data.erro;

    if (CEPIsValidated.value) {
      address.value.street = data.logradouro;
      address.value.district = data.bairro;
      address.value.complement = data.complemento;
      address.value.city = data.localidade;
      address.value.state = data.uf;
    } else {
      address.value.street = null;
      address.value.number = null;
      address.value.district = null;
      address.value.complement = null;
      address.value.city = null;
      address.value.state = null;
    }
  }

  async function checkCEP() {
    const cep = address.value.cep.replace(/\D/g, '');

    if (cep.length < 8) {
      return changeStatusCep(false);
    }

    const url = `https://viacep.com.br/ws/${cep}/json`;

    const { data } = await useFetch(url)

    if (! data.value) {
      return changeStatusCep(false);
    }

    changeStatusCep(true, data.value);
  }

  const resultData = computed(() => {
    let result = {
      items: [],
      address: { ...address.value },
      paymentMethod: paymentMethod.value
    };

    products.value.forEach(prod => {
      let newProduct = {
        id: prod.product.id,
        quantity: prod.count,
        additional: prod.additional.map(add => ({
          id: add.id,
          quantity: add.count,
        }))
      };

      result.items.push(newProduct);
    });

    return result;
  });


  async function finishOrder() {
    const { data } = await useApiCustomer('/order/store', {
      method: "POST",
      body: resultData.value,
    });

    console.log(data.value);
  }
</script>

<template>
  <div>
    <pre>
      {{ resultData }}
    </pre>
    <q-stepper
      v-model="step"
      ref="stepper"
      color="primary"
      animated
      flat
      vertical
      done-color="green"
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

              <div class="col-12 col-md-2">
                  <q-input
                      outlined
                      v-model="address.number"
                      label="Número"
                      dense
                      :disable="CEPIsnotValidated"
                      mask="#####"
                  >
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
        title="Contato & Pagamento"
        icon="credit_card"
        :done="step > 3"
      >
        <q-card flat>
            <q-card-section>
              <div class="row q-col-gutter-md">
                <div class="col-12 text-h6 text-weight-bolder">
                  Contato
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="personData.name"
                        label="Como podemos te chamar?"
                        dense
                        readonly
                    >
                    </q-input>
                </div>

                <div class="col-12 col-md-6">
                    <q-input
                        outlined
                        v-model="personData.cellphone"
                        label="Celular"
                        dense
                        mask="(##) #####-####"
                    >
                    </q-input>
                </div>

                <div class="col-12 text-h6 text-weight-bolder">
                  Forma de pagamento
                </div>

                <div class="col-12 col-md-6">
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
                </div>
              </div>
            </q-card-section>
        </q-card>
      </q-step>

      <q-step
        :name="4"
        title="Resumo"
        icon="check"
        :done="step > 4"
      >
        <div class="row q-col-gutter-xs">
          <div class="col-12">
            <q-card
              flat
              class="bg-grey-4"
            >
              <q-card-section v-for="product in products" >
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
          </div>

          <div class="col-12">
            <q-card
              flat
              class="bg-grey-4"
            >
              <q-card-section>
                <div class="text-h6 text-weight-bolder">
                  Entrega
                </div>

                <div class="text-caption text-grey-10">
                  Rua {{ address.street }}, Número {{ address.number }}
                </div>

                <div class="text-caption text-grey-10">
                  {{ address.district }}, {{ address.city }}
                </div>

                <div class="text-caption text-grey-10" v-if="address.complement">
                  {{ address.complement }}
                </div>

                <div class="text-caption text-grey-10">
                  CEP {{ address.cep }}
                </div>
              </q-card-section>
            </q-card>
          </div>

          <div class="col-6">
            <q-card
              flat
              class="bg-grey-4 fit"
            >
              <q-card-section>
                <div class="text-h6 text-weight-bolder">
                  Contato
                </div>

                <div class="text-caption text-grey-10">
                  {{ personData.name }}
                </div>

                <div class="text-caption text-grey-10">
                  {{ personData.cellphone }}
                </div>
              </q-card-section>
            </q-card>
          </div>

          <div class="col-6">
            <q-card
              flat
              class="bg-grey-4 fit"
            >
              <q-card-section>
                <div class="text-h6 text-weight-bolder">
                  Pagamento
                </div>

                <div class="text-caption text-grey-10">
                  {{ paymentMethodComputed }}
                </div>
              </q-card-section>
            </q-card>
          </div>

          <div class="col-12">
            <q-card
              flat
              class="bg-grey-4"
            >
              <q-card-section>
                <div class="text-h6 text-weight-bolder">
                  Total: R$ {{ totalOrderPrice }}
                </div>
              </q-card-section>
            </q-card>
          </div>
        </div>
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

                Ir para endereço de entrega
            </q-btn>

            <q-btn
                v-if="step === 2"
                @click="$refs.stepper.next()"
                color="black"
                class="col"
                no-caps
                :disable="addressIsNotCompleted"
            >
                <q-icon name="check" size="xs" class="q-mr-xs"/>

                {{ textButtonAdrees }}
            </q-btn>

            <q-btn
                v-if="step === 3"
                @click="$refs.stepper.next()"
                color="black"
                class="col"
                no-caps
                :disable="cannotFinish"
            >
                <q-icon name="check" size="xs" class="q-mr-xs"/>

                {{ textButtonPaymentMethodAndContact }}
            </q-btn>

            <q-btn
                v-if="step === 4"
                @click="finishOrder"
                color="black"
                class="col"
                no-caps
                :disable="cannotFinish"
            >
                <q-icon name="check" size="xs" class="q-mr-xs"/>

                Finalizar
            </q-btn>
        </q-card-actions>
      </q-card>
    </q-footer>
  </div>
</template>
