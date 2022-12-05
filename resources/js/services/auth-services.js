import axios from "axios";

/**
 *
 * @param email
 * @param password
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
export async function loginApi({email = '', password = ''}) {
    let userCredentials = {
        email: email,
        password: password
    }
    return await axios.post('/login', userCredentials);
}

/**
 *
 * @param name
 * @param email
 * @param password
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
export async function registerUserApi({name= '', email = '', password = ''}) {
    let user = {
        name: name,
        email: email,
        password: password
    }
    return await axios.post('/register', user);
}

/**
 *
 * @param params
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
export function getUserRolesApi(params = {
    list: false
}) {
    let query = queryFormatter(params);
    return axios.get('/roles' + query);
}

/**
 *
 * @param params
 * @returns {Promise<axios.AxiosResponse<any>>}
 */
export function getUsersApi(params = {
    page: null,
}) {
    return axios.get('/users' + params);

}
