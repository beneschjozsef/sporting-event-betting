import { createStore } from "vuex";
import apiService from "../services/apiService";

export interface State {
  events: any[];
  eventDetails: any | null;
  user: any | null;
  token: string | null;
}

const store = createStore<State>({
  state: {
    events: [],
    eventDetails: null,
    user: null,
    token: localStorage.getItem("token"),
  },
  mutations: {
    setEvents(state, events) {
      state.events = events;
    },
    setEventDetails(state, eventDetails) {
      state.eventDetails = eventDetails;
    },
    setUser(state, user) {
      state.user = user;
    },
    setToken(state, token) {
      state.token = token;
      localStorage.setItem("token", token);
    },
    clearUser(state) {
      state.user = null;
      state.token = null;
      localStorage.removeItem("token");
    },
  },
  actions: {
    async fetchEvents({ commit }) {
      const response = await apiService.fetchEvents();
      commit("setEvents", response.data);
    },
    async fetchEventDetails({ commit }, eventId) {
      const response = await apiService.fetchEventDetails(eventId);
      commit("setEventDetails", response.data);
    },
    async createEvent({ dispatch }, event) {
      await apiService.createEvent(event);
      dispatch("fetchEvents");
    },
    async updateEvent({ dispatch }, { id, ...event }) {
      await apiService.updateEvent(id, event);
      dispatch("fetchEvents");
    },
    async deleteEvent({ dispatch }, eventId) {
      await apiService.deleteEvent(eventId);
      dispatch("fetchEvents");
    },
    async register({ commit }, user) {
      const response = await apiService.register(user);
      commit("setUser", response.data);
    },
    async login({ commit }, credentials) {
      const response = await apiService.login(credentials);
      const token = response.data.token;
      commit("setToken", token);
      //const userResponse = await apiService.fetchUser(token);
      //commit("setUser", userResponse.data);
    },
    async submitGuess({ state, dispatch }, { eventId, participantId }) {
      if (!state.token) {
        throw new Error("User is not authenticated");
      }
      await apiService.makeGuess(
        { event_id: eventId, participant_id: participantId },
        {
          headers: {
            Authorization: `Bearer ${state.token}`,
          },
        }
      );
      dispatch("fetchEvents"); // Refresh events to update tips count
    },
  },
});

export default store;
