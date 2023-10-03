import { defineStore } from 'pinia';
import { useApiFetch } from '~/composables/useApiFetch';

type User = {
    id: number;
    name: string;
    email: string;
}

type Credentials = {
    email: string;
    password: string;
}

type RegistrationInfo = {
  name:string;
  email: string;
  password: string;
  password_confirmation: string;
}

export const useAuthStore = defineStore('auth', () => {
    const user = ref<User | null>(null);

    const isLoggedIn = computed(() => !!user.value);

    async function logout() {
      await useApiFetch('/api/customer/logout', { method: "POST" });

      user.value = null;

      navigateTo('/login');
    }

    async function fetchUser() {
      const { data, error } = await useApiFetch('/api/customer/user');

      user.value = data.value as User;
    }

    async function login(credentials: Credentials) {
        await useApiFetch('/sanctum/csrf-cookie');
    
        const login = await useApiFetch('/api/customer/login', {
          method: 'POST',
          body: credentials,
        });

        await fetchUser();

        return login;
    }

    async function register(info: RegistrationInfo) {
      const register = await useApiFetch('/api/customer/register', { 
        method: "POST",
        body: info
      });

      await fetchUser();

      return register;
    }

    return { user, login, fetchUser, isLoggedIn, logout, register};
  })