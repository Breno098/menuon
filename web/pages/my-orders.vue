<script setup>
  const { data } = await useApiCustomer(`/order/my`);
</script>

<template>
  <div>
    <q-card 
      v-for="order in data.orders"
    >
        <q-card-section>
          <div class="row q-col-gutter-xs"  >
           
            <div class="col-12">
              <q-card
                flat
                class="bg-grey-4"
              >
                <q-card-section>
                    <div class="text-weight-bolder">
                      {{ order.status }}
                    </div>
                </q-card-section>

                <q-card-section v-for="item in order.items" >
                    <div class="text-h6 text-weight-bolder">
                        {{ item.quantity }} un. {{ item.product.name }} ({{ item.price }} cada unidade)
                    </div>

                    <div class="text-caption text-grey-10"  v-if="item.additional.length">
                        Adicionais: {{ item.additional.map(add => `+${add.quantity} ${add.name} (R$ ${add.price} porção)`).join(' | ') }}
                    </div>

                    <div class="text-caption text-grey-9">
                        Total: R$ {{ item.total_price }}
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
                    Rua {{ order.delivery_address.street }}, Número {{ order.delivery_address.number }}
                  </div>

                  <div class="text-caption text-grey-10">
                    {{ order.delivery_address.district }}, {{ order.delivery_address.city }}
                  </div>

                  <div class="text-caption text-grey-10" v-if="order.delivery_address.complement">
                    {{ order.delivery_address.complement }}
                  </div>

                  <div class="text-caption text-grey-10">
                    CEP {{ order.delivery_address.cep }}
                  </div>
                </q-card-section>
              </q-card>
            </div>

            <div class="col-12">
              <q-card
                flat
                class="bg-grey-4 fit"
              >
                <q-card-section>
                  <div class="text-h6 text-weight-bolder">
                    Pagamento
                  </div>

                  <div class="text-caption text-grey-10">
                    {{ order.payment_method }}
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
                    Total: R$ {{ order.total_price }}
                  </div>
                </q-card-section>
              </q-card>
            </div>
          </div>
        </q-card-section>
    </q-card>
  </div>
</template>
