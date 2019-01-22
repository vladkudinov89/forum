<template>
    <div>
        <div :id="'reply-'+id" class="card-header d-flex justify-content-between" :class="isBest ? 'alert-success' : ''">
            <div class="">
                <a :href="'/profiles/' + data.owner.name" v-text="data.owner.name"></a>
                said <span v-text="ago"></span>...
            </div>

            <div v-if="signedIn">
                <favorite-component :reply="data">

                </favorite-component>
            </div>


        </div>

        <div class="card">

            <div class="card-body">
                <div class="body">

                    <div class="body" v-if="editing">
                        <form @submit="update" action="#">
                            <div class="form-group">
                                <textarea v-model.trim="body" class="form-control" required></textarea>
                            </div>

                            <button class="btn btn-sm btn-primary">Update</button>
                            <button class="btn btn-sm btn-link" @click="cancel" type="button">Cancel</button>
                        </form>
                    </div>

                    <div class="body" v-else v-html="body"></div>
                </div>

            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
               <div class="" v-if="autorize('updateReply', reply)">
                   <button type="button" class="btn btn-secondary btn-sm mr-2" @click="editing = true">Edit</button>
                   <button type="button" class="btn btn-danger btn-sm" @click="destroy">Delete</button>
               </div>
                <div class="">
                    <button type="button" class="btn btn-outline-secondary" v-show="! isBest" @click="markBestReply">
                        <span class="fa fa-thumbs-up"></span>
                    </button>
                </div>
            </div>

        </div>
    </div>

</template>

<script>
    import moment from 'moment';

    export default {

        props: ['data'],
        name: 'ReplyComponent',
        data() {
            return {
                editing: false,
                id: this.data.id,
                body: this.data.body,
                isBest: this.data.isBest,
                reply : this.data
            }
        },
        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
            }
        },
        created(){
          window.events.$on('best-reply-selected' , id => {
            this.isBest = (id === this.id);
          });
        },
        methods: {
            cancel() {
                this.body = this.data.body;
                this.editing = false;
            },
            update() {
                axios.patch('/replies/' + this.data.id, {
                    body: this.body
                })
                    .catch(error => {
                        flash(error.response.data, 'danger');
                    });

                this.editing = false;

                flash('Updated!');
            },
            destroy() {
                axios.delete('/replies/' + this.data.id);

                this.$emit('deleted', this.data.id);
            },
            markBestReply(){
                axios.post('/replies/' + this.data.id + '/best').then(() => {
                    flash('Best Reply Marked!');
                });

                window.events.$emit('best-reply-selected' , this.data.id)
            }
        }
    }
</script>