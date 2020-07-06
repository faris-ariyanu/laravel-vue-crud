export const routes = 
[
	{path: '/access-forbidden',name: 'AccessForbidden',component: require('./components/AccessForbidden.vue')},
	
	/**Menu**/
	{path: '/menu',name: 'listmenu',component: require('./components/menu/list.vue')},
	{path: '/menu/store',name: 'storemenu',component: require('./components/menu/store.vue')},
	{path: '/menu/edit/:id',name: 'editmenu',component: require('./components/menu/edit.vue')},

	/**Role**/
	{path: '/role',name: 'listrole',component: require('./components/role/list.vue')},
	{path: '/role/store',name: 'storerole',component: require('./components/role/store.vue')},
	{path: '/role/edit/:id',name: 'editrole',component: require('./components/role/edit.vue')},
	
	/**User**/
	{path: '/user',name: 'listuser',component: require('./components/user/list.vue')},
	{path: '/user/store',name: 'storeuser',component: require('./components/user/store.vue')},
	{path: '/user/edit/:id',name: 'edituser',component: require('./components/user/edit.vue')},

]