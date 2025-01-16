
window.dfadh_animation = function(heading) {
    const data = JSON.parse(heading.dataset.anmi);
    const wrapper = heading.querySelector('.words-wrapper');
    const words = wrapper.children;
    var animation = null;
    const transition_type = data.transition_type;
    
    if (transition_type === "word") {
        animation = new WordAnimation(words, wrapper, data);
    }
    if (transition_type === "letter") {
        animation = new LetterAnimation(words, wrapper, data);
    }
    return animation;
}

class WordAnimation {
    constructor(elements, wrapper, data) {
        this.data = data;
        this.index = 0;
        this.elements = elements;
        this.delay = 100;
        this.endDelay = Number(data.delay);
        this.duration = Number(data.duration);
        this.wrapper = wrapper;
        this.stagger = 50;
        this.loopCount = 0;
        this.showAnim = null;
        this.animate(this.index);
    }
    anim_restart() {
        var _this = this;
        _this.showAnim.reset();
        _this.wrapper.style.width = 'auto';
        for (var i = 0; i < _this.elements.length; i++) {
            if ( i === 0 ) {
                _this.elements[i].style.position = 'relative';
            } else {
                _this.elements[i].style.position = 'absolute';
            }
        }
    }
    setWrapperWidth(index) {
        var _this = this;
        _this.wrapper.style.minWidth = _this.elements[index].offsetWidth + 'px';
        _this.wrapper.style.minHeight = _this.elements[index].offsetHeight + 'px';
    }
    animate(index) {
        var _this = this;
        var nextEl = _this.nextIndex(index, _this.elements.length);
        var animation_objects = {
            targets: _this.elements[index],
            opacity: ['0', '1'],
            duration: _this.duration,
            endDelay: _this.endDelay,
            direction: 'alternate',
            begin: function(anim) {
                _this.setWrapperWidth(index);
                if (  _this.loopCount !== 0) {
                    _this.wrapper.style.width = getComputedStyle(_this.elements[index]).width;
                }
            },
            changeComplete: function() {
                if ( _this.loopCount === 0) {
                    _this.wrapper.style.width = getComputedStyle(_this.elements[index]).width;
                }
            },
            complete: function(anim) {   
                _this.elements[index].style.position = 'absolute';
                _this.elements[nextEl].style.position = 'relative';
                _this.loopCount++;
                _this.animate(nextEl);
            }
        }
        animation_objects = _this.animation_properties_show(animation_objects);
        
        if (_this.data.easing && _this.data.easing !== 'none') {
            animation_objects.easing = _this.data.easing;
        } else {
            var mass = parseInt(_this.data.mass);
            var stiffness = parseInt(_this.data.stiffness);
            var damping = parseInt(_this.data.damping);
            var velocity = parseInt(_this.data.velocity);
            animation_objects.easing = 'spring('+mass+', '+stiffness+', '+damping+', '+velocity+')';
        }
        _this.showAnim = anime(animation_objects);        
    }
    nextIndex(index, length) {
        return index < length -1 ? (index + 1) : 0;
    }

    animation_properties_show(animation_objects){
        var _this = this;
        var anim_type = _this.data.animation_type;
        if (anim_type === 'type-word-rotate') {
            animation_objects.rotateX = ['90deg', '0'];
            animation_objects.translateZ = ['0', '0'];
            animation_objects.translateX = ['0', '0'];
            animation_objects.translateY = ['0', '0'];
        } else if (anim_type === 'type-word-slide-top') {
            animation_objects.translateY = ['-100', '0'];
        } else if (anim_type === 'type-word-slide-left') {
            animation_objects.translateX = ['-100', '0'];
        } else if (anim_type === 'type-word-scale') {
            animation_objects.scale = ['0', '1'];
            animation_objects.translateZ = 0;
        }
        return animation_objects;
    }
}

