(function ($) {
    const df_acf_gallery = $('.difl_acfgallery');
    [].forEach.call(df_acf_gallery, function (ele, index) {
        const container = ele.querySelector('.df_acf_gallery_container');
        const settings = JSON.parse(container.dataset.settings);
        let image_obj = settings.images_array;
        const image_count = parseInt(settings.image_count);
        let grid = ele.querySelector('.grid');

        let target = settings.url_target;
        let acf_gallery_lightbox_options = {
            ig_lightbox: settings.use_lightbox,
            filter: false,
            filterValue: '',
            download: 'on' === settings.use_lightbox_download
        };

        if (typeof imagesLoaded === "function") {
            if (typeof Isotope === "function") {
                let iso = new Isotope(grid, {
                    layoutMode: settings.layout_mode,
                    percentPosition: false,
                    itemSelector: '.grid-item',
                    transitionDuration: '0.6s',
                    stagger: 30
                });
                // fix the lazy load layout issue
                let entries = grid.querySelectorAll('.grid-item');
                observer = new IntersectionObserver(function (item) {
                    iso.layout();
                });
                [].forEach.call(entries, function (v) {
                    observer.observe(v);
                })
                // *****************

                df_acf_gallery_isotop(grid, iso);

                // load more functionality
                if (ele.querySelector('.df-acf-gallery-load-more-btn')) {
                    ele.querySelector('.df-acf-gallery-load-more-btn').addEventListener('click', function (event) {
                        event.preventDefault();
                        ele.querySelector('.df-acf-gallery-load-more-btn').classList.add('loading')

                        const ajaxurl = window.et_pb_custom.ajaxurl;
                        let load_more = container.querySelector('.df-acf-gallery-load-more-btn');
                        let loaded = parseInt(event.target.dataset.loaded);

                        fetch(ajaxurl, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'Cache-Control': 'no-cache',
                            },
                            body: new URLSearchParams({
                                et_frontend_nonce: window.et_pb_custom.et_frontend_nonce,
                                action: 'df_acf_gallery_load_more',
                                page: load_more.dataset.page,
                                loaded: loaded,
                                image_count: parseInt(settings.image_count),
                                options: JSON.stringify(settings)
                            })
                        })
                            .then(function (response) {
                                return response.json()
                            })
                            .then(function (response) {
                                let parser = new DOMParser();
                                let parsedHtml = parser.parseFromString(response.data, 'text/html');
                                const items = parsedHtml.querySelectorAll('.df_acf_gallery_image');

                                if (loaded >= image_obj.length) {
                                    event.target.style.display = "none";
                                } else {
                                    items.forEach(function (item) {
                                        grid.appendChild(item)
                                    })
                                    loaded = loaded + image_count;
                                    event.target.setAttribute("data-loaded", loaded);
                                    if (loaded >= image_obj.length) {
                                        event.target.style.display = "none";
                                    }
                                }
                                iso.appended(items)
                                df_acf_gallery_isotop(grid, iso);
                                event.target.classList.remove('loading')
                            })
                            .then(function () {
                                df_acf_gallery_url_open(target, ele);

                                df_acf_gallery_use_lightbox(
                                    ele.querySelector('.grid'),
                                    acf_gallery_lightbox_options
                                );
                            })
                    })
                }

                // pagination functionality start
                const pageElem = ele.querySelector('.df-acf-gallery-pagination');
                if (pageElem !== null) {
                    const pageTags = pageElem.querySelectorAll('a');

                    pageElem.addEventListener('click', function (event) {
                        event.preventDefault();
                        window.scrollTo({top: $(ele).offset().top - 150, behavior: 'smooth'});
                        // Ditect mouse click outside button
                        if (!event.target.classList.contains('page-numbers')) {
                            return;
                        }
                        for (let i = 0, len = pageTags.length; i < len; i++) {
                            let pageTag = pageTags[i];
                            pageTag.classList.remove('current');
                        }

                        // only work with buttons
                        if (!matchesSelector(event.target, 'a')) {
                            return;
                        }

                        let pageNumber = '';
                        const imgCount = event.target.getAttribute('data-count');
                        if ('on' === settings.use_number_pagination) {
                            if (event.target.classList.contains('prev')) {
                                const currentPage = event.target.getAttribute('data-current');
                                if (currentPage === pageTags[1].getAttribute('data-page')) {
                                    pageTags[1].classList.add('current');
                                    return;
                                }
                                pageNumber = parseInt(currentPage) - 1;
                                pageTags[pageNumber].classList.add('current');
                                pageTags[0].setAttribute('data-current', pageNumber);
                                pageTags[pageTags.length - 1].setAttribute('data-current', pageNumber);
                            } else if (event.target.classList.contains('next')) {
                                const currentPage = event.target.getAttribute('data-current');
                                if (currentPage === pageTags[(parseInt(pageTags.length) - 2)].getAttribute('data-page')) {
                                    pageTags[pageTags.length - 2].classList.add('current');
                                    return;
                                }
                                pageNumber = parseInt(currentPage) + 1;
                                pageTags[pageNumber].classList.add('current');
                                pageTags[0].setAttribute('data-current', pageNumber);
                                pageTags[pageTags.length - 1].setAttribute('data-current', pageNumber);
                            } else {
                                pageNumber = event.target.getAttribute('data-page');
                                event.target.classList.add('current');
                                pageTags[0].setAttribute('data-current', pageNumber);
                                pageTags[pageTags.length - 1].setAttribute('data-current', pageNumber);
                            }
                            (parseInt(pageNumber) > 1) ? pageTags[0].style.display = 'block' : pageTags[0].style.display = 'none';
                            (parseInt(pageNumber) === pageTags.length - 2) ? pageTags[pageTags.length - 1].style.display = 'none' : pageTags[pageTags.length - 1].style.display = 'block';
                        } else {
                            if (event.target.classList.contains('prev')) {
                                const currentPage = event.target.getAttribute('data-current');
                                pageNumber = parseInt(currentPage) - 1;
                                pageTags[0].setAttribute('data-current', pageNumber);
                                pageTags[pageTags.length - 1].setAttribute('data-current', pageNumber);
                            } else if (event.target.classList.contains('next')) {
                                const currentPage = event.target.getAttribute('data-current');
                                pageNumber = parseInt(currentPage) + 1;
                                pageTags[0].setAttribute('data-current', pageNumber);
                                pageTags[pageTags.length - 1].setAttribute('data-current', pageNumber);
                            }
                            (parseInt(pageNumber) > 1) ? pageTags[0].style.display = 'block' : pageTags[0].style.display = 'none';
                            (parseInt(pageNumber) === Math.ceil(settings.image_ids.split(",").length / parseInt(imgCount))) ? pageTags[pageTags.length - 1].style.display = 'none' : pageTags[pageTags.length - 1].style.display = 'block';

                        }

                        const ajaxurl = window.et_pb_custom.ajaxurl;
                        fetch(ajaxurl, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                                'Cache-Control': 'no-cache',
                            },
                            body: new URLSearchParams({
                                et_frontend_nonce: window.et_pb_custom.et_frontend_nonce,
                                action: 'df_acf_gallery_fetch_page_data',
                                page: parseInt(pageNumber),
                                image_count: parseInt(imgCount),
                                options: JSON.stringify(settings)
                            })
                        })
                            .then(function (response) {
                                return response.json()
                            })
                            .then(function (response) {
                                let parser = new DOMParser();
                                let parsedHtml = parser.parseFromString(response.data, 'text/html');
                                const items = parsedHtml.querySelectorAll('.df_acf_gallery_image');
                                grid.innerHTML = ''
                                if (parseInt(imgCount) >= image_obj.length) {
                                    event.target.style.display = "none";
                                } else {
                                    items.forEach(function (item) {
                                        grid.appendChild(item);
                                    })
                                    if (parseInt(imgCount) >= image_obj.length) {
                                        event.target.style.display = "none";
                                    }
                                }
                                iso = new Isotope(grid, {
                                    layoutMode: settings.layout_mode,
                                    percentPosition: true,
                                    itemSelector: '.grid-item',
                                    transitionDuration: '0.6s',
                                    stagger: 30
                                });
                                df_acf_gallery_isotop(grid, iso);
                            })
                            .then(function () {
                                df_acf_gallery_url_open(target, ele);

                                df_acf_gallery_use_lightbox(
                                    ele.querySelector('.grid'),
                                    acf_gallery_lightbox_options
                                );
                            })
                    });
                }
                // pagination functionality end

                df_acf_gallery_url_open(target, ele);

                df_acf_gallery_use_lightbox(
                    ele.querySelector('.grid'),
                    acf_gallery_lightbox_options
                );

            }

        }

    })

    function df_acf_gallery_isotop(selector, iso) {
        imagesLoaded(selector).on('progress', function () {
            iso.layout()
        }).on('done', function () {
            selector.style.opacity = 1;
        })

    }

    function df_acf_gallery_use_lightbox(selector, options) {
        if ('on' === options.ig_lightbox) {
            let settings = {
                subHtmlSelectorRelative: true,
                addClass: 'df_acf_gallery_lightbox',
                counter: false,
                download: options.download
            };

            if (options.filter) {
                settings.selector = options.filterValue.replace('*', '');
                // window.lgData[selector.getAttribute('lg-uid')].destroy(true);
            }

            lightGallery(selector, settings);
        }
    }

    function df_acf_gallery_url_open(target, ele) {
        const elements = ele.querySelectorAll('.item-content');
        [].forEach.call(elements, function (image, index) {
            const url = image.dataset.url;
            if (url && url !== '') {
                image.addEventListener('click', function (event) {
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
})(jQuery)