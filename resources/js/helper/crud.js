import axios from 'axios'

const crud = {
  install (app) {  
    app.config.globalProperties.$post = async (url, payload = {}) => {
     
      let instance =  axios.create({
        headers: {
          'Content-Type': 'multipart/form-data'
        },
        baseURL: import.meta.env.VITE_APP_API_URL
      }) 

      let response = {
        'data': {},
        'errors': {},
      }

      await instance.post(url, payload).then(res => {
        response.data = res.data
      }).catch(err => {
        response.errors = err.response.data
      })
      return response
    }
  }
}

export default crud