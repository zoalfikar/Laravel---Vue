import axios from "axios";
import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            date: {

            },
            token: sessionStorage.getItem('TOKEN'),
        },
        currentSurvey: {
            loading: false,
            data: {}
        },
        surveys: {
            loading: false,
            data: []
        },
        questionTypes: ["text", "select", "radio", "checkbox", "textarea"],
    },
    getter: {},
    actions: {
        getSurveys({ commit }) {
            commit('setSurveysLoading', true)
            return axiosClient.get("/survey").then((res) => {
                commit('setSurveysLoading', false)
                commit("setSurveys", res.data)
                return res;
            })

        },
        deleteSurvey({}, id) {
            return axiosClient.delete(`/survey/${id}`);
        },
        getSurvey({ commit }, id) {

            commit("setCurrentSurveyLoading", true);
            return axiosClient.get(`/survey/${id}`).then((res) => {
                commit("setCurrentSurvey", res.data);
                commit("setCurrentSurveyLoading", false);
                return res;

            }).catch((err) => {
                commit("setCurrentSurveyLoading", false);
                throw err;
            });
        },
        saveSurvey({ commit }, survey) {
            delete survey.image_url;
            let response;
            if (survey.id) {
                response = axiosClient.put(`/survey/${survey.id}`, survey).then((res) => {
                    commit("setCurrentSurvey", res.data);
                    return res;
                });

            } else {
                response = axiosClient.post(`/survey`, survey).then((res) => {
                    commit("setCurrentSurvey", res.data);
                    return res;
                });
                return response;


            }
        },
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
        setCurrentSurveyLoading: (state, loading) => {
            state.currentSurvey.loading = loading;
        },
        setSurveysLoading: (state, loading) => {
            state.surveys.loading = loading;
        },
        setCurrentSurvey: (state, survey) => {
            state.currentSurvey.data = survey.data
        },
        setSurveys: (state, surveys) => {
            state.surveys.data = surveys.data
        },
        logout: (state) => {
            state.user.date = {};
            state.user.token = null;
            sessionStorage.removeItem('TOKEN');
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