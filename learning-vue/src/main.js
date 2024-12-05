import { createApp } from 'vue'
import router from './router/index.js'

import { Menu, List, Drawer, Button, message } from 'ant-design-vue';
import App from './App.vue'

import 'ant-design-vue/dist/reset.css'
import 'bootstrap/dist/css/bootstrap-grid.min.css'
import 'bootstrap/dist/css/bootstrap-utilities.min.css'

const app = createApp(App);
app.use(router);
app.use(Menu);
app.use(List);
app.use(Drawer);
app.use(Button);
app.mount('#app');

app.config.globalProperties.$message = message;