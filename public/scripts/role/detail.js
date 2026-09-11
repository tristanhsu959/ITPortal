/* Role Create JS */

document.addEventListener('alpine:init', () => {
    Alpine.data('roleData', (viewData) => ({
		response: {...viewData.response},
		formData: {...viewData.formData},
		options: {...viewData.options},
		activeTab: '',
		errors: new Set(),
		
		init(){
			const tabKey = Object.keys(this.options.functions)[0];
			this.activeTab = tabKey;
		},
		
        validate() {
			this.errors.clear();
			
			if (Helper.isEmpty(this.formData.name))
				this.errors.add('name');
			
			if (this.errors.size == 0)
			{
				this.$dispatch('show-loading');
				this.$el.submit();
			}
			else
				return false;
		},
		
		reset() {
			this.formData.name = '';
			this.formData.isActive = true;
			this.formData.permission = [];
			this.errors.clear();
		}
    }));
});
