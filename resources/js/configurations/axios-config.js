import axios from "axios";
import store from "@/helpers/store";

axios.defaults.baseURL = '/api';
axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + store.getters.token;
axios.defaults.headers.common['App-Platform'] = 'web';

export function setAxiosConfigurations(token) {
    window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
}

