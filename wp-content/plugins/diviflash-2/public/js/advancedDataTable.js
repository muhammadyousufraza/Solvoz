(function ( $ ) {
		const init = () => {
			const dataTableInit = () => {
				let selectors = document.querySelectorAll( '.difl_advanced_data_table' );
				[].forEach.call( selectors, function ( selector, index ) {
					let tableElement = selector.querySelector( '.df-advanced-table' );
					let optionSetttings = JSON.parse( selector.querySelector( '.df_adt_container' ).dataset.options );
					let itemSelector = '.difl_advanced_data_table_' + index;
					let languagName = (optionSetttings.multi_lang_enable && optionSetttings.multi_lang_name) ? optionSetttings.multi_lang_name : 'English';

					const options = {
						// UI Theme Defaults
						searching: optionSetttings.adt_search,
						paging: optionSetttings.adt_paging,
						ordering: optionSetttings.adt_order,
						info: optionSetttings.adt_info,
						// scrollX: optionSetttings.adt_scroll_x,
						responsive: true,
						language: {
							"url": "https://cdn.datatables.net/plug-ins/1.10.15/i18n/" + languagName + ".json"
						}
					};

					$( itemSelector + ' .df-advanced-table' ).DataTable(
						options
					);
				} );
			}
			const handleColSpan = tds => {
				let pos;
				tds.forEach( ( col_value, col_key ) => {
					let prev = col_key - 1
					const content = col_value.textContent
					if ( '#colspan#' === content ) {
						tds[col_key].seen = true
						if ( '#colspan#' === tds[prev].textContent && true === tds[prev].seen ) {
							tds[pos].col_count++;
						} else {
							pos = col_key - 1
							tds[pos].col_count = 2;
						}
					}
				} )

				tds.forEach( ( col_value ) => {
					if ( col_value.col_count ) {
						col_value.setAttribute( 'colspan', col_value.col_count )
					}

					if ( '#colspan#' === col_value.textContent ) {
						col_value.remove()
					}
				} )

			}
			const handleRows = rows => {
				[ ...rows ].forEach( ( row_val, row_key ) => {
					const tds = [ ...row_val.querySelectorAll( 'td' ) ];
					handleColSpan( tds );
					tds.forEach( ( col_value, col_key, maintds ) => {
						const content = col_value.textContent

						if ( '#span#' === content ) {
							col_value.remove();
						}

						if ( '#rowspan#' === content ) {
							let row_count = 2;
							const previousRow = col_value.parentNode.previousSibling;
							const previousCol = previousRow.querySelectorAll( 'td' )

							const nextRow = col_value.parentNode.nextSibling
							const nextCol = nextRow.querySelectorAll( 'td' )
							if ( '#rowspan#' === nextCol[col_key].textContent ) {
								row_count++;
								nextCol[col_key].remove();
							}
							previousCol[col_key].setAttribute( 'rowspan', row_count )
							col_value.remove();
						}
					} )
				} )
			}
			const handleSPanning = () => {
				const tables = document.querySelectorAll( '.difl_advanced_data_table' );
				[ ...tables ].forEach( table => {
					const rows = table.querySelectorAll( 'tbody tr' );
					handleRows( rows );
				} )
			}

			dataTableInit();
			handleSPanning()
		}

		document.addEventListener( 'DOMContentLoaded', init )
	}
)
( jQuery );
