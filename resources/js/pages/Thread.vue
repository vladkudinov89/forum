<template>
</template>

<script>
    import RepliesComponent from '../components/RepliesComponent.vue';
    import SubscribeButtonComponent from '../components/SubscribeButtonComponent';

    export default {

        name: 'Thread',
        components: {RepliesComponent, SubscribeButtonComponent},
        props: ['thread'],

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked
            }
        },
        methods: {
            toogleLock() {

                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

                this.locked = !this.locked;
            }
        }
    }
</script>