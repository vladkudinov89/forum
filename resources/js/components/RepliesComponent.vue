<template>
    <div class="">
        <div v-for="(reply,index) in items" :key="reply.id">

            <reply-component :data="reply" @deleted="remove(index)" class="mb-3">

            </reply-component>
        </div>

        <add-reply-component :endpoint="endpoint" @created="add"></add-reply-component>
    </div>

</template>

<script>
    import ReplyComponent from './ReplyComponent.vue';
    import AddReplyComponent from "./AddReplyComponent";

    export default {

        name: 'RepliesComponent',
        components: {AddReplyComponent, ReplyComponent},
        props: ['dataReplies'],
        data() {
            return {
                items: this.dataReplies,
                endpoint: location.pathname + '/replies'
            }
        },
        methods: {
            add(reply) {
                this.items.push(reply);
                this.$emit('added');
            },
            remove(index) {
                this.items.splice(index, 1);

                this.$emit('removed');

                flash('Reply was deleted!');
            }
        },
    }
</script>

<style lang="css" scoped>
</style>