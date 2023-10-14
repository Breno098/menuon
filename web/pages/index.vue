<script setup>
  const { data } = await useApiCustomer('/food_sessions');

  function showSession(session) {
    navigateTo(`/session/${session.id}`)
  }
</script>

<template>
  <div>
    <div class="row q-col-gutter-md">
      <div
        class="col-6 cursor-pointer"
        v-for="session in data.food_sessions" 
        :key="session.id"
      >
        <q-card 
          flat
          @click="showSession(session)"
        >
          <q-img 
            :src="session.image"
            height="200px"
          >
            <div class="absolute-bottom text-center">
              <div class="text-bold text-uppercase">{{ session.title }}</div>
            </div>
          </q-img>
        </q-card>
      </div>
    </div>
 
  </div>
</template>
