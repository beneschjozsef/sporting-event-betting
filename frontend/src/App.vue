<template>
  <div id="app">
    <nav>
      <router-link to="/">Home</router-link>
      <router-link to="/create-event">Create Event</router-link>
      <router-link to="/login">Login</router-link>
      <router-link to="/register">Register</router-link>
    </nav>
    <router-view></router-view>
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "App",
});
</script>

<style>
nav {
  display: flex;
  gap: 10px;
}
</style>
