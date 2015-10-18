/**
 * @license Copyright (c) 2003-2012, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    //config.skin = 'office2003';
    config.filebrowserBrowseUrl = '/application/public/kcfinder/browse.php?type=files';
    config.filebrowserImageBrowseUrl = '/application/public/kcfinder/browse.php?type=images';
    config.filebrowserFlashBrowseUrl = '/application/public/kcfinder/browse.php?type=flash';
    config.filebrowserUploadUrl = '/application/public/kcfinder/upload.php?type=files';
    config.filebrowserImageUploadUrl = '/application/public/kcfinder/upload.php?type=images';
    config.filebrowserFlashUploadUrl = '/application/public/kcfinder/upload.php?type=flash';

    //config.uiColor = '#739AC5';
    config.skin = 'ozone';
    config.language = 'uk';

    config.toolbar = 'Full';
    config.toolbar_Full =
        [
            { name: 'document',    items : [ 'Source','-','DocProps','Preview','Print','-','Templates' ] },
            { name: 'clipboard',   items : [ 'Cut','Copy','Paste','PasteText','PasteFromWord','-','Undo','Redo' ] },
            { name: 'editing',     items : [ 'Find','Replace','-','SelectAll','-','SpellChecker', 'Scayt' ] },
            { name: 'styles',      items : [ 'Styles','Format','Font','FontSize' ] },
            { name: 'colors',      items : [ 'TextColor','BGColor' ] },

            //{ name: 'forms',       items : [ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField' ] },
            '/',
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','Subscript','Superscript','-','RemoveFormat' ] },
            { name: 'paragraph',   items : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
            { name: 'links',       items : [ 'Link','Unlink','Anchor' ] },
            { name: 'insert',      items : [ 'Image','Table','HorizontalRule','Smiley','SpecialChar','PageBreak', 'Iframe' ] },
            { name: 'tools',       items : [ 'Maximize' ] }
            //{ name: 'tools',       items : [ 'Maximize', 'ShowBlocks','-','About' ] }
        ];
};
