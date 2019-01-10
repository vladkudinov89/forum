<template>
    <div>
        <div v-if="signedIn">

            <div class="form-group">

                        <textarea
                                name="body"
                                id="body"
                                class="form-control"
                                placeholder="Have something to say?"
                                rows="5" v-model="body"
                        ></textarea>
            </div>
            <button type="submit"
                    @click="addReply"
                    class="btn btn-info">Post
            </button>
        </div>
        <p
                v-else
                class="text-center">Please <a href="/login">sing in</a> to participate in this
            discussion.</p>
    </div>
</template>

<script>
    export default {
        name: "AddReplyComponent",
        props: ['endpoint'],
        data() {
            return {
                body: ''
            }
        },
        computed: {
            signedIn() {
                return window.App.signedIn;
            }
        },
        methods: {
            addReply() {
                axios.post(this.endpoint, {
                    body: this.body
                }).then(response => {
                    this.body = '';
                    flash('Your reply has been posted.');

                    this.$emit('created', response.data);
                });
            }
        }
    }
</script>

<style scoped>

</style>