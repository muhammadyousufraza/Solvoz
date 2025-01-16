const tmln_animations = {
   slide_right: {
      opacity: ['0', '1'],
      translateX: ['100px', '0']
   },
   slide_left: {
      opacity: ['0', '1'],
      translateX: ['-100px', '0']
   },
   slide_down: {
      opacity: ['0', '1'],
      translateY: ['-100px', '0']
   },
   slide_up: {
      opacity: ['0', '1'],
      translateY: ['100px', '0']
   },
   fade_in: {
      opacity: ['0', '1'],
   },
   zoom_right: {
      opacity: ['0', '1'],
      scale: ['.5', '1'],
      transformOrigin: ['100% 50%', '100% 50%'],
   },
   zoom_center: {
      opacity: ['0', '1'],
      scale: ['.5', '1'],
      transformOrigin: ['50% 50%', '50% 50%'],
   },
   zoom_left: {
      opacity: ['0', '1'],
      scale: ['.5', '1'],
      transformOrigin: ['0% 50%', '0% 50%'],
   }
}

// Scroll & Animation
const ScrollObserver = new IntersectionObserver(
   (entries, observer) => {
      entries.forEach((entry) => {
         if (entry.isIntersecting) {
            const tmln_content_area = entry.target;
            // item will appear if animation on
            tmln_content_area.closest('.df_timeline_item').style.opacity = 1
            const tmln_anim_data = JSON.parse(tmln_content_area.closest('.df_timeline_container').dataset.settings);
            const hasRev = tmln_content_area.closest('.df_timeline_item').classList.contains('reverse');
            const tmln_animation = tmln_anim_data.tmln_animation
            let tmln_animation_rev = '';
            if (tmln_animation.includes('_left')) {
               tmln_animation_rev = tmln_animation.replace('_left', '_right')
            } else if (tmln_animation.includes('_right')) {
               tmln_animation_rev = tmln_animation.replace('_right', '_left')
            }

            const object = {
               targets: tmln_content_area,
               easing: "linear",
               duration: 1000,
            };

            if (window.anime) {
               window.anime(Object.assign(object, tmln_animations[tmln_animation]));
               if (hasRev && '' !== tmln_animation_rev) {
                  window.anime(Object.assign(object, tmln_animations[tmln_animation_rev]));
               }
            }

            observer.unobserve(entry.target);
         }
      });
   },
   { threshold: 0.5 }
);

const difl_timeline = document.querySelectorAll(".difl_timeline");
var mobileBreakpointMax = window.matchMedia('(max-width: 767px)');
var mobileBreakpointMin = window.matchMedia('(max-width: 400px)');
document.addEventListener('DOMContentLoaded',function () {
   [].forEach.call(difl_timeline, function (parent) {
      const settings = JSON.parse(parent.querySelector('.df_timeline_container').dataset.settings);
      df_timeline_function(parent, settings);
      // responsive
      if (window.matchMedia("(max-width: 767px)")) {
         if ('left' == settings.layout_type_mobile) {
            parent.querySelector('.df_timeline_container').classList.add('layout_left');
         } else if ('right' == settings.layout_type_mobile) {
            parent.querySelector('.df_timeline_container').classList.add('layout_right');
         } else {
            parent.querySelector('.df_timeline_container').classList.add('layout_middle');
         }
      }

      // Set timeline item
      const df_tmln_items = parent.querySelectorAll('.df_timeline_item');
      df_tmln_items.forEach((item, index) => {
         if ('middle' == settings.layout_type) {
            if (index % 2 === 0) {
               item.classList.add('reverse');
            }
         } else if ('right' == settings.layout_type) {
            item.classList.add('reverse');
         }

         // item will appear straight if animation off
         if ("on" != settings.enable_item_animation) {
            item.style.opacity = 1
         } else {
            item.style.opacity = 0
         }
      });

      // Animation
      if ("on" == settings.enable_item_animation) {
         const df_tmln_content_area = parent.querySelectorAll('.df_timeline_content_area');
         df_tmln_content_area.forEach((element) => {
            ScrollObserver.observe(element);
         });
      }
   })
})

