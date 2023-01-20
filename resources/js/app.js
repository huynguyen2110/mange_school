require('./bootstrap');


import { createApp } from 'vue';
import Welcome from './components/Welcome.vue';
import LimitPageOption from './components/common/limitPageOption.vue';

import CreateStudent from './components/student/create';

const app = createApp({})

app.component('welcome', Welcome);
app.component('limit-page-option', LimitPageOption);
app.component('create-student', CreateStudent);

app.mount('#app');
