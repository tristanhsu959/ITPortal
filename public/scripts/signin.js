/* Login JS */

$(function(){
	$('#btnSignin').click(function() {
		if (validateForm(['#account', '#password']))
			$('#signinForm').submit();
		else
		{
			showToast('帳號或密碼不可空白');
			return false;
		}
	});
	
	$('#btnReset').click(function(){
		$('#signinForm')[0].reset();
	});
});