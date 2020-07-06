<template>
	<div>
		<div id="main-content">
			<form class="form-horizontal" name="iForm" v-on:submit.prevent="store">
			    <div class="row page-header">
			        <div class="col-md-6 no-padding">
			            <h3>Tambah Menu</h3>
			        </div>
			        <div class="col-md-6 no-padding">
			            <ol class="breadcrumb pull-right">
			                <li class="breadcrumb-item"><a>User & Role Management</a></li>
			                <li class="breadcrumb-item">Menu</li>
	                    	<li class="breadcrumb-item active">Tambah Menu</li>
			            </ol>
			        </div>
			    </div>
			    <div class="page-body padding15">
			    	<div class="row">
		                <div class="col-md-12">
		                    <div class="form-group">
		                        <label class="col-sm-12" for="url">* Nama:</label>
		                        <div class="col-sm-12">
		                            <input type="text" class="form-control" v-model="forms.name" required="required">
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-12" for="url">Parent:</label>
		                        <div class="col-sm-12">
		                        	<select class="form-control" required="required" v-model="forms.parent">
                                        <option value="0">
                                        	Pilih Parent Menu
                                        </option>
                                        <option v-for="row in parents" :value="row.id">
                                        	{{ row.name }}
                                        </option>
                                    </select>
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-12" for="url">* Link:</label>
		                        <div class="col-sm-12">
		                            <input type="text" class="form-control" required="required" v-model="forms.url">
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-12" for="url">* Sequence:</label>
		                        <div class="col-sm-3">
		                            <input type="number" class="form-control" v-model="forms.sequence" required="required">
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-12" for="url">Icon:</label>
		                        <div class="col-sm-5">
		                            <input type="text" class="form-control" v-model="forms.icon">
		                        </div>
		                    </div>
		                    <div class="form-group">
		                        <label class="col-sm-12" for="url">Status:</label>
		                        <div class="col-sm-12">
		                            <label class="radio-inline">
		                                <input type="radio" v-model="forms.status" value="1"><span class="label label-success">Active</span></label>
		                            <label class="radio-inline">
		                                <input type="radio" v-model="forms.status" value="2"><span class="label label-danger">Not Active</span></label>
		                        </div>
		                    </div>
		                </div>
		            </div>
			    </div>
			    <div class="page-footer-fix">
			        <div class="container-fluid">
			            <div class="col-md-6">
			            	<router-link to="/menu" title="Kembali" class="btn-rounded">
			            		<i class="fa fa-times"></i> &nbsp; Kembali
			            	</router-link>
			            	<button type="submit" title="Simpan" class="btn-rounded">
			                	<i class="fa fa-floppy-o"></i> &nbsp; Simpan
			               	</button>
			            </div>
			        </div>
			    </div>
    		</form>
        	<v-dialog v-bind:click-to-close="false"></v-dialog>
			<div v-show="!completed" id="spinner"></div>
		</div>
	</div>
</template>

<script>
	import {services} from '../../services';
	export default {
		props : ['token'],
		data() {
			return {
				completed: false,
				parents : [],
				forms : {
					parent : 0,
					sequence : 0,
					status : 1,
				},
			}
		},
		created(){
			/** check role akses **/
			services.get('auth/role',{
           		headers: {'KEY': this.token},
               	params : { 'url': 'menu'}
            }).then(response => {
            	if (response.data.iTotal && response.data.data.create) {

            		/** get list parent menu **/
			    	services.get('menu',{
		           		headers: {'KEY': this.token},
		               	params : { 'parent': 0}
		            }).then(response => {
		            	this.parents = response.data.data;
		            	this.completed = true
					})

				}else{
            		window.location = "#/access-forbidden";
				}
			},function(error){
				alert("error connection")
			})
		},
		methods : {
			store(){ 
				this.completed = false;
				services.post('menu/store',this.forms,{
		           	headers: {'KEY': this.token}
		       	}).then(response => {
		           	this.completed = true;
		           	this.$modal.show('dialog', {
		              title: '',
		              text: response.data.message,
		              buttons: [
		                {
		                    title: 'OK',
		                    handler: () => { 
		                        window.location = '#/menu';
		                    }
		                }
		             ]
		            })
				})
			},
		}
	}
</script>