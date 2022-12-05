<template>
    <v-container style="width: 100%;">
        <v-row class="p-0 m-0">
            <v-col cols="12" class="font-weight-bold">
                Register
            </v-col>
        </v-row>
        <v-form ref="form" v-on:submit.prevent="register">
            <v-row>
                <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                    <v-text-field
                        v-model="user.name"
                        label="Name *"
                        :rules="validation.name"
                        error-count="10"
                        hide-details="auto"
                    ></v-text-field>
                </v-col>
                <v-col cols="12" xl="6" lg="6" md="6" sm="6">
                    <v-text-field
                        v-model="user.email"
                        label="Email *"
                        :rules="validation.email"
                        error-count="10"
                        hide-details="auto"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col cols="12">
                    <v-text-field
                        v-model="user.password"
                        :append-icon="showP ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showP = !showP"
                        :type="showP? 'text':'password'"
                        label="Password *"
                        :rules="validation.password"
                        error-count="10"
                        hide-details="auto"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        v-model="user.password_confirmation"
                        :append-icon="showPC ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showPC = !showPC"
                        :type="showPC? 'text':'password'"
                        label="Confirm Password *"
                        :rules="validation.password_confirmation"
                        error-count="10"
                        hide-details="auto"
                    ></v-text-field>
                </v-col>
            </v-row>
            <v-row>
                <v-col>
                    <v-btn
                        type="submit"
                    >
                        Register
                    </v-btn>
                </v-col>
            </v-row>

        </v-form>

    </v-container>
</template>

<script>
import {registerUserApi} from "@/services/auth-services.js";
import {setAxiosConfigurations} from "@/configurations/axios-config.js";

export default {
    name: "login",
    data() {
        return {
            validation: {
                name: [
                    value => !!value || 'This field is required',
                    value => (value && value.length <= 30) || 'Max 30 characters',
                ],
                email: [
                    value => !!value || 'This field is required',
                    value => (value && this.$store.state.regex.email.test(value)) || 'The field must be an email address'
                ],
                password: [
                    value => !!value || "This field is required",
                    value => (value && value.length >= 8) || "At least 8 chars"

                ],
                password_confirmation: [
                    value => !!value || "This field is required",
                    value => value === this.user.password || "Confirm does not match password"
                ],
            },
            user: {
                name: '',
                email: '',
                password: '',
                password_confirmation: ''
            },
            showP: false,
            showPC: false,
        }
    },
    methods: {
        async register() {
            try {
                const valid = this.$refs.form.validate();
                if (valid) {
                    let response = await registerUserApi(this.user);
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
