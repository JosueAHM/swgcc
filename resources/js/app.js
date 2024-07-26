import './bootstrap';
import { createApp } from 'vue';
import App from '../src/App.vue';
import RecursosComponent from './components/RecursosComponent.vue';

const app = createApp(App);
// app.component('recursos-component', RecursosComponent);
app.mount('#app');
