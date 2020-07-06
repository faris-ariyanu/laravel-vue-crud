<template>
	<div>
		<div id="main-content">
			<form class="form-horizontal" name="iForm" v-on:submit.prevent="store">
			    <div class="row page-header">
			        <div class="col-md-6 no-padding">
			            <h3>Tambah Role</h3>
			        </div>
			        <div class="col-md-6 no-padding">
			            <ol class="breadcrumb pull-right">
			                <li class="breadcrumb-item"><a>User & Role Management</a></li>
			                <li class="breadcrumb-item">Role</li>
	                    	<li class="breadcrumb-item active">Tambah Role</li>
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
		                        <label class="col-sm-12" for="url">Status:</label>
		                        <div class="col-sm-12">
		                            <label class="radio-inline">
		                                <input type="radio" v-model="forms.status" value="1"><span class="label label-success">Active</span></label>
		                            <label class="radio-inline">
		                                <input type="radio" v-model="forms.status" value="2"><span class="label label-danger">Not Active</span></label>
		                        </div>
		                    </div>
		                </div>
		                <div class="clearfix"></div>
		                <div class="col-md-12">
		                    <table class="table table-striped dataTable no-footer">
		                        <thead>
		                            <tr>
		                                <td><b>Pengaturan Role Akses</b></td>
		                                <td width="10%" align="center"><b>Create</b></td>
		                                <td width="10%" align="center"><b>Read</b></td>
		                                <td width="10%" align="center"><b>Update</b></td>
		                                <td width="10%" align="center"><b>Delete</b></td>
		                            </tr>
		                        </thead>
		                        <tbody>
		                            <tr v-for="m in menus">
		                                <td>{{m.name}}</td>
		                                <td align="center"><input type="checkbox" v-model="forms.create[m.id]" v-bind:true-value="1" v-bind:false-value="0"></td>
		                                <td align="center"><input type="checkbox" v-model="forms.read[m.id]" v-bind:true-value="1" v-bind:false-value="0"></td>
		                                <td align="center"><input type="checkbox" v-model="forms.update[m.id]" v-bind:true-value="1" v-bind:false-value="0"></td>
		                                <td align="center"><input type="checkbox" v-model="forms.delete[m.id]" v-bind:true-value="1" v-bind:false-value="0"></td>
		                            </tr>
		                        </tbody>
		                    </table>
		                </div>
		            </div>
			    </div>
			    <div class="page-footer-fix">
			        <div class="container-fluid">
			            <div class="col-md-6">
			            	<router-link to="/role" title="Kembali" class="btn-rounded">
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
				menus : [],
				forms : {
					status : 1,
					create : {},
					read : {},
					update : {},
					delete : {},
				},
			}
		},
		created(){
			/** check role akses **/
			services.get('auth/role',{
           		headers: {'KEY': this.token},
               	params : { 'url': 'role'}
            }).then(response => {
            	if (response.data.iTotal && response.data.data.create) {

            		/** get list menu **/
			    	services.get('menu',{
		           		headers: {'KEY': this.token},
		               	params : {'status': 1}
		            }).then(response => {
		            	this.menus = response.data.data;
		            	this.completed = true;
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
				this.forms.role = this.setArrayRole();
				services.post('role/store',this.forms,{
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
		                        window.location = '#/role';
		                    }
		                }
		             ]
		            })
				})
			},
			setArrayRole(){
				let roles     = [];
                for (let i = 0; i < this.menus.length; i++) {
                    var id  = this.menus[i].id;
                    var arr = {
                         "menu_id": this.menus[i].id,
                         "role": {
                             "create": (this.forms.create!=undefined && this.forms.create[id])?1:0,
                             "read": (this.forms.read!=undefined && this.forms.read[id])?1:0,
                             "update": (this.forms.update!=undefined && this.forms.update[id])?1:0,
                             "delete": (this.forms.delete!=undefined && this.forms.delete[id])?1:0,
                         }
                    };
                    
                    roles.push(arr);
                }

                return roles;
			}
		}
	}
</script>