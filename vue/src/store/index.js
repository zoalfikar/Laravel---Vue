import { createStore } from "vuex";
import axiosClient from "../axios";
const store = createStore({
    state: {
        user: {
            date: {

            },
            token: sessionStorage.getItem('TOKEN'),
        },
    },
    getter: {},
    actions: {
        register({ commit }, user) {
            return axiosClient.post('/register', user).then(({ data }) => {
                commit('setUser', data)
                return data;
            })
        },
        login({ commit }, user) {
            return axiosClient.post('/login', user).then(({ data }) => {
                commit('setUser', data)
                return data;
            })
        },
        logout({ commit }) {
            return axiosClient.post('/logout').then(({ response }) => {
                commit('logout')
                return response;
            })
        }

    },
    mutations: {
        logout: (state) => {
            state.user.date = {};
            state.user.token = null;
        },
        setUser: (state, userData) => {
            state.user.token = userData.token;
            state.user.date = userData.user;
            sessionStorage.setItem('TOKEN', userData.token);
        }
    },
    modules: {}
})
export default store;