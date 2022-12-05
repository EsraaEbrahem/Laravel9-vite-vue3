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
                Create category
            </v-btn>
        </template>
        <v-container style="padding: 0;">
            <v-card>
                <v-card-title>
                    Create category
                </v-card-title>
                <v-card-text>
                    <v-form ref="form" v-on:submit.prevent="addCategory">
                        <v-row>
                            <v-col cols="12">
                                <v-text-field
                                    v-model="category.name"
                                    :rules="validation.name"
                                    label="category Name"
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

import {addCategoryApi} from "@/services/categories-services.js";

export default {
    name: "category-create",
    data() {
        return {
            show: false,
            categoryAdded: false,
            category: {
                name: '',
            },
            validation: {
                name: [
                    value => !!value || 'This field is required'
                ],
            },
            disableAddBtn: false,
        }
    },
    watch: {
        show: {
            handler() {
                if (!this.show && this.categoryAdded) {
                    this.$emit('refresh');
                }
            }
        }
    },
    methods: {
        async addCategory() {
            try {
                const valid = this.$refs.form.validate();
                if (valid) {
                    this.disableAddBtn = true;
                    let response = await addCategoryApi(this.category);
                    if (response.status === 200) {
                        this.product.name = '';
                        this.categoryAdded = true;
                        this.$refs.add_form.reset();
                    }
                    this.$notify(response.statusText);
                }
            } catch (error) {
                this.$notify(error.response.statusText);
                this.disableAddBtn = false;
            }
        },
    }
}
</script>
