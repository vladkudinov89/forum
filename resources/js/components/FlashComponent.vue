<template>
    <div class="alert alert-success flash-style" role="alert" v-show="show">
        <strong>Success!</strong> {{body}}
    </div>
</template>

<script>
    export default {
        name: "FlashComponent",
        props: ['message'],
        data() {
            return {
                body: '',
                show: false
            }
        },
        created() {
            if (this.message) {
                this.flash(this.message);
            }
        },
        methods: {
            flash(message) {
                this.body = this.message;
                this.show = true;

                this.hide();
            },
            hide() {
                setTimeout(() => {
                    this.show = false;
                }, 3000)
            }
        }
    }

</script>

<style scoped>
    .flash-style {
        position: fixed;
        right: 25px;
        bottom: 25px;
    }
</style>