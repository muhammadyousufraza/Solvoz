(function(){
  
    var cwrapper = document.querySelectorAll(".df-popupid-wrapper");
    var cbox = document.querySelectorAll(".df-popupid-copy");
    // console.log(cbox);
    for (let i = 0; i < cbox.length; i++) {
        cbox[i].addEventListener("click", function(event) {
            var text = event.target.innerText;
            var sibling = event.target.nextElementSibling;
            var el = document.createElement('textarea');
            el.value = text;
            el.setAttribute('readonly', '');
            el.style.position = 'absolute';
            el.style.left = '-9999px';
            document.body.appendChild(el);
            el.select();
            document.execCommand("copy");
            sibling.innerText = 'Copied to Clipboard';
        });
    }
    for (let i = 0; i < cwrapper.length; i++) {
        cwrapper[i].addEventListener("mouseout", function(event) {
            var tooltip = this.querySelector('.df-cpy-tooltip');
            tooltip.innerText = 'Click to copy';
        });
    }

})()
