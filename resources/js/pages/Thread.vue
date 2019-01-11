<template>
</template>

<script>
import RepliesComponent from '../components/RepliesComponent.vue';
import SubscribeButtonComponent from '../components/SubscribeButtonComponent';

export default {
	
  name: 'Thread',
  components: {RepliesComponent , SubscribeButtonComponent},
  props : ['initialRepliesCount'],

  data () {
    return {
    	repliesCount: this.initialRepliesCount
    }
  },
}
</script>