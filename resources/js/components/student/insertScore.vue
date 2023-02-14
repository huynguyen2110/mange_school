<template>
    <div class="container-fluid">
        <div class="path d-flex aline-flex-end">
            <h3 class="list mb-4 d-flex align-self-end ml-2">Nhập điểm</h3>
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
                                        <input type="hidden" :value="data.class_id" name="class_id"/>
                                        <input type="hidden" :value="data.student_id" name="student_id"/>

                                        <div class="mb-4">
                                            <label for="midterm_score" class="form-label"
                                            >Điểm giữa kì <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="number"
                                                class="form-control"
                                                v-model="model.midterm_score"
                                                max="10"
                                                min="0"
                                                name="midterm_score"
                                                rules="max_value:10|numeric|required"
                                                id="midterm_score"
                                            />
                                            <ErrorMessage class="error" name="midterm_score"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="final_score" class="form-label"
                                            >Điểm cuối kì <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="number"
                                                class="form-control"
                                                v-model="model.final_score"
                                                max="10"
                                                min="0"
                                                rules="max_value:10|numeric|required"
                                                name="final_score"
                                                id="final_score"
                                            />
                                            <ErrorMessage class="error" name="final_score"/>
                                        </div>
                                        <div class="mb-4">
                                            <label for="total" class="form-label"
                                            >Điểm tổng <span class="required-label">*</span></label
                                            >
                                            <Field
                                                type="text"
                                                readonly
                                                class="form-control"
                                                v-model="model.total"
                                                name="total"
                                                id="total"
                                            >
                                            </Field>
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
                    midterm_score: {
                        required: "Điểm giữa kì không được để trống",
                        max_value: "Điểm giữa kì không được nhập quá 10",
                        numeric: "Điểm giữa kì chỉ được nhập số từ 1 đến 10"
                    },
                    final_score: {
                        required: "Điểm cuối kì không được để trống",
                        max_value: "Điểm cuối kì không được nhập quá 10",
                        numeric: "Điểm cuối kì chỉ được nhập số từ 1 đến 10"
                    },
                },
            },
        };
        configure({
            generateMessage: localize(messError),
        });
    },
    mounted() {

        this.$watch( vm => [vm.model.midterm_score, vm.model.final_score],() => {
            if(this.model.midterm_score != undefined && this.model.final_score != undefined) {
                this.model.total = Number((this.model.midterm_score * 0.3 + this.model.final_score * 0.7).toFixed(1));
            }
        });


    },
    data: function () {
        return{
            csrfToken: Laravel.csrfToken,
            model: this.data.score,
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
