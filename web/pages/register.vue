<script lang="ts" setup>
  definePageMeta({
    middleware: ['guest'],
    layout: 'customer-guest'
  })

  import { useAuthStore } from '~/stores/useAuthStore';

  const form = ref({
    name: "",
    email: "",
    password: "",
    password_confirmation: ""
  });

  const auth = useAuthStore();

  async function handleRegister() {
    const { error } = await auth.register(form.value)

    if (! error.value) {
      navigateTo("/");
    }
  }
</script>

<template>
  <div>
    <q-card flat class="q-pa-md">
      <q-card-section class="text-center">
        CADASTRAR
      </q-card-section>

      <q-card-section class="row q-col-gutter-sm">
        <div class="col-12">
            <q-input
                outlined
                v-model="form.name"
                type="text"
                label="Nome"
            />
        </div>

        <div class="col-12">
            <q-input
                outlined
                v-model="form.email"
                type="email"
                label="E-mail"
            />
        </div>

        <div class="col-12">
            <q-input
                outlined
                v-model="form.password"
                type="password"
                label="Senha"
            />
        </div>

        <div class="col-12">
            <q-input
                outlined
                v-model="form.password_confirmation"
                type="password"
                label="Confirme a senha"
            />
        </div>
      </q-card-section>

      <q-card-actions class="q-gutter-sm">
          <q-btn
              color="green"
              label="Registre-se"
              @click="handleRegister"
              class="full-width"
          />

          <q-btn
              color="blue"
              label="Voltar"
              @click="navigateTo('login')"
              class="full-width"
              no-caps
              flat
          />
      </q-card-actions>
      
    </q-card>
  </div>
</template>