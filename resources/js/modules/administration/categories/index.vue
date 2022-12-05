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
                v-model:server-options="serverOptions"
                :headers="headers"
                :items="categories"
                :server-items-length="categories.length"
                :loading="loading"
                buttons-pagination
            >
                <template v-slot:item.actions="{item}">
                    <div class="clickable_action" @click="updateCategory(item)">
                        Edit
                    </div>
                    <div class="clickable_action" @click="deleteCategory(item.id, item.name)">
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
            ],
            serverOptions: {
                page: 1,
                rowsPerPage: 10,
            },
        }
    },
    methods: {
        async getCategories() {
            this.loading = true;
            let response = await getCategoriesApi({page: this.serverOptions.page});
            if (response.status === 200)
                this.categories = response.data;

            this.$notify(response.statusText);
            this.loading = false;
        },
        async deleteCategory(categoryId, categoryName) {
            const {onConfirm} = this.createConfirmDialog(ConfirmDialog, {
                question: "Are you sure you want to delete " + categoryName + "?",
            });
            onConfirm(() => {
                let response = deleteCategoryApi(categoryId);
                if (response.status === 200) {
                    this.getCategories();
                }
                this.$notify(response.statusText);
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


