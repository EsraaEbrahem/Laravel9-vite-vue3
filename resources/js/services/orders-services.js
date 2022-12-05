import axios from "axios";

export async function getOrdersApi() {
    return await axios.get('/orders');
}

export async function getMyOrdersApi() {
    return await axios.get('/my-orders');
}
