<template>
    <div>
        <div class="dropdown" v-if="notifications.length">
            <button class="btn btn-info" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="fa fa-bell"></span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                <li v-for="notification in notifications">
                    <a class="dropdown-item" :href="notification.data.link" v-text="notification.data.message"
                       @click="markAsRead(notification)"></a>
                </li>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "UserNotificationsComponent",
        data() {
            return {
                notifications: false,
                showNotification: false
            }
        },
        created() {
            axios.get("/profiles/" + window.App.user.name + "/notifications")
                .then(response => this.notifications = response.data);
        },
        methods: {
            markAsRead(notification) {
                axios.delete("/profiles/" + window.App.user.name + "/notifications/" + notification.id);
            }
        }
    }
</script>

<style scoped>

</style>