function df_timeline_function(parent, settings) {
   const df_tmln_line = parent.querySelector('.df_timeline_line');
   const df_line_inner = parent.querySelectorAll('.df_line_inner');
   const df_tmln_markers = parent.querySelectorAll('.df_timeline_marker');
   const df_tmln_content = parent.querySelectorAll('.df_timeline_content');
   const df_tmln_date_area = parent.querySelectorAll('.df_timeline_date_area');
   const df_tmln_date_content = parent.querySelectorAll('.df_timeline_date_content');

   df_tmln_line.style.opacity = 1;

   // date in blurb
   if (mobileBreakpointMax.matches && "on" !== settings.disable_date_mobile && "on" === settings.enable_date_in_blurb) {
      df_tmln_content.forEach((element, i) => {
         element.appendChild(df_tmln_date_area[i]);
         if (-1 !== settings.date_order) {
            df_tmln_date_area[i].style.order = settings.date_order
         } else {
            df_tmln_date_area[i].style.order = -1
         }
      });
   }

   // line vertical position + height
   if ("first_marker" == settings.line_start_from && !mobileBreakpointMax.matches) {
      df_tmln_position(df_tmln_markers, df_tmln_line, settings);
      window.addEventListener('resize', df_tmln_position); // line
   } else {
      const line_top_marker_space = settings.enable_line_top_marker ? parseInt(settings.line_top_marker_space) : 0;
      const line_bottom_marker_space = settings.enable_line_bottom_marker ? parseInt(settings.line_bottom_marker_space) : 0;
      df_tmln_line.style.height = `calc(100% + ${line_top_marker_space + line_bottom_marker_space}px)`;
      df_tmln_line.style.top = - line_top_marker_space + 'px';
   }

   // content arrow vertical position
   if ("on" == settings.enable_arrow) {
      const content_arrow_settings = {
         'vertical_align': settings.arrow_vertical_align,
         'vertical_position': settings.arrow_vertical_position,
         'context': 'content'
      };

      if (!mobileBreakpointMax.matches) {
         df_tmln_arrow_position(df_tmln_content, content_arrow_settings);
      }
   }

   // date arrow vertical position
   if ("on" == settings.enable_date_arrow) {
      const date_arrow_settings = {
         'vertical_align': settings.date_arrow_vertical_align,
         'vertical_position': settings.date_arrow_vertical_position,
         'context': 'date'
      };
      if (!mobileBreakpointMax.matches) {
         df_tmln_arrow_position(df_tmln_date_content, date_arrow_settings);
      }
   }

   // date arrow
   window.addEventListener('resize', df_tmln_arrow_position);

   // line horizontal position 
   if (typeof settings.line_width !== "undefined") {
      function df_tmln_line_setup() {
         const lineWidth = df_tmln_line.offsetWidth;
         if (!df_tmln_markers.length) return;
         const firstMarkerWidth = df_tmln_markers[0].offsetWidth;
         const markerOffsetSide = df_tmln_markers[0].offsetLeft + (firstMarkerWidth / 2) - (lineWidth / 2) + 'px';

         df_tmln_line.style.left = markerOffsetSide
         df_line_inner.forEach(innerLine => {
            innerLine.style.left = markerOffsetSide
         });

         if (mobileBreakpointMax.matches) {
            if ("middle" === settings.layout_type_mobile) {
               df_tmln_line.style.left = markerOffsetSide
               df_line_inner.forEach(innerLine => {
                  innerLine.style.left = markerOffsetSide
               });
            } else if ("left" === settings.layout_type_mobile) {
               const leftPosition = `calc(0% + ${(firstMarkerWidth / 2) - lineWidth / 2}px)`;
               df_tmln_line.style.left = leftPosition
               df_line_inner.forEach(innerLine => {
                  innerLine.style.left = leftPosition
               });
            } else if ("right" === settings.layout_type_mobile) {
               const rightPosition = `calc(100% - ${(firstMarkerWidth / 2) + lineWidth / 2}px)`;
               df_tmln_line.style.left = rightPosition
               df_line_inner.forEach(innerLine => {
                  innerLine.style.left = rightPosition
               });
            }
         }

      }

      setTimeout(() => {
         df_tmln_line_setup()
         window.addEventListener('resize', df_tmln_line_setup);
      }, 100)
   }

   // top bottom marker postion
   const lineTopMarker = parent.querySelector('.df_timeline_top .df_line_marker');
   const lineBottomMarker = parent.querySelector('.df_timeline_bottom .df_line_marker');
   const lineHalfWidth = parseInt(settings.line_width) / 2;
   const markerTxtAlign = "middle" === settings.layout_type_mobile ? "center" : settings.layout_type_mobile;

   setTimeout(() => {
      if (lineTopMarker) {
         const lineTopOffset = df_tmln_line.offsetLeft - lineTopMarker.offsetWidth / 2 + lineHalfWidth
         lineTopMarker.style.opacity = 1;
           lineTopMarker.style.left = lineTopOffset + "px";
       }

       if (lineBottomMarker) {
         const lineBottomOffset = df_tmln_line.offsetLeft - lineBottomMarker.offsetWidth / 2 + lineHalfWidth
         lineBottomMarker.style.opacity = 1
           lineBottomMarker.style.left = lineBottomOffset + "px";
       }

       if(mobileBreakpointMax.matches && 'text' === settings.line_top_marker_type){
         lineTopMarker.style.left = "auto"
         lineTopMarker.style.right = "auto"
         parent.querySelector('.df_timeline_top').style.textAlign = markerTxtAlign;
       }

       if(mobileBreakpointMax.matches && 'text' === settings.line_bottom_marker_type){
         lineBottomMarker.style.left = "auto"
         lineBottomMarker.style.right = "auto"
         parent.querySelector('.df_timeline_bottom').style.textAlign = markerTxtAlign;
       }

   }, 100)

   // marker position + line mobile
   if (mobileBreakpointMax.matches) {
      function df_tmln_mobile_max() {
         let isDisableDate = false
         let markerFromDate = "on" !== settings.marker_postion_mobile;
         if ("on" !== settings.disable_date) {
            if ("on" !== settings.disable_date_mobile) {
               isDisableDate = true
            }
         }

         if ("on" == settings.enable_arrow && "middle" !== settings.layout_type_mobile) {
            const blurbArrowSettings = {
               'vertical_align': settings.arrow_marker_vertical_align,
               'vertical_position': 0,
               'context': 'content'
            };

            setTimeout(() => {
               df_tmln_arrow_position(df_tmln_content, blurbArrowSettings);
            }, 100)
         }

         if ("on" == settings.enable_date_arrow && "middle" !== settings.layout_type_mobile) {
            const dateArrowSettings = {
               'vertical_align': settings.arrow_marker_vertical_align,
               'vertical_position': 0,
               'context': 'date'
            };

            setTimeout(() => {
               df_tmln_arrow_position(df_tmln_date_content, dateArrowSettings);
            }, 100)
         }

         const markerMargin = markerFromDate ? 'top' : 'marginTop';
         const itemVerticalAlign = settings.arrow_marker_vertical_align;
         for (let i = 0; i < df_tmln_markers.length; i++) {
            const blurbSpaceFromTop = parseInt(getComputedStyle(df_tmln_content[i]).marginTop, 10);
            const gapBetweenDateBlurb = 'middle' !== settings.layout_type_mobile && "on" !== settings.enable_date_in_blurb ? blurbSpaceFromTop : 0;
            const isDisableGap = isDisableDate ? gapBetweenDateBlurb : 0;
            const marker = df_tmln_markers[i];
            const markerOffsetHeight = marker.offsetHeight / 2;

            setTimeout(() => {
               let wrapperHeight;
               let markerOffset;
               if (markerFromDate && isDisableDate) {
                  if (marker.previousElementSibling || "on" !== settings.enable_date_in_blurb) {
                     wrapperHeight = marker.previousElementSibling.childNodes[1].offsetHeight;
                  } else {
                     wrapperHeight = marker.nextElementSibling.childNodes[1].offsetHeight;
                  }
               } else {
                  wrapperHeight = marker.nextElementSibling.childNodes[1].offsetHeight;
               }

               if (markerFromDate && isDisableDate) {
                  if ("top" === itemVerticalAlign) {
                     markerOffset = 0 + "px";
                  } else if ("middle" === itemVerticalAlign) {
                     markerOffset = (wrapperHeight / 2) - markerOffsetHeight + 'px';
                  } else {
                     markerOffset = wrapperHeight - marker.offsetHeight + 'px'
                  }
               } else {
                  markerOffset = isDisableGap + (wrapperHeight / 2) - markerOffsetHeight + 'px';

                  if ("top" === itemVerticalAlign) {
                     markerOffset = isDisableGap + "px";
                  } else if ("bottom" === itemVerticalAlign) {
                     markerOffset = isDisableGap + wrapperHeight - marker.offsetHeight + 'px';
                  }
               }

               if ('middle' !== settings.layout_type_mobile) {
                  if ("on" === settings.enable_date_in_blurb) {
                     marker.style[markerMargin] = parseInt(markerOffset) + gapBetweenDateBlurb + "px"
                  } else {
                     marker.style[markerMargin] = markerOffset
                  }
               }
            }, 100)
         };
         // });

         setTimeout(() => {
            if ("first_marker" == settings.line_start_from) {
               const markerFirstRect = df_tmln_markers[0].getBoundingClientRect();
               const lastContentRect = df_tmln_content[df_tmln_content.length - 1].getBoundingClientRect();
               const markerLastRect = df_tmln_markers[df_tmln_markers.length - 1].getBoundingClientRect();
               const lineBottom = "middle" === settings.layout_type_mobile ? lastContentRect.bottom : markerLastRect.bottom;
               const df_tmln_dot_inner_height = lineBottom - markerFirstRect.bottom;
               df_tmln_line.style.top = df_tmln_markers[0].offsetTop + markerFirstRect.height / 2 + 'px';

               if (df_tmln_markers.length > 1) {
                  df_tmln_line.style.height = df_tmln_dot_inner_height + 'px';
               } else {
                  df_tmln_line.style.height = 200 + 'px';
               }
            }
         }, 600);
      }

      df_tmln_mobile_max();
   }
   mobileBreakpointMax.addEventListener('change', df_tmln_mobile_max);
   window.addEventListener('resize', df_tmln_mobile_max);
}

