<template>
    <v-dialog
        v-model="show"
        hide-overlay
        width="50%"
        @click:outside="close"
    >
        <v-container>
            <v-card>
                <v-card-title>
                    Edit Category
                </v-card-title>
                <v-card-text>
                    <v-form ref="edit_form" v-on:submit.prevent="updateCategory">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="categoryToUpdate.name"
                                    :rules="validation.name"
                                    label="Category Name"
                                    :error-messages="server_validation_errors.name"
                                >

                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-btn
                                    type="submit"
                                    :disabled="disableEditBtn"
                                >
                                    Save
                                </v-btn>
                            </v-col>
                            <v-col cols="6">
                                <v-btn
                                    @click="show = false"
                                >
                                    Close
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
            </v-card>
        </v-container>
    </v-dialog>
</template>

<script>

import {updateCategoryApi} from "@/services/categories-services.js";

export default {
    name: "category-edit",
    props: {
        category: null
    },
    components: {},
    data() {
        return {
            show: true,
            categoryUpdated: false,
            categoryToUpdate: {
                name: '',
            },
            validation: {
                name: [
                    value => !!value || 'This field is required'
                ]
            },
            server_validation_errors: {
                name: '',
            },
            disableEditBtn: false,
        }
    },
    watch: {
        show: {
            handler() {
                if (!this.show) {
                    if (this.categoryUpdated) {
                        this.$emit('refresh');
                    }
                    this.$emit('closed');
                }
            }
        }
    },
    methods: {
        async updateCategory() {
            const valid = this.$refs.edit_form.validate();
            if (!valid) {
                return;
            }

            this.disableEditBtn = true;
            let response = await updateCategoryApi(this.categoryToUpdate);
            if (response.status == 200) {
                if (Boolean(response.content.result)) {
                    this.categoryUpdated = true;
                    this.$refs.edit_form.resetValidation();
                }
            } else if (response.status == 422) {
                this.server_validation_errors = response.content.data.errors;
            }
            this.disableEditBtn = false;
        },
        close() {
            this.show = false;
        }
    },
    created() {
        if (this.category != null) {
            this.categoryToUpdate = {...this.category};
        }
    }
}
</script>

<style scoped>

</style>
