<template>
</template>

<script>
import RepliesComponent from '../components/RepliesComponent.vue';

export default {
	
  name: 'Thread',
  components: {RepliesComponent},
  props : ['initialRepliesCount'],

  data () {
    return {
    	repliesCount: this.initialRepliesCount
    }
  },
}
</script>