(function ($) {
   $(document).ready(function () {
      [].forEach.call(difl_timeline, function (parent) {
         let parent_class = parent.classList.value.split(" ").filter(function (class_name) {
            return class_name.indexOf("difl_timeline_") !== -1;
         });
         const settings = JSON.parse(parent.querySelector('.df_timeline_container').dataset.settings);
         setTimeout(() => {
            LineScroll(parent_class, settings);
            if (mobileBreakpointMax.matches) {
               $('.' + parent_class[0]).find('.df_line_inner').first().css("opacity", 0);
            }
         }, mobileBreakpointMax.matches ? 2000 : 0)
      });
   })

   function LineScroll($parent_class, $settings) {
      const parent = $('.' + $parent_class[0]);
      const parentId = $parent_class[0];
      const item = parent.find(".df_timeline_item");
      const isMiddleMobile = "middle" === $settings.layout_type_mobile;
      const isFirstMarker = 'first_marker' === $settings.line_start_from;
      const isLineAnimation = "on" === $settings.enable_scroll_line;
      const isMarkerEffect = "on" === $settings.enable_marker_animation;
      const verticalAlign = $settings.item_vertical_alignment;
      const verticalGap = parseInt($settings.item_vertical_gap);
      const markerSpaceTop = parseInt($settings.line_top_marker_space);
      const markerSpaceBottom = parseInt($settings.line_bottom_marker_space);
      const line = parent.find('.df_timeline_line');
      const linePostionTop = Math.sign(markerSpaceTop) === -1 ? Math.abs(markerSpaceTop) : -markerSpaceTop;
      const innerLine = parent.find('.df_line_inner');
      const event = "scroll.timelineScroll" + parentId + " resize.timelineScroll" + parentId;
      const lineTopMarker = parent.find('.df_timeline_top .df_line_marker');
      const lineBottomMarker = parent.find('.df_timeline_bottom .df_line_marker');

      // set inner line top position
      if (innerLine.length > 0) {
         innerLine.first().css('top', linePostionTop)
      }

      // set marker top position
      const marker = item.find(".df_timeline_marker");
      setTimeout(() => {
         marker.each(function (i) {
            marker[i].setAttribute("offsetTop", marker[i].offsetTop)
            if (mobileBreakpointMax.matches) {
               const offsetWrapper = "on" === $settings.marker_postion_mobile && !!marker[i].previousElementSibling ?
                  marker[i].previousElementSibling.offsetHeight : 0;
               const markerOffset = marker[i].style.marginTop || marker[i].style.top || 0
               const markerHeight = marker[i].offsetHeight;
               marker[i].setAttribute("offsetTop", offsetWrapper + parseInt(markerOffset) + markerHeight)
            }
         })

         innerLine.first().css("opacity", 0);
      }, 300)

      // custom line limit
      let offsetHeightCustom = 0;
      if ('first_marker' !== $settings.line_start_from && !mobileBreakpointMax.matches) {
         let totalHeight = 0;
         let totalGap = 0;
         const lineHeight = line.height();
         for (let i = 0; i < item.length; i++) {
            const itemVerticalGap = getComputedStyle(item[i].closest(".difl_timelineitem")).marginTop
            totalHeight += item[i].offsetHeight;
            totalGap += parseInt(itemVerticalGap)
         }
         offsetHeightCustom = lineHeight - (totalHeight + totalGap)
      }

      function scroll_line_animation() {
         item.each(function (i) {
            const Itemheight = $(this).outerHeight(true);
            const itemOffsetTop = $(this).closest(".difl_timelineitem").css('margin-top');
            const isLastItem = i == item.length - 1;
            const itemLine = $(this).find(".df_line_inner");
            const itemLineFirst = item.first().find('.df_line_inner');
            const marker = $(this).find(".df_timeline_marker");
            const markerFirstTop = item.first().find(".df_timeline_marker").attr('offsetTop');
            const markerlastTop = item.last().find(".df_timeline_marker").attr('offsetTop');

            // set inner line height
            itemLine.css("opacity", 0);
            if (isFirstMarker && !mobileBreakpointMax.matches) {
               const secondItemSpace = item.eq(1).closest(".difl_timelineitem").css("margin-top");
               const isVerticalTop = "start" === verticalAlign ? parseInt(secondItemSpace) : 0;
               itemLineFirst.css("top", parseInt(markerFirstTop) + 5);
               itemLine.css("height", Itemheight + parseInt(itemOffsetTop));
               if (i == 0) {
                  itemLine.css("height", Itemheight + parseInt(itemOffsetTop) + isVerticalTop);
               }

               if (isLastItem) {
                  if ("start" === verticalAlign) {
                     itemLine.css("height", 0);
                  } else if ("center" === verticalAlign) {
                     itemLine.css("height", Itemheight / 2);
                  } else {
                     itemLine.css("height", Itemheight);
                  }
               }
            } else {
               itemLine.css("height", Itemheight)
               if (!isLastItem) {
                  itemLine.css("height", Itemheight + verticalGap);
               }
               if (isLastItem) {
                  itemLine.css("height", Itemheight + markerSpaceBottom);
               }
               if (i == 0) {
                  itemLine.css("height", Itemheight + Math.abs(linePostionTop) + verticalGap);
               }
            }

            if (isFirstMarker && mobileBreakpointMax.matches) {
               itemLineFirst.css("top", parseInt(markerFirstTop));
               item.last().find('.df_line_inner').css("height", parseInt(!isMiddleMobile ? markerlastTop : Itemheight));
            }

            const itemLineHeight = itemLine.outerHeight(true);
            const $itemLineOffsetTop = itemLine.offset().top;
            const windowMiddle = $(window).scrollTop() + $(window).height() / 2;
            const scrollLineInner = $(this).find(".df_line_inner");
            let scrollHeight = $(window).scrollTop() - scrollLineInner.offset().top + $(window).outerHeight() / 2;

            if ($itemLineOffsetTop < windowMiddle) {
               $(this).addClass("df_line_scroll");
            } else {
               $(this).removeClass("df_line_scroll");
            }

            // top/bottom marker
            if (lineTopMarker.length && isMarkerEffect) {
               if (lineTopMarker.offset().top < windowMiddle) {
                  lineTopMarker.addClass('active');
               } else {
                  if (lineTopMarker.hasClass('active')) {
                     lineTopMarker.removeClass('active');
                  }
               }
            }

            if (lineBottomMarker.length && isMarkerEffect) {
               if (lineBottomMarker.offset().top < windowMiddle) {
                  lineBottomMarker.addClass('active');
               } else {
                  if (lineBottomMarker.hasClass('active')) {
                     lineBottomMarker.removeClass('active');
                  }
               }
            }

            // inner marker
            if (isMarkerEffect) {
               if (marker.offset().top < windowMiddle) {
                  marker.addClass('active');
               } else {
                  if (marker.hasClass('active')) {
                     marker.removeClass('active');
                  }
               }
            }

            if ($itemLineOffsetTop < windowMiddle && item.hasClass("df_line_scroll") && isLineAnimation) {
               itemLine.css("opacity", 1);
               if (mobileBreakpointMax.matches && isMiddleMobile) {
                  item.last().find('.df_line_inner').css("opacity", 1);
               }
               if (itemLineHeight > scrollHeight) {
                  scrollLineInner.css({
                     height: scrollHeight + "px"
                  });
               } else {
                  scrollLineInner.css({
                     height: itemLineHeight + "px"
                  });
               }
            } else {
               scrollLineInner.css("height", "0px");
            }
         });
      }

      setTimeout(() => {
         if (isLineAnimation || isMarkerEffect) {
            scroll_line_animation();
            $(window).on(event, scroll_line_animation);
         } else {
            $(window).off(event);
         }
      }, 400)
   };


})(jQuery)

