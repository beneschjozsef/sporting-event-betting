<!-- src/components/EventsList.vue -->
<template>
  <div>
    <h1>Események Listája</h1>
    <div v-for="event in events" :key="event.id">
      <h2>{{ event.title }}</h2>
      <p>{{ event.date }}</p>
      <p>Creator: {{ event.creator.name }}</p>
      <h3>Participants</h3>
      <ul>
        <li v-for="participant in event.participants" :key="participant.id">
          {{ participant.name }} - {{ participant.role }} - Tips:
          {{ participant.tipsCount }}
          <button @click="submitGuess(event.id, participant.id)">
            Submit Guess
          </button>
        </li>
      </ul>
      <h3>Guesses</h3>
      <ul>
        <li
          v-for="guess in event.guesses"
          :key="guess.user + guess.participant"
        >
          {{ guess.user }} guessed on {{ guess.participant }}
        </li>
      </ul>
    </div>
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

    const submitGuess = (eventId: number, participantId: number) => {
      store.dispatch("submitGuess", { eventId, participantId });
    };

    return { events, submitGuess };
  },
});
</script>
