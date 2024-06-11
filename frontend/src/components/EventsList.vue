<!-- src/components/EventsList.vue -->
<template>
  <div>
    <h1>Események Listája</h1>
    <ul>
      <li v-for="event in events" :key="event.id">
        <router-link :to="{ name: 'event-details', params: { id: event.id } }">
          {{ event.title }} - {{ event.date }}
        </router-link>
      </li>
    </ul>
  </div>
</template>

<script lang="ts">
import { defineComponent, onMounted, computed } from "vue";
import { useStore } from "vuex";

export default defineComponent({
  setup() {
    const store = useStore();

    onMounted(() => {
      store.dispatch("fetchEvents");
    });

    const events = computed(() => store.state.events);

    return { events };
  },
});
</script>
