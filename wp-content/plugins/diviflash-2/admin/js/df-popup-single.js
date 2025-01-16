document.addEventListener( 'DOMContentLoaded', function () {
    const publishButton = document.querySelector( '#publish' );
    const fileInput = document.querySelector( 'input[name="import_file"]' );
    const fileExport = [ ...document.querySelectorAll( 'input[name="post_ids[]"]' ) ];
    const importBtn = document.querySelector( 'input[name="import"]' );
    const exportBtn = document.querySelector( 'input[name="export"]' );
    const selectAll = document.getElementById( 'select-all-header' );
    fileInput.addEventListener( 'change', ( e ) => {
        if ( e.target.value === '' ) {
            return;
        }
        importBtn.removeAttribute( 'disabled' )
    } )
    fileExport.forEach( ( input ) => {
        input.addEventListener( 'click', ( e ) => {
            if ( e.target.value === '' || ! exportBtn.hasAttribute( 'disabled' ) ) {
                return;
            }
            exportBtn.removeAttribute( 'disabled' )
        } )
    } )
    selectAll.addEventListener( 'click', ( e ) => {
        [ ...document.querySelectorAll( 'input[name="post_ids[]"]' ) ].forEach( input => {
            input.checked = e.target.checked;
        } )
        exportBtn.disabled = ! e.target.checked
    } )

    if ( publishButton && publishButton.value === 'Publish' ) {
        // Add a click event to the "Publish" button.
        publishButton.addEventListener( 'click', function () {
            // Code to execute when the "Publish" button is clicked.
            document.querySelector( '.df-button-wrap .components-button' ).click();
        } );
    }
} );

