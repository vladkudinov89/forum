<template>
    <div>
        <div :id="'reply-'+id" class="card-header d-flex justify-content-between">
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

                        <div class="form-group">
                            <textarea v-model="body" class="form-control"></textarea>
                        </div>

                        <button class="btn btn-sm btn-primary" @click="update">Update</button>
                        <button class="btn btn-sm btn-link" @click="editing = false">Cancel</button>

                    </div>

                    <div class="body" v-else v-text="body"></div>
                </div>

            </div>

            <div class="card-footer d-flex" v-if="canUpdate">
                <button type="button" class="btn btn-secondary btn-sm mr-2" @click="editing = true">Edit</button>
                <button type="button" class="btn btn-danger btn-sm" @click="destroy">Delete</button>
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
                body: this.data.body
            }
        },
        computed: {
            ago() {
                return moment(this.data.created_at).fromNow();
            },
            signedIn() {
                return window.App.signedIn;
            },
            canUpdate() {
                return this.autorize(user => this.data.user_id == user.id);
            }
        },
        methods: {
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
            }
        }
    }
</script>