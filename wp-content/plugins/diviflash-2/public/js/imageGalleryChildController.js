
(function($){

  var observer = new MutationObserver(function(mutations) {
    mutations.forEach(( mutation) => {
      if(mutation.type !== 'childList') return;
      const cat_selector = $('input[name="df_gallery_enable_category"]');
      const child_selector = $('.et-fb-settings-module-items-wrap');
      if (cat_selector.length <= 0 ) return;
      if('on' === cat_selector.val()){
          child_selector.css('display','none');
          $('.et-fb-tabs__panel--general .et-fb-form__toggle[data-order="1"]').css('marginTop', "-20px");
      }else{
          child_selector.css('display','block');
          $('.et-fb-tabs__panel--general .et-fb-form__toggle[data-order="1"]').css('marginTop', "20px");
      }

    })

  });

  observer.observe(document.body, { childList: true, subtree: true });

    $('body').on("click",function(e){
        const element = document.querySelector('.df-select2-wrapper');
        if ( element && element.contains(e.target)){
        } else{
            const field = document.querySelector('#df-select2-field')
            field && field.classList.contains('active')?field.classList.remove('active'):"";
        }
    });

})(jQuery)