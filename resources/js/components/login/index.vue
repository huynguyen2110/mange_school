<template>
    <div class="container login">
        <div class="row justify-content-center">
            <div class="col-md-8 form-login">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
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
                                    id="form-data"
                                >
                                    <input type="hidden" :value="csrfToken" name="_token"/>
                                    <div class="mb-4">
                                        <Field
                                            type="text"
                                            class="form-control form-input"
                                            v-model="model.email"
                                            rules="required|max:255|email"
                                            name="email"
                                            placeholder="Email"
                                            id="email"
                                        />
                                        <ErrorMessage class="error" name="email"/>
                                    </div>
                                    <div class="mb-4 ">
                                        <Field
                                            type="password"
                                            class="form-control form-input"
                                            v-model="model.password"
                                            name="password"
                                            rules="required"
                                            placeholder="Password"
                                            id="password"
                                        />
                                        <ErrorMessage class="error" name="password"/>
                                    </div>

                                    <div class="row"></div>
                                    <div class="form-group">
                                        <a
                                            class="text-decoration-none"
                                            :href="this.data.urlForgotPassword"
                                        >
                                            Quên mật khẩu?
                                        </a>
                                    </div>
                                    <div
                                        class="invalid-feedback d-block mb-1"
                                        v-if="error"
                                        role="alert"
                                    >
                                        {{ error }}
                                    </div>
                                    <button type="submit" class="btn btn-primary px-4 btn-blue">
                                        Đăng nhập
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
    created() {
        let messError = {
            en: {
                fields: {
                    email: {
                        required: "Email không được để trống",
                        max: "Email không được nhập quá 255 kí tự",
                        email: "Email không đúng với định dạng",
                    },
                    password: {
                        required: "Mật khẩu không được để trống",
                    }
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
            error: '',
        };
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
            this.flagShowLoader = true;
            let that = this;
            axios
                .post(this.data.urlStore, $('#form-data').serialize())
                .then(function (response) {
                    that.flagShowLoader = false;
                    location.href = response.data.url_redirect;
                })
                .catch((error) => {
                    that.flagShowLoader = false;
                    that.error = error.response.data.message;
                })
        },
    },
};
</script>


