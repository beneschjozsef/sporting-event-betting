<!-- src/components/EventDetails.vue -->
<template>
  <div v-if="event">
    <h1>{{ event.title }}</h1>
    <p>{{ event.date }}</p>
    <p>Organizer: {{ event.creator.name }}</p>
    <button @click="deleteEvent">Esemény Törlése</button>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useRoute, useRouter } from "vue-router";

export default defineComponent({
  setup() {
    const store = useStore();
    const route = useRoute();
    const router = useRouter();

    const eventId = computed(() => {
      const id = route.params.id;
      return Array.isArray(id) ? parseInt(id[0]) : parseInt(id);
    });

    onMounted(() => {
      store.dispatch("fetchEventDetails", eventId.value);
    });

    const event = computed(() => store.state.eventDetails);

    const deleteEvent = () => {
      store.dispatch("deleteEvent", eventId.value).then(() => {
        router.push("/");
      });
    };

    return { event, deleteEvent };
  },
});
</script>
