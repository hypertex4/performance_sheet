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
                url: "../controllers/update-employee-profile.php",type:"POST",data: $form.serialize(),
                success: function(data) {
                    sendSuccessResponse('Update Successful',data.message);
                    $.alert({
                        icon: 'fa fa-check-circle',title:'Update Successful',typeAnimated: true,content:data.message,type:'green',
                        buttons: {ok: ()=> { window.location.reload();}}
                    });
                },
                error: function(errData){
                    sendErrorResponse('Update Failed',errData.responseJSON.message);
                    $.dialog({
                        icon:'fa fa-exclamation-triangle',title: 'Update Failed',typeAnimated:true,type:'red',
                        content:errData.responseJSON.message
                    });
                },
                complete: function () {$submitButton.val( submitButtonText ).attr('disabled', false);}
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

}).apply(this, [jQuery]);

function sendSuccessResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-success alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="far fa-thumbs-up"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'success'});
}

function sendErrorResponse(head,body) {
    $("#response-alert").html('' +
        '<div class="alert alert-danger alert-dismissible" role="alert">'+
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+
        '<strong><i class="fas fa-exclamation-triangle"></i> '+head+'!</strong> '+body+'</div>'
    );
    new PNotify({title: head+'!', text: body, type: 'error'});
}