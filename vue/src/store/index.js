import { createStore } from "vuex";
import axiosClient from "../axios";
const tmpSurveys = [{
        id: 100,
        title: "sdsdsds",
        slug: "sdsldksldkl",
        status: "sdsdsd",
        image: "http://blog.logrocket.com/wp-content/uploads/2020/12/vue-skyline.png",
        description: "nothings make any sanse",
        created_at: "2322-32-32 21:12:1",
        updated_at: "2322-32-32 21:12:1",
        expire_date: "2322-32-32 21:12:1",
        questions: [{
                id: 1,
                type: "select",
                question: "from which country are you ?",
                description: null,
                data: {
                    options: [
                        { uuid: "wdzdsdasdasdasd", text: "combodia" },
                        { uuid: "wdzdsdasdasdasd", text: "syria" },
                        { uuid: "wdzdsdasdasdasd", text: "iaraq" },
                        { uuid: "wdzdsdasdasdasd", text: "guanatanmo" },

                    ]
                },
            },
            {
                id: 2,
                type: "text",
                question: "from which country are you ?",
                description: "just test",
                date: {},
            },
        ],
    },


];
const store = createStore({
    state: {
        user: {
            date: {

            },
            token: sessionStorage.getItem('TOKEN'),
        },
        surveys: [...tmpSurveys],
        questionTypes: ["text", "select", "radio", "checkbox", "textarea"],
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
            state.user.token = {};
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