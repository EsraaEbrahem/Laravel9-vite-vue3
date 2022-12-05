import axios from "axios";

export async function getCategoriesApi(params = {
    page: 1
}) {
    return await axios.get('/categories?page=' + params.page);
}


export async function addCategoryApi(params = {
    name: ''
}) {
    return await axios.post('/categories', params);
}

export async function updateCategoryApi(id, params = {
    name: '',
}) {
    return await axios.put('/categories/' + id, params);
}

export async function deleteCategoryApi(id) {
    return await axios.delete('/categories/' + id);
}
