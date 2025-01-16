(function(){
    var df_products = document.querySelectorAll('.difl_productgrid');

    [].forEach.call(df_products, function(ele, index) {
        var settings = JSON.parse(ele.querySelector('.df_productgrid_container').dataset.settings)
        var selector = ele.querySelector('.df-products-wrap .products');
        var first_load = false;
        if(settings.layout === 'masonry') {
            var masonry = new Isotope( selector, {
                layoutMode: 'masonry',
                itemSelector: 'li.product',
                percentPosition: true
            });
            // fix the lazy load layout issue
            var entries = selector.querySelectorAll('li.product');
            observer = new IntersectionObserver(function (item) {
                masonry.layout();
            });
            [].forEach.call(entries, function (v){
                observer.observe(v);
            })
            // *****************
            imagesLoaded(selector).on('progress', function(){
                masonry.layout();
            })
            .on('done', function(){
                masonry.layout();
            })
            setTimeout(function(){
                masonry.layout();
                first_load = true;
            }, 500);
            if(first_load){
                jQuery( document ).ajaxSuccess(function() {
                    masonry = new Masonry(ele.querySelector('.df-products-wrap'), {
                        layoutMode: 'masonry',
                        itemSelector: 'li.product',
                        percentPosition: true
                    });
                    setTimeout(function() {
                        masonry.layout();
                    }, 100);
                });
            }                         
        }

        // Extra Theme extra empty a tag issue. Select all empty tags
        const emptyTags = ele.querySelectorAll('a:empty');

        // Loop through empty tags and remove them
        emptyTags.forEach(tag => {
            tag.remove();
        });
    })
    
})()
