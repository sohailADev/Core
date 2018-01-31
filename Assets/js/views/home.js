// jQuery doc ready function
$(function(){

    // ---------------------------------------------------------------------------

    // loop fields and validate
    function validateForm() {
        // reset the errors
        var result = true;
        var errorcount = 0;
        var errors = '';
        var errorheader = 'Please correct the following:<br /><br />';

        // remove any error classes
        $(".form-control").each(function() {
            $(this).removeClass('hasError');
        });

        $('#fname').validcheck({req:true, title:'First Name', erprefix:'<li class="error-item">', erpostfix:'</li>', minlen:1, maxlen:50, type:'alphanum',messages:{length:'First Name must be at least 1 characters'}});
        if (!$('#fname').validcheck('isValid')) {
            $('#fname').addClass('hasError');
            errors += ( $('#fname').validcheck('getFirstError'));
            errorcount ++;
        }

        $('#lname').validcheck({req:true, title:'Last Name', erprefix:'<li class="error-item">', erpostfix:'</li>', minlen:2, maxlen:50, type:'alphanum',messages:{length:'Last Name must be at least 2 characters'}});
        if (!$('#lname').validcheck('isValid')) {
            $('#lname').addClass('hasError');
            errors += ( $('#lname').validcheck('getFirstError'));
            errorcount ++;
        }

        $('#email').validcheck({req:true, title:'Email', erprefix:'<li class="error-item">', erpostfix:'</li>', minlen:5, maxlen:150, type:'email',messages:{email: 'Invalid email address'}});
        if (!$('#email').validcheck('isValid')) {
            $('#email').addClass('hasError');
            errors += ( $('#email').validcheck('getFirstError'));
            errorcount ++;
        }

        $('#comment').validcheck({req:false, title:'Comments', erprefix:'<li class="error-item">', erpostfix:'</li>', minlen:0, maxlen:450, type:'comment', messages:{comment: 'Invalid characters entered'}});
        if (!$('#comment').validcheck('isValid')) {
            $('#comment').addClass('hasError');
            errors += ( $('#comment').validcheck('getFirstError'));
            errorcount ++;
        }

        $('#phone').validcheck({req:false, title:'Phone', erprefix:'<li class="error-item">', erpostfix:'</li>', minlen:10, maxlen:30, type:'phone',messages:{length: 'Phone must be at least 10 characters'}});
        if (!$('#phone').validcheck('isValid')) {
            $('#phone').addClass('hasError');
            errors += ( $('#phone').validcheck('getFirstError'));
            errorcount ++;
        }

        if (errorcount > 0) {
            result = false;
            var height = 340;
            var title = 'Some Information is Missing';
            var args = { title:title, message:errorheader + errors, error:true, topclose:true, modal:true, draggable:false, buttonpanel:true, outsideclose:true, height:height + 'px' };
            SiteTools.dialog(args);
        }

        return result;
    }

    // ------------------------------------------------------------------

    /**
     * move to the next page if the form validates
     */
    $('#contactfrm').submit(function(event) {
        if (validateForm()) {

            var data = {fname: $("#fname").val(), lname: $("#lname").val(), email: $("#email").val(), comment: $("#comment").val(), phone: $("#phone").val()}; // put the data into an array

            // ajax call to the api
            $.ajax({ url:'/contact/process', data:data, type:"POST", dataType:'json',
                success: function(json) {

                    // display thank you
                    if (json.status == 'OK') {
                        var title = 'Thank you!';
                        var args = {title:title, message:'Thank you for reaching out! <br /><br />We will get back to you right away.', error:false,
                                    topclose:false, modal:true, draggable:false, buttonpanel:true, outsideclose:true, height:'220px',
                                    close : function() {
                                        window.location = "/";
                                    }
                        };
                        var myDialog = SiteTools.dialog(args);
                    }
                },
                error: function( xhr, status, errorThrown ) {
                    // show a communications error dialog
                    var title = 'There was an error...';
                    var args = { title:title, message:'Unfortunately we couldn\'t save your info! <br /><br />Please try again or just give us a call; we really want ot hear from you!', error:true, topclose:false, modal:true, draggable:false, buttonpanel:true, outsideclose:true, height:'220px' };
                    var myDialog = SiteTools.dialog(args); // display thank you
                }
            });
        }
        return false;
    });

    // ------------------------------------------------------------------

    // look for an error message to display
    if (errormessage !== undefined) {
        var title = 'Payment Error';
        var args = { title:title, message:errormessage, error:true, topclose:true, modal:true, draggable:false, buttonpanel:true, outsideclose:true, height:'260px' };
        SiteTools.dialog(args);
    }

    // ------------------------------------------------------------------


});
