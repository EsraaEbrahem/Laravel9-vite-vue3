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
        <v-container>
            <v-card>
                <v-card-title>
                    Create Product
                    <v-spacer></v-spacer>
                    <div @click="show = !show" class="clickable_action">
                        <v-icon>mdi-close</v-icon>
                    </div>
                </v-card-title>
                <v-card-text>
                    <v-form ref="form" v-on:submit.prevent="addProduct">
                        <v-row>
                            <v-col cols="6">
                                <v-autocomplete
                                    v-model="product.category"
                                    :items="categories"
                                    :rules="validation.category_id"
                                    item-title="name"
                                    item-value="id"
                                    label="Category"
                                    no-data-text="No Data"
                                >
                                </v-autocomplete>
                            </v-col>
                            <v-col cols="6">
                                <v-file-input
                                    v-model="product.image"
                                    :rules="validation.image"
                                    label="Image"
                                    variant="filled"
                                    prepend-icon="mdi-camera"
                                ></v-file-input>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="product.name"
                                    :rules="validation.name"
                                    label="Product Name"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="product.available_stock"
                                    :rules="validation.available_stock"
                                    label="Available Stock"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-text-field
                                    v-model="product.cost"
                                    :rules="validation.cost"
                                    label="Cost"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="6">
                                <v-textarea
                                    label="Description"
                                    v-model="product.description"
                                    :rules="validation.description"
                                ></v-textarea>
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
                available_stock: '',
                cost: '',
                image: '',
                description: '',
                category: {
                    id: '',
                    name: ''
                },
            },
            validation: {
                name: [
                    value => !!value || 'This field is required'
                ],
                available_stock: [
                    value => !!value || 'This field is required',
                ],
                cost: [
                    value => !!value || 'This field is required',
                ],
                image: [
                    value => !!value || 'This field is required',
                ],
                description: [
                    value => !!value || 'This field is required',
                ],
                category: [
                    value => !!value || 'This field is required'
                ]
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
            try {
                const valid = this.$refs.form.validate();
                if (valid) {
                    this.disableAddBtn = true;
                    let response = await addProductApi(this.product);
                    if (response.status === 200) {
                        this.product.name = '';
                        this.product.category = null;
                        this.product.description = '';
                        this.product.cost = '';
                        this.product.available_stock = '';
                        this.product.image = null;
                        this.productAdded = true;
                        this.$refs.add_form.reset();
                    }
                    this.$notify(response.statusText);
                }
            } catch (error) {
                this.$notify(error.response.statusText);
                this.disableAddBtn = false;
            }
        },
        async getCategories() {
            let response = await getCategoriesApi({page: 1, limit: 10000});
            if (response.status === 200)
                this.categories = response.data;
        },

    },
    created() {
        this.getCategories();
    }
}
</script>
