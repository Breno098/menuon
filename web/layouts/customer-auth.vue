<script lang="ts" setup>
  import { useAuthStore } from '~/stores/useAuthStore';

  const auth = useAuthStore();

  async function handleLogout() {
    await auth.logout();
  }

  const userName = computed(() => auth.user ? auth.user.name : null);
</script>

<template>
   <q-layout view="lhh lpR lFf">
    <q-header class="bg-green">
      <q-toolbar>
        <q-toolbar-title class="text-black row items-center">
          MenuOn
        </q-toolbar-title>

        {{ userName }}

        <q-btn round dense flat @click="handleLogout">
          <q-icon name="logout" color="black" size="xs"/>
          <q-tooltip>Sair</q-tooltip>
        </q-btn>
      </q-toolbar>
    </q-header>

    <q-page-container>
      <q-page>
        <slot />
      </q-page>
    </q-page-container>
   </q-layout>
</template>
