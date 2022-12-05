<template>
    <v-card
        class="mx-auto"
    >
        <v-container fluid>
            <v-row dense>
                <v-col
                    v-for="product in products"
                    :key="product.name"
                    :cols="4"
                >
                    <v-card>
                        <v-img
                            :src="product.image"
                            class="align-end"
                            gradient="to bottom, rgba(0,0,0,.1), rgba(0,0,0,.5)"
                            height="200px"
                            cover
                        >
                            <v-card-title class="text-white" v-text="product.name"></v-card-title>
                        </v-img>

                        <v-card-actions>
                            <v-card-title v-text="product.category.name"></v-card-title>

                            <v-spacer></v-spacer>

                            <v-btn size="small" color="surface-variant" variant="text" icon="mdi-heart"></v-btn>

                            <v-btn size="small" color="surface-variant" variant="text" icon="mdi-bookmark"></v-btn>

                            <v-btn size="small" color="surface-variant" variant="text" icon="mdi-share-variant"></v-btn>
                        </v-card-actions>
                    </v-card>
                </v-col>
            </v-row>
        </v-container>
    </v-card>
</template>

<script>
import {getHomeProductsApi} from "@/services/products-services.js";
import {getCategoriesApi} from "@/services/categories-services.js";

export default {
    name: "home",
    components: {},
    data() {
        return {
            products: [],
            categories: [],
        }
    },
    methods: {
        async getProducts() {
            let response = await getHomeProductsApi(9);
            if (response.status === 200)
                this.products = response.data;
        },
        async getCategories() {
            let response = await getCategoriesApi();
            if (response.status === 200)
                this.categories = response.data;
        }
    },
    mounted() {
        this.getProducts();
        this.getCategories();
    }
}
</script>


