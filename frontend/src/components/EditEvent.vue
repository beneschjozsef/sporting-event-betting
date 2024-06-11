<!-- src/components/EditEvent.vue -->
<template>
  <div v-if="event">
    <h1>Esemény Szerkesztése</h1>
    <form @submit.prevent="updateEvent">
      <input v-model="event.title" placeholder="Esemény Címe" required />
      <input
        v-model="event.date"
        type="datetime-local"
        placeholder="Esemény Dátuma"
        required
      />
      <button type="submit">Mentés</button>
    </form>
  </div>
</template>

<script lang="ts">
import { defineComponent, ref, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useStore } from "vuex";
import { Event } from "../services/apiService";

export default defineComponent({
  setup() {
    const store = useStore();
    const route = useRoute();
    const router = useRouter();
    const event = ref<Partial<Event>>({});

    const eventId = computed(() => {
      const id = route.params.id;
      return Array.isArray(id) ? parseInt(id[0]) : parseInt(id);
    });

    onMounted(async () => {
      await store.dispatch("fetchEventDetails", eventId.value);
      event.value = store.state.eventDetails || {};
    });

    const updateEvent = () => {
      store
        .dispatch("updateEvent", { id: eventId.value, ...event.value })
        .then(() => {
          router.push("/");
        });
    };

    return { event, updateEvent };
  },
});
</script>
