<template>
	<div>
		<div class="d-flex">
			<img :src="avatar"
			width="50" height="50" alt=""
			class="mr-3"
			>

			<h1 v-text="user.name"></h1>
		</div>


		<form 
		v-if="canUpdate"
		method="POST"
		enctype="multipart/form-data">

		<image-upload-component name="avatar" @loaded="onLoad"></image-upload-component>

	</form>

</div>
</template>

<script>
import ImageUploadComponent from './ImageUploadComponent.vue';

export default {

	name: 'AvatarComponent',

	props: ['user'],

	components : {ImageUploadComponent},

	data () {
		return {
			avatar : this.user.avatar_path
		}
	},
	computed: {
		canUpdate(){
			return this.autorize(user => user.id === this.user.id);
		}
	},
	methods : {
		onLoad(avatar){
			this.avatar = avatar.src;

			this.persist(avatar.file);
		},
		persist(avatar){

			let data = new FormData();

			data.append('avatar' , avatar);


			axios.post(`/api/users/${this.user.name}/avatar` , data)
			.then(() => flash('Avatar Upload!'));
		}
	}
}
</script>

<style lang="css" scoped>
</style>