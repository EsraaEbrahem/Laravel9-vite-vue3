import axios from "axios";

export async function getOrdersApi(params = {
    page: 1
}) {
    return await axios.get('/orders?page=' + params.page);
}
