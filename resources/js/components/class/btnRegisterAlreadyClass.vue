<template>
    <a class="btn btn-warning m-1" @click="showAlert" >
        Đăng kí học
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
    props: ["registerAction", "listUrl", "messageConfirm", "classId", "studentUuid"],
    mounted() {
        console.log(this.studentUuid);
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
                confirmButtonText: "Quay lại",
                confirmButtonClass: "btn btn-warning btn-radius-auto",

            })
        },
    },
};
</script>
