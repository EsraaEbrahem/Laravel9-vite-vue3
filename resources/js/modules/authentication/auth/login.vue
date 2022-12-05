<template>
    <v-container style="width: 100%;">
        <v-row class="p-0 m-0">
            <v-col cols="12" class="font-weight-bold">
                Login
            </v-col>
        </v-row>
        <v-form ref="form" v-on:submit.prevent="login">
            <v-row>
                <v-col>
                    <v-text-field
                        v-model="userCredentials.email"
                        label="Email"
                        :rules="validation.email"
                    >
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-text-field
                        v-model="userCredentials.password"
                        :type="showPassword? 'text' : 'password'"
                        :append-icon="showPassword? 'mdi-eye-off':'mdi-eye'"
                        @click:append="showPassword = !showPassword"
                        label="Password"
                        :rules="validation.password"
                    >
                    </v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-btn
                        type="submit"
                    >
                        Login
                    </v-btn>
                </v-col>
                <v-col class="text-left">
                    <router-link :to="{name:'register'}">Register</router-link>
                </v-col>
            </v-row>

        </v-form>

    </v-container>
</template>

<script>
import {loginApi} from "@/services/auth-services.js";
import {setAxiosConfigurations} from "@/configurations/axios-config.js";

export default {
    name: "login",
    data() {
        return {
            validation: {
                email: [
                    value => !!value || 'This field is required',
                    value => (value && this.$store.state.regex.email.test(value)) || 'The field must be an email address'
                ],
                password: [
                    value => !!value || 'This field is required',
                ],
            },
            userCredentials: {
                email: '',
                password: ''
            },
            showPassword: false,
        }
    },
    methods: {
        async login() {
            try {
                const valid = this.$refs.form.validate();
                if (valid) {
                    let response = await loginApi(this.userCredentials);
                    let user = response.data;
                    setAxiosConfigurations(user.access_token);
                    this.$store.commit('setUser', user);
                    this.$router.push({name: "products"});
                    this.$notify(response.statusText);
                }
            } catch (error) {
                this.$notify(error.response.statusText);
            }
        }
    }
}
</script>
