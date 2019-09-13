var editor = CKEDITOR.replace( 'fields-ckeditor' );
CKFinder.setupCKEditor( editor );
CKFinder.config( { connectorPath: '/ckfinder/connector' } );
CKEDITOR.replace( 'fields-ckeditor',
{
    filebrowserBrowseUrl: '/ckfinder/ckfinder.html',
    filebrowserImageBrowseUrl: '/ckfinder/ckfinder.html?type=Images',
    filebrowserUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
    filebrowserImageUploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images'
});
ClassicEditor
         .create( document.querySelector( '#fields-ckeditor' ), {
             ckfinder: {
                 uploadUrl: '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files&responseType=json'
             },
             toolbar: [ 'ckfinder', 'imageUpload', '|', 'heading', '|', 'bold', 'italic', '|', 'undo', 'redo' ]
         } )
         .catch( function( error ) {
             console.error( error );
         } );