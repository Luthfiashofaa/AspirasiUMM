//import axios 
import axios from 'axios'; 
axios.defaults.withCredentials = true;
const Api = axios.create({ 

baseURL: 'http://localhost:8000' 
}) 
export default Api 