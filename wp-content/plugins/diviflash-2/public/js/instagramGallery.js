(function () {

    var df_image_gallery = document.querySelectorAll('.difl_instagramgallery');
    [].forEach.call(df_image_gallery, function (ele, index) {
        var container = ele.querySelector('.df_ing_container');
        var settings = JSON.parse(container.dataset.settings);
        var image_count = parseInt(settings.image_count);
        var total_item = parseInt(settings.total_item);
        var grid = ele.querySelector('.grid');
        var target = settings.url_target;
        var ig_lightbox_options = {
            ig_lightbox: settings.use_lightbox,
            filter: false,
            filterValue: '',
            download: settings.use_lightbox_download === 'on' ? true : false
        };

        if (typeof imagesLoaded === "function") {
            if (typeof Isotope === "function") {
                var iso = new Isotope(grid, {
                    layoutMode: settings.layout_mode,
                    percentPosition: true,
                    itemSelector: '.grid-item',
                    transitionDuration: '0.6s',
                    stagger: 30
                });
                // fix the lazy load layout issue
                var entries = grid.querySelectorAll('.grid-item');
                observer = new IntersectionObserver(function (item) {
                    iso.layout();
                });
                [].forEach.call(entries, function (v){
                    observer.observe(v);
                })
                // *****************
                df_ig_isotop(grid, iso);

                // load more functionality
                if (ele.querySelector('.ing-load-more-btn')) {
                    ele.querySelector('.ing-load-more-btn').addEventListener('click', function (event) {
                        event.preventDefault();
                        ele.querySelector('.ing-load-more-btn').classList.add('loading')

                        var ajaxurl = window.et_pb_custom.ajaxurl;
                        var load_more = container.querySelector('.ing-load-more-btn');
                        var loaded = parseInt(event.target.dataset.loaded);

                        fetch(ajaxurl, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'Cache-Control': 'no-cache',
                            },
                            body: new URLSearchParams({
                                et_frontend_nonce: window.et_pb_custom.et_frontend_nonce,
                                action: 'df_instagram_gallery_fetch',
                                images: settings.image_ids,
                                page: load_more.dataset.page,
                                loaded: loaded,
                                image_count: parseInt(settings.image_count),
                                options: JSON.stringify(settings)
                            })
                        })
                            .then(function (response) { return response.json() })
                            .then(function (response) {
                                let parser = new DOMParser();
                                let parsedHtml = parser.parseFromString(response.data, 'text/html');
                                var items = parsedHtml.querySelectorAll('.df_ing_image');

                                items.forEach(function (item) {
                                    grid.appendChild(item)
                                })
                                iso.appended(items)

                                df_ig_isotop(grid, iso);

                                loaded = loaded + image_count;

                                if (loaded >= total_item) {
                                    event.target.style.display = "none";
                                } else {
                                    event.target.setAttribute("data-loaded", loaded);
                                }
                                event.target.classList.remove('loading')
                            })
                            .then(function () {
                                df_ig_url_open(target, ele);

                                df_ig_use_lightbox(
                                    ele.querySelector('.grid'),
                                    ig_lightbox_options
                                );
                            })
                    })
                }

                df_ig_url_open(target, ele);

                df_ig_use_lightbox(
                    ele.querySelector('.grid'),
                    ig_lightbox_options
                );
            }
        }
    })

})()
function df_ig_isotop(selector, iso) {
    imagesLoaded(selector).on('progress', function () {
        iso.layout()
    }).on('done', function () {
        selector.style.opacity = 1;
    })
}
function df_ig_use_lightbox(selector, options) {
    if (options.ig_lightbox === 'on') {
        var settings = {
            subHtmlSelectorRelative: true,
            addClass: 'df_ig_lightbox',
            counter: false,
            download: options.download
        };

        lightGallery(selector, settings);
    }
}

function df_ig_url_open(target, ele) {
    var elements = ele.querySelectorAll('.item-content figure');
    [].forEach.call(elements, function (image, index) {
        var url = image.dataset.url;
        if (url && url !== '') {
            image.addEventListener('click', function imageClick(event) {
                if (target === 'same_window') {
                    window.location = url;
                } else {
                    window.open(url)
                }
            })
        }
    })
}
function igHandleClick(event) {
    return false;
}
