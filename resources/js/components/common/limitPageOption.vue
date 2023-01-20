<template>
    <div class="pageSizeForm form-horizontal">
        <select
            id="pageSize"
            class="form-control page-size-select cursor-point"
            name="limit"
            @change="onChange($event)"
        >
            <option
                v-for="value in limitPageOption"
                :key="'option_' + value"
                :value="value"
                v-bind:selected="value == newSizeLimit"
            >
                {{ value + " bản ghi" }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        limitPageOption: {
            type: Array,
        },
        newSizeLimit: {
            type: Number,
        },
    },
    methods: {
        onChange(event) {
            let pathname = window.location.pathname;
            let search = window.location.search;
            if (search.indexOf("limit_page=") >= 0) {
                search = search.replace(
                    /page=([0-9]*)/gi,
                    "page=1"
                )
                search = search.replace(
                    /limit_page=([0-9]*)/gi,
                    "limit_page=" + event.target.value
                );
            } else {
                if (search == "") {
                    search = search.replace(
                        /page=([0-9]*)/gi,
                        "page=1"
                    )
                    search = search + "?limit_page=" + event.target.value;
                } else {
                    search = search.replace(
                        /page=([0-9]*)/gi,
                        "page=1"
                    )
                    search = search + "&limit_page=" + event.target.value;
                }
            }
            // newURL = window.location.origin + pathname + search;
            window.location = window.location.origin + pathname + search;
        },
    },
};
</script>
