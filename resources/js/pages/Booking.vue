<template>
	<div class="container">
		<h4 class="text-muted">Book : <b class="text-dark">{{ user.name }}</b></h4>
		
		<BookingComponent />
	</div>
</template>
<script type="text/javascript">
	import BookingComponent from '../components/BookingComponent.vue'
	import { mapGetters, mapActions } from "vuex";
	export default{
        
		components:{
			BookingComponent
		},
		computed: {
	    	...mapGetters({ user: "getUser"}),
	 	},
	}
</script>