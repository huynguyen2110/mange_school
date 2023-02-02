<template>
    <div class="container login">
        <div class="row justify-content-center">
            <div class="col-md-8 form-login">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <span v-if="success">
                                <p class="text-message">Một email đặt lại mật khẩu sẽ được gửi đến địa chỉ email bạn đã nhập.</p>
                                <p class="text-message">Vui lòng đặt lại mật khẩu của bạn từ URL trong email.</p>
                            </span>
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
                                        <div
                                            class="invalid-feedback d-block mb-3"
                                            v-if=" errors"
                                            role="alert"
                                        >
                                            {{ errors }}
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary px-4 btn-blue">
                                        Gửi email để đặt lại mật khẩu
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
                    email: {
                        required: "Email không được để trống",
                        max: "Email không được nhập quá 255 kí tự",
                        email: "Email không đúng với định dạng",
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
            success: "",
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
<style>
.text-message {
    text-align: center;
}
</style>
