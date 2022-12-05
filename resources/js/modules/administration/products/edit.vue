<template>
    <v-dialog
        v-model="show"
        hide-overlay
        width="50%"
        @click:outside="close"
    >
        <v-container style="padding: 0;">
            <v-card>
                <v-card-title>
                    Edit Product
                </v-card-title>
                <v-card-text>
                    <v-form ref="edit_form" v-on:submit.prevent="updateProduct">
                        <v-row>
                            <v-col cols="12">
                                <v-autocomplete
                                    v-model="productToUpdate.category_id"
                                    :items="categories"
                                    :rules="validation.category_id"
                                    item-title="name"
                                    item-value="id"
                                    label="Category"
                                    :error-messages="server_validation_errors.category_id"
                                    no-data-text="No Data"
                                >

                                </v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="productToUpdate.name"
                                    :rules="validation.name"
                                    label="Product Name"
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

import {getCategoriesApi} from "@/services/categories-services.js";
import {updateProductApi} from "@/services/products-services.js";

export default {
    name: "product-edit",
    props: {
        product: null
    },
    components: {},
    data() {
        return {
            show: true,
            productUpdated: false,
            productToUpdate: {
                name: '',
                category_id: null,
            },
            validation: {
                name: [
                    value => !!value || 'This field is required'
                ],
                category_id: [
                    value => !!value || 'This field is required'
                ]
            },
            server_validation_errors: {
                name: '',
                category_id: ''
            },
            categories: [],
            disableEditBtn: false,
        }
    },
    watch: {
        show: {
            handler() {
                if (!this.show) {
                    if (this.productUpdated) {
                        this.$emit('refresh');
                    }
                    this.$emit('closed');
                }
            }
        }
    },
    methods: {
        async updateProduct() {
            const valid = this.$refs.edit_form.validate();
            if (!valid) {
                return;
            }

            this.disableEditBtn = true;
            let response = await updateProductApi(this.productToUpdate.id, this.productToUpdate);
            if (response.status == 200) {
                if (Boolean(response.content.result)) {
                    this.productUpdated = true;
                    this.$refs.edit_form.resetValidation();
                }
            } else if (response.status == 422) {
                this.server_validation_errors = response.content.data.errors;
            }
            this.disableEditBtn = false;
        },
        async getCategories() {
            const response = await getCategoriesApi({list: true});
            if (response.status == 200) {
                if (Boolean(response.content.result)) {
                    this.categories = response.content.data;
                }
            }
        },
        close() {
            this.show = false;
        }
    },
    created() {
        this.getCategories();
        if (this.product != null) {
            this.productToUpdate = {...this.product};
        }
    }
}
</script>

<style scoped>

</style>
