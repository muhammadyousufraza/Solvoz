(function ( $ ) {
    const dfMenu = {
        body: $( 'body' ),
        settingsModal: $( '.df-menu-item-settings' ),
        settingsModalWrap: $( '.df-settings-container' ),
        iconModal: $( '.df-icon-select-wrap' ),
        modalTitle: $( '.modal-title' ),
        init: function () {
            this.getDashboardSettings();
            this.addEditButton();
            this.openSettingsModal();
            this.addSettingsButton();
        },
        addEditButton: function () {
            $( '#menu-to-edit > .menu-item' ).each( function ( index, value ) {
                var item = $( this ).find( '.menu-item-bar .menu-item-checkbox' );
                var title = $( this ).find( '.menu-item-title' )[0].innerHTML;
                var isSubmenu = $( this ).hasClass( 'menu-item-depth-0' ) ? '0' : '1';
                var menuTitle = $( '#nav-menu-header #menu-name' ).val();
                var depthClass = $( this ).attr( "class" ).split( " " ).filter( function ( class_name ) {
                    return class_name.indexOf( 'item-depth' ) !== -1;
                } );
                $( this ).find( '.menu-item-bar .item-title' )
                    .append( `<button data-submenu="${ isSubmenu }"
                data-depth="${ depthClass }"
                data-menu-item-id="${ item[0].dataset.menuItemId }"
                data-menu-title="${ menuTitle }"
                class="df-menu-edit" data-menu-item-title="${ title }">Edit Menu</button>` );
            } )
        },
        openSettingsModal: function () {
            dfMenu.body.on( 'click', '.df-menu-edit', function ( ev ) {
                ev.preventDefault();
                $( '#df-menu-dashboard' ).toggleClass( 'show' );
                $( 'body' ).css( 'overflow', 'hidden' );
            } );
        },
        addSettingsButton: function () {
            $( '#nav-menu-header .major-publishing-actions' ).append( `<div class="df-settings-btn-wrap">
            <button class="df-switch">
            <span class="slider"></span>
            </button> Enable/Disable DiviFlash menu settings.
            <span class="df-menu-db-info">
            <span class="df-menu-db-info-icon">p</span>
            <span class="df-menu-db-info-box">If you don't see the "Edit Menu" after enable,
            Please save the menu.</span></span>
            </div>
            </div>
            </div>` );
            $( '#nav-menu-header .major-publishing-actions' ).append(`<div id="df-menu-export-import-modal"></div><div id="df-menu-export-import" data-title="Menu Exporter & Importer"><div class="icon"><svg width="24" height="20" viewBox="0 0 24 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M4.99994 12.8C4.99994 13.1713 5.14745 13.5275 5.40999 13.79C5.67254 14.0526 6.02864 14.2 6.39994 14.2C6.77125 14.2 7.12734 14.0526 7.3899 13.79C7.65244 13.5275 7.79994 13.1713 7.79994 12.8V4.97965L9.61014 6.78985C9.87418 7.04488 10.2278 7.18598 10.5949 7.18279C10.962 7.17961 11.3131 7.03238 11.5727 6.7728C11.8323 6.51323 11.9795 6.16209 11.9827 5.79501C11.9859 5.42795 11.8448 5.07429 11.5897 4.81025L7.38974 0.610254C7.1272 0.347796 6.77117 0.200348 6.39994 0.200348C6.02871 0.200348 5.67269 0.347796 5.41014 0.610254L1.21014 4.81025C0.955119 5.07429 0.814013 5.42795 0.817191 5.79501C0.820383 6.16209 0.967621 6.51323 1.2272 6.7728C1.48677 7.03238 1.8379 7.17961 2.20498 7.18279C2.57205 7.18598 2.9257 7.04488 3.18974 6.78985L4.99994 4.97965V12.8ZM18.9999 7.20005C18.9999 6.82875 18.8525 6.47266 18.5899 6.2101C18.3274 5.94756 17.9712 5.80005 17.5999 5.80005C17.2286 5.80005 16.8725 5.94756 16.61 6.2101C16.3475 6.47266 16.1999 6.82875 16.1999 7.20005V15.0204L14.3897 13.2102C14.1257 12.9553 13.772 12.8142 13.405 12.8174C13.0379 12.8205 12.6868 12.9677 12.4272 13.2273C12.1676 13.4869 12.0204 13.838 12.0171 14.2051C12.0141 14.5721 12.1552 14.9258 12.4101 15.1898L16.6101 19.3898C16.8726 19.6523 17.2288 19.7997 17.5999 19.7997C17.9712 19.7997 18.3272 19.6523 18.5897 19.3898L22.7897 15.1898C23.0448 14.9258 23.1859 14.5721 23.1827 14.2051C23.1795 13.838 23.0322 13.4869 22.7726 13.2273C22.5131 12.9677 22.162 12.8205 21.7949 12.8174C21.4278 12.8142 21.0742 12.9553 20.8101 13.2102L18.9999 15.0204V7.20005Z" fill="white"/>
</svg>
</div></div>`)

            $( '.df-switch' ).on( 'click', function ( ev ) {
                ev.preventDefault();
                $( this ).toggleClass( 'active' );
            } )
            $( '.df-menu-export' ).on( 'click', function ( ev ) {
                ev.preventDefault();
                dfMenu.exportMenu();
            } )
            $( '.df-menu-import' ).on( 'click', function ( ev ) {
                ev.preventDefault();
                ev.stopPropagation();
                window.onbeforeunload = null;
                dfMenu.importMenu();
            } )
            $( '.df-menu-import-input' ).on( 'change', ( e ) => {
                const file = e.target.files[0];
                if ( file ) {
                    $( '.df-menu-import' ).css( 'background-color', '#3B0AA0' )
                } else {
                    $( '.df-menu-import' ).css( 'background-color', '#ccc' )
                }
                if ( ! file ) {
                    return;
                }
                dfMenu.fileName = file?.name
                const reader = new FileReader();
                reader.onload = ( event ) => {
                    dfMenu.fileSettings = JSON.parse( event.target.result )
                };
                reader.readAsText( file )
            } )
        },
        getDashboardSettings: function () {
            var menuId = $( '#menu' ).val();

            window.wp.apiFetch( {
                path: '/df-menu-settings/v2/df-am-option-edit',
                method: 'POST',
                data: {
                    id: menuId
                }
            } ).then( ( res ) => {
                // console.log(res);
                $( '.df-switch' )[0].dataset.enable = res === 'on' ? 'on' : 'off';
                if ( res == 'on' ) {
                    $( '.df-switch' ).addClass( 'active' );
                    $( '.df-menu-edit' ).css( 'display', 'block' );
                } else {
                    $( '.df-menu-edit' ).css( 'display', 'none' );
                }
            } );

            $( 'body' ).on( 'click', '.df-switch', function ( ev ) {
                var $this = $( this );
                var _opt = ev.currentTarget.dataset.enable ? ev.currentTarget.dataset.enable : 'off';
                $this.css( 'pointer-events', 'none' );
                if ( _opt == 'on' ) {
                    $this.removeClass( 'active' );
                    $( '.df-menu-edit' ).css( 'display', 'none' );
                } else {
                    $this.addClass( 'active' );
                    $( '.df-menu-edit' ).css( 'display', 'block' );
                }

                dfMenu.setDashboardSetting( menuId, _opt );
            } )
        },
        setDashboardSetting: function ( menuId, _opt ) {
            window.wp.apiFetch( {
                path: '/df-menu-settings/v2/df-am-option-edit-set',
                method: 'POST',
                data: {
                    id: menuId,
                    _opt: _opt
                }
            } ).then( ( res ) => {
                // console.log(res);
                $( '.df-switch' )[0].dataset.enable = res === 'on' ? 'on' : 'off';
                $( '.df-switch' ).css( 'pointer-events', 'all' );
            } );
        }

    }
    dfMenu.init();

})( jQuery );
