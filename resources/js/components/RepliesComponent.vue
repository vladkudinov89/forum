<template>
    <div class="">
        <div v-for="(reply,index) in items">

            <reply-component :data="reply" @deleted="remove(index)" class="mb-3">

            </reply-component>
        </div>
    </div>

</template>

<script>
    import ReplyComponent from './ReplyComponent.vue';

    export default {

      name: 'RepliesComponent',
      components : {ReplyComponent},
      props: ['dataReplies'],
      data () {
        return {
            items : this.dataReplies
        }
    },
    methods: {
         remove(index) {
            this.items.splice(index , 1);

            this.$emit('removed');

            flash('Reply was deleted!');
        }
    },
}
</script>

<style lang="css" scoped>
</style>