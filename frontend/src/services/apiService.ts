import axios, { AxiosResponse } from "axios";

export interface User {
  name: string;
  email: string;
  password: string;
}

export interface Credentials {
  email: string;
  password: string;
}

export interface Event {
  id?: number;
  title: string;
  date: string;
  creatorId: number;
}

export interface Guess {
  event_id: number;
  participant_id: number;
}

const apiClient = axios.create({
  baseURL: "http://localhost/api",
  withCredentials: true,
  headers: {
    Accept: "application/json",
    "Content-Type": "application/json",
  },
});

export default {
  register(user: User): Promise<AxiosResponse<User>> {
    return apiClient.post("/register", user);
  },
  login(credentials: Credentials): Promise<AxiosResponse<{ token: string }>> {
    return apiClient.post("/login", credentials);
  },
  fetchEvents(): Promise<AxiosResponse<Event[]>> {
    return apiClient.get("/events");
  },
  fetchEventDetails(id: number): Promise<AxiosResponse<Event>> {
    return apiClient.get(`/events/${id}`);
  },
  createEvent(event: Event): Promise<AxiosResponse<Event>> {
    return apiClient.post("/events", event);
  },
  updateEvent(id: number, event: Event): Promise<AxiosResponse<Event>> {
    return apiClient.put(`/events/${id}`, event);
  },
  deleteEvent(id: number): Promise<AxiosResponse<unknown>> {
    return apiClient.delete(`/events/${id}`);
  },
  makeGuess(guess: Guess, config = {}): Promise<AxiosResponse<unknown>> {
    return apiClient.post("/guesses", guess, config);
  },
  fetchUser(token: string): Promise<AxiosResponse<User>> {
    return apiClient.get("/user", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    });
  },
};
