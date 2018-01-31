// create the closure - any functions within this closeure are private to the function
$(function(){

    var methods = {
        init : function(options) {
        },
        getErrors : function() {
            if (errors.length > 0) return errors;
        },
        getFirstError : function() {
            if (errors.length > 0) return errors[0];
        },
        isValid : function() {
            if (errors.length > 0) {
                return false;
            }
            return true;
        },
        alertErrors : function() {
            $.each(errors, function(index, objValue) {
                alert ('function result: ' + objValue);
            })
        }
    };

    var errors = new Array;

    // -----------------------------------------------------------------------

    $.fn.validcheck = function(options) {
        // look for a method or data being passed
        if ( methods[options] ) {
            return methods[options].apply( this, Array.prototype.slice.call( arguments, 1 ));
        }
        // reset the error array
        errors = [];

        // extend default options with the ones passed
        var opts = $.extend({}, $.fn.validcheck.defaults, options);

        // loop the elements
        this.each(function() {
            var obj = this; // assign current element to variable
            var value = obj.value;
            var jQid = '#' + obj.id;

            switch(opts['type']) {
                case 'multicheck':
                    selCount(jQid);
                    break;
                case 'dropdown':
                    var style = $(obj).data('dropdown').settings.styles.selected;
                    Count ( $(obj).find('tr.' + style) );
                    break;
                case 'treedrop':
                    var style = $(obj).data('treedrop').settings.styles.selected;
                    Count ( $(obj).find('li div.' + style) );
                    break;
                case 'checkbox':
                    isChecked(obj);
                    break;
                case 'password':
                    // assign current element to variable
                    var firstObj = opts['classname'] + ':eq(0)';
                    var id = this.id;
                    var value = $(firstObj).val();
                    value = checkType(value);
                    checkLen(value);
                    checkPass();
                    break;
                default:
                    // run the validation functions
                    if (required(value)) {
                        value = checkType(value);
                        checkLen(value);
                    }
            }
            if (opts.match) {
                matchField(value);
            }
            displayErrors(obj,opts);
        });

        if (errors.length == 0) return true;

        // -----------------------------------------------------------------------

        function required(strng) {
            // only return false if the field is blank and not required
            if ((!opts['req']) && strng.length == 0) {
                return false;
            }
            // required but no value
            if ((opts['req']) && (strng.length == 0)) {
                if (opts['messages']['req']) {
                    errors.push (opts['messages']['req']);
                } else {
                    errors.push (opts['title'] + ' is required');
                }
            }
            return true;
        }

        // -----------------------------------------------------------------------

        function matchField(value) {
            if (value != $(opts.match).val()) {
                errors.push (opts['title'] + ' must match');
            }
        }

        // -----------------------------------------------------------------------

        // test password and confirmation
        function checkPass() {
            var pass = "";
            $(opts['classname']).each(function(i){
                if (i == 0) {
                    pass = $(this).val();
                } else {
                    if ($(this).val() != pass) {
                        if (opts['messages']['confirmation']) {
                            errors.push (opts['messages']['confirmation']);
                        } else {
                            errors.push (opts['title'] + ' confirmation mismatch');
                        }
                    }
                }
            });
        }

        // -----------------------------------------------------------------------

        function isChecked(obj) {
            if (!$(obj).is(':checked')  ) {
                if (opts['messages']['req']) {
                    errors.push (opts['messages']['req']);
                } else {
                    errors.push (opts['title'] + ' not checked');
                }
            }
        }

        // -----------------------------------------------------------------------

        // count of selected items in multicheck
        function selCount(obj) {
            var selected =  $.fn.multicheck.selcount(obj);
            if ( selected < opts['minlen']) {
                if (opts['messages']['multicheck']) {
                    errors.push (opts['messages']['multicheck']);
                } else {
                    errors.push (opts['title'] + ' must select ' + opts['minlen'] + ' to ' + opts['maxlen'] + ' items');
                }
            }
        }

        // -----------------------------------------------------------------------

        // count of selected items in an array of elems
        function Count(obj) {
            if ( obj.length < opts['minlen']) {
                if (opts['messages']['multicheck']) {
                    errors.push (opts['messages']['multicheck']);
                } else {
                    errors.push (opts['title'] + ' must select ' + opts['minlen'] + ' to ' + opts['maxlen'] + ' items');
                }
            }
        }

        // -----------------------------------------------------------------------

        // length value
        function checkLen(strng) {
            if ((strng.length < opts['minlen']) || (strng.length > opts['maxlen'])) {
                if (opts['messages']['length']) {
                    errors.push (opts['messages']['length']);
                } else {
                    if ( opts['minlen'] == opts['maxlen'] ) {
                        errors.push (opts['title'] + ' must be ' + opts['maxlen'] + ' characters');
                    } else {
                        errors.push (opts['title'] + ' must be ' + opts['minlen'] + ' to ' + opts['maxlen'] + ' characters');
                    }
                }
            }
        }

        // -----------------------------------------------------------------------

        // check for common field types
        function checkType(strng) {
            switch(opts.type) {
                case 'email':
                    var filter=/^[a-zA-Z0-9._]+@.+\..{2,3}$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['email']) {
                            errors.push (opts['messages']['email']);
                        } else {
                            errors.push (opts['title'] + ' invalid email address');
                        }
                    }
                    break;
                case 'phone':
                    strng = strng.replace(/[\(\)\.\-\ ]/g, '');
                    var filter= /^[0-9+]+$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['number']) {
                            errors.push (opts['messages']['number']);
                        } else {
                            errors.push (opts['title'] + ' must be a valid phone number');
                        }
                    }
                    //strip out acceptable non-numeric characters
                    if (isNaN(parseInt(strng))) {
                        if (opts['messages']['length']) {
                            errors.push (opts['messages']['phone']);
                        } else {
                            errors.push (opts['title'] + ' invalid phone');
                        }
                    }
                    break;
                case 'comment':
                    var filter= /^[\sa-zA-Z0-9\;:,_.#?*@!/$\\n\\r\-\+]+$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['alpha']) {
                            errors.push (opts['messages']['alpha']);
                        } else {
                            errors.push (opts['title'] + ' must be: A-Z,0-9,_.#*@!$-');
                        }
                    }
                    break;
                case 'pass':
                    var filter= /^[\sa-zA-Z0-9\,_.#*@:!\^/$\-\+]+$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['alpha']) {
                            errors.push (opts['messages']['alpha']);
                        } else {
                            errors.push (opts['title'] + ' must be: A-Z,0-9,_.#*@!$-');
                        }
                    }
                    break;
                case 'alpha':
                    var filter= /^[\sa-zA-Z\,.'\-]+$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['alpha']) {
                            errors.push (opts['messages']['alpha']);
                        } else {
                            errors.push (opts['title'] + ' must be letters only');
                        }
                    }
                    break;
                case 'alphanum':
                    var filter= /^[\sa-zA-Z0-9\,.'#?\-]+$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['alphanum']) {
                            errors.push (opts['messages']['alphanum']);
                        } else {
                            errors.push (opts['title'] + ' must be alpha-numeric');
                        }
                    }
                    break;
                case 'money':
                    var filter= /^\d+\.\d{2}$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['number']) {
                            errors.push (opts['messages']['number']);
                        } else {
                            errors.push (opts['title'] + ' invalid amount');
                        }
                    } else {
                        if (parseFloat(strng) < parseFloat(opts['minvalue'])) {
                            if (opts['messages']['minvalue']) {
                                errors.push (opts['messages']['minvalue']);
                            } else {
                                errors.push (opts['title'] + ' minimum ' + opts['minvalue']);
                            }
                        }
                        if (opts.maxvalue) {
                            if (strng > opts['maxvalue']) {
                                if (opts['messages']['maxvalue']) {
                                    errors.push (opts['messages']['maxvalue']);
                                } else {
                                    errors.push (opts['title'] + ' must be less than ' + opts['maxvalue']);
                                }
                            }
                        }
                    }
                    break;
                case 'number':
                case 'numeric':
                    var filter= /^[0-9.\,\-]+$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['number']) {
                            errors.push (opts['messages']['number']);
                        } else {
                            errors.push (opts['title'] + ' must be numeric');
                        }
                    } else {
                        if (parseFloat(strng) < parseFloat(opts['minvalue'])) {
                            if (opts['messages']['minvalue']) {
                                errors.push (opts['messages']['minvalue']);
                            } else {
                                errors.push (opts['title'] + ' minimum ' + opts['minvalue']);
                            }
                        }
                        if (opts.maxvalue) {
                            if (strng > opts['maxvalue']) {
                                if (opts['messages']['maxvalue']) {
                                    errors.push (opts['messages']['maxvalue']);
                                } else {
                                    errors.push (opts['title'] + ' must be less than ' + opts['maxvalue']);
                                }
                            }
                        }
                    }
                    break;

                case 'mod10':
                case 'crednum':
                case 'cardnum':
                    var filter= /^[0-9\,\-]+$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['number']) {
                            errors.push (opts['messages']['number']);
                        } else {
                            errors.push (opts['title'] + ' must be numeric');
                        }
                    } else {
                        if (!mod10(strng)) {
                            errors.push (opts['title'] + ' invalid card');
                        }
                    }
                    break;
                case 'us_zipcode':
                case 'zipcode':
                case 'zip':
                    var filter= /(^\d{5}$)|(^\d{5}-\d{4}$)/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['us_zipcode']) {
                            errors.push (opts['messages']['us_zipcode']);
                        } else {
                            errors.push (opts['title'] + ' invalid zipcode');
                        }
                    }
                    break;

                case 'date':
                    // regular expression to match required date format
                    var filter = /^\d{1,2}\/\d{1,2}\/\d{4}$/;
                    if (!(filter.test(strng))) {
                        if (opts['messages']['date']) {
                            errors.push (opts['messages']['date']);
                        } else {
                            errors.push (opts['title'] + ' invalid date');
                        }
                    }
                    break;
                default:
                //code to be executed if n is different from case 1 and 2
            };
            return (strng);
        }

        // -----------------------------------------------------------------------

        function displayErrors(obj, opts){
            // add the prefix and postfix to error messages
            if (typeof opts['errorElem'] == 'undefined') {
                $.each(errors, function(index, objValue){
                    errors[index] = opts['erprefix'] + objValue + opts['erpostfix'];
                });
                return false;
            }

            // add an error state to the object
            if (errors.length > 0) {
                $.each(errors,function(index, objValue){
                    if (index < opts['dispCount']) {
                        if (opts['errorElem'] !== 'undefined') {
                            if (opts.append) {
                                $(opts['errorElem']).html($(opts['errorElem']).html() + opts['erprefix'] + objValue + opts['erpostfix']);
                            } else {
                                $(opts['errorElem']).html(opts['erprefix'] + objValue + opts['erpostfix']);
                            }
                        }
                        else {
                            alert (objValue);
                        }
                    }
                });

                // add the error class to the element
                if (opts.errorState && opts.title != 'Agree to terms') {
                    $(obj).addClass(opts.errorState);
                } else {
                    $(obj).removeClass(opts.errorState);
                }
            }
            // remove error class from element
            else if(opts.errorState) {
                $(obj).removeClass(opts.errorState);
            }
        }

        // -----------------------------------------------------------------------

        function mod10(ccNumb) {  // v2.0
            var valid = "0123456789"  // Valid digits in a credit card number
            var len = ccNumb.length;  // The length of the submitted cc number
            var iCCN = parseInt(ccNumb);  // integer of ccNumb
            var sCCN = ccNumb.toString();  // string of ccNumb
            sCCN = sCCN.replace (/^s+|s+$/g,'');  // strip spaces
            var iTotal = 0;  // integer total set at zero
            var bNum = true;  // by default assume it is a number
            var bResult = false;  // by default assume it is NOT a valid cc
            var temp;  // temp variable for parsing string
            var calc;  // used for calculation of each digit

            // Determine if the ccNumb is in fact all numbers
            for (var j=0; j<len; j++) {
                temp = "" + sCCN.substring(j, j+1);
                if (valid.indexOf(temp) == "-1"){bNum = false;}
            }

            // if it is NOT a number, you can either alert to the fact, or just pass a failure
            if(!bNum){
                /*alert("Not a Number");*/bResult = false;
            }

            // Determine if it is the proper length
            if((len == 0)&&(bResult)){  // nothing, field is blank AND passed above # check
                bResult = false;
            } else{  // ccNumb is a number and the proper length - let's see if it is a valid card number
                if(len >= 15){  // 15 or 16 for Amex or V/MC
                    for(var i=len;i>0;i--){  // LOOP throught the digits of the card
                        calc = parseInt(iCCN) % 10;  // right most digit
                        calc = parseInt(calc);  // assure it is an integer
                        iTotal += calc;  // running total of the card number as we loop - Do Nothing to first digit
                        i--;  // decrement the count - move to the next digit in the card
                        iCCN = iCCN / 10;                               // subtracts right most digit from ccNumb
                        calc = parseInt(iCCN) % 10 ;    // NEXT right most digit
                        calc = calc *2;                                 // multiply the digit by two
                        // Instead of some screwy method of converting 16 to a string and then parsing 1 and 6 and then adding them to make 7,
                        // I use a simple switch statement to change the value of calc2 to 7 if 16 is the multiple.
                        switch(calc){
                            case 10: calc = 1; break;       //5*2=10 & 1+0 = 1
                            case 12: calc = 3; break;       //6*2=12 & 1+2 = 3
                            case 14: calc = 5; break;       //7*2=14 & 1+4 = 5
                            case 16: calc = 7; break;       //8*2=16 & 1+6 = 7
                            case 18: calc = 9; break;       //9*2=18 & 1+8 = 9
                            default: calc = calc;           //4*2= 8 &   8 = 8  -same for all lower numbers
                        }
                        iCCN = iCCN / 10;  // subtracts right most digit from ccNum
                        iTotal += calc;  // running total of the card number as we loop
                    }  // END OF LOOP
                    if ((iTotal%10)==0){  // check to see if the sum Mod 10 is zero
                        bResult = true;  // This IS (or could be) a valid credit card number.
                    } else {
                        bResult = false;  // This could NOT be a valid credit card number
                    }
                }
            }
            // change alert to on-page display or other indication as needed.
            return bResult; // Return the results
        }

    };

    // -----------------------------------------------------------------------

    // plugin defaults
    $.fn.validcheck.defaults = {
        append: false,
        req: false,
        dispCount: 1,
        css: 'errorDiv',
        minlen: 0,
        maxlen: 35,
        type: 'varchar',
        name: 'the field',
        messages: {}
    };

    // -----------------------------------------------------------------------

});
