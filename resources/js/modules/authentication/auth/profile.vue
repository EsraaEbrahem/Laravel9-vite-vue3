<template>
    <v-card-text v-if="user!=null">
        <v-row justify="space-around">
            <v-col cols="12" class="text-center">
                <v-icon
                    size="75">mdi-account-circle
                </v-icon>
            </v-col>
            <v-col cols="12" sm="6" class="text-center">
                <label>Name</label>
                <p>{{ user.name }}</p>
            </v-col>
            <v-col cols="12" sm="6" class="text-center">
                <label>Email</label>
                <p>{{ user.email }}</p>
            </v-col>
        </v-row>
    </v-card-text>
</template>

<script>
export default {
    name: "profile",
    data() {
        return {
            user: this.$store.getters.user,
        }
    },
}
</script>
