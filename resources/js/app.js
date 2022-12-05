import './bootstrap';
import '../css/app.css';


import Vue3EasyDataTable from "vue3-easy-data-table";
import "vue3-easy-data-table/dist/style.css";

import 'material-design-icons-iconfont/dist/material-design-icons.css'

import {createApp} from 'vue';
import Router from "@/helpers/router.js";
import Store from "@/helpers/store.js";

import 'vuetify/styles';
import {createVuetify} from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';
import { aliases, mdi } from 'vuetify/iconsets/mdi'

import * as ConfirmDialog from 'vuejs-confirm-dialog';
import Notifications from '@kyvg/vue3-notification'

import App from '@/app.vue';

const Vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'mdi',
        aliases,
        sets: {
            mdi,
        }
    },
});

const app = createApp(App);

app.config.globalProperties.$axios = axios;

app.use(Vuetify)
    .use(Router)
    .use(Store)
    .use(ConfirmDialog)
    .use(Notifications)
    .component("EasyDataTable", Vue3EasyDataTable)
    .mount('#app');
