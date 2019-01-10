<template>
    <div class="">
        <div v-for="(reply,index) in items" :key="reply.id">

            <reply-component :data="reply" @deleted="remove(index)" class="mb-3">

            </reply-component>
        </div>

        <paginator-component :dataSet="dataSet" @changed="fetch"></paginator-component>

        <add-reply-component @created="add"></add-reply-component>
    </div>

</template>

<script>
    import ReplyComponent from './ReplyComponent.vue';
    import AddReplyComponent from "./AddReplyComponent";
    import collection from '../mixins/collection';

    export default {

        name: 'RepliesComponent',

        components: {AddReplyComponent, ReplyComponent},

        mixins: [collection],

        data() {
            return {
                dataSet: false
            }
        },
        created() {
            this.fetch();
        },
        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh);
            },
            url(page) {
                if (! page)
                {
                    let query = location.search.match(/page=(\d+)/);

                    page = query ? query[1] : 1;
                }

                return `${location.pathname}/replies?page=${page}`;
            },
            refresh({data}) {
                this.dataSet = data;
                this.items = data.data;

                window.scrollTo(0,0);
            }
        },
    }
</script>

<style lang="css" scoped>
</style>