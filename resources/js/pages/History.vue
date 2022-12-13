<template>
	<div class="container">
		<h4 class="text-muted">My Bookings : <b class="text-dark">{{ user.name }}</b></h4>
		
		<HistoryComponent />
	</div>
</template>
<script type="text/javascript">
	import HistoryComponent from '../components/HistoryComponent.vue'
	import { mapGetters, mapActions } from "vuex";
	export default{
        
		components:{
			HistoryComponent
		},
		computed: {
	    	...mapGetters({ user: "getUser"}),
	 	},
	}
</script>