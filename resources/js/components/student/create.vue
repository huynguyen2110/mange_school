<template>
    <div class="container-fluid">
        <div class="path d-flex aline-flex-end">
            <h3 class="list mb-4 d-flex align-self-end ml-2">Thêm sinh viên</h3>
        </div>
        <div class="fade-in">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="example">
                                <VeeForm
                                    as="div"
                                    v-slot="{ handleSubmit }"
                                    @invalid-submit="onInvalidSubmit"
                                >
                                    <form
                                        method="POST"
                                        @submit="handleSubmit($event, onSubmit)"
                                        ref="formData"
                                        :action="data.urlStore"
                                    >
                                        <input type="hidden" :value="csrfToken" name="_token"/>
                                        <div class="mb-4">
                                            <label for="name" class="form-label"
                                            >Tên <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="text"
                                                class="form-control"
                                                rules="required|max:128"
                                                v-model="model.name"
                                                name="name"
                                                placeholder="Tên"
                                                id="name"
                                            />
                                            <ErrorMessage class="error" name="name"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="email" class="form-label"
                                            >Email <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="text"
                                                class="form-control"
                                                name="email"
                                                rules="required|max:255|unique_custom|email"
                                                v-model="model.email"
                                                placeholder="Email"
                                                id="email"
                                            />
                                            <ErrorMessage class="error" name="email"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="password" class="form-label"
                                            >Mật khẩu <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="password"
                                                class="form-control"
                                                name="password"
                                                v-model="model.password"
                                                rules="required|max:16|min:8|password_rule"
                                                placeholder="Mật khẩu"
                                                id="password"
                                            />
                                            <ErrorMessage class="error" name="password"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="password_old" class="form-label"
                                            >Xác nhận mật khẩu <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="password"
                                                class="form-control"
                                                name="password_old"
                                                v-model="model.password_old"
                                                rules="required|confirmed:@password"
                                                placeholder="Xác nhận mật khẩu"
                                                id="password_old"
                                            />
                                            <ErrorMessage class="error" name="password_old"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="major_id" class="form-label"
                                            >Ngành <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="text"
                                                class="form-control"
                                                as="select"
                                                rules="required"
                                                name="major_id"
                                                v-model="model.major_id"
                                                placeholder="Ngành"
                                                id="major_id"
                                            >
                                                <option value="" disabled selected>
                                                    -- Chọn ngành --
                                                </option>
                                                <option
                                                    v-for="item in this.data.major"
                                                    :key="item.id"
                                                    :value="item.id"
                                                >
                                                    {{ item.name }}
                                                </option>
                                            </Field>
                                            <ErrorMessage class="error" name="major_id"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="course_id" class="form-label"
                                            >Khóa <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="text"
                                                class="form-control"
                                                as="select"
                                                v-model="model.course_id"
                                                rules="required"
                                                name="course_id"
                                                placeholder="Khóa"
                                                id="course_id"
                                            >
                                                <option value="" disabled selected>
                                                    -- Chọn khóa --
                                                </option>
                                                <option
                                                    v-for="item in this.data.course"
                                                    :key="item.id"
                                                    :value="item.id"
                                                >
                                                    {{ item.name }}
                                                </option>
                                            </Field>
                                            <ErrorMessage class="error" name="course_id"/>
                                        </div>

                                        <div class="mb-4">
                                            <label for="birthday" class="form-label"
                                            >Ngày sinh<span class="required-label">*</span></label
                                            >
                                            <Field
                                                as="div"
                                                id="birthday"
                                                v-model="model.birthday"
                                                name="birthday"
                                                rules="required"
                                            >
                                                <datepicker
                                                    v-model="model.birthday"
                                                    :monthChangeOnScroll="false"
                                                    locale="vi"
                                                    name="birthday"
                                                    selectText="Chọn"
                                                    cancelText="Hủy"
                                                    format="yyyy/MM/dd"
                                                    placeholder="1990 / 01 / 01"
                                                    :enableTimePicker="false"
                                                    vertical
                                                    :max-date="new Date()"
                                                />
                                            </Field>
                                            <ErrorMessage class="error" name="birthday"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="gender" class="form-label"
                                            >Giới tính<span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="text"
                                                class="form-control"
                                                name="gender"
                                                rules="required"
                                                placeholder="Giới tính"
                                                id="gender"
                                                as="select"
                                                v-model="model.gender"
                                            >
                                                <option value="" disabled selected>
                                                    -- Chọn giới tính --
                                                </option>
                                                <option value="0">
                                                    Nữ
                                                </option>
                                                <option value="1">
                                                    Nam
                                                </option>
                                            </Field>
                                            <ErrorMessage class="error" name="gender"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="phone" class="form-label"
                                            >Số điện thoại<span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="text"
                                                class="form-control"
                                                rules="required|telephone|max:24|unique_custom_phone"
                                                name="phone"
                                                placeholder="Số điện thoại"
                                                id="phone"
                                                v-model="model.phone"
                                            />
                                            <ErrorMessage class="error" name="phone"/>
                                        </div>

                                        <div class="mb-4">
                                            <label for="address" class="form-label"
                                            >Địa chỉ</label
                                            >
                                            <Field
                                                type="text"
                                                class="form-control"
                                                name="address"
                                                placeholder="Địa chỉ"
                                                id="address"
                                                rules="max:1024"
                                                v-model="model.address"
                                            />
                                            <ErrorMessage class="error" name="address"/>
                                        </div>

                                        <div class="text-center">
                                            <a
                                                class="btn btn-outline-secondary btn-back"
                                                style="margin-right: 10px"
                                                :href="data.urlBack"
                                            >
                                                Back
                                            </a>
                                            <button class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </VeeForm>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <loader :flag-show="flagShowLoader"></loader>
    </div>
