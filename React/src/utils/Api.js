import axios from "axios";

// Entrez votre clé API ici
const apiKey = "919fe617df3809fdca74";

export default axios.create({
  baseURL: "http://127.0.0.1/sevice_web/projetfinal",
  headers: {
    Authorization: "api_key " + apiKey,
  },
});