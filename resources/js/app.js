require('./bootstrap');

import { configure, defineRule } from "vee-validate";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import { createApp } from 'vue';

import Notyf from "./components/common/notyf.vue";
import Welcome from './components/Welcome.vue';
import LimitPageOption from './components/common/limitPageOption.vue';
import BtnDeleteConfirm from './components/common/btnDeleteConfirm.vue';

import CreateStudent from './components/student/create';
import EditStudent from './components/student/edit';

import CreateTeacher from './components/teacher/create';
import EditTeacher from './components/teacher/edit';

configure({
    validateOnBlur: true,
    validateOnChange: true,
    validateOnInput: true,
    validateOnModelUpdate: true,
});
defineRule('password_rule', value => {
    return /^[A-Za-z0-9]*$/i.test(value);
});
defineRule('telephone', (value) => {
    if (value == undefined) {
        return []
    }
    if (value == '') {
        return []
    }
    return (
        /^0(\d-\d{4}-\d{4})+$/i.test(value) ||
        /^0(\d{3}-\d{2}-\d{4})+$/i.test(value) ||
        /^(070|080|090|050)(-\d{4}-\d{4})+$/i.test(value) ||
        /^0(\d{2}-\d{3}-\d{4})+$/i.test(value) ||
        /^0(\d{9,10})+$/i.test(value)
    )
})

const app = createApp({})

app.component('welcome', Welcome);
app.component('limit-page-option', LimitPageOption);
app.component('create-student', CreateStudent);
app.component('edit-student', EditStudent);
app.component('create-teacher', CreateTeacher);
app.component('edit-teacher', EditTeacher);

app.component("notyf", Notyf);
app.component("btn-delete-confirm", BtnDeleteConfirm);
app.use(VueSweetalert2);

app.mount('#app');
