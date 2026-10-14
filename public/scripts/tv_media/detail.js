/* Role Create JS */

document.addEventListener('alpine:init', () => {
	Alpine.data('mediaData', (viewData) => ({
		response: {...viewData.response},
		formData: {...viewData.formData},
		previewUrl: '',
		options: {...viewData.options},
		errors: new Set(),
		
		init() {this.formData.uploadFile = 'test';
		},
		
		handleFileChange(event) {
			const file = event.target.files[0];
            
			if (file)
			{
				if (this.previewUrl)
                    URL.revokeObjectURL(this.previewUrl); //釋放舊的記憶體
				
				this.previewUrl = URL.createObjectURL(file);
			}
			else
				this.previewUrl = '';
		},
		
		validate() {
			this.errors.clear();
			
			if (Helper.isEmpty(this.formData.name))
				this.errors.add('name');
			
			if (this.formData.type == 'image' && Helper.isEmpty(this.formData.uploadFile))
				this.errors.add('uploadFile');
			
			if (this.formData.type == 'link' && Helper.isEmpty(this.formData.uploadLink))
				this.errors.add('uploadLink');
			
			if (this.formData.stDate && this.formData.endDate)
			{
				if (new Date(this.formData.stDate) > new Date(this.formData.endDate))
				{
					this.errors.add('endDate');
					Alpine.store('toast').notify('結束日期不可小於開始日期');
				}
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
			this.formData.type 			= 'image';
			this.formData.name 			= '';
			this.formData.uploadFile 	= '';
			this.$refs.fileInput.value 	= '';
			ui(this.$refs.fileInput);
			
			this.formData.uploadLink 	= '';
			this.formData.stDate 		= '';
			this.formData.endDate 		= '';
			this.formData.isActive 		= true;
		}
    }));
});

