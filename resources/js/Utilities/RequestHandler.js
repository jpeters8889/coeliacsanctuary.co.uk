import axios from 'axios';
import Coeliac from "../CoeliacApplication";

const request = axios.create();

request.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').content;

request.interceptors.response.use(
    response => response,
    error => {
        const status = error.response;

        if (status >= 500) {
            Coeliac.$emit('error', error.response.data.message);
        }

        return Promise.reject(error);
    }
);

export default request;
