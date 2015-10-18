/**
 * @author Andriy Tolstokorov
 */

function backendControllerClass() {
    var clip;
};

backendControllerClass.prototype = {
    initLayout: function() {

    },

    initClipboard: function( pathToFlash, selector ) {
        ZeroClipboard.setMoviePath( pathToFlash );
        this.clip = new ZeroClipboard.Client( selector );
    },

    // Init client form validation
    initClientValidation: function( formId, validationRules, validationMessages, beforeValidateFunc ) {
        jQuery( '#' + formId ).validate(
            {
                beforeValidate: function( form ) {
                    if ( ( typeof( beforeValidateFunc ) != undefined ) && beforeValidateFunc ) {
                        return beforeValidateFunc( form );
                    }
                },
                submitHandler: function(form) {
                    form.submit();
                },
                //unhighlight: function() { console.log('!!!');},
                focusInvalid: false,
                focusCleanup: true,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                onfocusin: false,
                rules: validationRules,
                messages: validationMessages,
                errorPlacement: function(error, element) {
                    var $form = element.closest( 'form');
                    var fieldName = element.attr( 'id' );

                    var errorText = error.html();
                    var $errorContainer = $form.find('#' + fieldName + '_error' );

                    if( !$errorContainer[0] ){ // no error container
                        $('<div class="errorMessage" id="' + fieldName + '_error">' + errorText + '</div>')
                            .insertAfter( element )
                            .show( 0 );
                    } else {
                        $errorContainer
                            .html( errorText )
                            .show( 0 );
                    }

                    element.addClass( 'error' );
                },
                debug:true
            }
        );
    },

    initClientValidationWithAjaxSubmit: function( formId, rules, messages, submitFunc, callBackFunc, beforeValidateFunc ) {
        jQuery( '#' + formId ).validate(
            {
                submitHandler: function(form) {
                    submitFunc( formId, callBackFunc );
                },
                beforeValidate: function( form ) {
                    if ( ( typeof( beforeValidateFunc ) != undefined ) && beforeValidateFunc )
                    {
                        return beforeValidateFunc( form );
                    }
                },
                focusInvalid: false,
                focusCleanup: true,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                onfocusin: false,
                rules: validationRules,
                messages: validationMessages,
                errorPlacement: function(error, element) {
                    var $form = element.closest( 'form');
                    var fieldName = element.attr( 'id' );

                    var errorText = error.html();
                    var $errorContainer = $form.find('#' + fieldName + '_error' );

                    if( !$errorContainer[0] ){ // no error container
                        $('<div class="errorMessage" id="' + fieldName + '_error">' + errorText + '</div>')
                            .insertAfter( element )
                            .show( 0 );
                    } else {
                        $errorContainer
                            .html( errorText )
                            .show( 0 );
                    }

                    element.addClass( 'error' );
                },
                debug:true
            }
        );
    },

    // Messages and popups
    showErrorMessage : function(message) {
        alert( message );
        console.log( message );
    },

    showSuccessMessage : function(message) {
        alert( message );
        console.log( message );
    },

    showNotificationMessage : function( message ) {
        alert( message );
        console.log( message );
    },

    showConnectionError : function() {
        backendController.showErrorMessage( 'Connection error' );
    },

    // Forms
    showFormErrors : function( errorsArray, $form ) {
        var formName = $form.attr('name');

        jQuery.each( errorsArray, function( fieldName, errorText ) {

            var $input = $form.find( '#' + formName + '_' + fieldName );
            var $errorContainer = $form.find('#'+formName + '_' + fieldName + '_error' );

            if( !$errorContainer[0] ){ // no error container
                $('<div class="errorMessage" id="' + formName + '_' + fieldName + '_error">' + errorText + '</div>')
                    .insertAfter( $input )
                    .show( 0 );
            } else {
                $errorContainer
                    .html( errorText.toString() )
                    .show( 0 );
            }
            $input.addClass( 'error' );
        });
    },

    removeFormErrorHighlightings : function( $form ) {

        $form
            .find( '.errorMessage' )
            .html('')
            .hide();

        $form
            .find( '.error' )
            .removeClass( 'error' );
    },

    removeErrorHighlighting : function( caller ) {

        var id = jQuery( caller ).removeClass( 'error').attr( 'id' );
        jQuery( '#' + id + '_error').html( '' );

        return true;
    },

    ajaxSubmitFormCK : function( formId, callbackFunction ) {
        // for ckeditor
        for(var instanceName in CKEDITOR.instances) {
            CKEDITOR.instances[instanceName].updateElement();
        }

        return backendController.ajaxSubmitForm( formId, callbackFunction );
    },

    ajaxSubmitForm : function( formId, callbackFunction ) {

        var $form = $( '#' + formId );

        backendController.removeFormErrorHighlightings( $form );

        var method = $form.attr('method');
        method = ( method != undefined && method != '' ) ? method : 'POST';

        $form.ajaxSubmit({
            url         : $form.attr('action'),
            dataType    : 'json',
            cache       : false,
            type        : method,

            beforeSubmit: function(arr, $form, options) {
                backendController.showLoader($form);
            },
            error: function(xhr, status, error) {
                console.log('Server error: ' + error);
                backendController.showConnectionError();
                backendController.hideLoader($form);
            },
            success: function(data) {
                backendController.hideLoader($form);

                // show Error Message if it is setted
                if( (typeof(data.errorMessage) != 'undefined') && (data.errorMessage != '') ) {
                    backendController.showErrorMessage( data.errorMessage );
                }

                // show Success Message if it is setted
                if( (typeof(data.successMessage) != 'undefined') && (data.successMessage != '') ) {
                    backendController.showSuccessMessage( data.successMessage );
                }

                // show Errors from form validation action if it is setted
                if( (typeof(data.errors) != 'undefined') && (data.errors != '') ) {
                    backendController.showFormErrors( data.errors, $form );
                }

                // redirect if url is setted
                if( (typeof(data.redirect) != 'undefined') && (data.redirect != '') ) {
                    window.location.href = data.redirect;
                }

                // reload if necessary
                if( (typeof(data['reload']) != 'undefined') && (data['reload'] != '') ) {
                    window.location.reload();
                }

                // call callback function if it is setted
                if( (typeof( callbackFunction ) != 'undefined') && callbackFunction ){
                    callbackFunction( data );
                }
            }
        });

        return false;
    },

    ajaxSubmitFormWithFile: function( formId, callbackFunction ) {

        var $form = jQuery( '#' + formId );

        backendController.removeFormErrorHighlightings( $form );

        var method = $form.attr('method');
        method = ( method != undefined && method != '' ) ? method : 'POST';

        $form.ajaxSubmit({
            url         : $form.attr('action'),
            dataType    : 'html',
            target      : '#uploadOutput',
            cache       : false,
            type        : method,

            beforeSubmit: function(arr, $form, options) {
                commonController.showLoader($form);
            },
            error: function(xhr, status, error) {
                backendController.showConnectionError();
                backendController.hideLoader($form);
            },
            success: function(html) {
                data = eval('(' + html + ')');
                backendController.hideLoader($form);
                // show Error Message if it is setted
                if( (typeof(data.errorMessage) != 'undefined') && (data.errorMessage != '') ) {
                    backendController.showErrorMessage( data.errorMessage );
                }

                // show Success Message if it is setted
                if( (typeof(data.successMessage) != 'undefined') && (data.successMessage != '') ) {
                    backendController.showSuccessMessage( data.successMessage );
                }

                // show Errors from form validation action if it is setted
                if( (typeof(data.errors) != 'undefined') && (data.errors != '') ) {
                    backendController.showFormErrors( data.errors, $form );
                }

                // redirect if url is setted
                if( (typeof(data.redirect) != 'undefined') && (data.redirect != '') ) {
                    window.location.href = data.redirect;
                }

                // reload if necessary
                if( (typeof(data['reload']) != 'undefined') && (data['reload'] != '') ) {
                    window.location.reload();
                }

                // call callback function if it is setted
                if( (typeof( callbackFunction ) != 'undefined') && callbackFunction ){
                    callbackFunction( data );
                }
            }
        });

        return false;
    },

    submitFormByLink : function( caller, callbackFunction ) {
        var $form = jQuery( caller ).parents( 'form' );

        if ( typeof($form) == undefined ) {
            console.log('backendController(submitFormOnLink): Form not found!');
        } else {
            var formId = $form.attr('id');
            backendController.ajaxSendForm( formId, callbackFunction );
        }

        return false;
    },

    // Ajax send  helpers
    ajaxGet : function( url, args, callbackFunction, loaderId ) {
        return backendController.sendAjax( 'get', url, args, callbackFunction, loaderId );
    },

    ajaxPost : function( url, args, callbackFunction, loaderId ){
        return backendController.sendAjax('post', url, args, callbackFunction, loaderId );
    },

    sendAjax : function( type,url,args, callbackFunction, loaderId ) {
        backendController.showLoader( loaderId );
        jQuery.ajax({
            url: url,
            dataType: 'json',
            cache: type=='get'?true:false,
            type: type,
            data: args,
            error: function( xhr, status, error ) {
                console.log('Server error: ' + error );
                backendController.showConnectionError();
                backendController.hideLoader(loaderId);
            },
            success: function(data)
            {
                backendController.hideLoader( loaderId );
                // show Error Message if it is setted
                if( (typeof(data.errorMessage) != 'undefined') && (data.errorMessage != '') ) {
                    backendController.showErrorMessage( data.errorMessage );
                }

                // show Success Message if it is setted
                if( (typeof(data.successMessage) != 'undefined') && (data.successMessage != '') ) {
                    backendController.showSuccessMessage( data.successMessage );
                }

                // show Errors from form validation action if it is setted
                if( (typeof(data.errors) != 'undefined') && (data.errors != '') ) {
                    backendController.showFormErrors( data.errors, $form );
                }

                // redirect if url is setted
                if( (typeof(data.redirect) != 'undefined') && (data.redirect != '') ) {
                    window.location.href = data.redirect;
                }

                // reload if necessary
                if( (typeof(data['reload']) != 'undefined') && (data['reload'] != '') ) {
                    window.location.reload();
                }

                // call callback function if it is setted
                if( (typeof( callbackFunction ) != 'undefined') && callbackFunction ){
                    callbackFunction( data );
                }
            }
        });
        return false;
    },

    // Utils
    toUrlString : function( obj, prefix ) {
        var str = [];
        for( var p in obj ) {
            var k = prefix ? prefix + "[" + p + "]" : p, v = obj[p];
            str.push( typeof v == "object" ?
                this.toUrlString(v, k) :
                encodeURIComponent(k) + "=" + encodeURIComponent(v)
            );
        }
        return str.join("&");
    },

    ajaxSendForm : function( form, callBackFunc ) {
        var $form = null;
        if (typeof form == 'string') {
            $form = $( '#' + form );
        }

        if ( form instanceof jQuery ) {
            $form = form;
        }

        if ( !$form ) {
            console.log( 'form is not neither id of form, neither jQuery object');
            return false;
        }

        jQuery.ajax({
            url: $form.attr( 'action' ),
            type: 'POST',
            dataType: 'json',
            data: $form.serialize(),

            error: function(xhr, status, error) {
                console.log('Server error: ' + error);
                backendController.showConnectionError();
            },

            success: function(data) {

                if( (typeof(callBackFunc) != 'undefined') && callBackFunc ){
                    callBackFunc(data);
                }
            }
        });
    },

    onSelectPageUrl: function( selector, caller ) {
        var value = jQuery( caller).val(); // url
        jQuery( selector )
            .data( 'clipboard-text', value )
            .html( value );

        this.clip.setText( value );

        return false;
    },

    showLoader : function( selector ) {
        if (!jQuery( selector ).length) {
            return false;
        }

        var $selector = jQuery( selector );

        $selector.addClass( 'loader-transparent' );

        var loader = $selector.find('.loader-wrapper');
        var loaderHtml = '<div class="loader-wrapper" style="display: none;"><div class="loader"></div></div>';

        if( !jQuery(loader).size() ) {
            loader = $selector.prepend( loaderHtml ).find( '.loader-wrapper' );
        }

        var height = $selector.height() + $selector.css('padding-top').replace('px','')*1 + $selector.css('padding-bottom').replace('px','')*1;
        var width = $selector.width() + $selector.css('padding-left').replace('px','')*1 + $selector.css('padding-right').replace('px','')*1;

        loader.height( height );
        loader.width( width );
        loader.css( 'margin-top', '-' + $selector.css('padding-top') );
        loader.css( 'margin-left', '-' + $selector.css('padding-left') );
        loader.find('.loader').css('margin-top', (height-11)/2);
        loader.show();
        return loader;
    },

    hideLoader : function(selector) {
        var $selector = jQuery( selector );
        $selector.removeClass('loader-transparent');
        var $loader = $selector.find('.loader-wrapper');
        $loader.remove();
    }
}

var backendController;

jQuery( document ).ready(
    function()
    {
        if ( typeof(backendController) != 'object' )
        {
            backendController = new backendControllerClass();
        }
    }
);