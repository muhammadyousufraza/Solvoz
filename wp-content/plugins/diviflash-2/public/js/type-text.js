(function(){
    document.addEventListener("DOMContentLoaded", function () {
        var selectors = document.querySelectorAll('.df-twt-container');
        [].forEach.call(selectors, function(selector){

            var data = JSON.parse( selector.dataset.options );
            var typeWriterSelector = selector.querySelector(".df-twt-container .df-twt-element");
            var content = typeWriterSelector.dataset.content;

            var _typwwriterArray = JSON.parse(content);

            var typewriter = new Typewriter( typeWriterSelector, {
                loop: data.loop === 'on' ? true : false,
                delay: parseInt( data.speed ),
                cursor: data.cursor === 'on' ? data.cursorchar : null,
            });

            [].forEach.call( _typwwriterArray, function( _string, index ) {
                
                typewriter.typeString( _string ).pauseFor( parseInt(data.pauseFor) )

                if( (_typwwriterArray.length - 1) != index ) {
                    typewriter.deleteAll(parseInt( data.deleteSpeed ))
                }

            } )

            typewriter.start();
  
        });
        
    });
})()