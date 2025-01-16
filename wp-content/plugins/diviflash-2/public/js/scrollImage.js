(function(){
    var scroll_image = document.querySelectorAll('.difl_scrollimage');
    [].forEach.call(scroll_image, function(ele, index) {
        var container = ele.querySelector('.df_scroll_image_container');
        var settings = JSON.parse(container.dataset.settings);
        var frame = settings.frame;
        var frame_type = settings.frame_type;
        if(frame === 'on'){

            setTimeout(frame_height_controll, 100, frame_type, ele);
            window.addEventListener('resize', function(e) {
                frame_height_controll(frame_type, ele);
                //setTimeout(frame_height_controll, 50, frame_type, ele);
            });
      
        }
      
        var target = settings.link_url_target;
        var ig_lightbox_options = {
            enable_light_box: settings.use_light_box,
            filter: false,
            filterValue: '',
            download : settings.use_lightbox_download === 'on' ? true : false
        }; 

        df_ig_url_open(target, ele);

        df_ig_use_lightbox(
            ele.querySelector('.df_scroll_image_container'), 
            ig_lightbox_options
        );
    })
})()


function df_ig_use_lightbox(selector, options) {
    if (options.enable_light_box === 'on') {
        var settings = {
            subHtmlSelectorRelative: true,
            addClass: 'df_si_lightbox',
            //counter: true,
            download : options.download
            // download: options.download
        };
           
        lightGallery(selector,settings);
    }
}

function df_ig_url_open(target, ele) {   
    var elements = ele.querySelectorAll('.df_scroll_image_holder');
   
    [].forEach.call(elements, function(image, index) {
        var url = image.dataset.url;
        if(url && url !== '') {
            image.addEventListener('click', function(event) {
               
                if (target === 'same_window') {
                    window.location = url;
                } else {
                    window.open(url)
                }
            })
        }
    })
}
function frame_height_controll(frame_type, ele){
    const browser = ["chrome_dark", "chrome", "edge", "edge_dark", "firefox", "firefox_dark", "opera" , "opera_dark"];
   
    var frame_height_selector = '.frame_image';
    var frame_container =  ele.querySelector(frame_height_selector); 
    let height = frame_container.clientHeight;
    
    if( height > 0 ){
        if(frame_type === 'desktop'){
            height = Math.ceil(height * .6031);
        }else if(frame_type === 'laptop'){
            height = Math.ceil(height * .762);
        }else if(frame_type === 'tablet'){
            height = Math.ceil(height * .814);
        }
        else if(frame_type === 'phone'){
            height = Math.ceil(height * .9299);
        }
        else if(frame_type === 'ipad'){
            height = Math.ceil(height * .8254);
        }
        else if(frame_type === 'macbook'){
            height = Math.ceil(height * .873);
        }
        else if(frame_type === 'macbookpro'){
            height = Math.ceil(height * .824);
        }
        else if(frame_type === 'safari'){
            height = Math.ceil(height * .922);
        }else{
            // /height = Math.ceil(height * .908);
        }
        const dynamic_height = ele.querySelector('.df_device_slider_device .scroll_image_section');

        var caption_height_container = ele.querySelector('.df_scroll_image_caption');
        const caption_height = caption_height_container ? caption_height_container.clientHeight: 0;
        // console.log(height);
        dynamic_height.style.height  = browser.includes(frame_type) ? (Math.ceil(height * .910)-caption_height) + "px" : (height-caption_height) + "px";
    }
}

