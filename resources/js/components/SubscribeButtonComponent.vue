<template>
    <button :class="classes" @click="subscribe">Subscribe</button>
</template>

<script>
    export default {
        name: "SubscribeButtonComponent",
        props: ['active'],
        data(){
          return {
              activeBtn: this.active
          }
        },
        computed: {
            classes() {
                return ['btn', this.activeBtn ? 'btn-info' : 'btn-outline-info'];
            },
        },
        methods: {
            subscribe() {
                axios[
                    (this.activeBtn ? 'delete' : 'post')
                    ](location.pathname + '/subscriptions');

                this.activeBtn = ! this.activeBtn;

            }
        },
    }
</script>

<style scoped>

</style>