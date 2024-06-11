<!-- src/components/Register.vue -->
<template>
  <div>
    <h1>Regisztráció</h1>
    <form @submit.prevent="register">
      <input v-model="name" placeholder="Név" required />
      <input v-model="email" type="email" placeholder="Email" required />
      <input v-model="password" type="password" placeholder="Jelszó" required />
      <button type="submit">Regisztráció</button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { useStore } from "vuex";

export default defineComponent({
  setup() {
    const store = useStore();
    const name = ref("");
    const email = ref("");
    const password = ref("");

    const register = () => {
      store.dispatch("register", {
        name: name.value,
        email: email.value,
        password: password.value,
      });
    };

    return { name, email, password, register };
  },
});
</script>
