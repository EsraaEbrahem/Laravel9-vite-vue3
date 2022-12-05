<template>
    <v-navigation-drawer floating permanent>
        <v-list density="compact" nav>
            <v-list-item
                v-if="$store.getters.isLogged && $store.getters.user != undefined"
                prepend-icon="mdi-view-dashboard" to="profile" :title="$store.getters.user.name">
            </v-list-item>
            <v-list-item prepend-icon="mdi-view-dashboard" to="categories" title="Categories">
            </v-list-item>
            <v-list-item prepend-icon="mdi-view-dashboard" to="products" title="Products">
            </v-list-item>
            <v-list-item prepend-icon="mdi-view-dashboard" to="orders" title="Orders">
            </v-list-item>
            <v-list-item v-if="!$store.getters.isLogged"
                         prepend-icon="mdi-view-dashboard"
                         to="register" title="Register">
            </v-list-item>
            <v-list-item v-if="!$store.getters.isLogged"
                         prepend-icon="mdi-view-dashboard"
                         to="login" title="Login">
            </v-list-item>
            <v-spacer></v-spacer>
            <template v-if="$store.getters.isLogged && $store.getters.user != undefined">
                <div class="ml-4 clickable_action" @click="logout">
                    Logout
                </div>
            </template>



        </v-list>
    </v-navigation-drawer>
</template>

<script>

import Profile from "@/modules/authentication/auth/profile.vue"

export default {
    name: "app-navigation",
    components: {Profile},
    data() {
        return {
            showProfile: false,
        }
    },
    methods: {
        logout() {
            this.$store.commit('logout');
            this.$router.push({name: 'login'});
        },
    }
}
</script>

