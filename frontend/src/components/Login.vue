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
import { useRouter } from "vue-router";

export default defineComponent({
  setup() {
    const store = useStore();
    const router = useRouter();
    const email = ref("");
    const password = ref("");

    const login = async () => {
      try {
        await store.dispatch("login", {
          email: email.value,
          password: password.value,
        });
        router.push({ name: "home" }); // Navigate to home or any other page
      } catch (error) {
        console.error("Login failed:", error);
      }
    };

    return { email, password, login };
  },
});
</script>
