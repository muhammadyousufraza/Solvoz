window.wp = window.wp || {};

(function($) {
	const media = wp.media;

	media.view.AttachmentFilters.Taxonomy = media.view.AttachmentFilters.extend({
		tagName: 'select',

		createFilters: function() {
			const filters = {};
			const that = this;

			_.each(that.options.termList || {}, function(term, key) {
				const term_id = term['term_id'];
				const total_count = term['total_count'];
				const term_name = $("<div/>").html(term['term_name']).text();
				filters[term_id] = {
					// text: term_name + " (" + total_count + ")",
					text: term_name,
					priority: key + 2
				};
				filters[term_id]['props'] = {};
				filters[term_id]['props'][that.options.taxonomy] = term_id;
			});

			filters.all = {
				text: that.options.termListTitle,
				priority: 1
			};
			filters['all']['props'] = {};
			filters['all']['props'][that.options.taxonomy] = null;

			this.filters = filters;
		}
	});

	const curAttachmentsBrowser = media.view.AttachmentsBrowser;

	media.view.AttachmentsBrowser = media.view.AttachmentsBrowser.extend({
		createToolbar: function() {
			const filters = this.options.filters;

			curAttachmentsBrowser.prototype.createToolbar.apply(this, arguments);

			const that = this;
			let i = 1;

			$.each(difl_media_taxonomie_data, function(taxonomy, values) {
				if (values.term_list && filters) {
					that.toolbar.set(taxonomy + '-filter', new media.view.AttachmentFilters.Taxonomy({
						controller: that.controller,
						model: that.collection.props,
						priority: -80 + 10 * i++,
						taxonomy: taxonomy,
						termList: values.term_list,
						termListTitle: values.list_title,
						className: 'difl-mc-taxonomy-filter attachment-' + taxonomy + '-filter'
					}).render());
				}
			});
		}
	});

    media.view.AttachmentCompat.prototype.save = function( event ) {
        var data = {};

        if ( event ) {
            event.preventDefault();
        }

        _.each( this.$el.serializeArray(), function( pair ) {
            if ( /\[\]$/.test( pair.name ) ) {
                if ( undefined === data[ pair.name ] ) {
                    data[ pair.name ] = [];
                }
                data[ pair.name ].push( pair.value );
            } else {
                data[ pair.name ] = pair.value;
            }
        });

        this.controller.trigger( 'attachment:compat:waiting', ['waiting'] );
        this.model.saveCompat( data ).always( _.bind( this.postSave, this ) );
    };
})(jQuery);
