import axios from 'axios'

const client = axios.create({
  baseURL: "/",
  json: true
})

export default client;