// line vertical position + height
function df_tmln_position(marker, line, settings) {
   if (marker.length > 0) {
      const first_marker_offset = marker[0].offsetTop;
      const first_marker_height = marker[0].getBoundingClientRect().height
      line.style.top = first_marker_offset + first_marker_height / 2 + 'px'; // position

      if (marker.length > 1) {
         const df_tmln_marker_last = marker[marker.length - 1];
         const df_tmln_dot_inner_height = df_tmln_marker_last.getBoundingClientRect().bottom - marker[0].getBoundingClientRect().bottom;
         line.style.height = df_tmln_dot_inner_height + 'px';
      } else {
         const itemWrapperHeight = marker[0].parentElement.offsetHeight;
         if ('start' === settings.item_vertical_alignment) {
            line.style.height = itemWrapperHeight - first_marker_height / 2 + 'px';
         } else if ('center' === settings.item_vertical_alignment) {
            line.style.height = itemWrapperHeight / 2 + 'px';
         } else {
            line.style.height = 0 + 'px';
         }

      }
   }
}

// arrow vertical position
function df_tmln_arrow_position(wrapper, settings) {
   if (wrapper.length > 0) {
      wrapper.forEach(element => {
         let arrow;
         if ('content' === settings.context) {
            if (element.nextElementSibling) {
               arrow = element.nextElementSibling.firstChild;
            }
         } else {
            arrow = element.querySelector(".timeline_arrow > *");
         }
         if (arrow === undefined) return
         const wrapperHeight = element.getBoundingClientRect().height;
         const wrapperBorderTop = parseInt(getComputedStyle(element).borderTopWidth, 10);
         const isIcon = arrow.classList.contains('timeline_arrow_icon');
         const isReverse = element.closest(".df_timeline_item").classList.contains("reverse");
         const arrow_height = arrow.getBoundingClientRect().height;
         const childSettings = JSON.parse(element.closest('.df_timeline_item').dataset.settings);
         const isCArrowPosition = !!childSettings.child_arrow_vertical_position;
         const isCDateArrowPosition = !!childSettings.child_date_arrow_vertical_position;

         const contentArrVertical = isCArrowPosition ? childSettings.child_arrow_vertical_position : 0;
         const dateArrVertical = isCDateArrowPosition ? childSettings.child_date_arrow_vertical_position : 0;
         const hasMargin = parseInt(getComputedStyle(element).marginTop);

         // custom vertical position
         let arrowOffset = "";
         let arrVerticalPos = null;
         if ('content' === settings.context) {
            if (isCArrowPosition) {
               arrVerticalPos = parseInt(contentArrVertical)
            } else {
               arrVerticalPos = parseInt(settings.vertical_position)
            }
         } else if ('date' === settings.context) {
            if (isCDateArrowPosition) {
               arrVerticalPos = parseInt(dateArrVertical)
            } else {
               arrVerticalPos = parseInt(settings.vertical_position)
            }
         }

         if (typeof arrVerticalPos != "undefined") {
            var arrowVerticalPosPercent = wrapperHeight * arrVerticalPos / 100;
            var arrowSzeOffsetPercent = arrow_height * arrVerticalPos / 100;
         }

         var customOffset = arrowVerticalPosPercent - arrowSzeOffsetPercent;
         let offsetBorderRadi = 0;
         const wrapperBorderRadi = get_border_radius(element)
         if ("top" == settings.vertical_align || 0 == arrVerticalPos) {
            offsetBorderRadi = isReverse ? wrapperBorderRadi[0].TopRight : wrapperBorderRadi[0].TopLeft;
         } else if ("bottom" == settings.vertical_align || 100 == arrVerticalPos) {
            offsetBorderRadi = isReverse ? wrapperBorderRadi[0].BottomRight : wrapperBorderRadi[0].BottomLeft;
         }

         const verticalTop = !isIcon ? offsetBorderRadi + hasMargin : - wrapperBorderTop / 2 + (offsetBorderRadi / 2) + hasMargin
         const verticalMid = ((wrapperHeight - arrow_height) / 2) + wrapperBorderTop / 2 + hasMargin;
         const verticalBot = wrapperHeight - arrow_height - offsetBorderRadi + hasMargin;

         switch (settings.vertical_align) {
            case "top":
               arrowOffset = verticalTop;
               break;
            case "middle":
               arrowOffset = verticalMid;
               break;
            case "bottom":
               arrowOffset = !isIcon ? verticalBot : verticalBot + wrapperBorderTop / 2;
               break;
            case "custom":
               if (typeof arrVerticalPos != "undefined") {
                  arrowOffset = customOffset
               }
               break;
         }

         arrow.style.top = `${arrowOffset}px`
         if ('content' === settings.context && isCArrowPosition) {
            arrow.style.top = `${customOffset}px`
         } else if ('date' === settings.context && isCDateArrowPosition) {
            arrow.style.top = `${customOffset}px`
         }

      });
   }
}

function get_border_radius(element) {
   const borderRadiusValues = [];
   const computedStyle = getComputedStyle(element);
   const TopLeft = parseInt(computedStyle.borderTopLeftRadius, 10) || 0;
   const TopRight = parseInt(computedStyle.borderTopRightRadius, 10) || 0;
   const BottomRight = parseInt(computedStyle.borderBottomRightRadius, 10) || 0;
   const BottomLeft = parseInt(computedStyle.borderBottomLeftRadius, 10) || 0;

   borderRadiusValues.push({
      TopLeft,
      TopRight,
      BottomRight,
      BottomLeft
   });

   return borderRadiusValues
}
