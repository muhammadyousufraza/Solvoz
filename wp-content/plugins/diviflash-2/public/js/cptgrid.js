(function($){
    const df_posts = $('.difl_cptgrid');
    let load_data = [];
    let container_height = [];
    let prev_page_number = [];
    let page_number = [];

    [].forEach.call(df_posts, function(ele, index) {
        const settings = JSON.parse(ele.querySelector('.df_cptgrid_container').dataset.settings);
        const container = ele.querySelector('.df_cptgrid_container');
        const selector = ele.querySelector('.df-cpts-wrap');

        container_height[index] = $(ele).height();
        prev_page_number[index] = 1;
        page_number[index] = 2;
        load_data[index] = true;
        if ('on' === settings.on_scroll_load) {
            $(window).scroll(function () {
                if ($(ele).height() >= container_height[index]) {
                    container_height[index] = $(ele).height();
                    load_data[index] = true;
                }
                // Check if the user has scrolled to the bottom
                if (is_scrolled_to_bottom(ele) && true === load_data[index] && prev_page_number[index] !== page_number[index]) {
                    load_data[index] = false;
                    prev_page_number[index] = page_number[index];
                    if(!df_cpt_grid_loader.loader_exist('df-cpt-grip', container) && 'on' === settings.loader.status){
                        df_cpt_grid_loader.load({
                            type: settings.loader.type,
                            name: 'df-cpt-grip',
                            color: settings.loader.color,
                            background: settings.loader.background,
                            size: settings.loader.size,
                            margin:[settings.loader.margin[0],settings.loader.margin[1],settings.loader.margin[2],settings.loader.margin[3]],
                            alignment: settings.loader.alignment,
                            container: container,
                            position: 'relative'
                        });
                    }

                    fetch(window.et_pb_custom.ajaxurl, {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'Cache-Control': 'no-cache',
                        },
                        body: new URLSearchParams({
                            et_frontend_nonce: window.et_pb_custom.et_frontend_nonce,
                            action: 'df_cpt_grid_scroll_data',
                            use_current_loop: settings.use_current_loop,
                            post_type: settings.post_type,
                            posts_number: settings.posts_number,
                            post_display: settings.post_display,
                            orderby: settings.orderby,
                            offset_number: settings.offset_number,
                            page_number: page_number[index],
                            use_image_as_background: settings.use_image_as_background,
                            use_background_scale: settings.use_background_scale,
                            equal_height: settings.equal_height,
                            entire_item_clickable: settings.entire_item_clickable,
                            taxonomy_values: settings.taxonomy_values,
                            selected_terms: settings.selected_terms,
                            selected_taxonomy: settings.selected_taxonomy,
                            df_cpt_items: JSON.stringify(settings.df_cpt_items ? settings.df_cpt_items : []),
                            df_cpt_items_outside: JSON.stringify(settings.df_cpt_items_outside ? settings.df_cpt_items_outside : []),
                        })
                    })
                        .then(function (response) {
                            return response.json()
                        })
                        .then(function (response) {
                            if(df_cpt_grid_loader.loader_exist('df-cpt-grip', container) && 'on' === settings.loader.status) df_cpt_grid_loader.remove_loader('df-cpt-grip', container);
                            const parsedHtml = new DOMParser().parseFromString(response.data, 'text/html');
                            const items = parsedHtml.querySelectorAll('.df-cpt-item');
                            items.forEach((item) => selector.appendChild(item));
                            if(items.length > 0) page_number[index] = page_number[index] + 1;
                        })
                }
            });
        }
        if( 'masonry' === settings.layout ) {
            let masonry = new Isotope( selector, {
                layoutMode: 'masonry',
                itemSelector: '.df-cpt-item',
                percentPosition: true
            });
            // fix the lazy load layout issue
            const entries = selector.querySelectorAll('.df-cpt-item');
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
            }, 500);

            $( document ).ajaxSuccess(function() {
                masonry = new Masonry(ele.querySelector('.df-cpts-wrap'), {
                    layoutMode: 'masonry',
                    itemSelector: '.df-cpt-item',
                    percentPosition: true
                });
                setTimeout(function() {
                    masonry.layout();
                }, 100);
            });

        }

    })
    function is_scrolled_to_bottom(container) {
        return $(window).scrollTop() >= $(container).height() - $(container).offset().top - 250;
    }

    $('body').on('click', '.df-cpt-outer-wrap .et_main_video_container', function(event){
        $(this).find('.et_pb_video_overlay').addClass('df-hide-overlay');
    })

})(jQuery)

