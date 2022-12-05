import axios from "axios";

export async function getUsersApi() {
    return await axios.get('/users');
}


export async function getUserByIdApi(id) {
    return await axios.get('/users/' + id);
}

export async function deleteUserApi(id) {
    return await axios.delete('/users/' + id);
}

