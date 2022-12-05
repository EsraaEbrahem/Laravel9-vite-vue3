<template>
    <v-container>
        <category-edit v-if="categoryToUpdate!= null" :category="categoryToUpdate" @closed="categoryToUpdate = null"
                       @refresh="getCategories"></category-edit>
        <v-row>
            <v-col cols="12" sm="6">
                <h2>Categories</h2>
            </v-col>
            <v-col class="text-left" cols="12" sm="6">
                <category-create @refresh="getCategories"></category-create>
            </v-col>
        </v-row>
        <v-data-table
            :headers="categoriesTableHeaders"
            :items="categories"
            :loading="loadingCategories"
            :items-per-page="5"
            loading-text="Loading categorys.."
            no-data-text="No Data"
        >
            <template v-slot:item.actions="{item}">
                <div class="clickable_action" @click="updateCategory(item)">
                    <v-icon>mdi-pencil</v-icon>
                </div>
                <div class="clickable_action" @click="deleteCategory(item.id, item.name)">
                    <v-icon color="red">mdi-close</v-icon>
                </div>
            </template>
        </v-data-table>
    </v-container>
</template>

<script>


import {deleteCategoryApi, getCategoriesApi} from "../../../services/categories-services.js";
import CategoryCreate from "./create.vue";
import CategoryEdit from "./edit.vue";
import Category_create from "@/modules/administration/categories/create.vue";

export default {
    name: "categories_index",
    components: {Category_create, CategoryCreate, CategoryEdit},
    data() {
        return {
            categories: [],
            loadingCategories: false,
            categoryToUpdate: null,
        }
    },
    computed: {
        categoriesTableHeaders() {
            return [
                {
                    text: 'Name',
                    value: 'name',
                    sortable: true,
                    align: 'center'
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
        async getCategories() {
            this.loadingCategories = true;
            const response = await getCategoriesApi();
            if (response.status == 200) {
                this.categories = response.data;
            }
            this.loadingCategories = false;
        },
        async deleteCategory(categoryId, categoryName) {
            this.$confirm({
                message: 'Are you sure you want to delete: ' + categoryName,
                button: {
                    no: 'No',
                    yes: 'Yes',
                },
                callback: async confirm => {
                    if (confirm) {
                        const response = await deleteCategoryApi(categoryId);
                        if (response.status == 200) {
                            await this.getCategories();
                        }
                    }
                }
            });

        },
        updateCategory(category) {
            this.categoryToUpdate = category;
        }
    },
    mounted() {
        this.getCategories();
    }
}
</script>