</template>
<script>
import {
    Form as VeeForm,
    Field,
    ErrorMessage,
    defineRule,
    configure,
} from "vee-validate";
import { localize } from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
import $ from "jquery";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import Loader from "../common/loader.vue";

export default {
    setup(){
        Object.keys(rules).forEach((rule) => {
            if (rule != "default") {
                defineRule(rule, rules[rule]);
            }
        });
    },
    created() {
        let messError = {
            en: {
                fields: {
                    name: {
                        required: "Tên không được để trống",
                        max: "Tên không được nhập quá 128 kí tự",
                    },
                    email: {
                        required: "Email không được để trống",
                        max: "Email không được nhập quá 255 kí tự",
                        unique_custom: "Email trùng với email đã đăng kí",
                        email: "Email không đúng với định dạng",
                    },
                    major: {
                        required: "Ngành không được để trống",
                    },
                    course: {
                        required: "Khóa không được để trống",
                    },
                    password: {
                        required: "Mật khẩu không được để trống",
                        max: "Mật khẩu chỉ được nhập trong vòng 8 đến 16 kí tự",
                        min: "Mật khẩu chỉ được nhập trong vòng 8 đến 16 kí tự",
                        password_rule: "Mật khẩu chỉ bao gồm chữ hoặc số"
                    },
                    password_old: {
                        required: "Mật khẩu không được để trống",
                        confirmed: "Mật khẩu xác nhận phải trùng với mật khẩu đã nhập"
                    },
                    birthday: {
                        required: "Ngày sinh không được để trống",
                    },
                    gender: {
                        required: "Giới tính không được để trống",
                    },
                    phone: {
                        required: "Số điện thoại không được để trống",
                        telephone: "Số điện thoại không đúng với định dạng",
                        max: "Số điện thoại không được nhập quá 24 kí tự",
                        unique_custom_phone: "Số điện thoại trùng với số điện thoại đã đăng kí"
                    },
                    address: {
                        max: "Địa chỉ không được nhập quá 1024 kí tự",
                    }
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });
        let that = this;
        defineRule("unique_custom", (value) => {
            return axios
                .post(that.data.urlCheckEmail, {
                    _token: Laravel.csrfToken,
                    value: value,
                })
                .then(function (response) {
                    return response.data.valid;
                })
                .catch((error) => {});
        });
        defineRule("unique_custom_phone", (value) => {
            return axios
                .post(that.data.urlCheckPhone, {
                    _token: Laravel.csrfToken,
                    value: value,
                })
                .then(function (response) {
                    return response.data.valid;
                })
                .catch((error) => {});
        });

    },
    data: function () {
        return{
            csrfToken: Laravel.csrfToken,
            model: {},
            flagShowLoader: false,
        }
    },
    components: {
        VeeForm,
        Field,
        ErrorMessage,
        Datepicker,
        Loader,
    },
    props: ["data"],
    methods: {
        onInvalidSubmit({values, errors, results}) {
            let firstInputError = Object.entries(errors)[0][0];
            this.$el.querySelector("input[name=" + firstInputError + "]").focus();
            $("html, body").animate(
                {
                    scrollTop:
                        $("input[name=" + firstInputError + "]").offset().top - 150,
                },
                500
            );
        },
        onSubmit() {
            this.flagShowLoader = true
            this.$refs.formData.submit();
        },
    },
}

</script>
