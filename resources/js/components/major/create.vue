<template>
    <div class="container-fluid">
        <div class="path d-flex aline-flex-end">
            <h3 class="list mb-4 d-flex align-self-end ml-2">Thêm ngành học</h3>
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
                                                rules="required|max:128|unique_custom_name"
                                                v-model="model.name"
                                                name="name"
                                                placeholder="Tên"
                                                id="name"
                                            />
                                            <ErrorMessage class="error" name="name"/>
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
                        unique_custom_name: "Tên trùng với tên đã đăng kí"
                    },
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });
        let that = this;
        defineRule("unique_custom_name", (value) => {
            return axios
                .post(that.data.urlCheckName, {
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
