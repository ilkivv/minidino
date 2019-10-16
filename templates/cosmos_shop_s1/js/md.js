function validateEmail(email, element) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if (!emailReg.test(email)) {
		$(element).removeClass('valid');
		$(element).addClass('error');
        return false;
    } else {
		$(element).removeClass('error');
		$(element).addClass('valid');
        return true;
    }
}