const df_cpt_grid_loader = {
    options: {
        type: 'bar_1',
        name: '',
        color: '#000000',
        background: '#ADD8E6',
        size: '10px',
        margin: ['0px', '0px', '0px', '0px'],
        alignment: 'center',
        container: null,
        position: 'relative',
        z_index: '',
        margin_from_top: '',
    },
    __init__: function (user_data) {
        for (let prop in user_data) {
            if (Object.prototype.hasOwnProperty.call(user_data, prop)) {
                if (user_data[prop] !== undefined && user_data[prop] !== null && user_data[prop] !== '') {
                    this.options[prop] = user_data[prop];
                }
            }
        }
    },
    __render__loader: function () {
        const container = this.__generate__loader_container();
        container.appendChild(this.__generate__loader_style());
        container.appendChild(this.__generate__loader_content());
        this.options.container.appendChild(container);
    },
    __generate__loader_container: function () {
        const loader = document.createElement('div');
        if (1 === this.options.margin.length) loader.style.margin = this.options.margin[0].length > 0 ? this.options.margin[0] : '0px';
        if (2 === this.options.margin.length) loader.style.margin = `${this.options.margin[0].length > 0 ? this.options.margin[0] : '0px'} ${this.options.margin[1] && this.options.margin[1].length > 0 ? this.options.margin[1] : '0px'}`;
        if (4 === this.options.margin.length) loader.style.margin = `${this.options.margin[0].length > 0 ? this.options.margin[0] : '0px'} ${this.options.margin[1] && this.options.margin[1].length > 0 ? this.options.margin[1] : '0px'} ${this.options.margin[2] && this.options.margin[2].length > 0 ? this.options.margin[2] : '0px'} ${this.options.margin[3] && this.options.margin[3].length > 0 ? this.options.margin[3] : '0px'}`;

        loader.style.width = '100%';
        loader.style.display = 'flex';
        if ('left' === this.options.alignment) loader.style.justifyContent = 'flex-start';
        if ('center' === this.options.alignment) loader.style.justifyContent = 'center';
        if ('right' === this.options.alignment) loader.style.justifyContent = 'flex-end';
        loader.style.position = this.options.position;
        loader.style.top = this.options.margin_from_top;
        loader.style.left = '0px';
        loader.style.right = '0px';
        loader.style.zIndex = this.options.z_index;
        loader.classList.add(`${this.options.name}--loader`);

        return loader;
    },
    __generate__loader_style: function () {
        const styles = {
            classic: `
            .${this.options.name}-${this.options.type} {
              width: fit-content;
              font-weight: bold;
              font-family: monospace;
              font-size: ${this.options.size};
              color: ${this.options.color};
            }
            .${this.options.name}-${this.options.type}:before {
              content:"Loading...";
              clip-path: inset(0 3ch 0 0);
              animation: ${this.options.name}-anim 1s steps(4) infinite;
            }
            @keyframes ${this.options.name}-anim {to{clip-path: inset(0 -1ch 0 0)}}
            `,
            dot_1: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 4;
              --_g: no-repeat radial-gradient(circle closest-side,${this.options.color} 90%,transparent);
              background: 
                var(--_g) 0%   50%,
                var(--_g) 50%  50%,
                var(--_g) 100% 50%;
              background-size: calc(100%/3) 100%;
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
                33%{background-size:calc(100%/3) 0%  ,calc(100%/3) 100%,calc(100%/3) 100%}
                50%{background-size:calc(100%/3) 100%,calc(100%/3) 0%  ,calc(100%/3) 100%}
                66%{background-size:calc(100%/3) 100%,calc(100%/3) 100%,calc(100%/3) 0%  }
            }
            `,
            dot_2: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              margin-right:5px;
              aspect-ratio: 1;
              border-radius: 50%;
              animation: ${this.options.name}-anim 1s infinite linear alternate;
            }
            @keyframes ${this.options.name}-anim {
                0%   {box-shadow: ${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 1)}, -${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 0.2)}; background: ${this.hex2rgba(this.options.color, 1)}}
                33%  {box-shadow: ${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 1)}, -${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 0.2)}; background: ${this.hex2rgba(this.options.color, 0.2)}}
                66%  {box-shadow: ${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 0.2)}, -${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 1)}; background: ${this.hex2rgba(this.options.color, 0.2)}}
                100% {box-shadow: ${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 0.2)}, -${parseInt(this.options.size.replace(/[^0-9]/g, '')) + 5}px 0 ${this.hex2rgba(this.options.color, 1)}; background: ${this.hex2rgba(this.options.color, 1)}}
            }
            `,
            bar_1: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: .75;
              --c: no-repeat linear-gradient(${this.options.color} 0 0);
              background: 
                var(--c) 0%   50%,
                var(--c) 50%  50%,
                var(--c) 100% 50%;
              animation: ${this.options.name}-anim 1s infinite linear alternate;
            }
            @keyframes ${this.options.name}-anim {
              0%  {background-size: 20% 50% ,20% 50% ,20% 50% }
              20% {background-size: 20% 20% ,20% 50% ,20% 50% }
              40% {background-size: 20% 100%,20% 20% ,20% 50% }
              60% {background-size: 20% 50% ,20% 100%,20% 20% }
              80% {background-size: 20% 50% ,20% 50% ,20% 100%}
              100%{background-size: 20% 50% ,20% 50% ,20% 50% }
            }
            `,
            bar_2: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              background: 
                linear-gradient(transparent calc(1*100%/6),${this.options.color} 0 calc(3*100%/6),transparent 0) left   bottom,
                linear-gradient(transparent calc(2*100%/6),${this.options.color} 0 calc(4*100%/6),transparent 0) center bottom,
                linear-gradient(transparent calc(3*100%/6),${this.options.color} 0 calc(5*100%/6),transparent 0) right  bottom;
              background-size: 20% 600%;
              background-repeat: no-repeat;
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              100% {background-position: left top,center top,right top }
            }
            `,
            spinner_1: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              border-radius: 50%;
              border: 8px solid ${this.options.background};
              border-right-color: ${this.options.color};
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              to{transform: rotate(1turn)}}
            }
            `,
            spinner_2: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              padding: 8px;
              aspect-ratio: 1;
              border-radius: 50%;
              background: ${this.options.color};
              --_m: 
                conic-gradient(#0000 10%,#000),
                linear-gradient(#000 0 0) content-box;
              -webkit-mask: var(--_m);
                      mask: var(--_m);
              -webkit-mask-composite: source-out;
                      mask-composite: subtract;
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              to{transform: rotate(1turn)}
            }
            `,
            spinner_3: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              border-radius: 50%;
              background: 
                radial-gradient(farthest-side,${this.options.color} 94%,#0000) top/8px 8px no-repeat,
                conic-gradient(#0000 30%,${this.options.color});
              -webkit-mask: radial-gradient(farthest-side,#0000 calc(100% - 8px),#000 0);
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              100%{transform: rotate(1turn)}
            }
            `,
            spinner_4: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              border-radius: 50%;
              padding: 6px;
              background:
                conic-gradient(from 135deg at top,${this.options.color} 90deg, #0000 0) 0 calc(50% - 4px)/17px 8.5px,
                radial-gradient(farthest-side at bottom left,#0000 calc(100% - 6px),${this.options.color} calc(100% - 5px) 99%,#0000) top right/50%  50% content-box content-box,
                radial-gradient(farthest-side at top        ,#0000 calc(100% - 6px),${this.options.color} calc(100% - 5px) 99%,#0000) bottom   /100% 50% content-box content-box;
              background-repeat: no-repeat;
              animation: ${this.options.name}-anim 1s infinite linear;
            }
            @keyframes ${this.options.name}-anim {
              100%{transform: rotate(1turn)}
            }
            `,
            spinner_5: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              display: grid;
              border-radius: 50%;
              background:
                linear-gradient(0deg ,${this.hex2rgba(this.options.color, 0.5)} 30%,#0000 0 70%,${this.hex2rgba(this.options.color, 1)} 0) 50%/8% 100%,
                linear-gradient(90deg,${this.hex2rgba(this.options.color, 0.25)} 30%,#0000 0 70%,${this.hex2rgba(this.options.color, 0.75)} 0) 50%/100% 8%;
              background-repeat: no-repeat;
              animation: ${this.options.name}-anim 1s infinite steps(12);
            }
            .${this.options.name}-${this.options.type}::before,
            .${this.options.name}-${this.options.type}::after {
               content: "";
               grid-area: 1/1;
               border-radius: 50%;
               background: inherit;
               opacity: 0.915;
               transform: rotate(30deg);
            }
            .${this.options.name}-${this.options.type}::after {
               opacity: 0.83;
               transform: rotate(60deg);
            }
            @keyframes ${this.options.name}-anim {
              100% {transform: rotate(1turn)}
            }
            `,
            spinner_6: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              border-radius: 50%;
              border: 8px solid ${this.options.color};
              animation:
                ${this.options.name}-anim 0.8s infinite linear alternate,
                ${this.options.name}-anim2 1.6s infinite linear;
            }
            @keyframes ${this.options.name}-anim{
              0%    {clip-path: polygon(50% 50%,0       0,  50%   0%,  50%    0%, 50%    0%, 50%    0%, 50%    0% )}
              12.5% {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100%   0%, 100%   0%, 100%   0% )}
              25%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 100% 100%, 100% 100% )}
              50%   {clip-path: polygon(50% 50%,0       0,  50%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
              62.5% {clip-path: polygon(50% 50%,100%    0, 100%   0%,  100%   0%, 100% 100%, 50%  100%, 0%   100% )}
              75%   {clip-path: polygon(50% 50%,100% 100%, 100% 100%,  100% 100%, 100% 100%, 50%  100%, 0%   100% )}
              100%  {clip-path: polygon(50% 50%,50%  100%,  50% 100%,   50% 100%,  50% 100%, 50%  100%, 0%   100% )}
            }
            @keyframes ${this.options.name}-anim2 {
              0%    {transform:scaleY(1)  rotate(0deg)}
              49.99%{transform:scaleY(1)  rotate(135deg)}
              50%   {transform:scaleY(-1) rotate(0deg)}
              100%  {transform:scaleY(-1) rotate(-135deg)}
            }
            `,
            spinner_7: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              display:grid;
              -webkit-mask: conic-gradient(from 15deg,#0000,#000);
              animation: ${this.options.name}-anim 1s infinite steps(12);
            }
            .${this.options.name}-${this.options.type},
            .${this.options.name}-${this.options.type}:before,
            .${this.options.name}-${this.options.type}:after{
              background:
                radial-gradient(closest-side at 50% 12.5%,
                 ${this.options.color} 96%,#0000) 50% 0/20% 80% repeat-y,
                radial-gradient(closest-side at 12.5% 50%,
                 ${this.options.color} 96%,#0000) 0 50%/80% 20% repeat-x;
            }
            .${this.options.name}-${this.options.type}:before,
            .${this.options.name}-${this.options.type}:after {
              content: "";
              grid-area: 1/1;
              transform: rotate(30deg);
            }
            .${this.options.name}-${this.options.type}:after {
              transform: rotate(60deg);
            }
            @keyframes ${this.options.name}-anim {
              100% {transform:rotate(1turn)}
            }
            `,
            spinner_8: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              --_c:no-repeat radial-gradient(farthest-side,${this.options.color} 92%,#0000);
              background: 
                var(--_c) top,
                var(--_c) left,
                var(--_c) right,
                var(--_c) bottom;
              background-size: 12px 12px;
              animation: ${this.options.name}-anim 1s infinite;
            }
            @keyframes ${this.options.name}-anim {
              to{transform: rotate(.5turn)}
            }
            `,
            continuous: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              height: calc(${this.options.size}/6);
              -webkit-mask: linear-gradient(90deg,${this.options.color} 70%,#0000 0) left/20% 100%;
              background:
               linear-gradient(${this.options.color} 0 0) left -25% top 0 /20% 100% no-repeat
               #ddd;
              animation: ${this.options.name}-anim 1s infinite steps(6);
            }
            @keyframes ${this.options.name}-anim {
              100% {background-position: right -25% top 0}
            }
            `,
            blob_1: `
            .${this.options.name}-${this.options.type} {
              height: ${this.options.size};
              aspect-ratio: 2;
              border: 10px solid ${this.options.background};
              box-sizing: border-box;
              background: 
                radial-gradient(farthest-side,${this.options.color} 98%,#0000) left/calc(${this.options.size} / 2.5) calc(${this.options.size} / 2.5),
                radial-gradient(farthest-side,${this.options.color} 98%,#0000) left/calc(${this.options.size} / 2.5) calc(${this.options.size} / 2.5),
                radial-gradient(farthest-side,${this.options.color} 98%,#0000) center/calc(${this.options.size} / 2.5) calc(${this.options.size} / 2.5),
                radial-gradient(farthest-side,${this.options.color} 98%,#0000) right/calc(${this.options.size} / 2.5) calc(${this.options.size} / 2.5),
                ${this.options.background};
              background-repeat: no-repeat;
              filter: blur(4px) contrast(10);
              animation: ${this.options.name}-anim 1s infinite;
            }
            @keyframes ${this.options.name}-anim {
              100%  {background-position:right,left,center,right}
            }
            `,
            // blob_2: `
            // .${this.options.name}-${this.options.type} {
            //   width: ${this.options.size};
            //   aspect-ratio: 1;
            //   padding: 10px;
            //   box-sizing: border-box;
            //   display: grid;
            //   background: #fff;
            //   filter: blur(5px) contrast(10);
            //   mix-blend-mode: darken;
            // }
            // .${this.options.name}-${this.options.type}:before,
            // .${this.options.name}-${this.options.type}:after{
            //   content: "";
            //   grid-area: 1/1;
            //   width: calc(${this.options.size} / 2.5);
            //   height: calc(${this.options.size} / 2.5);
            //   background: ${this.options.color};
            //   animation: ${this.options.name}-anim 2s infinite;
            // }
            // .${this.options.name}-${this.options.type}:after{
            //   animation-delay: -1s;
            // }
            // @keyframes ${this.options.name}-anim {
            //   0%   {transform: translate(   0,0)}
            //   25%  {transform: translate(100%,0)}
            //   50%  {transform: translate(100%,100%)}
            //   75%  {transform: translate(   0,100%)}
            //   100% {transform: translate(   0,0)}
            // }
            // `,
            flipping_1: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              display: grid;
              grid: 50%/50%;
              color: ${this.options.color};
              --_g: no-repeat linear-gradient(currentColor 0 0);
              background: var(--_g),var(--_g),var(--_g);
              background-size: 50.1% 50.1%;
              animation: 
                ${this.options.name}-anim   1.5s infinite steps(1) alternate,
                ${this.options.name}-anim-0 3s   infinite steps(1);
            }
            .${this.options.name}-${this.options.type}::before {
              content: "";
              background: currentColor;
              transform: perspective(150px) rotateY(0deg) rotateX(0deg);
              transform-origin: bottom right; 
              animation: ${this.options.name}-anim1 1.5s infinite linear alternate;
            }
            @keyframes ${this.options.name}-anim {
              0%  {background-position: 0    100%,100% 100%,100% 0}
              33% {background-position: 100% 100%,100% 100%,100% 0}
              66% {background-position: 100% 0   ,100% 0   ,100% 0}
            }
            @keyframes ${this.options.name}-anim-0 {
              0%  {transform: scaleX(1)  rotate(0deg)}
              50% {transform: scaleX(-1) rotate(-90deg)}
            }
            @keyframes ${this.options.name}-anim1 {
              16.5%{transform:perspective(150px) rotateX(-90deg)  rotateY(0deg)    rotateX(0deg);filter:grayscale(0.8)}
              33%  {transform:perspective(150px) rotateX(-180deg) rotateY(0deg)    rotateX(0deg)}
              66%  {transform:perspective(150px) rotateX(-180deg) rotateY(-180deg) rotateX(0deg)}
              100% {transform:perspective(150px) rotateX(-180deg) rotateY(-180deg) rotateX(-180deg);filter:grayscale(0.8)}
            }
            `,
            flipping_2: `
            .${this.options.name}-${this.options.type} {
              width: ${this.options.size};
              aspect-ratio: 1;
              color: ${this.options.color};
              background:
                linear-gradient(currentColor 0 0) 100%  0,
                linear-gradient(currentColor 0 0) 0  100%;
              background-size: 50.1% 50.1%;
              background-repeat: no-repeat;
              animation:  ${this.options.name}-anim 1s infinite steps(1);
            }
            .${this.options.name}-${this.options.type}::before,
            .${this.options.name}-${this.options.type}::after {
              content:"";
              position: absolute;
              inset: 0 50% 50% 0;
              background: currentColor;
              transform: scale(var(--s,1)) perspective(150px) rotateY(0deg);
              transform-origin: bottom right; 
              animation: ${this.options.name}-anim1 .5s infinite linear alternate;
            }
            .${this.options.name}-${this.options.type}::after {
              --s:-1,-1;
            }
            @keyframes ${this.options.name}-anim {
              0%  {transform: scaleX(1)  rotate(0deg)}
              50% {transform: scaleX(-1) rotate(-90deg)}
            }
            @keyframes ${this.options.name}-anim1 {
              49.99% {transform:scale(var(--s,1)) perspective(150px) rotateX(-90deg) ;filter:grayscale(0)}
              50%    {transform:scale(var(--s,1)) perspective(150px) rotateX(-90deg) ;filter:grayscale(0.8)}
              100%   {transform:scale(var(--s,1)) perspective(150px) rotateX(-180deg);filter:grayscale(0.8)}
            }
            `,
        }
        const styleTag = document.createElement('style');
        styleTag.appendChild(document.createTextNode(styles[this.options.type]));
        return styleTag;
    },
    __generate__loader_content: function () {
        const loaderBar = document.createElement('div');
        loaderBar.classList.add(`${this.options.name}-${this.options.type}`);
        return loaderBar;
    },
    load: function (options = {}) {
        this.__init__(options);
        this.__render__loader();
    },
    remove_loader: function (loader_name, container) {
        const loaderElement = container.querySelector(`.${loader_name}--loader`);
        if (loaderElement) {
            loaderElement.remove();
        }
    },
    loader_exist: function (loader_name, container) {
        const loaderElement = container.querySelector(`.${loader_name}--loader`);
        if (loaderElement) {
            return true;
        }
        return false;
    },
    hex2rgba: (hex, alpha = 1) => {
        const [r, g, b] = hex.match(/\w\w/g).map(x => parseInt(x, 16));
        return `rgba(${r},${g},${b},${alpha})`;
    }
};