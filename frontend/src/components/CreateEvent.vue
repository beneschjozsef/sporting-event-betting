<!-- src/components/CreateEvent.vue -->
<template>
  <div>
    <h1>Új Esemény Létrehozása</h1>
    <form @submit.prevent="createEvent">
      <input v-model="title" placeholder="Esemény Címe" required />
      <input
        v-model="date"
        type="datetime-local"
        placeholder="Esemény Dátuma"
        required
      />
      <button type="submit">Létrehozás</button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref } from "vue";
import { useStore } from "vuex";

export default defineComponent({
  setup() {
    const store = useStore();
    const title = ref("");
    const date = ref("");

    const createEvent = () => {
      store.dispatch("createEvent", { title: title.value, date: date.value });
    };

    return { title, date, createEvent };
  },
});
</script>
