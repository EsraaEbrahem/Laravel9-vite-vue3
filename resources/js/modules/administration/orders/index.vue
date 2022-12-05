<template>
    <v-container>
        <v-row class="mb-5">
            <v-col cols="12" sm="6">
                <h2>Orders</h2>
            </v-col>
        </v-row>
        <div>
            <EasyDataTable
                ref="dataTable"
                :headers="headers"
                :items="orders"
                :rows-per-page="10"
            />
        </div>
    </v-container>
</template>
<script>
import {getOrdersApi} from "@/services/orders-services.js";

export default {
    name: "orders-index",
    data() {
        return {
            orders: [],
            loading: false,
            headers: [
                {
                    text: "Id",
                    value: "id",
                    sortable: true
                },
                {
                    text: "Ref",
                    value: "reference_code",
                    sortable: true
                },
                {
                    text: "Total amount",
                    value: "total_amount",
                    sortable: true
                },
                {
                    text: "Notes",
                    value: "notes",
                    sortable: true
                },
                {
                    text: "Status",
                    value: "status",
                    sortable: true
                }
            ],
        }
    },
    methods: {
        async getOrders() {
            this.loading = true;
            let response = await getOrdersApi();
            if (response.status === 200)
                this.orders = response.data;
            else
                this.$notify(response.statusText);
            this.loading = false;
        },
    },
    mounted() {
        this.getOrders();
    }
}
</script>


