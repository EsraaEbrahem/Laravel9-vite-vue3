import {createStore} from 'vuex'
import cookie from "vue-cookies";

const store = createStore({
    state: {
        regex: {
            email: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i,
            numirecs: /^[0-9]{10}$/,
        },
        isLoggedIn: !!cookie.get('user'),
        signedUser: cookie.get('user') ? cookie.get('user') : null,
    },
    getters: {
        isLogged(state) {
            return state.isLoggedIn;
        },
        user(state) {
            if (state.signedUser == undefined) {
                state.signedUser = cookie.get('user') ? JSON.parse(cookie.get('user')) : null;
                return state.signedUser;
            } else {
                return state.signedUser;
            }
        },
        token(state) {
            return state.signedUser != undefined ? state.signedUser.access_token : '';
        },
        isAdmin(state) {
            if (state.isLoggedIn) {
                return state.signedUser.is_admin
            }
            return false;
        }
    },
    mutations: {
        setUser(state, user) {
            cookie.set('user', JSON.stringify(user));
            state.signedUser = user;
            state.isLoggedIn = true;
        },
        logout(state, payload = null) {
            cookie.remove('user');
            state.signedUser = null;
            state.isLoggedIn = false;
        }
    }
})

export default store;
