<template>
    <v-container>
        <category-edit v-if="categoryToUpdate!= null" :category="categoryToUpdate" @closed="categoryToUpdate = null"
                       @refresh="getCategories"></category-edit>
        <v-row class="mb-5">
            <v-col cols="12" sm="6">
                <h2>Categories</h2>
            </v-col>
            <v-col class="text-left" cols="12" sm="6">
                <category-create @refresh="getCategories"></category-create>
            </v-col>
        </v-row>
        <div>
            <EasyDataTable
                ref="dataTable"
                :headers="headers"
                :items="categories"
                :rows-per-page="10"
            >
                <template #item-actions="{id}">
                    <div class="clickable_action" @click="updateCategory(id)">
                        Edit
                    </div>
                    <div class="clickable_action" @click="deleteCategory(id)">
                        Delete
                    </div>
                </template>
            </EasyDataTable>
        </div>
    </v-container>
</template>
<script>
import {deleteCategoryApi, getCategoriesApi} from "@/services/categories-services.js";
import CategoryCreate from "./create.vue";
import CategoryEdit from "./edit.vue";
import ConfirmDialog from "@/shared/confirm-dialog.vue";
import {createConfirmDialog} from "vuejs-confirm-dialog";

export default {
    name: "categories-index",
    components: {CategoryEdit, CategoryCreate},
    data() {
        return {
            categories: [],
            categoryToUpdate: null,
            loading: false,
            category: {
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
                    text: 'Actions',
                    value: 'actions',
                    sortable: false
                }
            ]
        }
    },
    methods: {
        async getCategories() {
            this.loading = true;
            let response = await getCategoriesApi();
            if (response.status === 200)
                this.categories = response.data;
            else
                this.$notify(response.statusText);
            this.loading = false;
        },
        deleteCategory(categoryId) {
            const dialog = createConfirmDialog(ConfirmDialog)
            dialog.onConfirm(async () => {
                let response = await deleteCategoryApi(categoryId);
                if (response.status === 200) {
                    await this.getCategories();
                }
                this.$notify(response.statusText);
            })
            dialog.reveal();
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


