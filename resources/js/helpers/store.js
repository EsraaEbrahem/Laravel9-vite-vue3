import {createStore} from 'vuex'
import cookie from "vue-cookies";

const store = createStore({
    state: {
        regex: {
            email: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}$/i,
            verificationCode: /^[0-9]{4}$/,
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
        hasRole(state, roles) {
            if (state.isLoggedIn) {
                const userRoles = Object.keys(state.signedUser.user_roles);
                return roles.some(role => userRoles.includes(role));
            }
            return false;
        },
        hasPermission(state, permission) {
            if (state.isLoggedIn) {
                const userPermission = state.signedUser.user_permissions;
                return userPermission[permission] !== undefined;
            }
            return false;
        },
        canComment(state, getters, complaintOwner) {
            const user = state.signedUser.info;
            if (user.id === complaintOwner || getters.hasRole('موظف قسم')) {
                return true;
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
