/* Login JS */

$(function(){
	$('#btnSignin').click(function() {
		if (validationInput('#ad_account') && validationInput('#ad_password'))
			$('#signinForm').submit();
		else
			return false;
	});
	
});