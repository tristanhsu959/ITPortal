/* Role Create JS */

document.addEventListener('alpine:init', () => {
    Alpine.data('roleData', (response) => ({
		response: {...response},
		errors: new Set(),
		
		init(){
			
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
			this.formData.permission = [];
			this.formData.area = [];
			this.errors.clear();
		}
    }));
});
