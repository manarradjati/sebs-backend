import axios from 'axios'
import { createApp } from 'vue'
import Toast from 'vue-toast-notification'
import 'vue-toast-notification/dist/theme-sugar.css'
import router from '@/router'

const app = createApp()

// Register the Toast plugin globally
app.use(Toast)

// Use the router globally
app.use(router)

// Object containing all possible messages with status codes, types, and messages
const messageArray = {
  'success': {
    status: 200,
    type: 'success',
    message: 'Successfully completed the operation!',
  },
  'notAuthorized': {
    status: 401,
    type: 'info',
    message: 'You are not allowed, you need to be authenticated.',
  },
  'serverError': {
    status: 'default',
    type: 'error',
    message: 'Server error, please try again later or contact the dev team.',
  },
}


// Response interceptor for success and error
axios.interceptors.response.use(
  response => {
    // Handle successful responses if needed
    if(response.data.toastmessage){
      app.config.globalProperties.$toast.open({
        message: response.data.toastmessage,
        type: 'success',
        duration:5000
      })
    }else{
      app.config.globalProperties.$toast.open({
        message: messageArray['success'].message,
        type: messageArray['success'].type,
        duration:5000
      })
    }

    return response
  },
  error => {
    // Handle errors
    if (error.response && error.response.status === 401) {
      // Redirect to the /login route
      router.push('/login')
      app.config.globalProperties.$toast.open({
        message: messageArray['notAuthorized'].message,
        type: messageArray['notAuthorized'].type,
        duration:5000
      })
    } else {
      if(error.response.data.toastmessage)
      {
        app.config.globalProperties.$toast.open({
          message: error.response.data.toastmessage,
          type: 'error',
          duration:5000
        })
      }else{
        app.config.globalProperties.$toast.open({
          message: messageArray['serverError'].message,
          type: messageArray['serverError'].type,
          duration:5000
        })
      }
    }

    return Promise.reject(error)
  },
)

axios.interceptors.request.use(
  config => {
    const storedData = localStorage.getItem('data');

    if (storedData) {
      const data = JSON.parse(storedData);

      // Check if 'token' exists before adding to headers
      if (data && data.token) {
        config.headers['Authorization'] = `Bearer ${data.token}`;
      }
    }

    return config;
  }
);

