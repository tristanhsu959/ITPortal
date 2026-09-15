/* Role Create JS */

document.addEventListener('alpine:init', () => {
	Alpine.data('userData', (viewData) => ({
		response: {...viewData.response},
		formData: {...viewData.formData},
		options: {...viewData.options},
		errors: new Set(),
		showPassword: false,
		
		init() {
		},
		
		validate() {
			this.errors.clear();
			
			
			if (this.formData.roleId == 0)
				this.errors.add('roleId');
			if (Helper.isEmpty(this.formData.account))
				this.errors.add('account');
			if (Helper.isEmpty(this.formData.password) && this.formData.id == 0)
				this.errors.add('password');
			if (Helper.isEmpty(this.formData.email))
				this.errors.add('email');
						
			if (! Helper.isEmpty(this.formData.password) && ! Helper.isValidPassword(this.formData.password)) 
			{
				this.errors.add('password');
				Alpine.store('toast').notify('密碼須包含英數，6個字元以上');
			}
			
			if (! Helper.isEmpty(this.formData.email) && ! Helper.isValidEmail(this.formData.email)) 
				this.errors.add('email');
			
			if (this.errors.size == 0)
			{
				this.$dispatch('show-loading');
				this.$el.submit();
			}
			else
				return false;
		},
		
		reset() {
			this.formData.displayName = '';
			this.formData.department = '';
			this.formData.roleId = 0;
			this.formData.account = '';
			this.formData.password = '';
			this.formData.email = '';
		}
    }));
});

