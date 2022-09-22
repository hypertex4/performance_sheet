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

    $("form[name='admin_register_form']").validate({
        rules: {
            emp_name: {required: true, minlength: 4},
            emp_email: {required: true, email: true},
            emp_unit: "required",
            emp_password: {required: true, minlength: 6},
            emp_rep_password: {equalTo: '[name="emp_password"]'},
            captcha_answer: {equalTo: '[name="captcha_answer_raw"]'},
            captcha_answer_raw: "required"
        },
        messages: {
            emp_name: "Enter your name",
            emp_email: "Enter a valid email address",
            emp_unit: "Select your unit",
            emp_password: {
                required: "Enter password",
                minlength: "Password must be at least 6 characters long"
            },
            emp_rep_password: {equalTo:"Password not matched"},
            captcha_answer:"Incorrect answer, try again"
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);

            $.ajax({
                url: "controllers/employee-register.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    document.getElementById("register_form").reset();
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Registration Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.replace('./');}}
                    });
                },
                error: function (errData) {
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Registration Failed',typeAnimated:true,type:'red',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1',content:errData.responseJSON.message
                    });
                },
                complete: function () {$submitButton.val( submitButtonText ).attr('disabled', false);}
            });
        }
    });

    $("form[name='admin_login_form']").validate({
        rules: {
            adm_email: {required: true, email: true},
            adm_password: "required"
        },
        messages: {
            adm_email: "Enter a valid email address",
            adm_password: "Enter your password"
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
                url: "../controllers/admin-login.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    document.getElementById("admin_login_form").reset();
                    window.location.replace('dashboard');
                },
                error: function (errData) {
                    sendErrorResponse('Login Failed',errData.responseJSON.message);
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Login Failed',typeAnimated:true,type:'red',
                        content:errData.responseJSON.message
                    });
                },
                complete: function () {$submitButton.val( submitButtonText ).attr('disabled', false);}
            });
        }
    });

    $("form[name='admin_profile']").validate({
        rules: {
            adm_name: "required",
            adm_email: {required: true, email: true},
        },
        messages: {
            adm_name: "Enter fullname",
            adm_email: "Enter a valid email",
        },
        submitHandler: function(form, e) {
            e.preventDefault();
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/update-admin-profile.php",type:"POST",data: $form.serialize(),
                success: function(data) {
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Update Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.replace('../admin/logout');}}
                    });
                },
                error: function(errData){
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Update Failed',typeAnimated:true,type:'red',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1',content:errData.responseJSON.message
                    });
                },
                complete: function () {$submitButton.val( submitButtonText ).attr('disabled', false);}
            });
        }
    });

    $("form[name='add_dept_form']").validate({
        rules: {
            dept_name: {required: true, minlength: 4},
        },
        messages: {
            dept_name: "Department name must be at least 4 character"
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/admin-action.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.reload();}}
                    });
                },
                error: function (errData) {
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Failed',typeAnimated:true,type:'red',content:errData.responseJSON.message
                    });
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='updateDepartment']").validate({
        rules: {
            dept_name: {required: true, minlength: 4},
        },
        messages: {
            dept_name: "Department name must be at least 4 character"
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/admin-action.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.reload();}}
                    });
                },
                error: function (errData) {
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Failed',typeAnimated:true,type:'red',content:errData.responseJSON.message
                    });
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='add_project_form']").validate({
        rules: {
            proj_name: {required: true, minlength: 3},
            proj_code: {required: true, minlength: 2}
        },
        messages: {
            proj_name: "Project name must be at least 3 characters",
            proj_code: "Project code  must be at least 2 characters"
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);

            $.ajax({
                url: "../controllers/admin-action.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.reload();}}
                    });
                },
                error: function (errData) {
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Failed',typeAnimated:true,type:'red',content:errData.responseJSON.message
                    });
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='updateProject']").validate({
        rules: {
            edit_proj_name: {required: true, minlength: 4},
            edit_proj_code: {required: true, minlength: 2},
        },
        messages: {
            edit_proj_name: "Project name must be at least 3 characters",
            edit_proj_code: "Department name must be at least 2 characters"
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/admin-action.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.reload();}}
                    });
                },
                error: function (errData) {
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Failed',typeAnimated:true,type:'red',content:errData.responseJSON.message
                    });
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    $("form[name='updateEmployee']").validate({
        rules: {
            edit_emp_name: {required: true, minlength: 4},
            edit_emp_email: {required: true, email:true},
            edit_emp_dept: "required",
            edit_emp_design: "required",
        },
        messages: {
            edit_emp_name: "Employee name must be at least 4 characters",
            edit_emp_email: "Enter a valid email address",
            edit_emp_dept: "Department is required",
            edit_emp_design: "Designation is required",
        },
        submitHandler: function (form, e) {
            e.preventDefault();
            var $form = $(form),
                $submitButton = $(this.submitButton),
                submitButtonText = $submitButton.val();

            $submitButton.val( $submitButton.data('loading-text') ? $submitButton.data('loading-text') : 'Please wait...' ).attr('disabled', true);
            $.ajax({
                url: "../controllers/admin-action.php", type: "POST", data: $form.serialize(),
                success: function (data) {
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                        columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.reload();}}
                    });
                },
                error: function (errData) {
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Failed',typeAnimated:true,type:'red',content:errData.responseJSON.message
                    });
                },
                complete: function () { $submitButton.val( submitButtonText ).attr('disabled', false); }
            });
        }
    });

    var datatableInit = function() {
        var $table = $('#datatable-timesheet');

        var table = $table.dataTable({
            "pageLength": 20,
            "aLengthMenu": [[20, 100, 200, 500, -1], [20, 100, 200, 500, "All"]],
            sDom: '<"text-right mb-md"T><"row"<"col-lg-6"l><"col-lg-6"f>><"table-responsive"t>p',
            buttons: [
                {
                    extend: 'print',
                    text: 'Print'
                },
                {
                    extend: 'excel',
                    text: 'Excel'
                },
                {
                    extend: 'pdf',
                    text: 'PDF',
                    customize : function(doc){
                        var colCount = new Array();
                        $('#datatable-guard').find('tbody tr:first-child td').each(function(){
                            if($(this).attr('colspan')){
                                for(var i=1;i<=$(this).attr('colspan');$i++){
                                    colCount.push('*');
                                }
                            }else{ colCount.push('*'); }
                        });
                        doc.content[1].table.widths = colCount;
                    }
                }
            ]
        });
        $('<div />').addClass('dt-buttons mb-2 pb-1 text-end').prependTo('#datatable-tabletools_wrapper');
        $table.DataTable().buttons().container().prependTo( '#datatable-tabletools_wrapper .dt-buttons' );
        $('#datatable-tabletools_wrapper').find('.btn-secondary').removeClass('btn-secondary').addClass('btn-default');
    };
    $(function() {datatableInit();});

    $('.modal-basic').magnificPopup({type: 'inline', preloader: false, modal: true});

    $(document).on('click', '.modal-dismiss', function (e) {
        e.preventDefault();
        $.magnificPopup.close();
    });

    $(document).on("click", "#delete_department", function (e) {
        e.preventDefault();
        var d_id = $(this).data("did");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);

        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this department ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/admin-action.php", type: "POST", data: {d_id: d_id, action_code: 203},
                        success: function (data) {
                            $.alert({
                                icon: 'fa fa-check-circle',
                                title: 'Successful',
                                typeAnimated: true,
                                content: data.message,
                                type: 'green',
                                columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1',
                                buttons: {ok: () => {window.location.reload();}}
                            });
                        },
                        error: function (errData) {
                            $.dialog({
                                icon: 'fa fa-exclamation-triangle',
                                title: 'Failed',
                                typeAnimated: true,
                                type: 'red',
                                content: errData.responseJSON.message
                            });
                        },
                    });
                },
                cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);},
            }
        });
    });

    $(document).on("click", "#edit_department", function (e) {
        e.preventDefault();
        var d_id = $(this).data("did");
        var d_name = $(this).data("dname");
        $("#edit_dept_name").val(d_name);
        $("#edit_dept_id").val(d_id);
    });

    $(document).on("click", "#delete_project", function (e) {
        e.preventDefault();
        var p_id = $(this).data("pid");
        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);

        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this project ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/admin-action.php", type: "POST", data: {p_id:p_id,action_code:303},
                        success: function (data) {
                            $.alert({
                                icon: 'fa fa-check-circle',title:'Successful',typeAnimated: true,content:data.message,type:'green',
                                columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1', buttons: {ok: ()=> { window.location.reload();}}
                            });
                        },
                        error: function (errData) {
                            $.dialog({
                                icon:'fa fa-exclamation-triangle',title: 'Failed',typeAnimated:true,type:'red',content:errData.responseJSON.message
                            });
                        },
                    });
                }, cancel: function () { submitButton.val(submitButtonText).attr('disabled', false);},
            }
        });
    });

    $(document).on("click", "#edit_project", function (e) {
        e.preventDefault();
        var p_id = $(this).data("pid");
        var p_name = $(this).data("pname");
        var p_code = $(this).data("pcode");
        $("#edit_proj_name").val(p_name);
        $("#edit_proj_code").val(p_code);
        $("#edit_proj_id").val(p_id);
    });

    $(document).on("click", "#delete_employee", function (e) {
        e.preventDefault();
        var u_id = $(this).data("uid");

        var submitButton = $(this);
        var submitButtonText = $(this).val();
        submitButton.val('wait..' ).attr('disabled', true);

        $.confirm({
            title: 'Warning', content: 'Are you sure you want to delete this employee record ?',
            buttons: {
                confirm: function () {
                    $.ajax({
                        url: "../controllers/admin-action.php", type: "POST", data: {u_id: u_id, action_code: 403},
                        success: function (data) {
                            $.alert({
                                icon: 'fa fa-check-circle', title: 'Successful', typeAnimated: true, content: data.message,
                                type: 'green', columnClass: 'col-md-5 col-md-offset-3 col-10 offset-1',
                                buttons: {ok: () => {window.location.reload();}}
                            });
                        },
                        error: function (errData) {
                            $.dialog({
                                icon: 'fa fa-exclamation-triangle',
                                title: 'Failed',
                                typeAnimated: true,
                                type: 'red',
                                content: errData.responseJSON.message
                            });
                        },
                    });
                },
                cancel: function () {submitButton.val(submitButtonText).attr('disabled', false);}
            }
        });
    });

    $(document).on("click", "#edit_employee", function (e) {
        e.preventDefault();
        var u_id = $(this).data("uid");
        var u_name = $(this).data("uname");
        var u_email = $(this).data("uemail");
        var u_dept = $(this).data("udept");
        var u_design = $(this).data("udesign");
        $("#edit_emp_name").val(u_name);
        $("#edit_emp_email").val(u_email);
        $("#edit_emp_dept").val(u_dept);
        $("#edit_emp_design").val(u_design);
        $("#edit_user_id").val(u_id);
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