<template>
    <v-dialog
        v-model="show"
        hide-overlay
        width="50%"
    >
        <template v-slot:activator="on, attrs">
            <v-btn
                small
                class=""
                v-bind="attrs"
                v-on="on"
                @click="show = !show">
                Create Product
            </v-btn>
        </template>
        <v-container style="padding: 0;">
            <v-card>
                <v-card-title>
                    Create Product
                    <v-spacer></v-spacer>
                    <div @click="show = !show" class="clickable_action">
                        <v-icon>mdi-close</v-icon>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-form ref="add_form" v-on:submit.prevent="addProduct">
                        <v-row>
                            <v-col cols="12">
                                <v-autocomplete
                                    v-model="product.category_id"
                                    :items="categories"
                                    :rules="validation.category_id"
                                    item-text="name"
                                    item-value="id"
                                    label="Category"
                                    :error-messages="server_validation_errors.category_id"
                                    no-data-text="No Date"
                                >

                                </v-autocomplete>
                            </v-col>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="product.name"
                                    :rules="validation.name"
                                    label="Product Name"
                                    :error-messages="server_validation_errors.name"
                                >

                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-btn
                                    type="submit"
                                    :disabled="disableAddBtn"
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
import {addProductApi} from "@/services/products-services.js";

export default {
    name: "product-create",
    components: {},
    data() {
        return {
            show: false,
            productAdded: false,
            product: {
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
            disableAddBtn: false,
        }
    },
    watch: {
        show: {
            handler() {
                if (!this.show && this.productAdded) {
                    this.$emit('refresh');
                }
            }
        }
    },
    methods: {
        async addProduct() {
            const valid = this.$refs.add_form.validate();
            if (!valid) {
                return;
            }

            this.disableAddBtn = true;
            let response = await addProductApi(this.product);
            if (response.status == 200) {
                if (Boolean(response.content.result)) {
                    this.product.name = '';
                    this.product.category_id = null;
                    this.productAdded = true;
                    this.$refs.add_form.reset();

                }
            } else if (response.status == 422) {
                this.server_validation_errors = response.content.data.errors;
            }
            this.disableAddBtn = false;
        },
        async getCategories() {
            const response = await getCategoriesApi();
            if (response.status == 200) {
                this.categories = response.data;
            }
        }
    },
    created() {
        this.getCategories();
    }
}
</script>

<style scoped>

</style>
