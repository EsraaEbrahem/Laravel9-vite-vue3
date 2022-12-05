<template>
    <v-container>
        <product-edit v-if="productToUpdate!= null" :product="productToUpdate" @closed="productToUpdate = null"
                      @refresh="getProducts"></product-edit>
        <v-row class="mb-5">
            <v-col cols="12" sm="6">
                <h2>Products</h2>
            </v-col>
            <v-col class="text-left" cols="12" sm="6">
                <product-create @refresh="getProducts"></product-create>
            </v-col>
        </v-row>
        <div>
            <EasyDataTable
                ref="dataTable"
                :headers="headers"
                :items="products"
                :rows-per-page="10"
            >
                <template #item-actions="{id}">
                    <div class="clickable_action" @click="updateProduct(id)">
                        Edit
                    </div>
                    <div class="clickable_action" @click="deleteProduct(id)">
                        Delete
                    </div>
                </template>
            </EasyDataTable>
        </div>
    </v-container>
</template>
<script>
import {deleteProductApi, getProductsApi} from "@/services/products-services.js";
import ProductCreate from "./create.vue";
import ProductEdit from "./edit.vue";
import ConfirmDialog from "@/shared/confirm-dialog.vue";
import {createConfirmDialog} from "vuejs-confirm-dialog";

export default {
    name: "products-index",
    components: {ProductCreate, ProductEdit},
    data() {
        return {
            products: [],
            productToUpdate: null,
            loading: false,
            product: {
                id: '',
                name: ''
            },
            headers: [
                {
                    text: "Id",
                    value: "id",
                    sortable: true
                },
                {
                    text: "Name",
                    value: "name",
                    sortable: true
                },
                {
                    text: "Cost",
                    value: "cost",
                    sortable: true
                },
                {
                    text: "Available Stock",
                    value: "available_stock",
                    sortable: true
                },
                {
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                }
            ],
        }
    },
    methods: {
        async getProducts() {
            this.loading = true;
            let response = await getProductsApi();
            if (response.status === 200)
                this.products = response.data;
            else
                this.$notify(response.statusText);
            this.loading = false;
        },
        deleteProduct(productId) {
            const dialog = createConfirmDialog(ConfirmDialog)
            dialog.onConfirm(async () => {
                let response = await deleteProductApi(productId);
                if (response.status === 200) {
                    await this.getProducts();
                }
                this.$notify(response.statusText);
            })
            dialog.reveal();
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


