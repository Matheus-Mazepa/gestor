import axios from 'axios';

export const getStates = () => axios.get(`/address/states`);

export const getCitiesFor = (state_uf) => axios.get(`/address/${state_uf}/cities`);

export const getAddressForCep = (cep) => {
  axios.defaults.headers.common = null;

  const url = window.location.origin;
  let protocol = 'http';

  if(url && url.match(/^https/)) {
    protocol = 'https';
  }

  return axios.get(`${protocol}://viacep.com.br/ws/${cep}/json/`, {
    transformRequest: [function (data, headers) {
        delete headers['X-Socket-Id'];
        return data;
    }]
  });
};

export default {
  getStates,
  getCitiesFor,
  getAddressForCep,
};