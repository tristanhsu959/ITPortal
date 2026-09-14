/* Role Create JS */

document.addEventListener('alpine:init', () => {
	Alpine.data('userData', (viewData) => ({
		response: {...viewData.response},
		formData: {...viewData.formData},
		options: {...viewData.options},
		errors: new Set(),
		showPassword: false,
		
		init() {},
		
		validate() {
			this.errors.clear();
			
			if (Helper.isEmpty(this.formData.account))
				this.errors.add('account');
			if (Helper.isEmpty(this.formData.password) && this.formData.id == 0)
				this.errors.add('password');
						
			const pattern = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/;
			
			if (! Helper.isEmpty(this.formData.password) && ! pattern.test(this.formData.password)) 
			{
				this.errors.add('password');
				Alpine.store('toast').notify('密碼須包含英數，6個字元以上');
			}
			
			if (this.errors.size == 0)
			{
				this.$dispatch('show-loading');
				this.$el.submit();
			}
			else
				return false;
		},
		
		reset() {
			this.formData.account = '';
			this.formData.password = '';
			this.formData.displayName = '';
			this.formData.department = '';
			this.formData.email = '';
			this.formData.permission = [];
			this.formData.opCenter = [];
			this.formData.salesArea = [];
			this.formData.purchaseArea = [];
			this.formData.description = '';
		}
    }));
});

