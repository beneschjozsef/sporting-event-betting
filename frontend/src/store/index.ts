// src/store/index.ts
import { createStore } from "vuex";
import apiService from "../services/apiService";

export interface State {
  events: any[];
  eventDetails: any | null;
  user: any | null;
}

const store = createStore<State>({
  state: {
    events: [],
    eventDetails: null,
    user: null,
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
      commit("setUser", response.data);
    },
  },
});

export default store;
