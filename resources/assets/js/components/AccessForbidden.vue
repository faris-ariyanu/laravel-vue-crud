<template>
	<div>
		<div id="main-content">
		    <div class="page-body">
		    	<h3><i class="fa fa-warning"></i> Access Forbidden</h3>
		        <h5>
		        	 Anda tidak diijinkan untuk mengakses halaman ini.
		        </h5>
		    </div>
		</div>
		<div v-show="!completed" id="spinner"></div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				completed : true,
			}
		},
	}
</script>