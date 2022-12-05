import axios from "axios";

export async function getProductsApi(params = {
    page: 1
}) {
    return await axios.get('/products?page=' + params.page);
}

export async function getProductByIdApi(id, params = {
    with_category: false,
}) {
    return await axios.get('/products/' + id + params);
}

export async function addProductApi(params = {
    name: '',
    description: '',
    available_stock: null,
    cost: null,
    image: null,
    category: null
}) {

    let data = new FormData;
    data.append('name', params.name);
    data.append('cost', params.cost);
    data.append('description', params.description);
    data.append('available_stock', params.available_stock);
    data.append('image', params.image);
    data.append('category_id', params.category);

    return await axios.post('/products', data);
}

export async function updateProductApi(id, params = {
    name: '',
    category_id: null
}) {
    return await axios.put('/products/' + id, params);
}

export async function deleteProductApi(id) {
    return await axios.delete('/products/' + id);
}

