<template>
	<div>
		<div id="main-content">
		    <div class="row page-header">
		        <div class="col-md-6 no-padding">
		            <h3>User</h3>
		        </div>
		        <div class="col-md-6 no-padding">
		            <ol class="breadcrumb pull-right">
		                <li class="breadcrumb-item"><a>User & Role Management</a></li>
		                <li class="breadcrumb-item active">User</li>
		            </ol>
		        </div>
		    </div>
		    <div class="page-body">
		        <div class="col-md-12 no-padding margin-bottom15">
		            <div class="col-md-3 pull-right no-padding">
		                <div class="input-group">
		                    <input type="text" placeholder="Pencarian" v-model="config.search" v-on:keyup.enter="get()" class="form-control" />
		                    <a href="javascript:void(0)" v-on:click="get()" class="input-group-addon">
		                        <i class="fa fa-search"></i>
		                    </a>    
		                </div>
		            </div>
		        </div>
		        <table id="systable" class="table table-striped dataTable no-footer">
		            <thead v-if="config.iTotal">
		                <tr>
		                    <th v-for="h in config.header" :width="h.width">
		                        <a v-if="h.value" 
		                        	class="sort dark-font" :id="h.value"
		                        	v-on:click="sort(h.value)"
		                        	href="javascript:void(0)">
		                            {{h.title}}
		                            <i class="fa fa-sort"></i>
		                        </a>
		                        <a v-if="!h.value"
		                        	class="sort dark-font" :id="h.value"
		                        	href="javascript:void(0)">
		                            {{h.title}}
		                        </a>
		                    </th>
		                </tr>
		            </thead>
		            <tbody>
		                <tr v-if="config.iTotal" v-for="data in config.datas">
		                    <td>{{data.username}}</td>
		                    <td>{{data.fullname}}</td>
		                    <td>{{data.role.name}}</td>
		                    <td>
		                    	<span :class="'label label-'+data.status.class">
		                    		{{data.status.name}}
		                    	</span>
		                    </td>
		                    <td align="center">
		                    	<router-link :to="'user/edit/'+data.id" v-if="role.update" title="Edit" class="btn btn-default">
		            				<i class="fa fa-pencil"></i>
		            			</router-link>
		                        <button v-on:click="destroy(data.id)" v-if="role.delete" title="Hapus" class="btn btn-default">
		                        	<i class="fa fa-trash"></i>
		                        </button>
		                    </td>
		                </tr>
		                <tr v-if="!config.iTotal">
		                    <td colspan="config.header.length" align="center"> No data evailable. </td>
		                </tr>
		            </tbody>
		            <tfoot v-if="config.iTotal">
		                <tr>
		                    <td :colspan="config.header.length">
		                        <div class="pull-left">
		                            <p>Total {{config.iTotal}} data</p>
		                        </div>
		                        <div class="pull-right pagination">
		                            <b-pagination @change="gotoPage" :total-rows="config.iTotal" v-model="config.page" :per-page="config.limit">
                                	</b-pagination>
		                        </div>
		                    </td>
		                </tr>
		            </tfoot>
		        </table>
		    </div>
		    <div class="page-footer-fix">
		        <div class="container-fluid">
		            <div class="col-md-6">
		            	<router-link to="user/store" v-if="role.create" title="Tambah" class="btn-rounded">
		            		<i class="fa fa-plus"></i> &nbsp; Tambah
		            	</router-link>
		            	<button v-on:click="get()" title="Refresh" class="btn-rounded">
		                	<i class="fa fa-refresh"></i> &nbsp; Refresh
		               	</button>
		            </div>
		        </div>
		    </div>
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
				role : [],
				config : {
					"datas": [],
	                "iTotal": 0,
	                "limit": 20,
	                "offset": 0,
	                "orderby": "id",
	                "sort": "desc",
	                "page": 1,
	                "search" : "",
	                "header": [{
	                    "title": "Username",
	                    "value": "username",
	                    "width": "20%",
	                },{
	                    "title": "Nama",
	                    "value": "fullname",
	                    "width": "30%",
	                },{
	                    "title": "Role",
	                    "value": "role_id",
	                    "width": "25%",
	                },{
	                    "title": "Status",
	                    "value": "status",
	                    "width": "15%",
	                }, {
	                    "title": "",
	                    "value": false,
	                    "width": "15%",
	                }],
				}
			}
		},
		created(){
			/** check role akses **/
			services.get('auth/role',{
           		headers: {'KEY': this.token},
               	params : { 'url': 'user'}
            }).then(response => {
            	if (response.data.iTotal) {
            		this.role = response.data.data;
			    	this.get();
				}else{
            		window.location = "#/access-forbidden";
				}
			},function(error){
				alert("error connection")
			})
		},
		methods : {
			/** load data to table **/
			get(){ 
				this.completed = false;
				services.get('user',{
                	headers: {'KEY': this.token},
                	params:{ 
                		'search': this.config.search,
                		'limit': this.config.limit,
                        'offset': this.config.offset,
                        'orderby': this.config.orderby,
                        'sort': this.config.sort,
                    }
            	})
			    .then(response => {
			    	this.config.datas = response.data.data;
                    this.config.iTotal= response.data.iTotal;
            		this.completed = true;
			   	})
			},
			sort(orderby) {
                this.config.orderby = orderby;
                this.config.sort = (this.config.sort == "asc") ? "desc" : "asc";
                var elm = $("#" + orderby + ' i');
                elm.removeClass();
                elm.addClass("fa fa-sort-" + this.config.sort);
                this.get();
            },
            gotoPage() {
                this.config.offset = (parseInt(this.config.page) - 1) * parseInt(this.config.limit);
                this.get();
            },
            destroy(id){
            	this.$modal.show('dialog', {
	              title: '',
	              text: 'Yakin akan menghapus data?',
	              buttons: [
	                {
	                    title: 'Ya',
	                    handler: () => { 
	                        this.$modal.hide('dialog')
	                        this.completed     = true
	                        services.delete('user/delete',
	                       	{
	                        	headers: {'KEY': this.token},
	                        	params:{ 'id': id }
	                        }).then(response => {
	                            this.get()
	                        })
	                        .catch(error => {
	                            this.completed = true
	                            alert("error connection")
	                        })
	                    }
	                },
	                {
	                  title: 'Tidak'
	                }
	             ]
	            })
            }
		}
	}
</script>