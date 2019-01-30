<template>
	<div>
		<input id="trix" type="hidden" :name="name" :value="value">
		<trix-editor ref="trix" input="trix"></trix-editor>
	</div>
</template>

<script>

import Trix from 'trix';

export default {

	name: 'WysiwygComponent',
	props : ['name' , 'value'],
	data () {
		return {

		}
	},
	mounted(){
		this.$refs.trix.addEventListener('trix-change' , e => {
			this.$emit('input' , e.target.innerHTML);
		});
	},
}
</script>

<style lang="css" scoped>
</style>