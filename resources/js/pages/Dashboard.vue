<template>
	<div class="container">
		<h4 class="text-muted">Dashboard : <b class="text-dark">{{ user.name }}</b></h4>
		<DashboardComponent />
	</div>
</template>
<script type="text/javascript">
	import DashboardComponent from '../components/DashboardComponent.vue'
	import { mapGetters, mapActions } from "vuex";
	export default{
		components:{
			DashboardComponent
		},
		computed: {
	    	...mapGetters({ user: "getUser"}),
	 	},
	}
</script>