<!-- src/components/Login.vue -->
<template>
  <div>
    <h1>Bejelentkezés</h1>
    <form @submit.prevent="login">
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Jelszó" required />
      <button type="submit">Bejelentkezés</button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { useStore } from "vuex";

export default defineComponent({
  setup() {
    const store = useStore();
    const email = ref("");
    const password = ref("");

    const login = () => {
      store.dispatch("login", { email: email.value, password: password.value });
    };

    return { email, password, login };
  },
});
</script>
