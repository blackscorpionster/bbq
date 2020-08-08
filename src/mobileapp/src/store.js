import Vue from "vue";

export const store = Vue.observable({
  token: null,
  user: {}
});

export const mutations = {
  setToken(token) {
    store.token = token;
  },
  serUser(user) {
    store.user = user
  }
};
