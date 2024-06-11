// src/router/index.ts
import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";
import EventsList from "../components/EventsList.vue";
import EventDetails from "../components/EventDetails.vue";
import Register from "../components/Register.vue";
import Login from "../components/Login.vue";
import CreateEvent from "../components/CreateEvent.vue";
import EditEvent from "../components/EditEvent.vue";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "home",
    component: EventsList,
  },
  {
    path: "/event/:id",
    name: "event-details",
    component: EventDetails,
    props: true,
  },
  {
    path: "/register",
    name: "register",
    component: Register,
  },
  {
    path: "/login",
    name: "login",
    component: Login,
  },
  {
    path: "/create-event",
    name: "create-event",
    component: CreateEvent,
  },
  {
    path: "/edit-event/:id",
    name: "edit-event",
    component: EditEvent,
    props: true,
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

export default router;
