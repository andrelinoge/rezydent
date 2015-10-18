/**
 * @author Andre Linoge
 */

function uploadController()
{
    var self = this;
};

uploadController.prototype = {
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
                frontendController.showLoader( '#' + element );
            },
            onProgress:function (id, fileName, loaded, total) {
                // show indicator
            },
            onComplete: function(id, fileName, responseJSON)
            {
                jQuery( '#avatar-img').attr( 'src', responseJSON.thumbSrc ).show();
                jQuery( '#avatar-fancy').attr( 'href', responseJSON.originalSrc );
                frontendController.hideLoader( this.button );

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

    initUserPhotosUploader: function( handlerUrl, element, uploaderSettings, parametersToSend )
    {
        uploadController.uploader = new qq.FileUploaderBasic({
            // pass the dom node (ex. $(selector)[0] for jQuery users)
            action: handlerUrl,
            button: document.getElementById( element ),
            multiple: true,
            params: parametersToSend,
            maxConnections: 2,
            allowedExtensions: uploaderSettings.allowedExtensions,
            // path to server-side upload script
            sizeLimit: uploaderSettings.sizeLimit, // max size

            // set to true to output server response to console
            debug: false,

            onSubmit: function(id, fileName){
                // show loader
                frontendController.showLoader( '#' + element );
            },
            onProgress:function (id, fileName, loaded, total) {
                // show indicator
            },
            onComplete: function(id, fileName, responseJSON)
            {
                var block = '<li class="frame item center" id="photo-' + responseJSON.photoId + '">';
                block += '<a href="' + responseJSON.originalSrc + '" class="fancy">';
                block += '<img alt="" width="200px;" src="' + responseJSON.thumbSrc + '"></a>';
                block += '<a data-id="' + responseJSON.photoId + '" class="button red offsetFromPhoto deletePhoto"><span class="icon-erase"></span> Видалити</a></li>';
                jQuery( '#photos-container').append( block );

                frontendController.hideLoader( this.button );

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
    }
}

var uploadController;
jQuery(document).ready(function(){
    uploadController = new uploadController();
});