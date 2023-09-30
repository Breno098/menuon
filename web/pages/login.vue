<script lang="ts" setup>
  definePageMeta({
    middleware: ['guest'],
    layout: 'guest'
  })

  import { useAuthStore } from '~/stores/useAuthStore';

  const form = ref({
    email: 'test@example.com',
    password: 'password'
  });

  const auth = useAuthStore();

  async function handleLogin() {
    const { error } = await auth.login(form.value)

    if(! error.value) {
      return navigateTo("/");
    }
  }
</script>

<template>
  <div>
    <q-card flat class="q-pa-md">
      <q-card-section class="text-center">
        LOGIN
      </q-card-section>

      <q-card-section class="row q-col-gutter-sm">
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
      </q-card-section>

      <q-card-actions class="q-gutter-sm">
          <q-btn
              color="green"
              label="Entrar"
              @click="handleLogin"
              class="full-width"
          />

          <q-btn
              color="blue"
              label="Registre-se"
              @click="navigateTo('register')"
              class="full-width"
              no-caps
              flat
          />
      </q-card-actions>
      
    </q-card>
  </div>
</template>