/**
 * @author Andriy Tolstokorov
 */

function uploadControllerClass()
{
    this.uploader;
};

uploadControllerClass.prototype = {

    initArticleImageUploader: function( handlerUrl, element, uploaderSettings, parametersToSend )
    {
        uploadController.uploader = new qq.FileUploaderBasic({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            action: handlerUrl,
            button: document.getElementById( element ),
            multiple: false,
            params: parametersToSend,
            maxConnections: 2,
            allowedExtensions: uploaderSettings.allowedExtensions,
            // path to server-side upload script
            sizeLimit: uploaderSettings.sizeLimit, // max size

            // set to true to output server response to console
            debug: false,

            onSubmit: function(id, fileName){
                //$( '#avatarUploadIndicatorHolder').show();
                // show loader
                backendController.showLoader( '#uploadButton' );
            },
            onProgress:function (id, fileName, loaded, total) {
                //$( '#avatarUploadIndicator').width( (Math.ceil(100 * loaded / total)) + '%' );
                // show indicator
            },
            onComplete: function(id, fileName, responseJSON)
            {
                jQuery( '#upload-image-hint').hide();
                jQuery( '#article-image').attr( 'src', responseJSON.imageSrc).show();
                jQuery( '#article-image-fancy').attr( 'href', responseJSON.imageSrc );
                jQuery( '#article-image-field').val( responseJSON.fileName );

                backendController.hideLoader( '#uploadButton' );

            },
            onCancel: function(id, fileName){

            },

            messages :
            {
                typeError: "{file} has invalid extension. Only {extensions} are allowed.",
                sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
                minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
                emptyError: "{file} is empty, please select files again without it.",
                onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
            },
            showMessage: function(message){ console.log(message) }
        });
    },

    initSliderImageUploader: function( handlerUrl, element, uploaderSettings, parametersToSend )
    {
        uploadController.uploader = new qq.FileUploaderBasic({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            action: handlerUrl,
            button: document.getElementById( element ),
            multiple: false,
            params: parametersToSend,
            maxConnections: 2,
            allowedExtensions: uploaderSettings.allowedExtensions,
            // path to server-side upload script
            sizeLimit: uploaderSettings.sizeLimit, // max size

            // set to true to output server response to console
            debug: false,

            onSubmit: function(id, fileName){
                backendController.showLoader( '#' + element );
            },
            onProgress:function (id, fileName, loaded, total) {
                //$( '#avatarUploadIndicator').width( (Math.ceil(100 * loaded / total)) + '%' );
                // show indicator
            },
            onComplete: function(id, fileName, responseJSON)
            {
                if ( responseJSON.status === true )
                {
                    jQuery( '#upload-image-hint').hide();
                    jQuery( '#img-' + responseJSON.fileName ).attr( 'src', responseJSON.imageSrc + '?' +  (new Date).getTime() );
                    jQuery( '#fancy-' + responseJSON.fileName ).attr( 'href', responseJSON.imageSrc + '?' +  (new Date).getTime() );

                    console.log( '#img-' + responseJSON.fileName  );
                    console.log( jQuery( '#img-' + responseJSON.fileName ).length );
                }

                backendController.hideLoader( '#' + element );
            },
            onCancel: function(id, fileName){

            },

            messages :
            {
                typeError: "{file} has invalid extension. Only {extensions} are allowed.",
                sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
                minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
                emptyError: "{file} is empty, please select files again without it.",
                onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
            },
            showMessage: function(message){ console.log(message) }
        });
    },

    initUserAvatarUploader : function( handlerUrl, element, uploaderSettings, parametersToSend )
    {
        uploadController.uploader = new qq.FileUploaderBasic({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            action: handlerUrl,
            button: document.getElementById( element ),
            multiple: false,
            params: parametersToSend,
            maxConnections: 2,
            allowedExtensions: uploaderSettings.allowedExtensions,
            // path to server-side upload script
            sizeLimit: uploaderSettings.sizeLimit, // max size

            // set to true to output server response to console
            debug: false,

            onSubmit: function(id, fileName){
                // show loader
                backendController.showLoader( '#' + element );
            },
            onProgress:function (id, fileName, loaded, total) {
                // show indicator
            },
            onComplete: function(id, fileName, responseJSON)
            {
                jQuery( '#avatar-img').attr( 'src', responseJSON.thumbSrc ).show();
                jQuery( '#avatar-fancy').attr( 'href', responseJSON.originalSrc );
                backendController.hideLoader( this.button );

            },
            onCancel: function(id, fileName){

            },

            messages :
            {
                typeError: "{file} has invalid extension. Only {extensions} are allowed.",
                sizeError: "{file} is too large, maximum file size is {sizeLimit}.",
                minSizeError: "{file} is too small, minimum file size is {minSizeLimit}.",
                emptyError: "{file} is empty, please select files again without it.",
                onLeave: "The files are being uploaded, if you leave now the upload will be cancelled."
            },
            showMessage: function(message){ console.log(message) }
        });
    },
}

var uploadController;

jQuery( document ).ready(
    function()
    {
        if ( typeof( uploadController ) != 'object' )
        {
            uploadController = new uploadControllerClass();
        }
    }
);