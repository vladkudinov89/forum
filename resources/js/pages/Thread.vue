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
                locked: this.thread.locked,
                editing: false,
                title: this.thread.title,
                body: this.thread.body,
                form: {}
            }
        },
        created(){
          this.resetForm();
        },
        methods: {
            toogleLock() {

                axios[this.locked ? 'delete' : 'post']('/locked-threads/' + this.thread.slug);

                this.locked = !this.locked;
            },
            cancel() {
                this.resetForm();
            },
            update() {
                let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;
                axios.patch(uri, this.form).then(() => {
                    this.editing = false;
                    this.title = this.form.title;
                    this.body = this.form.body;


                    flash('Your Thread has been Updated!')
                });
            },
            resetForm() {
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body
                };

                this.editing = false;
            }
        }
    }
</script>