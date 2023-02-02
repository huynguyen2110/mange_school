<template>
    <div class="container login">
        <div class="row justify-content-center">
            <div class="col-md-8 form-login">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">

                            <div v-if="success">
                                <div class="mb-4">
                                    <span class="text-black"> {{ message }}</span>
                                </div>
                                <a :href="data.urlLogin" class="text-decoration-none">
                                    Trở về trang đăng nhập
                                </a>
                            </div>

                            <VeeForm
                                as="div"
                                v-slot="{ handleSubmit }"
                                @invalid-submit="onInvalidSubmit"
                                v-else
                            >
                                <form
                                    method="POST"
                                    @submit="handleSubmit($event, onSubmit)"
                                    ref="formData"
                                    :action="data.urlStore"
                                    id="form-data"
                                >
                                    <input type="hidden" :value="csrfToken" name="_token"/>
                                    <input type="hidden" :value="token" name="token"/>
                                    <div class="mb-4 ">
                                        <Field
                                            type="password"
                                            class="form-control form-input"
                                            v-model="model.password"
                                            name="password"
                                            rules="required|max:16|min:8|password_rule"
                                            placeholder="Mật khẩu mới"
                                            id="password"
                                        />
                                        <ErrorMessage class="error" name="password"/>
                                    </div>
                                    <div class="mb-4 ">
                                        <Field
                                            type="password"
                                            class="form-control form-input"
                                            v-model="model.password_confirm"
                                            name="password_confirm"
                                            rules="required|confirmed:@password"
                                            placeholder="Xác nhận mật khẩu mới"
                                            id="password_confirm"
                                        />
                                        <ErrorMessage class="error" name="password_confirm"/>
                                    </div>
                                    <div
                                        class="invalid-feedback d-block mb-3"
                                        v-if=" errors"
                                        role="alert"
                                    >
                                        {{ errors }}
                                    </div>
                                    <div class="row"></div>
                                    <button type="submit" class="btn btn-primary px-4 btn-blue">
                                        Đổi mật khẩu
                                    </button>
                                </form>
                            </VeeForm>
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
import {localize} from "@vee-validate/i18n";
import * as rules from "@vee-validate/rules";
import $ from "jquery";
import Loader from "../common/loader.vue";
import axios from "axios";
export default {
    setup() {
        Object.keys(rules).forEach((rule) => {
            if (rule != "default") {
                defineRule(rule, rules[rule]);
            }
        });
    },
    props: ["data"],
    created() {
        let messError = {
            en: {
                fields: {
                    password: {
                        required: "Mật khẩu không được để trống",
                        max: "Mật khẩu chỉ được nhập trong vòng 8 đến 16 kí tự",
                        min: "Mật khẩu chỉ được nhập trong vòng 8 đến 16 kí tự",
                        password_rule: "Mật khẩu chỉ bao gồm chữ hoặc số"
                    },
                    password_confirm: {
                        required: "Mật khẩu không được để trống",
                        confirmed: "Mật khẩu xác nhận phải trùng với mật khẩu đã nhập"
                    },
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });
    },
    components: {
        VeeForm,
        Field,
        ErrorMessage,
        Loader,

    },
    data() {
        return {
            csrfToken: Laravel.csrfToken,
            model: {},
            flagShowLoader: false,
            errors: '',
            token: window.location.search.split("?reset_password_token=")[1],
            success: '',
        };
    },
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
            this.flagShowLoader = true;
            let that = this;
            axios
                .post(this.data.urlStore, $('#form-data').serialize())
                .then(function (response) {
                    that.success = true;
                    that.message = response.data.message;
                    that.flagShowLoader = false;
                })
                .catch((errors) => {
                    that.flagShowLoader = false;
                    that.errors = errors.response.data.message;
                })
        },
    },
};
</script>
