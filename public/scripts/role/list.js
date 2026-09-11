/* JS */

document.addEventListener('alpine:init', () => {
	Alpine.store('roleFilter', {
		filter: '',
		
		reset(){
			this.filter = '';
		}
	});
	
    Alpine.data('roleList', (listData) => ({
		list: {...listData.data},
		response: {...listData.response},
		
		init(){
		},
		
		get filterRoles() {
			const searchKeyword = Alpine.store('roleFilter').filter.toLowerCase();
			const list = Object.values(this.list);
			
			const result = list.filter(role => 
				String(role.roleName || '').toLowerCase().includes(searchKeyword) ||
				String(role.isActive ?? 0).toLowerCase().includes(String(searchKeyword).toLowerCase())
			);
			
			return result;
		},
		
		/* Delete */
		confirmDelete(url) {
			Alpine.store('dialog').show('確定要刪除此帳號?', true, () => this.deleteRole(url));
		},
		
		/* Delete callback */
		deleteRole(url) {
			this.$dispatch('show-loading');
			const form = this.$refs.roleListForm;
            form.action = url;
            form.submit();
		}
    }));
});
