<template>
    <v-container>
        <product-edit v-if="productToUpdate!= null" :product="productToUpdate" @closed="productToUpdate = null"
                      @refresh="getProducts"></product-edit>
        <v-row>
            <v-col cols="12" sm="6">
                <h2>Products</h2>
            </v-col>
            <v-col class="text-left" cols="12" sm="6">
                <product-create @refresh="getProducts"></product-create>
            </v-col>
        </v-row>
        <v-data-table
            :headers="productsTableHeaders"
            :items="products"
            :loading="loadingProducts"
            :items-per-page="5"
            loading-text="Loading Products.."
            no-data-text="No Data"
        >
            <template v-slot:item.actions="{item}">
                <div class="clickable_action" @click="updateProduct(item)">
                    <v-icon>mdi-pencil</v-icon>
                </div>
                <div class="clickable_action" @click="deleteProduct(item.id, item.name)">
                    <v-icon color="red">mdi-close</v-icon>
                </div>
            </template>
        </v-data-table>
    </v-container>
</template>

<script>


import {deleteProductApi, getProductsApi} from "@/services/products-services.js";
import ProductCreate from "./create.vue";
import ProductEdit from "./edit.vue";

export default {
    name: "products_index",
    components: {ProductCreate, ProductEdit},
    data() {
        return {
            products: [],
            loadingProducts: false,
            productToUpdate: null,
        }
    },
    computed: {
        productsTableHeaders() {
            return [
                // {
                //     text: 'Category',
                //     value: 'category.name',
                //     sortable: true,
                //     align: 'center'
                // },
                {
                    text: 'Name',
                    value: 'name',
                    sortable: true,
                    align: 'center'
                },
                {
                    text: 'Available Stock',
                    value: 'available_stock',
                    sortable: true,
                    align: 'center',
                },
                {
                    text: '',
                    value: 'actions',
                    sortable: false
                }
            ];
        }
    },
    methods: {
        async getProducts() {
            this.loadingProducts = true;
            const response = await getProductsApi({with_category: true});
            if (response.status == 200) {
                this.products = response.data;
            }
            this.loadingProducts = false;
        },
        async deleteProduct(productId, productName) {
            this.$confirm({
                message: 'Are you sure you want to delete: ' + productName,
                button: {
                    no: 'No',
                    yes: 'Yes',
                },
                callback: async confirm => {
                    if (confirm) {
                        const response = await deleteProductApi(productId);
                        if (response.status == 200) {
                            await this.getProducts();
                        }
                    }
                }
            });

        },
        updateProduct(product) {
            this.productToUpdate = product;
        }
    },
    mounted() {
        this.getProducts();
    }
}
</script>
