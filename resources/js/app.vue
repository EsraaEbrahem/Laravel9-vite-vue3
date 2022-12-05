<template>
    <v-app>
            <v-container>
                <v-app-bar :elevation="2" class="mb-5">
                    <router-link to="/">
                        UMG-E-Commerce
                    </router-link>
                </v-app-bar>
                <notifications />
                <DialogsWrapper />
                <app-navigation />
            </v-container>
            <v-main>
                <router-view></router-view>
            </v-main>
        <app-footer style="z-index: 10000;" class="px-0"></app-footer>

    </v-app>
</template>

<script>
import {setAxiosConfigurations} from "@/configurations/axios-config";
import AppNavigation from "@/shared/app-navigation.vue";
import AppFooter from "@/shared/app-footer.vue";

export default {
    name: "App",
    components: {AppFooter, AppNavigation},
    mounted() {
        if (this.$store.getters.isLogged) {
            setAxiosConfigurations(this.$store.getters.token);
        }else {
            setAxiosConfigurations(null);
        }
    },
}
</script>


