<template>
    <button type="button" :class="classes" @click="toggle">
        <span class="fa fa-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
    export default {
        name: "FavoriteComponent",
        props: ['reply'],
        data() {
            return {
                favoritesCount: this.reply.favoritesCount,
                isFavorited: this.reply.isFavorited
            }
        },
        computed: {
            classes() {
                return ['btn', this.isFavorited ? 'btn-primary' : 'btn-outline-secondary'];
            },
            endpoint() {
                return '/replies/' + this.reply.id + '/favorites';
            }
        },
        methods: {
            unfavorited() {
                axios.delete(this.endpoint);
                this.isFavorited = false;
                this.favoritesCount--;
            },
            favorited() {
                axios.post(this.endpoint);
                this.isFavorited = true;
                this.favoritesCount++;
            },
            toggle() {
                this.isFavorited ? this.unfavorited() : this.favorited()
            }
        },
    }
</script>

<style scoped>

</style>