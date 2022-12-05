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
                v-model:server-options="serverOptions"
                :headers="headers"
                :items="products"
                :server-items-length="products.length"
                :loading="loading"
                buttons-pagination
            >
                <template v-slot:item.actions="{item}">
                    <div class="clickable_action" @click="updateProduct(item)">
                        Edit
                    </div>
                    <div class="clickable_action" @click="deleteProduct(item.id, item.name)">
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
            serverOptions: {
                page: 1,
                rowsPerPage: 10,
            },
        }
    },
    methods: {
        async getProducts() {
            this.loading = true;
            let response = await getProductsApi({page: this.serverOptions.page});
            if (response.status === 200)
                this.products = response.data;

            this.$notify(response.statusText);
            this.loading = false;
        },
        async deleteProduct(productId, productName) {
            const {onConfirm} = this.createConfirmDialog(ConfirmDialog, {
                question: "Are you sure you want to delete " + productName + "?",
            });
            onConfirm(() => {
                let response = deleteProductApi(productId);
                if (response.status === 200) {
                    this.getProducts();
                }
                this.$notify(response.statusText);
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


