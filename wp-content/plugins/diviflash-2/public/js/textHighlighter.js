window.addEventListener('DOMContentLoaded', () => {
    (function ($) {
        const ElementObserver = (options, config) => {
            return new IntersectionObserver((entries, observer) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) return

                    const svg = entry.target
                    const svgID = svg.attributes.id.value
                    const container = svg.closest('.df-texthighlighter-container')
                    const data = JSON.parse(container.dataset.settings)

                    function animateSVG(iteration) {
                        const animation = new Vivus(svgID, config, () => {
                            const getIteration = 'on' !== data.loop ? data.iteration : Infinity

                            if (iteration < getIteration) {
                                setTimeout(function () {
                                    animateSVG(iteration + 1)
                                }, data.iterationGap)
                            }
                        })

                        animation.reset()
                    }

                    setTimeout(() => {
                        animateSVG(1);
                        if (container.classList.contains('active')) {
                            container.classList.remove('active')
                        }
                    }, data.delay)

                    observer.unobserve(svg)
                })
            }, options)
        }

        const diflTextHighlighter = document.querySelectorAll('.difl_text_highlighter');
        [].forEach.call(diflTextHighlighter, function (parent) {
            if (!parent) {
                return
            }
            const container = parent.querySelector('.df-texthighlighter-container');
            const data = JSON.parse(container.dataset.settings)
            const dataSvg = JSON.parse(container.dataset.svg)

            const uniqueID = parent.classList.value.split(' ').filter(function (class_name) {
                return -1 !== class_name.indexOf('difl_text_highlighter_')
            })

            // set svg ID
            const svg = parent.querySelector('svg');
            if (!svg) {
                return
            }
            const svgID = svg.attributes.id.value;
            svg.setAttribute('id', svgID + '_' + uniqueID[0]);

            // apply svg gradient color
            if ('on' === dataSvg.isGradient)
                setGradientColor(dataSvg, svg.attributes.id.value);

            // animation
            if ('off' === data.animation) {
                if (container.classList.contains('active'))
                    container.classList.remove('active')

                return;
            }

            const viewPortPosition = (($(window).height() - 40) / 100) * parseInt(data.viewportPosition)
            const options = {rootMargin: '0px 0px -' + viewPortPosition + 'px 0px'}
            const animationDuration = (data.duration / 1000) * 60;

            const config = {
                type: 'oneByOne',
                duration: animationDuration,
                animTimingFunction: Vivus[data.animTimingFunction],
            }

            // on page load
            if ('page_load' === data.animationStart) {

                config.start = 'autostart'

                function animateSVG(iteration) {
                    const animation = new Vivus(svg.attributes.id.value, config, () => {
                        const getIteration = 'on' !== data.loop ? data.iteration : Infinity

                        if (iteration < getIteration) {
                            setTimeout(function () {
                                animateSVG(iteration + 1)
                            }, data.iterationGap)
                        }
                    })

                    animation.reset()
                }

                setTimeout(() => {
                    animateSVG(1)
                    if (container.classList.contains('active')) {
                        container.classList.remove('active')
                    }
                }, data.delay)

                return
            }

            // viewport
            ElementObserver(options, config).observe(svg);
        }) // loop end

        function setGradientColor(data, id) {
            const svgDefs = document.createElementNS('http://www.w3.org/2000/svg', 'defs')
            const gradient = document.createElementNS('http://www.w3.org/2000/svg', data.gradientType)
            gradient.setAttribute('id', 'gradient_' + id);
            const gradientDirection = parseInt(data.gradientDirection)

            if ('radialGradient' === data.gradientType) {
                let coordinates = angleToRadialGradient(data.gradientDirectionRadial);

                gradient.setAttribute("cx", coordinates.cx);
                gradient.setAttribute("cy", coordinates.cy);
                gradient.setAttribute("r", coordinates.r);
                gradient.setAttribute("fx", coordinates.fx);
                gradient.setAttribute("fy", coordinates.fy);
            } else {
                let coordinates = angleToLinearGradientCoordinates(gradientDirection);

                gradient.setAttribute('x1', coordinates.x1);
                gradient.setAttribute('y1', coordinates.y1);
                gradient.setAttribute('x2', coordinates.x2);
                gradient.setAttribute('y2', coordinates.y2);
            }

            const stop1 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
            stop1.setAttribute('offset', data.startPosition);
            stop1.setAttribute('stop-color', data.colorStart);

            const stop2 = document.createElementNS('http://www.w3.org/2000/svg', 'stop');
            stop2.setAttribute('offset', data.endPosition);
            stop2.setAttribute('stop-color', data.colorEnd);

            gradient.appendChild(stop1);
            gradient.appendChild(stop2);
            svgDefs.appendChild(gradient);

            const svgContainer = document.getElementById(id)

            svgContainer.insertBefore(svgDefs, svgContainer.firstChild)
        }

        function angleToLinearGradientCoordinates(angleInDegrees) {
            // Convert degrees to radians
            var angleInRadians = angleInDegrees * Math.PI / 180;

            // Calculate coordinates for linear gradient in percentage
            var x1Percent = Math.round(50 + 50 * Math.cos(angleInRadians));
            var y1Percent = Math.round(50 + 50 * Math.sin(angleInRadians));
            var x2Percent = Math.round(50 - 50 * Math.cos(angleInRadians));
            var y2Percent = Math.round(50 - 50 * Math.sin(angleInRadians));

            return {x1: x1Percent + '%', y1: y1Percent + '%', x2: x2Percent + '%', y2: y2Percent + '%'};
        }

        function angleToRadialGradient(position = 'top') {

            const angleObj = {top: 0, bottom: 180, left: 270, right: 90}
            const angleInRadians = angleObj[position] * Math.PI / 180;
            let fxPercent = Math.round(Math.abs(Math.cos(angleInRadians) * 50));
            let fyPercent = Math.round(Math.abs(Math.sin(angleInRadians) * 50));

            if ('right' === position) {
                fxPercent = 100
            }
            if ('bottom' === position) {
                fyPercent = 100
            }

            const positionObj = {
                top: {
                    cx: '50%',
                    cy: '0%'
                },
                bottom: {
                    cx: '50%',
                    cy: '100%'
                },
                left: {
                    cx: '0%',
                    cy: '50%'
                },
                right: {
                    cx: '100%',
                    cy: '50%'
                },
                center: {
                    cx: '50%',
                    cy: '50%'
                },
            };

            const defaultRadialObj = {r: '70%', fx: fxPercent + '%', fy: fyPercent + '%'};

            const cordinate = {
                ...defaultRadialObj,
                ...positionObj[position]
            }

            return cordinate;
        }

    })(jQuery)
})
