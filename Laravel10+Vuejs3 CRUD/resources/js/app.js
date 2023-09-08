import { createApp } from 'vue'
import routers from './routes';
import store from './store';
import Alert from './components/layouts/alert.vue';
import VueSweetAlert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import AES from 'crypto-js/aes';
import CryptoJS from 'crypto-js';
const app = createApp();
app.use(VueSweetAlert2);
app.use(store);
app.use(routers);
app.component('Alert', Alert);

//ENCRYPTION
app.config.globalProperties.$encrypt = (text, key) => {
    const encryptedText = AES.encrypt(text.toString(), key).toString();
    return encryptedText;
  };
 
//DECRYPTION
  app.config.globalProperties.$decrypt = (cipherText, key) => {
    const bytes = AES.decrypt(cipherText, key);
    const plainText = bytes.toString(CryptoJS.enc.Utf8);
    return plainText;
};

app.mount('#app');