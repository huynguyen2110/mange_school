

require('./bootstrap');

import { configure, defineRule } from "vee-validate";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import { createApp } from 'vue';

import Notyf from "./components/common/notyf.vue";
import Welcome from './components/Welcome.vue';
import LimitPageOption from './components/common/limitPageOption.vue';
import BtnDeleteConfirm from './components/common/btnDeleteConfirm.vue';
import BtnRegisterClass from './components/class/btnRegisterClass';
import BtnCancelClass from './components/class/btnCancelClass';
import BtnRegisterAlreadyClass from "./components/class/btnRegisterAlreadyClass";
import BtnPreventCancelClass from "./components/class/btnPreventCancelClass";



import CreateStudent from './components/student/create';
import EditStudent from './components/student/edit';
import InsertScore from './components/student/insertScore';

import CreateTeacher from './components/teacher/create';
import EditTeacher from './components/teacher/edit';

import CreateMajor from './components/major/create';
import EditMajor from './components/major/edit';

import CreateCourse from './components/course/create';
import EditCourse from './components/course/edit';

import CreateSubject from './components/subject/create';
import EditSubject from './components/subject/edit';

import CreateClass from './components/class/create';
import EditClass from './components/class/edit';

import Login from './components/login/index';
import ForgotPassword from './components/forgot-password/index';
import ResetPassword from './components/reset-password/index';

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
app.component('create-major', CreateMajor);
app.component('edit-major', EditMajor);
app.component('create-course', CreateCourse);
app.component('edit-course', EditCourse);
app.component('create-subject', CreateSubject);
app.component('edit-subject', EditSubject);
app.component('create-class', CreateClass);
app.component('edit-class', EditClass);
app.component('login', Login);
app.component('forgot-password', ForgotPassword);
app.component('reset-password', ResetPassword);
app.component('insert-score', InsertScore);


app.component("notyf", Notyf);
app.component("btn-delete-confirm", BtnDeleteConfirm);
app.component("btn-register-class", BtnRegisterClass);
app.component("btn-cancel-class", BtnCancelClass);
app.component("btn-register-already-class", BtnRegisterAlreadyClass);
app.component("btn-prevent-cancel-class", BtnPreventCancelClass);
app.use(VueSweetalert2);

app.mount('#app');
