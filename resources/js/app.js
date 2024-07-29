import './bootstrap';
import { createApp } from 'vue';
import App from '../src/App.vue';
import RecursosComponent from './components/RecursosComponent.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';

const app = createApp(App);
// app.component('recursos-component', RecursosComponent);
app.mount('#app');
