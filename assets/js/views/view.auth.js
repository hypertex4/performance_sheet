(function($) {
	'use strict';
	// No White Space
	$.validator.addMethod("noSpace", function(value, element) {
		if( $(element).attr('required') ) {
			return value.search(/^(?! *$)[^]+$/) == 0;
		}
		return true;
	}, 'Please fill this empty field.');
	$.validator.addClassRules({
	    'form-control': {noSpace: true}
	});

    $("form[name='register_form']").validate({
        rules: {
            emp_name: {required: true, minlength: 4},
            emp_email: {required: true, email: true},
            emp_unit: "required",
            emp_approval: "required",
            emp_password: {required: true, minlength: 6},
            emp_rep_password: {equalTo: '[name="emp_password"]'},
            captcha_answer: {equalTo: '[name="captcha_answer_raw"]'},
            captcha_answer_raw: "required"
        },
        messages: {
            emp_name: "Enter your name",
            emp_email: "Enter a valid email address",
            emp_unit: "Select your unit",
            emp_approval: "Approval required",
            emp_password: {
                required: "Enter password",
                minlength: "Password must be at least 6 characters long"
            },
            emp_rep_password: {equalTo:"Password not matched"},
            captcha_answer:"Incorrect answer, try again"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "controllers/employee-register.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    document.getElementById("register_form").reset();
                    sendSuccessResponse("Registration Successful",data.message);
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Registration Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-6 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.replace('./');}}
                    });
                },
                error: function (errData) {
                    if (errData.responseJSON.status===422){
                        sendErrorResponse("Registration Failed",errData.responseJSON.message);
                    } else {
                        sendErrorResponse("Registration Failed",errData.responseJSON.message);
                        $.dialog({
                            icon:'fa fa-exclamation-triangle',title: 'Registration Failed',typeAnimated:true,type:'red',
                            columnClass: 'col-md-6 col-md-offset-3 col-10 offset-1',content:errData.responseJSON.message
                        });
                    }
                },
                complete: function () {$submitButton.val( submitButtonText ).attr('disabled', false);}
            });
        }
    });

    $("form[name='login_form']").validate({
        rules: {
            emp_email: {required: true, email: true},
            emp_password: "required"
        },
        messages: {
            emp_email: "Enter a valid email address",
            emp_password: "Enter your password"
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function (form) {
           var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);

            $.ajax({
                url: "controllers/employee-login.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    document.getElementById("login_form").reset();
                    sendSuccessResponse("Login successful",data.message);
                    window.location.replace(data.location);
                },
                error: function (errData) {
                    if (errData.responseJSON.status===404){
                        sendErrorResponse('Login Failed',errData.responseJSON.message);
                    } else if (errData.responseJSON.status===422){
                        sendErrorResponse('Login Failed',errData.responseJSON.message);
                    } else {
                        $.dialog({icon:'fa fa-exclamation-triangle',title: 'Login Failed',typeAnimated:true,type:'red',content:errData.responseJSON.message});
                    }
                },
                complete: function () {$submitButton.val( submitButtonText ).attr('disabled', false);}
            });
        }
    });

    $("form[name='profile']").validate({
        rules: {
            emp_name: "required",
            emp_email: {required: true, email: true},
            emp_unit: "required",
        },
        messages: {
            emp_name: "Enter fullname",
            emp_email: "Enter a valid email",
            emp_unit: "Unit is required",
        },
        errorPlacement: function(error, element) {
            if(element.attr('type') === 'radio' || element.attr('type') === 'checkbox') {
                error.appendTo(element.closest('.form-group'));
            } else if( element.is('select') && element.closest('.custom-select-1') ) {
                error.appendTo(element.closest('.form-group'));
            } else {
                if( element.closest('.form-group').length ) {
                    error.appendTo(element.closest('.form-group'));
                } else {
                    error.insertAfter(element);
                }
            }
        },
        submitHandler: function(form) {
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);

            $.ajax({
                url: "controllers/update-employee-profile.php",type:"POST",data: $form.serialize(),
                success: function(data) {
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Update Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-6 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.reload();}}
                    });
                },
                error: function(errData){
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Update Failed',typeAnimated:true,type:'red',
                        columnClass: 'col-md-6 col-md-offset-3 col-10 offset-1',content:errData.responseJSON.message
                    });
                },
                complete: function () {$submitButton.val( submitButtonText ).attr('disabled', false);}
            });
        }
    });

}).apply(this, [jQuery]);

function sendSuccessResponse(head,body) {
	$("#response-alert").html('' +
		'<div class="alert alert-success alert-dismissible" role="alert">'+
		'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
		'<strong><i class="far fa-thumbs-up"></i> '+head+'!</strong> '+body+'</div>'
	);
}

function sendErrorResponse(head,body) {
	$("#response-alert").html('' +
		'<div class="alert alert-danger alert-dismissible" role="alert">'+
		'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
		'<strong><i class="fas fa-exclamation-triangle"></i> '+head+'!</strong> '+body+'</div>'
	);
}