class LetterAnimation {
    constructor(elements, wrapper, data) {
        this.data = data;
        this.index = 0;
        this.elements = elements;
        this.delay = 50;
        this.endDelay = Number(data.delay);
        this.duration = Number(data.duration);
        this.wrapper = wrapper;
        this.stagger = 50;
        this.showAnim = null;
        this.loopCount = 0;
        this.animate(this.index);
    }
    anim_restart() {
        var _this = this;
        _this.showAnim.reset();
        _this.wrapper.style.width = 'auto';
        for (var i = 0; i < _this.elements.length; i++) {
            if ( i === 0 ) {
                _this.elements[i].style.position = 'relative';
            } else {
                _this.elements[i].style.position = 'absolute';
            }
        }
    }
    animate(index) {
        var _this = this;
        var nextEl = _this.nextIndex(index, _this.elements.length)
        var letters = _this.elements[index].querySelectorAll('span');
        var animation_objects = {
            targets: letters,
            opacity: ['0', '1'],
            direction: 'alternate',
            duration: _this.duration,
            delay: anime.stagger(_this.stagger),
            endDelay: _this.endDelay,
            begin: function(anim) {
                _this.setWrapperWidth(index);
                if (  _this.loopCount !== 0) {
                    _this.wrapper.style.width = getComputedStyle(_this.elements[index]).width;
                }
            },
            changeComplete: function() {
                if ( _this.loopCount === 0) {
                    _this.wrapper.style.width = getComputedStyle(_this.elements[index]).width;
                }
            },
            complete: function(anim) {
                _this.elements[index].style.position = 'absolute';
                _this.elements[nextEl].style.position = 'relative';
                _this.loopCount++;
                _this.animate(nextEl)
            }
        };
        // animation with differnet types
        animation_objects = _this.animation_properties_show(animation_objects);

        if (_this.data.easing && _this.data.easing !== 'none') {
            animation_objects.easing = _this.data.easing;
        } else {
            var mass = parseInt(_this.data.mass);
            var stiffness = parseInt(_this.data.stiffness);
            var damping = parseInt(_this.data.damping);
            var velocity = parseInt(_this.data.velocity);
            animation_objects.easing = 'spring('+mass+', '+stiffness+', '+damping+', '+velocity+')';
        }

        _this.showAnim = anime(animation_objects);
    }

    setWrapperWidth(index) {
        var _this = this;
        _this.wrapper.style.minWidth = _this.elements[index].offsetWidth + 'px';
        _this.wrapper.style.minHeight = _this.elements[index].offsetHeight + 'px';
    }

    nextIndex(index, length) {
        return index < length -1 ? (index + 1) : 0;
    }
    animation_properties_show(animation_objects) {
        var _this = this;
        if (_this.data.animation_type === 'type-letter-flip') {
            animation_objects.rotateY = ['180deg', '0'];
        } else if (_this.data.animation_type === 'type-letter-scale') {
            animation_objects.scale = ['0', '1'];
            animation_objects.translateZ = 0;
        } else if ( _this.data.animation_type === 'type-letter-wave' ) {
            animation_objects.translateY = ["1.1em", "0"];
            animation_objects.translateZ = 0;
        } else if ( _this.data.animation_type === 'type-letter-stand' ) {
            animation_objects.translateY = ["1.1em", 0];
            animation_objects.translateX = ["0.55em", 0];
            animation_objects.translateZ = 0;
            animation_objects.rotateZ = [180, 0];
            animation_objects.easing = "easeOutExpo";
        } else if ( _this.data.animation_type === "type-letter-slide" ) {
            animation_objects.translateX = [40,0];
            animation_objects.easing = "easeOutExpo";
        }
        return animation_objects;
    }
}


(function(){
    if(window.dfadh_animation && !window.ET_Builder) {
        var headings = document.querySelectorAll('.headline-animation');
        [].forEach.call(headings, function(heading) {
            window.dfadh_animation(heading);
        })
    }
})()














