<template>
    <a class="btn btn-danger m-1" @click="showAlert" >
        Hủy đăng kí
    </a>
    <loader :flag-show="flagShowLoader"></loader>
</template>

<script>
import Loader from "../common/loader.vue";
import axios from "axios";
import $ from "jquery";

export default {
    data() {
        return {
            flagShowLoader: false,
        };
    },
    components: {
        Loader,
    },
    props: ["cancelAction", "listUrl", "messageConfirm", "classId", "studentUuid"],
    mounted() {
    },
    methods: {
        showAlert() {
            let that = this;
            this.$swal({
                title:
                    '<p style="font-size: 25px;">' +
                    that.messageConfirm +
                    "</p>",
                icon: "warning",
                confirmButtonText: "Có",
                confirmButtonColor: "#E55656",
                cancelButtonText: "Quay lại",
                confirmButtonClass: "btn btn-warning btn-radius-auto",
                cancelButtonClass: "btn btn-warning btn-radius-auto ",
                showCancelButton: true,
            }).then((result) => {
                if (result.value) {
                    that.flagShowLoader = true;
                    $(".loading-div").removeClass("hidden");
                    axios
                        .post(that.cancelAction, {
                            _token: Laravel.csrfToken,
                            class_id: that.classId,
                            student_id: that.studentUuid
                        })
                        .then(function (response) {
                            that.flagShowLoader = false;
                            $(".loading-div").addClass("hidden");
                            that.$swal({
                                title:
                                    '<p style="font-size: 25px;">' +
                                    response.data.message +
                                    "</p>",
                                icon: "success",
                                confirmButtonText: "Hoàn tất",
                                confirmButtonColor: "#FBAF03",
                                confirmButtonClass:
                                    "btn btn-warning btn-radius-auto",
                            }).then(function () {
                                window.location.href = that.listUrl;
                                location.reload();
                            });
                        })
                        .catch((error) => {
                            that.flagShowLoader = false;
                            that.$swal({
                                title:
                                    '<p style="font-size: 25px;">' +
                                    error.response.data.message +
                                    "</p>",
                                icon: "error",
                                confirmButtonText: "Hoàn tất",
                                confirmButtonColor: "#FBAF03",
                                confirmButtonClass:
                                    "btn btn-warning btn-radius-auto",})
                        });
                }
            });
        },
    },
};
</script>
