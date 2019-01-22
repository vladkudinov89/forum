<template>
    <div>
        <div v-if="signedIn">

            <div class="form-group">

                        <textarea
                                name="body"
                                id="body"
                                class="form-control"
                                placeholder="Have something to say?"
                                rows="5"
                                v-model="body"
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
    import 'jquery.caret';
    import 'at.js';

    export default {
        name: "AddReplyComponent",
        data() {
            return {
                body: ''
            }
        },
        mounted() {
          $('textarea#body').atwho({
             at : "@",
             delay : 750,
             callbacks : {
                 remoteFilter: function (query , callback) {
                     $.getJSON("/api/users" , {name: query} , function (usernames) {
                         callback(usernames);
                     })
                 }
             } 
          });
        },
        methods: {
            addReply() {
                axios.post(location.pathname + '/replies', {
                    body: $('#body').val()
                })
                    .then(response => {
                        this.body = '';
                        flash('Your reply has been posted.');

                        this.$emit('created', response.data);
                    })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });
            }
        }
    }
</script>

<style scoped>

</style>