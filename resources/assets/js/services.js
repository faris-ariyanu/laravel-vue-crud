import axios from 'axios';

export const services = axios.create({
  baseURL: 'http://localhost/vodjo/vivamultikarya/public/api/admin/',
  //baseURL: '',
})