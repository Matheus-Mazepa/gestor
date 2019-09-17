(function($, undefined) {

    $.widget('ui.rotatable', $.ui.mouse, {
        widgetEventPrefix: 'rotate',

        options: {
            handle: false,
            angle: false,
            wheelRotate: true,
            snap: false,
            step: 22.5,

            handleOffset: {
                top: 0,
                left: 0,
            },

            rotationCenterX: false,
            rotationCenterY: false,

            // callbacks
            start: null,
            rotate: null,
            stop: null,
        },

        rotationCenterX: function(x) {
            if (x === undefined) {
                return this.options.rotationCenterX;
            }
            this.options.rotationCenterX = x;
        },

        rotationCenterY: function(y) {
            if (y === undefined) {
                return this.options.rotationCenterY;
            }
            this.options.rotationCenterY = y;
        },

        handle: function(handle) {
            if (handle === undefined) {
                return this.options.handle;
            }
            this.options.handle = handle;
        },

        angle: function(angle) {
            if (angle === undefined) {
                return this.options.angle;
            }
            this.options.angle = angle;
            this.elementCurrentAngle = angle;
            this.performRotation(this.options.angle);
        },

        _create: function() {
            var handle;
            if (!this.options.handle) {
                handle = $(document.createElement('div'));
                handle.addClass('ui-rotatable-handle');
            }
            else {
                handle = this.options.handle;
            }

            this.listeners = {
                rotateElement: $.proxy(this.rotateElement, this),
                startRotate: $.proxy(this.startRotate, this),
                stopRotate: $.proxy(this.stopRotate, this),
                wheelRotate: $.proxy(this.wheelRotate, this),
            };

            if (this.options.wheelRotate) {
                this.element.bind('wheel', this.listeners.wheelRotate);
            }

            handle.draggable(
                {helper: 'clone', start: this.dragStart, handle: handle});
            handle.bind('mousedown', this.listeners.startRotate);

            if (!handle.closest(this.element).length) {
                handle.appendTo(this.element);
            }

            if (this.options.angle != false) {
                this.elementCurrentAngle = this.options.angle;
                this.performRotation(this.elementCurrentAngle);
            }
            else {
                this.elementCurrentAngle = 0;
            }
        },

        _destroy: function() {
            this.element.removeClass('ui-rotatable');
            this.element.find('.ui-rotatable-handle').remove();

            if (this.options.wheelRotate) {
                this.element.unbind('wheel', this.listeners.wheelRotate);
            }
        },

        performRotation: function(angle) {
            this.element.css('transform-origin', this.options.rotationCenterX + '% ' +
                this.options.rotationCenterY + '%');
            this.element.css('-ms-transform-origin', this.options.rotationCenterX +
                '% ' + this.options.rotationCenterY + '%');
            /* IE 9 */
            this.element.css(
                '-webkit-transform-origin',
                this.options.rotationCenterX + '% ' + this.options.rotationCenterY +
                '%');
            /* Chrome, Safari, Opera */

            this.element.css('transform', 'rotate(' + angle + 'rad)');
            this.element.css('-moz-transform', 'rotate(' + angle + 'rad)');
            this.element.css('-webkit-transform', 'rotate(' + angle + 'rad)');
            this.element.css('-o-transform', 'rotate(' + angle + 'rad)');
        },

        getElementOffset: function() {
            this.performRotation(0);
            var offset = this.element.offset();
            this.performRotation(this.elementCurrentAngle);
            return offset;
        },

        getElementCenter: function() {
            var elementOffset = this.getElementOffset();

            if (this.options.rotationCenterX === false) {
                var elementCentreX = elementOffset.left + this.element.width() / 2;
                var elementCentreY = elementOffset.top + this.element.height() / 2;
            }
            else {
                var elementCentreX = elementOffset.left + (this.element.width() / 100) *
                    this.options.rotationCenterX;
                var elementCentreY = elementOffset.top + (this.element.height() / 100) *
                    this.options.rotationCenterY;
            }

            return Array(elementCentreX, elementCentreY);
        },

        dragStart: function(event) {
            if (this.element) {
                return false;
            }
        },

        startRotate: function(event) {
            var center = this.getElementCenter();
            var startXFromCenter = event.pageX - this.options.handleOffset.left -
                center[0];
            var startYFromCenter = event.pageY - this.options.handleOffset.top -
                center[1];
            this.mouseStartAngle = Math.atan2(startYFromCenter, startXFromCenter);
            this.elementStartAngle = this.elementCurrentAngle;
            this.hasRotated = false;

            this._propagate('start', event);

            $(document).bind('mousemove', this.listeners.rotateElement);
            $(document).bind('mouseup', this.listeners.stopRotate);

            return false;
        },

        rotateElement: function(event) {
            if (!this.element || this.element.disabled) {
                return false;
            }

            if (!event.which) {
                this.stopRotate(event);
                return false;
            }

            var rotateAngle = this.getRotateAngle(event);
            var previousRotateAngle = this.elementCurrentAngle;
            this.elementCurrentAngle = rotateAngle;

            // Plugins callbacks need to be called first.
            this._propagate('rotate', event);

            if (this._propagate('rotate', event) === false) {
                this.elementCurrentAngle = previousRotateAngle;
                return false;
            }
            var ui = this.ui();
            if (this._trigger('rotate', event, ui) === false) {
                this.elementCurrentAngle = previousRotateAngle;
                return false;
            } else if (ui.angle.current != rotateAngle) {
                rotateAngle = ui.angle.current;
                this.elementCurrentAngle = rotateAngle;
            }

            this.performRotation(rotateAngle);

            if (previousRotateAngle != rotateAngle) {
                this.hasRotated = true;
            }

            return false;
        },

        stopRotate: function(event) {
            if (!this.element || this.element.disabled) {
                return;
            }

            $(document).unbind('mousemove', this.listeners.rotateElement);
            $(document).unbind('mouseup', this.listeners.stopRotate);

            this.elementStopAngle = this.elementCurrentAngle;

            this._propagate('stop', event);

            setTimeout(function() {
                this.element = false;
            }, 10);
            return false;
        },

        getRotateAngle: function(event) {
            var center = this.getElementCenter();

            var xFromCenter = event.pageX - this.options.handleOffset.left -
                center[0];
            var yFromCenter = event.pageY - this.options.handleOffset.top - center[1];
            var mouseAngle = Math.atan2(yFromCenter, xFromCenter);
            var rotateAngle = mouseAngle - this.mouseStartAngle +
                this.elementStartAngle;

            if (this.options.snap || event.shiftKey) {
                rotateAngle = this._calculateSnap(rotateAngle);
            }

            return rotateAngle;
        },

        wheelRotate: function(event) {
            var angle = Math.round(event.originalEvent.deltaY / 10) * Math.PI / 180;
            if (this.options.snap || event.shiftKey) {
                angle = this._calculateSnap(angle);
            }
            angle = this.elementCurrentAngle + angle;
            this.angle(angle);
            this._trigger('rotate', event, this.ui());
        },

        _calculateSnap: function(rotateAngle) {
            var rotateDegrees = ((rotateAngle / Math.PI) * 180);
            rotateDegrees = Math.round(rotateDegrees / this.options.step) *
                this.options.step;
            return (rotateDegrees * Math.PI) / 180;
        },

        _propagate: function(n, event) {
            $.ui.plugin.call(this, n, [event, this.ui()]);
            (n !== 'rotate' && this._trigger(n, event, this.ui()));
        },

        plugins: {},

        ui: function() {
            return {
                api: this,
                element: this.element,
                angle: {
                    start: this.elementStartAngle,
                    current: this.elementCurrentAngle,
                    stop: this.elementStopAngle,
                },
            };
        },

    });

})(jQuery);

/**
 * jscolor - JavaScript Color Picker
 *
 * @link    http://jscolor.com
 * @license For open source use: GPLv3
 *          For commercial use: JSColor Commercial License
 * @author  Jan Odvarko
 * @version 2.0.4
 *
 * See usage examples at http://jscolor.com/examples/
 */


'use strict';

if (!window.jscolor) {
    window.jscolor = (function() {

        var jsc = {

            register: function() {
                jsc.attachDOMReadyEvent(jsc.init);
                jsc.attachEvent(document, 'mousedown', jsc.onDocumentMouseDown);
                jsc.attachEvent(document, 'touchstart', jsc.onDocumentTouchStart);
                jsc.attachEvent(window, 'resize', jsc.onWindowResize);
            },

            init: function() {
                if (jsc.jscolor.lookupClass) {
                    jsc.jscolor.installByClassName(jsc.jscolor.lookupClass);
                }
            },

            tryInstallOnElements: function(elms, className) {
                var matchClass = new RegExp('(^|\\s)(' + className +
                    ')(\\s*(\\{[^}]*\\})|\\s|$)', 'i');

                for (var i = 0; i < elms.length; i += 1) {
                    if (elms[i].type !== undefined && elms[i].type.toLowerCase() ==
                        'color') {
                        if (jsc.isColorAttrSupported) {
                            // skip inputs of type 'color' if supported by the browser
                            continue;
                        }
                    }
                    var m;
                    if (!elms[i].jscolor && elms[i].className &&
                        (m = elms[i].className.match(matchClass))) {
                        var targetElm = elms[i];
                        var optsStr = null;

                        var dataOptions = jsc.getDataAttr(targetElm, 'jscolor');
                        if (dataOptions !== null) {
                            optsStr = dataOptions;
                        } else if (m[4]) {
                            optsStr = m[4];
                        }

                        var opts = {};
                        if (optsStr) {
                            try {
                                opts = (new Function('return (' + optsStr + ')'))();
                            } catch (eParseError) {
                                jsc.warn('Error parsing jscolor options: ' + eParseError +
                                    ':\n' + optsStr);
                            }
                        }
                        targetElm.jscolor = new jsc.jscolor(targetElm, opts);
                    }
                }
            },

            isColorAttrSupported: (function() {
                var elm = document.createElement('input');
                if (elm.setAttribute) {
                    elm.setAttribute('type', 'color');
                    if (elm.type.toLowerCase() == 'color') {
                        return true;
                    }
                }
                return false;
            })(),

            isCanvasSupported: (function() {
                var elm = document.createElement('canvas');
                return !!(elm.getContext && elm.getContext('2d'));
            })(),

            fetchElement: function(mixed) {
                return typeof mixed === 'string' ?
                    document.getElementById(mixed) :
                    mixed;
            },

            isElementType: function(elm, type) {
                return elm.nodeName.toLowerCase() === type.toLowerCase();
            },

            getDataAttr: function(el, name) {
                var attrName = 'data-' + name;
                var attrValue = el.getAttribute(attrName);
                if (attrValue !== null) {
                    return attrValue;
                }
                return null;
            },

            attachEvent: function(el, evnt, func) {
                if (el.addEventListener) {
                    el.addEventListener(evnt, func, false);
                } else if (el.attachEvent) {
                    el.attachEvent('on' + evnt, func);
                }
            },

            detachEvent: function(el, evnt, func) {
                if (el.removeEventListener) {
                    el.removeEventListener(evnt, func, false);
                } else if (el.detachEvent) {
                    el.detachEvent('on' + evnt, func);
                }
            },

            _attachedGroupEvents: {},

            attachGroupEvent: function(groupName, el, evnt, func) {
                if (!jsc._attachedGroupEvents.hasOwnProperty(groupName)) {
                    jsc._attachedGroupEvents[groupName] = [];
                }
                jsc._attachedGroupEvents[groupName].push([el, evnt, func]);
                jsc.attachEvent(el, evnt, func);
            },

            detachGroupEvents: function(groupName) {
                if (jsc._attachedGroupEvents.hasOwnProperty(groupName)) {
                    for (var i = 0; i <
                    jsc._attachedGroupEvents[groupName].length; i += 1) {
                        var evt = jsc._attachedGroupEvents[groupName][i];
                        jsc.detachEvent(evt[0], evt[1], evt[2]);
                    }
                    delete jsc._attachedGroupEvents[groupName];
                }
            },

            attachDOMReadyEvent: function(func) {
                var fired = false;
                var fireOnce = function() {
                    if (!fired) {
                        fired = true;
                        func();
                    }
                };

                if (document.readyState === 'complete') {
                    setTimeout(fireOnce, 1); // async
                    return;
                }

                if (document.addEventListener) {
                    document.addEventListener('DOMContentLoaded', fireOnce, false);

                    // Fallback
                    window.addEventListener('load', fireOnce, false);

                } else if (document.attachEvent) {
                    // IE
                    document.attachEvent('onreadystatechange', function() {
                        if (document.readyState === 'complete') {
                            document.detachEvent('onreadystatechange', arguments.callee);
                            fireOnce();
                        }
                    });

                    // Fallback
                    window.attachEvent('onload', fireOnce);

                    // IE7/8
                    if (document.documentElement.doScroll && window == window.top) {
                        var tryScroll = function() {
                            if (!document.body) {
                                return;
                            }
                            try {
                                document.documentElement.doScroll('left');
                                fireOnce();
                            } catch (e) {
                                setTimeout(tryScroll, 1);
                            }
                        };
                        tryScroll();
                    }
                }
            },

            warn: function(msg) {
                if (window.console && window.console.warn) {
                    window.console.warn(msg);
                }
            },

            preventDefault: function(e) {
                if (e.preventDefault) {
                    e.preventDefault();
                }
                e.returnValue = false;
            },

            captureTarget: function(target) {
                // IE
                if (target.setCapture) {
                    jsc._capturedTarget = target;
                    jsc._capturedTarget.setCapture();
                }
            },

            releaseTarget: function() {
                // IE
                if (jsc._capturedTarget) {
                    jsc._capturedTarget.releaseCapture();
                    jsc._capturedTarget = null;
                }
            },

            fireEvent: function(el, evnt) {
                if (!el) {
                    return;
                }
                if (document.createEvent) {
                    var ev = document.createEvent('HTMLEvents');
                    ev.initEvent(evnt, true, true);
                    el.dispatchEvent(ev);
                } else if (document.createEventObject) {
                    var ev = document.createEventObject();
                    el.fireEvent('on' + evnt, ev);
                } else if (el['on' + evnt]) { // alternatively use the traditional event model
                    el['on' + evnt]();
                }
            },

            classNameToList: function(className) {
                return className.replace(/^\s+|\s+$/g, '').split(/\s+/);
            },

            // The className parameter (str) can only contain a single class name
            hasClass: function(elm, className) {
                if (!className) {
                    return false;
                }
                return -1 !=
                    (' ' + elm.className.replace(/\s+/g, ' ') + ' ').indexOf(' ' +
                        className + ' ');
            },

            // The className parameter (str) can contain multiple class names separated by whitespace
            setClass: function(elm, className) {
                var classList = jsc.classNameToList(className);
                for (var i = 0; i < classList.length; i += 1) {
                    if (!jsc.hasClass(elm, classList[i])) {
                        elm.className += (elm.className ? ' ' : '') + classList[i];
                    }
                }
            },

            // The className parameter (str) can contain multiple class names separated by whitespace
            unsetClass: function(elm, className) {
                var classList = jsc.classNameToList(className);
                for (var i = 0; i < classList.length; i += 1) {
                    var repl = new RegExp(
                        '^\\s*' + classList[i] + '\\s*|' +
                        '\\s*' + classList[i] + '\\s*$|' +
                        '\\s+' + classList[i] + '(\\s+)',
                        'g',
                    );
                    elm.className = elm.className.replace(repl, '$1');
                }
            },

            getStyle: function(elm) {
                return window.getComputedStyle ?
                    window.getComputedStyle(elm) :
                    elm.currentStyle;
            },

            setStyle: (function() {
                var helper = document.createElement('div');
                var getSupportedProp = function(names) {
                    for (var i = 0; i < names.length; i += 1) {
                        if (names[i] in helper.style) {
                            return names[i];
                        }
                    }
                };
                var props = {
                    borderRadius: getSupportedProp(
                        ['borderRadius', 'MozBorderRadius', 'webkitBorderRadius']),
                    boxShadow: getSupportedProp(
                        ['boxShadow', 'MozBoxShadow', 'webkitBoxShadow']),
                };
                return function(elm, prop, value) {
                    switch (prop.toLowerCase()) {
                        case 'opacity':
                            var alphaOpacity = Math.round(parseFloat(value) * 100);
                            elm.style.opacity = value;
                            elm.style.filter = 'alpha(opacity=' + alphaOpacity + ')';
                            break;
                        default:
                            elm.style[props[prop]] = value;
                            break;
                    }
                };
            })(),

            setBorderRadius: function(elm, value) {
                jsc.setStyle(elm, 'borderRadius', value || '0');
            },

            setBoxShadow: function(elm, value) {
                jsc.setStyle(elm, 'boxShadow', value || 'none');
            },

            getElementPos: function(e, relativeToViewport) {
                var x = 0, y = 0;
                var rect = e.getBoundingClientRect();
                x = rect.left;
                y = rect.top;
                if (!relativeToViewport) {
                    var viewPos = jsc.getViewPos();
                    x += viewPos[0];
                    y += viewPos[1];
                }
                return [x, y];
            },

            getElementSize: function(e) {
                return [e.offsetWidth, e.offsetHeight];
            },

            // get pointer's X/Y coordinates relative to viewport
            getAbsPointerPos: function(e) {
                if (!e) {
                    e = window.event;
                }
                var x = 0, y = 0;
                if (typeof e.changedTouches !== 'undefined' &&
                    e.changedTouches.length) {
                    // touch devices
                    x = e.changedTouches[0].clientX;
                    y = e.changedTouches[0].clientY;
                } else if (typeof e.clientX === 'number') {
                    x = e.clientX;
                    y = e.clientY;
                }
                return {x: x, y: y};
            },

            // get pointer's X/Y coordinates relative to target element
            getRelPointerPos: function(e) {
                if (!e) {
                    e = window.event;
                }
                var target = e.target || e.srcElement;
                var targetRect = target.getBoundingClientRect();

                var x = 0, y = 0;

                var clientX = 0, clientY = 0;
                if (typeof e.changedTouches !== 'undefined' &&
                    e.changedTouches.length) {
                    // touch devices
                    clientX = e.changedTouches[0].clientX;
                    clientY = e.changedTouches[0].clientY;
                } else if (typeof e.clientX === 'number') {
                    clientX = e.clientX;
                    clientY = e.clientY;
                }

                x = clientX - targetRect.left;
                y = clientY - targetRect.top;
                return {x: x, y: y};
            },

            getViewPos: function() {
                var doc = document.documentElement;
                return [
                    (window.pageXOffset || doc.scrollLeft) - (doc.clientLeft || 0),
                    (window.pageYOffset || doc.scrollTop) - (doc.clientTop || 0),
                ];
            },

            getViewSize: function() {
                var doc = document.documentElement;
                return [
                    (window.innerWidth || doc.clientWidth),
                    (window.innerHeight || doc.clientHeight),
                ];
            },

            redrawPosition: function() {

                if (jsc.picker && jsc.picker.owner) {
                    var thisObj = jsc.picker.owner;

                    var tp, vp;

                    if (thisObj.fixed) {
                        // Fixed elements are positioned relative to viewport,
                        // therefore we can ignore the scroll offset
                        tp = jsc.getElementPos(thisObj.targetElement, true); // target pos
                        vp = [0, 0]; // view pos
                    } else {
                        tp = jsc.getElementPos(thisObj.targetElement); // target pos
                        vp = jsc.getViewPos(); // view pos
                    }

                    var ts = jsc.getElementSize(thisObj.targetElement); // target size
                    var vs = jsc.getViewSize(); // view size
                    var ps = jsc.getPickerOuterDims(thisObj); // picker size
                    var a, b, c;
                    switch (thisObj.position.toLowerCase()) {
                        case 'left':
                            a = 1;
                            b = 0;
                            c = -1;
                            break;
                        case 'right':
                            a = 1;
                            b = 0;
                            c = 1;
                            break;
                        case 'top':
                            a = 0;
                            b = 1;
                            c = -1;
                            break;
                        default:
                            a = 0;
                            b = 1;
                            c = 1;
                            break;
                    }
                    var l = (ts[b] + ps[b]) / 2;

                    // compute picker position
                    if (!thisObj.smartPosition) {
                        var pp = [
                            tp[a],
                            tp[b] + ts[b] - l + l * c,
                        ];
                    } else {
                        var pp = [
                            -vp[a] + tp[a] + ps[a] > vs[a] ?
                                (-vp[a] + tp[a] + ts[a] / 2 > vs[a] / 2 &&
                                tp[a] + ts[a] - ps[a] >= 0 ? tp[a] + ts[a] - ps[a] : tp[a]) :
                                tp[a],
                            -vp[b] + tp[b] + ts[b] + ps[b] - l + l * c > vs[b] ?
                                (-vp[b] + tp[b] + ts[b] / 2 > vs[b] / 2 &&
                                tp[b] + ts[b] - l - l * c >= 0 ?
                                    tp[b] + ts[b] - l - l * c :
                                    tp[b] + ts[b] - l + l * c) :
                                (tp[b] + ts[b] - l + l * c >= 0 ?
                                    tp[b] + ts[b] - l + l * c :
                                    tp[b] + ts[b] - l - l * c),
                        ];
                    }

                    var x = pp[a];
                    var y = pp[b];
                    var positionValue = thisObj.fixed ? 'fixed' : 'absolute';
                    var contractShadow =
                        (pp[0] + ps[0] > tp[0] || pp[0] < tp[0] + ts[0]) &&
                        (pp[1] + ps[1] < tp[1] + ts[1]);

                    jsc._drawPosition(thisObj, x, y, positionValue, contractShadow);
                }
            },

            _drawPosition: function(thisObj, x, y, positionValue, contractShadow) {
                var vShadow = contractShadow ? 0 : thisObj.shadowBlur; // px

                jsc.picker.wrap.style.position = positionValue;
                jsc.picker.wrap.style.left = x + 'px';
                jsc.picker.wrap.style.top = y + 'px';

                jsc.setBoxShadow(
                    jsc.picker.boxS,
                    thisObj.shadow ?
                        new jsc.BoxShadow(0, vShadow, thisObj.shadowBlur, 0,
                            thisObj.shadowColor) :
                        null);
            },

            getPickerDims: function(thisObj) {
                var displaySlider = !!jsc.getSliderComponent(thisObj);
                var dims = [
                    2 * thisObj.insetWidth + 2 * thisObj.padding + thisObj.width +
                    (displaySlider ?
                        2 * thisObj.insetWidth + jsc.getPadToSliderPadding(thisObj) +
                        thisObj.sliderSize :
                        0),
                    2 * thisObj.insetWidth + 2 * thisObj.padding + thisObj.height +
                    (thisObj.closable ?
                        2 * thisObj.insetWidth + thisObj.padding + thisObj.buttonHeight :
                        0),
                ];
                return dims;
            },

            getPickerOuterDims: function(thisObj) {
                var dims = jsc.getPickerDims(thisObj);
                return [
                    dims[0] + 2 * thisObj.borderWidth,
                    dims[1] + 2 * thisObj.borderWidth,
                ];
            },

            getPadToSliderPadding: function(thisObj) {
                return Math.max(thisObj.padding, 1.5 *
                    (2 * thisObj.pointerBorderWidth + thisObj.pointerThickness));
            },

            getPadYComponent: function(thisObj) {
                switch (thisObj.mode.charAt(1).toLowerCase()) {
                    case 'v':
                        return 'v';
                        break;
                }
                return 's';
            },

            getSliderComponent: function(thisObj) {
                if (thisObj.mode.length > 2) {
                    switch (thisObj.mode.charAt(2).toLowerCase()) {
                        case 's':
                            return 's';
                            break;
                        case 'v':
                            return 'v';
                            break;
                    }
                }
                return null;
            },

            onDocumentMouseDown: function(e) {
                if (!e) {
                    e = window.event;
                }
                var target = e.target || e.srcElement;

                if (target._jscLinkedInstance) {
                    if (target._jscLinkedInstance.showOnClick) {
                        target._jscLinkedInstance.show();
                    }
                } else if (target._jscControlName) {
                    jsc.onControlPointerStart(e, target, target._jscControlName, 'mouse');
                } else {
                    // Mouse is outside the picker controls -> hide the color picker!
                    if (jsc.picker && jsc.picker.owner) {
                        jsc.picker.owner.hide();
                    }
                }
            },

            onDocumentTouchStart: function(e) {
                if (!e) {
                    e = window.event;
                }
                var target = e.target || e.srcElement;

                if (target._jscLinkedInstance) {
                    if (target._jscLinkedInstance.showOnClick) {
                        target._jscLinkedInstance.show();
                    }
                } else if (target._jscControlName) {
                    jsc.onControlPointerStart(e, target, target._jscControlName, 'touch');
                } else {
                    if (jsc.picker && jsc.picker.owner) {
                        jsc.picker.owner.hide();
                    }
                }
            },

            onWindowResize: function(e) {
                jsc.redrawPosition();
            },

            onParentScroll: function(e) {
                // hide the picker when one of the parent elements is scrolled
                if (jsc.picker && jsc.picker.owner) {
                    jsc.picker.owner.hide();
                }
            },

            _pointerMoveEvent: {
                mouse: 'mousemove',
                touch: 'touchmove',
            },
            _pointerEndEvent: {
                mouse: 'mouseup',
                touch: 'touchend',
            },

            _pointerOrigin: null,
            _capturedTarget: null,

            onControlPointerStart: function(e, target, controlName, pointerType) {
                var thisObj = target._jscInstance;

                jsc.preventDefault(e);
                jsc.captureTarget(target);

                var registerDragEvents = function(doc, offset) {
                    jsc.attachGroupEvent('drag', doc, jsc._pointerMoveEvent[pointerType],
                        jsc.onDocumentPointerMove(e, target, controlName, pointerType,
                            offset));
                    jsc.attachGroupEvent('drag', doc, jsc._pointerEndEvent[pointerType],
                        jsc.onDocumentPointerEnd(e, target, controlName, pointerType));
                };

                registerDragEvents(document, [0, 0]);

                if (window.parent && window.frameElement) {
                    var rect = window.frameElement.getBoundingClientRect();
                    var ofs = [-rect.left, -rect.top];
                    registerDragEvents(window.parent.window.document, ofs);
                }

                var abs = jsc.getAbsPointerPos(e);
                var rel = jsc.getRelPointerPos(e);
                jsc._pointerOrigin = {
                    x: abs.x - rel.x,
                    y: abs.y - rel.y,
                };

                switch (controlName) {
                    case 'pad':
                        // if the slider is at the bottom, move it up
                        switch (jsc.getSliderComponent(thisObj)) {
                            case 's':
                                if (thisObj.hsv[1] === 0) {
                                    thisObj.fromHSV(null, 100, null);
                                }

                                break;
                            case 'v':
                                if (thisObj.hsv[2] === 0) {
                                    thisObj.fromHSV(null, null, 100);
                                }

                                break;
                        }
                        jsc.setPad(thisObj, e, 0, 0);
                        break;

                    case 'sld':
                        jsc.setSld(thisObj, e, 0);
                        break;
                }

                jsc.dispatchFineChange(thisObj);
            },

            onDocumentPointerMove: function(
                e, target, controlName, pointerType, offset) {
                return function(e) {
                    var thisObj = target._jscInstance;
                    switch (controlName) {
                        case 'pad':
                            if (!e) {
                                e = window.event;
                            }
                            jsc.setPad(thisObj, e, offset[0], offset[1]);
                            jsc.dispatchFineChange(thisObj);
                            break;

                        case 'sld':
                            if (!e) {
                                e = window.event;
                            }
                            jsc.setSld(thisObj, e, offset[1]);
                            jsc.dispatchFineChange(thisObj);
                            break;
                    }
                };
            },

            onDocumentPointerEnd: function(e, target, controlName, pointerType) {
                return function(e) {
                    var thisObj = target._jscInstance;
                    jsc.detachGroupEvents('drag');
                    jsc.releaseTarget();
                    // Always dispatch changes after detaching outstanding mouse handlers,
                    // in case some user interaction will occur in user's onchange callback
                    // that would intrude with current mouse events
                    jsc.dispatchChange(thisObj);
                };
            },

            dispatchChange: function(thisObj) {
                if (thisObj.valueElement) {
                    if (jsc.isElementType(thisObj.valueElement, 'input')) {
                        jsc.fireEvent(thisObj.valueElement, 'change');
                    }
                }
            },

            dispatchFineChange: function(thisObj) {
                if (thisObj.onFineChange) {
                    var callback;
                    if (typeof thisObj.onFineChange === 'string') {
                        callback = new Function(thisObj.onFineChange);
                    } else {
                        callback = thisObj.onFineChange;
                    }
                    callback.call(thisObj);
                }
            },

            setPad: function(thisObj, e, ofsX, ofsY) {
                var pointerAbs = jsc.getAbsPointerPos(e);
                var x = ofsX + pointerAbs.x - jsc._pointerOrigin.x - thisObj.padding -
                    thisObj.insetWidth;
                var y = ofsY + pointerAbs.y - jsc._pointerOrigin.y - thisObj.padding -
                    thisObj.insetWidth;

                var xVal = x * (360 / (thisObj.width - 1));
                var yVal = 100 - (y * (100 / (thisObj.height - 1)));

                switch (jsc.getPadYComponent(thisObj)) {
                    case 's':
                        thisObj.fromHSV(xVal, yVal, null, jsc.leaveSld);
                        break;
                    case 'v':
                        thisObj.fromHSV(xVal, null, yVal, jsc.leaveSld);
                        break;
                }
            },

            setSld: function(thisObj, e, ofsY) {
                var pointerAbs = jsc.getAbsPointerPos(e);
                var y = ofsY + pointerAbs.y - jsc._pointerOrigin.y - thisObj.padding -
                    thisObj.insetWidth;

                var yVal = 100 - (y * (100 / (thisObj.height - 1)));

                switch (jsc.getSliderComponent(thisObj)) {
                    case 's':
                        thisObj.fromHSV(null, yVal, null, jsc.leavePad);
                        break;
                    case 'v':
                        thisObj.fromHSV(null, null, yVal, jsc.leavePad);
                        break;
                }
            },

            _vmlNS: 'jsc_vml_',
            _vmlCSS: 'jsc_vml_css_',
            _vmlReady: false,

            initVML: function() {
                if (!jsc._vmlReady) {
                    // init VML namespace
                    var doc = document;
                    if (!doc.namespaces[jsc._vmlNS]) {
                        doc.namespaces.add(jsc._vmlNS, 'urn:schemas-microsoft-com:vml');
                    }
                    if (!doc.styleSheets[jsc._vmlCSS]) {
                        var tags = [
                            'shape',
                            'shapetype',
                            'group',
                            'background',
                            'path',
                            'formulas',
                            'handles',
                            'fill',
                            'stroke',
                            'shadow',
                            'textbox',
                            'textpath',
                            'imagedata',
                            'line',
                            'polyline',
                            'curve',
                            'rect',
                            'roundrect',
                            'oval',
                            'arc',
                            'image'];
                        var ss = doc.createStyleSheet();
                        ss.owningElement.id = jsc._vmlCSS;
                        for (var i = 0; i < tags.length; i += 1) {
                            ss.addRule(jsc._vmlNS + '\\:' + tags[i],
                                'behavior:url(#default#VML);');
                        }
                    }
                    jsc._vmlReady = true;
                }
            },

            createPalette: function() {

                var paletteObj = {
                    elm: null,
                    draw: null,
                };

                if (jsc.isCanvasSupported) {
                    // Canvas implementation for modern browsers

                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');

                    var drawFunc = function(width, height, type) {
                        canvas.width = width;
                        canvas.height = height;

                        ctx.clearRect(0, 0, canvas.width, canvas.height);

                        var hGrad = ctx.createLinearGradient(0, 0, canvas.width, 0);
                        hGrad.addColorStop(0 / 6, '#F00');
                        hGrad.addColorStop(1 / 6, '#FF0');
                        hGrad.addColorStop(2 / 6, '#0F0');
                        hGrad.addColorStop(3 / 6, '#0FF');
                        hGrad.addColorStop(4 / 6, '#00F');
                        hGrad.addColorStop(5 / 6, '#F0F');
                        hGrad.addColorStop(6 / 6, '#F00');

                        ctx.fillStyle = hGrad;
                        ctx.fillRect(0, 0, canvas.width, canvas.height);

                        var vGrad = ctx.createLinearGradient(0, 0, 0, canvas.height);
                        switch (type.toLowerCase()) {
                            case 's':
                                vGrad.addColorStop(0, 'rgba(255,255,255,0)');
                                vGrad.addColorStop(1, 'rgba(255,255,255,1)');
                                break;
                            case 'v':
                                vGrad.addColorStop(0, 'rgba(0,0,0,0)');
                                vGrad.addColorStop(1, 'rgba(0,0,0,1)');
                                break;
                        }
                        ctx.fillStyle = vGrad;
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                    };

                    paletteObj.elm = canvas;
                    paletteObj.draw = drawFunc;

                } else {
                    // VML fallback for IE 7 and 8

                    jsc.initVML();

                    var vmlContainer = document.createElement('div');
                    vmlContainer.style.position = 'relative';
                    vmlContainer.style.overflow = 'hidden';

                    var hGrad = document.createElement(jsc._vmlNS + ':fill');
                    hGrad.type = 'gradient';
                    hGrad.method = 'linear';
                    hGrad.angle = '90';
                    hGrad.colors = '16.67% #F0F, 33.33% #00F, 50% #0FF, 66.67% #0F0, 83.33% #FF0';

                    var hRect = document.createElement(jsc._vmlNS + ':rect');
                    hRect.style.position = 'absolute';
                    hRect.style.left = -1 + 'px';
                    hRect.style.top = -1 + 'px';
                    hRect.stroked = false;
                    hRect.appendChild(hGrad);
                    vmlContainer.appendChild(hRect);

                    var vGrad = document.createElement(jsc._vmlNS + ':fill');
                    vGrad.type = 'gradient';
                    vGrad.method = 'linear';
                    vGrad.angle = '180';
                    vGrad.opacity = '0';

                    var vRect = document.createElement(jsc._vmlNS + ':rect');
                    vRect.style.position = 'absolute';
                    vRect.style.left = -1 + 'px';
                    vRect.style.top = -1 + 'px';
                    vRect.stroked = false;
                    vRect.appendChild(vGrad);
                    vmlContainer.appendChild(vRect);

                    var drawFunc = function(width, height, type) {
                        vmlContainer.style.width = width + 'px';
                        vmlContainer.style.height = height + 'px';

                        hRect.style.width =
                            vRect.style.width =
                                (width + 1) + 'px';
                        hRect.style.height =
                            vRect.style.height =
                                (height + 1) + 'px';

                        // Colors must be specified during every redraw, otherwise IE won't display
                        // a full gradient during a subsequential redraw
                        hGrad.color = '#F00';
                        hGrad.color2 = '#F00';

                        switch (type.toLowerCase()) {
                            case 's':
                                vGrad.color = vGrad.color2 = '#FFF';
                                break;
                            case 'v':
                                vGrad.color = vGrad.color2 = '#000';
                                break;
                        }
                    };

                    paletteObj.elm = vmlContainer;
                    paletteObj.draw = drawFunc;
                }

                return paletteObj;
            },

            createSliderGradient: function() {

                var sliderObj = {
                    elm: null,
                    draw: null,
                };

                if (jsc.isCanvasSupported) {
                    // Canvas implementation for modern browsers

                    var canvas = document.createElement('canvas');
                    var ctx = canvas.getContext('2d');

                    var drawFunc = function(width, height, color1, color2) {
                        canvas.width = width;
                        canvas.height = height;

                        ctx.clearRect(0, 0, canvas.width, canvas.height);

                        var grad = ctx.createLinearGradient(0, 0, 0, canvas.height);
                        grad.addColorStop(0, color1);
                        grad.addColorStop(1, color2);

                        ctx.fillStyle = grad;
                        ctx.fillRect(0, 0, canvas.width, canvas.height);
                    };

                    sliderObj.elm = canvas;
                    sliderObj.draw = drawFunc;

                } else {
                    // VML fallback for IE 7 and 8

                    jsc.initVML();

                    var vmlContainer = document.createElement('div');
                    vmlContainer.style.position = 'relative';
                    vmlContainer.style.overflow = 'hidden';

                    var grad = document.createElement(jsc._vmlNS + ':fill');
                    grad.type = 'gradient';
                    grad.method = 'linear';
                    grad.angle = '180';

                    var rect = document.createElement(jsc._vmlNS + ':rect');
                    rect.style.position = 'absolute';
                    rect.style.left = -1 + 'px';
                    rect.style.top = -1 + 'px';
                    rect.stroked = false;
                    rect.appendChild(grad);
                    vmlContainer.appendChild(rect);

                    var drawFunc = function(width, height, color1, color2) {
                        vmlContainer.style.width = width + 'px';
                        vmlContainer.style.height = height + 'px';

                        rect.style.width = (width + 1) + 'px';
                        rect.style.height = (height + 1) + 'px';

                        grad.color = color1;
                        grad.color2 = color2;
                    };

                    sliderObj.elm = vmlContainer;
                    sliderObj.draw = drawFunc;
                }

                return sliderObj;
            },

            leaveValue: 1 << 0,
            leaveStyle: 1 << 1,
            leavePad: 1 << 2,
            leaveSld: 1 << 3,

            BoxShadow: (function() {
                var BoxShadow = function(hShadow, vShadow, blur, spread, color, inset) {
                    this.hShadow = hShadow;
                    this.vShadow = vShadow;
                    this.blur = blur;
                    this.spread = spread;
                    this.color = color;
                    this.inset = !!inset;
                };

                BoxShadow.prototype.toString = function() {
                    var vals = [
                        Math.round(this.hShadow) + 'px',
                        Math.round(this.vShadow) + 'px',
                        Math.round(this.blur) + 'px',
                        Math.round(this.spread) + 'px',
                        this.color,
                    ];
                    if (this.inset) {
                        vals.push('inset');
                    }
                    return vals.join(' ');
                };

                return BoxShadow;
            })(),

            //
            // Usage:
            // var myColor = new jscolor(<targetElement> [, <options>])
            //

            jscolor: function(targetElement, options) {

                // General options
                //
                this.value = null; // initial HEX color. To change it later, use methods fromString(), fromHSV() and fromRGB()
                this.valueElement = targetElement; // element that will be used to display and input the color code
                this.styleElement = targetElement; // element that will preview the picked color using CSS backgroundColor
                this.required = true; // whether the associated text <input> can be left empty
                this.refine = true; // whether to refine the entered color code (e.g. uppercase it and remove whitespace)
                this.hash = false; // whether to prefix the HEX color code with # symbol
                this.uppercase = true; // whether to uppercase the color code
                this.onFineChange = null; // called instantly every time the color changes (value can be either a function or a string with javascript code)
                this.activeClass = 'jscolor-active'; // class to be set to the target element when a picker window is open on it
                this.minS = 0; // min allowed saturation (0 - 100)
                this.maxS = 100; // max allowed saturation (0 - 100)
                this.minV = 0; // min allowed value (brightness) (0 - 100)
                this.maxV = 100; // max allowed value (brightness) (0 - 100)

                // Accessing the picked color
                //
                this.hsv = [0, 0, 100]; // read-only  [0-360, 0-100, 0-100]
                this.rgb = [255, 255, 255]; // read-only  [0-255, 0-255, 0-255]

                // Color Picker options
                //
                this.width = 181; // width of color palette (in px)
                this.height = 101; // height of color palette (in px)
                this.showOnClick = true; // whether to display the color picker when user clicks on its target element
                this.mode = 'HSV'; // HSV | HVS | HS | HV - layout of the color picker controls
                this.position = 'bottom'; // left | right | top | bottom - position relative to the target element
                this.smartPosition = true; // automatically change picker position when there is not enough space for it
                this.sliderSize = 16; // px
                this.crossSize = 8; // px
                this.closable = false; // whether to display the Close button
                this.closeText = 'Close';
                this.buttonColor = '#000000'; // CSS color
                this.buttonHeight = 18; // px
                this.padding = 12; // px
                this.backgroundColor = '#FFFFFF'; // CSS color
                this.borderWidth = 1; // px
                this.borderColor = '#BBBBBB'; // CSS color
                this.borderRadius = 8; // px
                this.insetWidth = 1; // px
                this.insetColor = '#BBBBBB'; // CSS color
                this.shadow = true; // whether to display shadow
                this.shadowBlur = 15; // px
                this.shadowColor = 'rgba(0,0,0,0.2)'; // CSS color
                this.pointerColor = '#4C4C4C'; // px
                this.pointerBorderColor = '#FFFFFF'; // px
                this.pointerBorderWidth = 1; // px
                this.pointerThickness = 2; // px
                this.zIndex = 1000;
                this.container = null; // where to append the color picker (BODY element by default)

                for (var opt in options) {
                    if (options.hasOwnProperty(opt)) {
                        this[opt] = options[opt];
                    }
                }

                this.hide = function() {
                    if (isPickerOwner()) {
                        detachPicker();
                    }
                };

                this.show = function() {
                    drawPicker();
                };

                this.redraw = function() {
                    if (isPickerOwner()) {
                        drawPicker();
                    }
                };

                this.importColor = function() {
                    if (!this.valueElement) {
                        this.exportColor();
                    } else {
                        if (jsc.isElementType(this.valueElement, 'input')) {
                            if (!this.refine) {
                                if (!this.fromString(this.valueElement.value, jsc.leaveValue)) {
                                    if (this.styleElement) {
                                        this.styleElement.style.backgroundImage = this.styleElement._jscOrigStyle.backgroundImage;
                                        this.styleElement.style.backgroundColor = this.styleElement._jscOrigStyle.backgroundColor;
                                        this.styleElement.style.color = this.styleElement._jscOrigStyle.color;
                                    }
                                    this.exportColor(jsc.leaveValue | jsc.leaveStyle);
                                }
                            } else if (!this.required &&
                                /^\s*$/.test(this.valueElement.value)) {
                                this.valueElement.value = '';
                                if (this.styleElement) {
                                    this.styleElement.style.backgroundImage = this.styleElement._jscOrigStyle.backgroundImage;
                                    this.styleElement.style.backgroundColor = this.styleElement._jscOrigStyle.backgroundColor;
                                    this.styleElement.style.color = this.styleElement._jscOrigStyle.color;
                                }
                                this.exportColor(jsc.leaveValue | jsc.leaveStyle);

                            } else if (this.fromString(this.valueElement.value)) {
                                // managed to import color successfully from the value -> OK, don't do anything
                            } else {
                                this.exportColor();
                            }
                        } else {
                            // not an input element -> doesn't have any value
                            this.exportColor();
                        }
                    }
                };

                this.exportColor = function(flags) {
                    if (!(flags & jsc.leaveValue) && this.valueElement) {
                        var value = this.toString();
                        if (this.uppercase) {
                            value = value.toUpperCase();
                        }
                        if (this.hash) {
                            value = '#' + value;
                        }

                        if (jsc.isElementType(this.valueElement, 'input')) {
                            this.valueElement.value = value;
                        } else {
                            this.valueElement.innerHTML = value;
                        }
                    }
                    if (!(flags & jsc.leaveStyle)) {
                        if (this.styleElement) {
                            this.styleElement.style.backgroundImage = 'none';
                            this.styleElement.style.backgroundColor = '#' + this.toString();
                            this.styleElement.style.color = this.isLight() ? '#000' : '#FFF';
                        }
                    }
                    if (!(flags & jsc.leavePad) && isPickerOwner()) {
                        redrawPad();
                    }
                    if (!(flags & jsc.leaveSld) && isPickerOwner()) {
                        redrawSld();
                    }
                };

                // h: 0-360
                // s: 0-100
                // v: 0-100
                //
                this.fromHSV = function(h, s, v, flags) { // null = don't change
                    if (h !== null) {
                        if (isNaN(h)) {
                            return false;
                        }
                        h = Math.max(0, Math.min(360, h));
                    }
                    if (s !== null) {
                        if (isNaN(s)) {
                            return false;
                        }
                        s = Math.max(0, Math.min(100, this.maxS, s), this.minS);
                    }
                    if (v !== null) {
                        if (isNaN(v)) {
                            return false;
                        }
                        v = Math.max(0, Math.min(100, this.maxV, v), this.minV);
                    }

                    this.rgb = HSV_RGB(
                        h === null ? this.hsv[0] : (this.hsv[0] = h),
                        s === null ? this.hsv[1] : (this.hsv[1] = s),
                        v === null ? this.hsv[2] : (this.hsv[2] = v),
                    );

                    this.exportColor(flags);
                };

                // r: 0-255
                // g: 0-255
                // b: 0-255
                //
                this.fromRGB = function(r, g, b, flags) { // null = don't change
                    if (r !== null) {
                        if (isNaN(r)) {
                            return false;
                        }
                        r = Math.max(0, Math.min(255, r));
                    }
                    if (g !== null) {
                        if (isNaN(g)) {
                            return false;
                        }
                        g = Math.max(0, Math.min(255, g));
                    }
                    if (b !== null) {
                        if (isNaN(b)) {
                            return false;
                        }
                        b = Math.max(0, Math.min(255, b));
                    }

                    var hsv = RGB_HSV(
                        r === null ? this.rgb[0] : r,
                        g === null ? this.rgb[1] : g,
                        b === null ? this.rgb[2] : b,
                    );
                    if (hsv[0] !== null) {
                        this.hsv[0] = Math.max(0, Math.min(360, hsv[0]));
                    }
                    if (hsv[2] !== 0) {
                        this.hsv[1] = hsv[1] === null ?
                            null :
                            Math.max(0, this.minS, Math.min(100, this.maxS, hsv[1]));
                    }
                    this.hsv[2] = hsv[2] === null ?
                        null :
                        Math.max(0, this.minV, Math.min(100, this.maxV, hsv[2]));

                    // update RGB according to final HSV, as some values might be trimmed
                    var rgb = HSV_RGB(this.hsv[0], this.hsv[1], this.hsv[2]);
                    this.rgb[0] = rgb[0];
                    this.rgb[1] = rgb[1];
                    this.rgb[2] = rgb[2];

                    this.exportColor(flags);
                };

                this.fromString = function(str, flags) {
                    var m;
                    if (m = str.match(/^\W*([0-9A-F]{3}([0-9A-F]{3})?)\W*$/i)) {
                        // HEX notation
                        //

                        if (m[1].length === 6) {
                            // 6-char notation
                            this.fromRGB(
                                parseInt(m[1].substr(0, 2), 16),
                                parseInt(m[1].substr(2, 2), 16),
                                parseInt(m[1].substr(4, 2), 16),
                                flags,
                            );
                        } else {
                            // 3-char notation
                            this.fromRGB(
                                parseInt(m[1].charAt(0) + m[1].charAt(0), 16),
                                parseInt(m[1].charAt(1) + m[1].charAt(1), 16),
                                parseInt(m[1].charAt(2) + m[1].charAt(2), 16),
                                flags,
                            );
                        }
                        return true;

                    } else if (m = str.match(/^\W*rgba?\(([^)]*)\)\W*$/i)) {
                        var params = m[1].split(',');
                        var re = /^\s*(\d*)(\.\d+)?\s*$/;
                        var mR, mG, mB;
                        if (
                            params.length >= 3 &&
                            (mR = params[0].match(re)) &&
                            (mG = params[1].match(re)) &&
                            (mB = params[2].match(re))
                        ) {
                            var r = parseFloat((mR[1] || '0') + (mR[2] || ''));
                            var g = parseFloat((mG[1] || '0') + (mG[2] || ''));
                            var b = parseFloat((mB[1] || '0') + (mB[2] || ''));
                            this.fromRGB(r, g, b, flags);
                            return true;
                        }
                    }
                    return false;
                };

                this.toString = function() {
                    return (
                        (0x100 | Math.round(this.rgb[0])).toString(16).substr(1) +
                        (0x100 | Math.round(this.rgb[1])).toString(16).substr(1) +
                        (0x100 | Math.round(this.rgb[2])).toString(16).substr(1)
                    );
                };

                this.toHEXString = function() {
                    return '#' + this.toString().toUpperCase();
                };

                this.toRGBString = function() {
                    return ('rgb(' +
                        Math.round(this.rgb[0]) + ',' +
                        Math.round(this.rgb[1]) + ',' +
                        Math.round(this.rgb[2]) + ')'
                    );
                };

                this.isLight = function() {
                    return (
                        0.213 * this.rgb[0] +
                        0.715 * this.rgb[1] +
                        0.072 * this.rgb[2] >
                        255 / 2
                    );
                };

                this._processParentElementsInDOM = function() {
                    if (this._linkedElementsProcessed) {
                        return;
                    }
                    this._linkedElementsProcessed = true;

                    var elm = this.targetElement;
                    do {
                        // If the target element or one of its parent nodes has fixed position,
                        // then use fixed positioning instead
                        //
                        // Note: In Firefox, getComputedStyle returns null in a hidden iframe,
                        // that's why we need to check if the returned style object is non-empty
                        var currStyle = jsc.getStyle(elm);
                        if (currStyle && currStyle.position.toLowerCase() === 'fixed') {
                            this.fixed = true;
                        }

                        if (elm !== this.targetElement) {
                            // Ensure to attach onParentScroll only once to each parent element
                            // (multiple targetElements can share the same parent nodes)
                            //
                            // Note: It's not just offsetParents that can be scrollable,
                            // that's why we loop through all parent nodes
                            if (!elm._jscEventsAttached) {
                                jsc.attachEvent(elm, 'scroll', jsc.onParentScroll);
                                elm._jscEventsAttached = true;
                            }
                        }
                    } while ((elm = elm.parentNode) && !jsc.isElementType(elm, 'body'));
                };

                // r: 0-255
                // g: 0-255
                // b: 0-255
                //
                // returns: [ 0-360, 0-100, 0-100 ]
                //
                function RGB_HSV(r, g, b) {
                    r /= 255;
                    g /= 255;
                    b /= 255;
                    var n = Math.min(Math.min(r, g), b);
                    var v = Math.max(Math.max(r, g), b);
                    var m = v - n;
                    if (m === 0) {
                        return [null, 0, 100 * v];
                    }
                    var h = r === n ?
                        3 + (b - g) / m :
                        (g === n ? 5 + (r - b) / m : 1 + (g - r) / m);
                    return [
                        60 * (h === 6 ? 0 : h),
                        100 * (m / v),
                        100 * v,
                    ];
                }

                // h: 0-360
                // s: 0-100
                // v: 0-100
                //
                // returns: [ 0-255, 0-255, 0-255 ]
                //
                function HSV_RGB(h, s, v) {
                    var u = 255 * (v / 100);

                    if (h === null) {
                        return [u, u, u];
                    }

                    h /= 60;
                    s /= 100;

                    var i = Math.floor(h);
                    var f = i % 2 ? h - i : 1 - (h - i);
                    var m = u * (1 - s);
                    var n = u * (1 - s * f);
                    switch (i) {
                        case 6:
                        case 0:
                            return [u, n, m];
                        case 1:
                            return [n, u, m];
                        case 2:
                            return [m, u, n];
                        case 3:
                            return [m, n, u];
                        case 4:
                            return [n, m, u];
                        case 5:
                            return [u, m, n];
                    }
                }

                function detachPicker() {
                    jsc.unsetClass(THIS.targetElement, THIS.activeClass);
                    jsc.picker.wrap.parentNode.removeChild(jsc.picker.wrap);
                    delete jsc.picker.owner;
                }

                function drawPicker() {

                    // At this point, when drawing the picker, we know what the parent elements are
                    // and we can do all related DOM operations, such as registering events on them
                    // or checking their positioning
                    THIS._processParentElementsInDOM();

                    if (!jsc.picker) {
                        jsc.picker = {
                            owner: null,
                            wrap: document.createElement('div'),
                            box: document.createElement('div'),
                            boxS: document.createElement('div'), // shadow area
                            boxB: document.createElement('div'), // border
                            pad: document.createElement('div'),
                            padB: document.createElement('div'), // border
                            padM: document.createElement('div'), // mouse/touch area
                            padPal: jsc.createPalette(),
                            cross: document.createElement('div'),
                            crossBY: document.createElement('div'), // border Y
                            crossBX: document.createElement('div'), // border X
                            crossLY: document.createElement('div'), // line Y
                            crossLX: document.createElement('div'), // line X
                            sld: document.createElement('div'),
                            sldB: document.createElement('div'), // border
                            sldM: document.createElement('div'), // mouse/touch area
                            sldGrad: jsc.createSliderGradient(),
                            sldPtrS: document.createElement('div'), // slider pointer spacer
                            sldPtrIB: document.createElement('div'), // slider pointer inner border
                            sldPtrMB: document.createElement('div'), // slider pointer middle border
                            sldPtrOB: document.createElement('div'), // slider pointer outer border
                            btn: document.createElement('div'),
                            btnT: document.createElement('span'), // text
                        };

                        jsc.picker.pad.appendChild(jsc.picker.padPal.elm);
                        jsc.picker.padB.appendChild(jsc.picker.pad);
                        jsc.picker.cross.appendChild(jsc.picker.crossBY);
                        jsc.picker.cross.appendChild(jsc.picker.crossBX);
                        jsc.picker.cross.appendChild(jsc.picker.crossLY);
                        jsc.picker.cross.appendChild(jsc.picker.crossLX);
                        jsc.picker.padB.appendChild(jsc.picker.cross);
                        jsc.picker.box.appendChild(jsc.picker.padB);
                        jsc.picker.box.appendChild(jsc.picker.padM);

                        jsc.picker.sld.appendChild(jsc.picker.sldGrad.elm);
                        jsc.picker.sldB.appendChild(jsc.picker.sld);
                        jsc.picker.sldB.appendChild(jsc.picker.sldPtrOB);
                        jsc.picker.sldPtrOB.appendChild(jsc.picker.sldPtrMB);
                        jsc.picker.sldPtrMB.appendChild(jsc.picker.sldPtrIB);
                        jsc.picker.sldPtrIB.appendChild(jsc.picker.sldPtrS);
                        jsc.picker.box.appendChild(jsc.picker.sldB);
                        jsc.picker.box.appendChild(jsc.picker.sldM);

                        jsc.picker.btn.appendChild(jsc.picker.btnT);
                        jsc.picker.box.appendChild(jsc.picker.btn);

                        jsc.picker.boxB.appendChild(jsc.picker.box);
                        jsc.picker.wrap.appendChild(jsc.picker.boxS);
                        jsc.picker.wrap.appendChild(jsc.picker.boxB);
                    }

                    var p = jsc.picker;

                    var displaySlider = !!jsc.getSliderComponent(THIS);
                    var dims = jsc.getPickerDims(THIS);
                    var crossOuterSize = (2 * THIS.pointerBorderWidth +
                        THIS.pointerThickness + 2 * THIS.crossSize);
                    var padToSliderPadding = jsc.getPadToSliderPadding(THIS);
                    var borderRadius = Math.min(
                        THIS.borderRadius,
                        Math.round(THIS.padding * Math.PI)); // px
                    var padCursor = 'crosshair';

                    // wrap
                    p.wrap.style.clear = 'both';
                    p.wrap.style.width = (dims[0] + 2 * THIS.borderWidth) + 'px';
                    p.wrap.style.height = (dims[1] + 2 * THIS.borderWidth) + 'px';
                    p.wrap.style.zIndex = THIS.zIndex;

                    // picker
                    p.box.style.width = dims[0] + 'px';
                    p.box.style.height = dims[1] + 'px';

                    p.boxS.style.position = 'absolute';
                    p.boxS.style.left = '0';
                    p.boxS.style.top = '0';
                    p.boxS.style.width = '100%';
                    p.boxS.style.height = '100%';
                    jsc.setBorderRadius(p.boxS, borderRadius + 'px');

                    // picker border
                    p.boxB.style.position = 'relative';
                    p.boxB.style.border = THIS.borderWidth + 'px solid';
                    p.boxB.style.borderColor = THIS.borderColor;
                    p.boxB.style.background = THIS.backgroundColor;
                    jsc.setBorderRadius(p.boxB, borderRadius + 'px');

                    // IE hack:
                    // If the element is transparent, IE will trigger the event on the elements under it,
                    // e.g. on Canvas or on elements with border
                    p.padM.style.background =
                        p.sldM.style.background =
                            '#FFF';
                    jsc.setStyle(p.padM, 'opacity', '0');
                    jsc.setStyle(p.sldM, 'opacity', '0');

                    // pad
                    p.pad.style.position = 'relative';
                    p.pad.style.width = THIS.width + 'px';
                    p.pad.style.height = THIS.height + 'px';

                    // pad palettes (HSV and HVS)
                    p.padPal.draw(THIS.width, THIS.height, jsc.getPadYComponent(THIS));

                    // pad border
                    p.padB.style.position = 'absolute';
                    p.padB.style.left = THIS.padding + 'px';
                    p.padB.style.top = THIS.padding + 'px';
                    p.padB.style.border = THIS.insetWidth + 'px solid';
                    p.padB.style.borderColor = THIS.insetColor;

                    // pad mouse area
                    p.padM._jscInstance = THIS;
                    p.padM._jscControlName = 'pad';
                    p.padM.style.position = 'absolute';
                    p.padM.style.left = '0';
                    p.padM.style.top = '0';
                    p.padM.style.width = (THIS.padding + 2 * THIS.insetWidth +
                        THIS.width + padToSliderPadding / 2) + 'px';
                    p.padM.style.height = dims[1] + 'px';
                    p.padM.style.cursor = padCursor;

                    // pad cross
                    p.cross.style.position = 'absolute';
                    p.cross.style.left =
                        p.cross.style.top =
                            '0';
                    p.cross.style.width =
                        p.cross.style.height =
                            crossOuterSize + 'px';

                    // pad cross border Y and X
                    p.crossBY.style.position =
                        p.crossBX.style.position =
                            'absolute';
                    p.crossBY.style.background =
                        p.crossBX.style.background =
                            THIS.pointerBorderColor;
                    p.crossBY.style.width =
                        p.crossBX.style.height =
                            (2 * THIS.pointerBorderWidth + THIS.pointerThickness) + 'px';
                    p.crossBY.style.height =
                        p.crossBX.style.width =
                            crossOuterSize + 'px';
                    p.crossBY.style.left =
                        p.crossBX.style.top =
                            (Math.floor(crossOuterSize / 2) -
                                Math.floor(THIS.pointerThickness / 2) -
                                THIS.pointerBorderWidth) + 'px';
                    p.crossBY.style.top =
                        p.crossBX.style.left =
                            '0';

                    // pad cross line Y and X
                    p.crossLY.style.position =
                        p.crossLX.style.position =
                            'absolute';
                    p.crossLY.style.background =
                        p.crossLX.style.background =
                            THIS.pointerColor;
                    p.crossLY.style.height =
                        p.crossLX.style.width =
                            (crossOuterSize - 2 * THIS.pointerBorderWidth) + 'px';
                    p.crossLY.style.width =
                        p.crossLX.style.height =
                            THIS.pointerThickness + 'px';
                    p.crossLY.style.left =
                        p.crossLX.style.top =
                            (Math.floor(crossOuterSize / 2) -
                                Math.floor(THIS.pointerThickness / 2)) + 'px';
                    p.crossLY.style.top =
                        p.crossLX.style.left =
                            THIS.pointerBorderWidth + 'px';

                    // slider
                    p.sld.style.overflow = 'hidden';
                    p.sld.style.width = THIS.sliderSize + 'px';
                    p.sld.style.height = THIS.height + 'px';

                    // slider gradient
                    p.sldGrad.draw(THIS.sliderSize, THIS.height, '#000', '#000');

                    // slider border
                    p.sldB.style.display = displaySlider ? 'block' : 'none';
                    p.sldB.style.position = 'absolute';
                    p.sldB.style.right = THIS.padding + 'px';
                    p.sldB.style.top = THIS.padding + 'px';
                    p.sldB.style.border = THIS.insetWidth + 'px solid';
                    p.sldB.style.borderColor = THIS.insetColor;

                    // slider mouse area
                    p.sldM._jscInstance = THIS;
                    p.sldM._jscControlName = 'sld';
                    p.sldM.style.display = displaySlider ? 'block' : 'none';
                    p.sldM.style.position = 'absolute';
                    p.sldM.style.right = '0';
                    p.sldM.style.top = '0';
                    p.sldM.style.width = (THIS.sliderSize + padToSliderPadding / 2 +
                        THIS.padding + 2 * THIS.insetWidth) + 'px';
                    p.sldM.style.height = dims[1] + 'px';
                    p.sldM.style.cursor = 'default';

                    // slider pointer inner and outer border
                    p.sldPtrIB.style.border =
                        p.sldPtrOB.style.border =
                            THIS.pointerBorderWidth + 'px solid ' + THIS.pointerBorderColor;

                    // slider pointer outer border
                    p.sldPtrOB.style.position = 'absolute';
                    p.sldPtrOB.style.left = -(2 * THIS.pointerBorderWidth +
                        THIS.pointerThickness) + 'px';
                    p.sldPtrOB.style.top = '0';

                    // slider pointer middle border
                    p.sldPtrMB.style.border = THIS.pointerThickness + 'px solid ' +
                        THIS.pointerColor;

                    // slider pointer spacer
                    p.sldPtrS.style.width = THIS.sliderSize + 'px';
                    p.sldPtrS.style.height = sliderPtrSpace + 'px';

                    // the Close button
                    function setBtnBorder() {
                        var insetColors = THIS.insetColor.split(/\s+/);
                        var outsetColor = insetColors.length < 2 ?
                            insetColors[0] :
                            insetColors[1] + ' ' + insetColors[0] + ' ' + insetColors[0] +
                            ' ' + insetColors[1];
                        p.btn.style.borderColor = outsetColor;
                    }

                    p.btn.style.display = THIS.closable ? 'block' : 'none';
                    p.btn.style.position = 'absolute';
                    p.btn.style.left = THIS.padding + 'px';
                    p.btn.style.bottom = THIS.padding + 'px';
                    p.btn.style.padding = '0 15px';
                    p.btn.style.height = THIS.buttonHeight + 'px';
                    p.btn.style.border = THIS.insetWidth + 'px solid';
                    setBtnBorder();
                    p.btn.style.color = THIS.buttonColor;
                    p.btn.style.font = '12px sans-serif';
                    p.btn.style.textAlign = 'center';
                    try {
                        p.btn.style.cursor = 'pointer';
                    } catch (eOldIE) {
                        p.btn.style.cursor = 'hand';
                    }
                    p.btn.onmousedown = function() {
                        THIS.hide();
                    };
                    p.btnT.style.lineHeight = THIS.buttonHeight + 'px';
                    p.btnT.innerHTML = '';
                    p.btnT.appendChild(document.createTextNode(THIS.closeText));

                    // place pointers
                    redrawPad();
                    redrawSld();

                    // If we are changing the owner without first closing the picker,
                    // make sure to first deal with the old owner
                    if (jsc.picker.owner && jsc.picker.owner !== THIS) {
                        jsc.unsetClass(jsc.picker.owner.targetElement, THIS.activeClass);
                    }

                    // Set the new picker owner
                    jsc.picker.owner = THIS;

                    // The redrawPosition() method needs picker.owner to be set, that's why we call it here,
                    // after setting the owner
                    if (jsc.isElementType(container, 'body')) {
                        jsc.redrawPosition();
                    } else {
                        jsc._drawPosition(THIS, 0, 0, 'relative', false);
                    }

                    if (p.wrap.parentNode != container) {
                        container.appendChild(p.wrap);
                    }

                    jsc.setClass(THIS.targetElement, THIS.activeClass);
                }

                function redrawPad() {
                    // redraw the pad pointer
                    switch (jsc.getPadYComponent(THIS)) {
                        case 's':
                            var yComponent = 1;
                            break;
                        case 'v':
                            var yComponent = 2;
                            break;
                    }
                    var x = Math.round((THIS.hsv[0] / 360) * (THIS.width - 1));
                    var y = Math.round((1 - THIS.hsv[yComponent] / 100) *
                        (THIS.height - 1));
                    var crossOuterSize = (2 * THIS.pointerBorderWidth +
                        THIS.pointerThickness + 2 * THIS.crossSize);
                    var ofs = -Math.floor(crossOuterSize / 2);
                    jsc.picker.cross.style.left = (x + ofs) + 'px';
                    jsc.picker.cross.style.top = (y + ofs) + 'px';

                    // redraw the slider
                    switch (jsc.getSliderComponent(THIS)) {
                        case 's':
                            var rgb1 = HSV_RGB(THIS.hsv[0], 100, THIS.hsv[2]);
                            var rgb2 = HSV_RGB(THIS.hsv[0], 0, THIS.hsv[2]);
                            var color1 = 'rgb(' +
                                Math.round(rgb1[0]) + ',' +
                                Math.round(rgb1[1]) + ',' +
                                Math.round(rgb1[2]) + ')';
                            var color2 = 'rgb(' +
                                Math.round(rgb2[0]) + ',' +
                                Math.round(rgb2[1]) + ',' +
                                Math.round(rgb2[2]) + ')';
                            jsc.picker.sldGrad.draw(THIS.sliderSize, THIS.height, color1,
                                color2);
                            break;
                        case 'v':
                            var rgb = HSV_RGB(THIS.hsv[0], THIS.hsv[1], 100);
                            var color1 = 'rgb(' +
                                Math.round(rgb[0]) + ',' +
                                Math.round(rgb[1]) + ',' +
                                Math.round(rgb[2]) + ')';
                            var color2 = '#000';
                            jsc.picker.sldGrad.draw(THIS.sliderSize, THIS.height, color1,
                                color2);
                            break;
                    }
                }

                function redrawSld() {
                    var sldComponent = jsc.getSliderComponent(THIS);
                    if (sldComponent) {
                        // redraw the slider pointer
                        switch (sldComponent) {
                            case 's':
                                var yComponent = 1;
                                break;
                            case 'v':
                                var yComponent = 2;
                                break;
                        }
                        var y = Math.round((1 - THIS.hsv[yComponent] / 100) *
                            (THIS.height - 1));
                        jsc.picker.sldPtrOB.style.top = (y -
                            (2 * THIS.pointerBorderWidth + THIS.pointerThickness) -
                            Math.floor(sliderPtrSpace / 2)) + 'px';
                    }
                }

                function isPickerOwner() {
                    return jsc.picker && jsc.picker.owner === THIS;
                }

                function blurValue() {
                    THIS.importColor();
                }

                // Find the target element
                if (typeof targetElement === 'string') {
                    var id = targetElement;
                    var elm = document.getElementById(id);
                    if (elm) {
                        this.targetElement = elm;
                    } else {
                        jsc.warn('Could not find target element with ID \'' + id + '\'');
                    }
                } else if (targetElement) {
                    this.targetElement = targetElement;
                } else {
                    jsc.warn('Invalid target element: \'' + targetElement + '\'');
                }

                if (this.targetElement._jscLinkedInstance) {
                    jsc.warn('Cannot link jscolor twice to the same element. Skipping.');
                    return;
                }
                this.targetElement._jscLinkedInstance = this;

                // Find the value element
                this.valueElement = jsc.fetchElement(this.valueElement);
                // Find the style element
                this.styleElement = jsc.fetchElement(this.styleElement);

                var THIS = this;
                var container =
                    this.container ?
                        jsc.fetchElement(this.container) :
                        document.getElementsByTagName('body')[0];
                var sliderPtrSpace = 3; // px

                // For BUTTON elements it's important to stop them from sending the form when clicked
                // (e.g. in Safari)
                if (jsc.isElementType(this.targetElement, 'button')) {
                    if (this.targetElement.onclick) {
                        var origCallback = this.targetElement.onclick;
                        this.targetElement.onclick = function(evt) {
                            origCallback.call(this, evt);
                            return false;
                        };
                    } else {
                        this.targetElement.onclick = function() {
                            return false;
                        };
                    }
                }

                /*
		var elm = this.targetElement;
		do {
			// If the target element or one of its offsetParents has fixed position,
			// then use fixed positioning instead
			//
			// Note: In Firefox, getComputedStyle returns null in a hidden iframe,
			// that's why we need to check if the returned style object is non-empty
			var currStyle = jsc.getStyle(elm);
			if (currStyle && currStyle.position.toLowerCase() === 'fixed') {
				this.fixed = true;
			}

			if (elm !== this.targetElement) {
				// attach onParentScroll so that we can recompute the picker position
				// when one of the offsetParents is scrolled
				if (!elm._jscEventsAttached) {
					jsc.attachEvent(elm, 'scroll', jsc.onParentScroll);
					elm._jscEventsAttached = true;
				}
			}
		} while ((elm = elm.offsetParent) && !jsc.isElementType(elm, 'body'));
		*/

                // valueElement
                if (this.valueElement) {
                    if (jsc.isElementType(this.valueElement, 'input')) {
                        var updateField = function() {
                            THIS.fromString(THIS.valueElement.value, jsc.leaveValue);
                            jsc.dispatchFineChange(THIS);
                        };
                        jsc.attachEvent(this.valueElement, 'keyup', updateField);
                        jsc.attachEvent(this.valueElement, 'input', updateField);
                        jsc.attachEvent(this.valueElement, 'blur', blurValue);
                        this.valueElement.setAttribute('autocomplete', 'off');
                    }
                }

                // styleElement
                if (this.styleElement) {
                    this.styleElement._jscOrigStyle = {
                        backgroundImage: this.styleElement.style.backgroundImage,
                        backgroundColor: this.styleElement.style.backgroundColor,
                        color: this.styleElement.style.color,
                    };
                }

                if (this.value) {
                    // Try to set the color from the .value option and if unsuccessful,
                    // export the current color
                    this.fromString(this.value) || this.exportColor();
                } else {
                    this.importColor();
                }
            },

        };

//================================
// Public properties and methods
//================================

// By default, search for all elements with class="jscolor" and install a color picker on them.
//
// You can change what class name will be looked for by setting the property jscolor.lookupClass
// anywhere in your HTML document. To completely disable the automatic lookup, set it to null.
//
        jsc.jscolor.lookupClass = 'jscolor';

        jsc.jscolor.installByClassName = function(className) {
            var inputElms = document.getElementsByTagName('input');
            var buttonElms = document.getElementsByTagName('button');

            jsc.tryInstallOnElements(inputElms, className);
            jsc.tryInstallOnElements(buttonElms, className);
        };

        jsc.register();

        return jsc.jscolor;

    })();
}
var PosterEditor = {},
    imageCounter = (function($) {
        let images = $('[id*=image-]').map(function(index, image) {
            return _.replace($(image).attr('id'), 'image-', '');
        });

        if (!!images && images.length > 0) {
            $('[name="has_images"]').val(1);
            return _.last(images);
        } else {
            $('[name="has_images"]').val(0);
            return 0;
        }

    })(jQuery);
PosterEditor.BodyMask = {};
PosterEditor.PosterZoom = {};
PosterEditor.ThemesScroll = {};
PosterEditor.ThemeSelect = {};
PosterEditor.ThemeSearch = {};
PosterEditor.CampaignSelect = {};
PosterEditor.Components = {};
PosterEditor.GeometricComponents = {};
PosterEditor.Behaviors = {};
PosterEditor.ThemeAjax = (function($) {

    var getCurrentSelectedTheme = function(e, callback) {

        if (e) {
            var theme_id = e.attr('data-value');
            $.ajax({
                url: '/ajax/poster/image',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    theme_id: theme_id,
                },
                success: callback,
                beforeSend: function() {
                    $('.poster-editor').removeClass('editor-ready');
                },
                complete: function() {
                    $('.poster-editor').addClass('editor-ready');
                },
            });

        } else {
            // var theme_informations = $('ul.theme-informations').clone();
            $('#poster-editor').empty();
            // $('#poster-editor' ).append(theme_informations);
            $('#paper_format').html('--');
            $('#width').html('--');
            $('#height').html('--');

        }

    };

    return {
        getCurrentSelectedTheme: getCurrentSelectedTheme,
    };

})(jQuery);

PosterEditor.CampaignFieldsAjax = (function($) {

    var getDatarolesByCampaign = function() {
        return $.ajax({
            url: '/ajax/poster/fields-select',
            type: 'POST',
            data: {
                campaign_id: $('select[name="campaign_id"]').val(),
            },
            success: (data) => {
                return data;
            },
        });
    };

    var getCurrentSelectedCampaign = function(callback) {
        if (checkCampaignSelected()) {
            return $.ajax({
                url: '/ajax/poster/fields',
                type: 'POST',
                data: {
                    campaign_id: $('select[name="campaign_id"]').val(),
                },
                success: callback,
                beforeSend: function() {
                    $('.editor-fields').removeClass('editor-ready');
                },
                complete: function() {
                    $('.editor-fields').addClass('editor-ready');
                },
            });
        } else {
            removeAllComponentsList();
        }
    };

    var checkCampaignSelected = function() {
        return ($('select[name="campaign_id"]').val());
    };

    var removeAllComponentsList = function() {
        $('.relative-component').remove();
        $('.panel-components-list').children().remove();
    };

    return {
        getCurrentSelectedCampaign: getCurrentSelectedCampaign,
        getDatarolesByCampaign: getDatarolesByCampaign,
    };

})(jQuery);

PosterEditor.ThemesAjax = (function($) {

    function getCurrentSelectedTheme(e, callback) {

        if (e) {
            var theme_id = e.attr('data-value');
            $.ajax({
                url: '/ajax/poster/image',
                type: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    theme_id: theme_id,
                },
                success: callback,
                beforeSend: function() {
                    $('.poster-editor').removeClass('editor-ready');
                },
                complete: function() {
                    $('.poster-editor').addClass('editor-ready');
                },
            });

        } else {
            // var theme_informations = $('ul.theme-informations').clone();
            $('#poster-editor').empty();
            // $('#poster-editor' ).append(theme_informations);
            $('#paper_format').html('--');
            $('#width').html('--');
            $('#height').html('--');

        }

    }

    function getPaginatedThemes(callback) {

        $.ajax({
            url: '/ajax/poster/themes',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                themes_total: $('.thumbnail').length,
                theme_old: $('select[name="theme_id"]').attr('data-old'),
            },
            success: callback,
            beforeSend: function() {
                $('.themes-list').removeClass('themes-ready');
            },
            complete: function() {
                $('.themes-list').addClass('themes-ready');
            },
        });

    }

    function getThemeSearch(callback) {

        $.ajax({
            url: '/ajax/poster/searchtheme',
            type: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                searchTheme: $('input[name="searchTheme"]').val(),
            },
            success: callback,
            beforeSend: function() {
                $('.themes-list').removeClass('themes-ready');
            },
            complete: function() {
                $('.themes-list').addClass('themes-ready');
            },
        });

    }

    return {
        getPaginatedThemes: getPaginatedThemes,
        getCurrentSelectedTheme: getCurrentSelectedTheme,
        getThemeSearch: getThemeSearch,
    };

})(jQuery);

PosterEditor.Themes = (function($, ajax) {

    var addThemes = function() {
        ajax.getPaginatedThemes(addThemesList);
    };

    var searchThemes = function() {
        ajax.getThemeSearch(addThemesList);
    };

    var getTagsSeparatedByCommas = function(tagList) {
        let tags = tagList.map(function(tag) {
            return tag.name;
        });

        return tags.join(', ');
    };

    var addThemesList = function(themes) {
        let items = [];
        themes = JSON.parse(themes);
        let filterThemes = (themes.themes) ? themes.themes : themes;

        $(filterThemes).each(function(i, item) {

            var tags = getTagsSeparatedByCommas(item.tags);

            items.push(
                '<div class="col-xs-12">' +
                '<a class="thumbnail" data-toggle="popover" src="javascript:void(0);" data-content="' +
                item.paper_format.name + '<br>" title="' + item.name +
                '" data-value="' + item.id + '">' +
                '<img src="' + item.url_thumb_link + '" alt="' + item.name + '">' +
                '<div class="tags-container">' + tags + '</div>' +
                '</a>' +
                '</div>',
            );

        });

        $('.themes-list').
        append(items.join('')).
        attr('data-total', themes.count_all);

    };

    return {
        addThemes: addThemes,
        searchThemes: searchThemes,
    };

})(jQuery, PosterEditor.ThemesAjax);

PosterEditor.Fields = (function($, ajax) {

    var addFieldList = function() {
        return ajax.getCurrentSelectedCampaign(addCampaignFildsList);
    };

    var initializeRelativeComponents = function() {
        $('.relative-component, .geometric-component').
        draggable({containment: 'parent'});
    };

    var stringToColour = function(str) {
        var hash = 0, i;
        for (i = 0; i < str.length; i++) {
            hash = str.charCodeAt(i) + ((hash << 5) - hash);
        }
        var colour = '#';
        for (i = 0; i < 3; i++) {
            var value = (hash >> (i * 8)) & 0xFF;
            colour += ('00' + value.toString(16)).substr(-2);
        }
        return colour;
    };

    var addCampaignFildsList = function(fields) {
        var
            color,
            items = [];

        fields = JSON.parse(fields);
        $(fields).each(function(i, item) {
            color = stringToColour(item.field_id);
            items.push('<a class="label label-primary" style="border-bottom:4px solid ' +
                color + ';" href="javascript:void(0);"  data-component="' +
                item.field_id + '" data-class="' + item.field_id + '" data-text="' +
                item.name + '">' + item.name + '</a>');
        });

        $('.panel-components-list').children().remove();
        $('.panel-components-list').append(items.join(''));

        $('.relative-component').each(function(index, element) {
            $('[data-component="' + element.dataset.role + '"]').
            prop('disabled', true).
            addClass('disabled');
        });

        initializeRelativeComponents();
    };

    return {
        addFieldList: addFieldList,
    };

})(jQuery, PosterEditor.CampaignFieldsAjax);

PosterEditor.Panel = (function($, ajax) {

    var setVerticalAlign = function() {
        $('.relative-component').each(function(index, element) {
            var componentContent = $(element).children('.component-content'),
                verticalAlign = componentContent.attr('data-vertical-align');
            if (verticalAlign == 'up') {
                componentContent.removeAttr('data-vertical-align');
                componentContent.css({
                    'position': '',
                    'left': '',
                    'right': '',
                    'bottom': '',
                });
            } else if (verticalAlign == 'down') {
                componentContent.removeAttr('data-vertical-align');
                var position = componentContent.css('position'),
                    left = componentContent.css('left'),
                    right = componentContent.css('right'),
                    bottom = componentContent.css('bottom');
                componentContent.css({
                    'position': '',
                    'left': '',
                    'right': '',
                    'bottom': '',
                });
                componentContent.children('span').css({
                    'position': 'absolute',
                    'left': left,
                    'right': right,
                    'bottom': '0',
                });
            }
        });
    };

    var addBackgroundImage = function(e) {
        ajax.getCurrentSelectedTheme(e, addImageOnCanvas);
    };

    var loadBackgroundImage = function() {
        var theme = $('[name="theme_id"]');
        if (theme.val()) {
            theme.attr('data-value', theme.val());
            ajax.getCurrentSelectedTheme(theme, addImageOnCanvas);
        }
    };

    var addImageOnCanvas = function(theme) {
        $('.thumbnail').removeClass('active');
        $('[data-role="backgroundImage"]').remove();

        theme = JSON.parse(theme);

        var img = new Image();
        const route = '/ajax/template/theme/' + theme.id + '/image';
        img.src = route;
        img.dataset.role = 'backgroundImage';

        $('[data-value="' + theme.id + '"]').addClass('active');
        $('[name="theme_id"]').attr('value', theme.id);

        if (theme.paper_format.format_position === 'R') {
            img.style.width = theme.paper_format.width + 'mm';
            img.style.height = theme.paper_format.height + 'mm';
        } else {
            img.style.width = theme.paper_format.width + 'mm';
            img.style.height = theme.paper_format.height + 'mm';
        }

        $('#poster-editor').width(img.style.width).height(img.style.height);
        $('#poster-editor').prepend($(img).hide().fadeIn(400));

        var marginLeft = parseFloat(img.style.width.match(/\d/g).join('')) / 2;
        $('.grid-rulers').width(img.style.width).height(img.style.height).css({
            'transform-origin': '0 0',
            'top': '0',
            'left': '0',
            'right': '0',
            'bottom': '0',
            'margin': 'auto',
        });

        $('#paper_format').html(theme.paper_format.name);
        $('#width').html(theme.paper_format.width);
        $('#height').html(theme.paper_format.height);

    };

    return {
        addBackgroundImage: addBackgroundImage,
        loadBackgroundImage: loadBackgroundImage,
        setVerticalAlign: setVerticalAlign,
    };

})(jQuery, PosterEditor.ThemeAjax);

PosterEditor.Components.RelativeComponent = (function($) {

    var make = function(component_name, component_fields) {
        var component = '<div class="relative-component" data-role="' +
            component_name +
            '"><div class="component-content text-left vertical-top text-normal" style="font-family: Arial; font-size: 24px; color: rgb(0, 0, 0);">';
        $.each(component_fields, function(index, value) {
            component += '<span class="' + index + '">' + value + '</span>';
        });
        component += '</div></div>';
        return component;
    };

    return {
        make: make,
    };

})(jQuery);


PosterEditor.Components.unitary_value = (function($) {

    var make = function() {
        var
            component_name = 'unitary_value',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_plot_separated = (function($) {

    var make = function() {
        var
            component_name = 'value_plot_separated',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.cet = (function($) {

    var make = function() {
        var
            component_name = 'cet',
            component_fields = {
                'integer': '1,00',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.cet_py = (function($) {

    var make = function() {
        var
            component_name = 'cet_py',
            component_fields = {
                'integer': '99',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.interest_py = (function($) {

    var make = function() {
        var
            component_name = 'interest_py',
            component_fields = {
                'integer': '1,00',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.iof = (function($) {

    var make = function() {
        var
            component_name = 'iof',
            component_fields = {
                'integer': '1,00',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.additional_per_day = (function($) {

    var make = function() {
        var
            component_name = 'additional_per_day',
            component_fields = {
                'integer': '1,00',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.factor = (function($) {

    var make = function() {
        var
            component_name = 'factor',
            component_fields = {
                'integer': '9',
                'decimal': ',99999',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.departament = (function($) {

    var make = function() {
        var
            component_name = 'departament',
            component_fields = {
                'departament': 'Departamento',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.discount = (function($) {

    var make = function() {
        var
            component_name = 'discount',
            component_fields = {
                'integer': '99',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.discount_bundle = (function($) {

    var make = function() {
        var
            component_name = 'discount_bundle',
            component_fields = {
                'integer': '99',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.has_interest = (function($) {

    var make = function() {
        var
            component_name = 'has_interest',
            component_fields = {
                'integer': '99',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.payment_type = (function($) {

    var make = function() {
        var
            component_name = 'payment_type',
            component_fields = {
                'text': 'tipo de pagamento',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.spared_percent = (function($) {

    var make = function() {
        var
            component_name = 'spared_percent',
            component_fields = {
                'integer': '99',
                'percent': '%',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.LineComponent = (function($) {

    function make() {

        const $new_element = $('<div class="relative-component component-line" data-role="line" style="width: 5px; height: 15px;">' +
            '<div class="component-properties">' +
            '<div class="input-group-btn">' +
            '<span class="btn btn-danger btn-xs btn-trash">' +
            '<i class="fa fa-trash"></i>' +
            '</span>' +
            '<span class="btn btn-warning btn-xs btn-close">' +
            '<i class="fa fa-close"></i>' +
            '</span>' +
            '</div>' +
            '<div class="input-group">' +
            '<input type="text" class="jscolor {hash:true}" value="000000" name="background">' +
            '</div>' +
            '</div>' +
            '<div class="component-content"></div>' +
            '</div>');

        $('#poster-editor').append($new_element);

        $('.relative-component').draggable({containment: 'parent'});

        jscolor.installByClassName('jscolor');

    }

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.legal_informations = (function($) {

    var make = function() {
        var
            component_name = 'legal_informations',
            component_fields = {
                'text': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla dapibus.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.MarkedTextComponent = (function($) {

    var make = function() {

        var $new_element = $('<div class="relative-component marked-text-component" data-role="marked-text-component" style="width: 165px; height:24px;">' +
            '<div class="component-content text-left vertical-top text-normal" style="font-family: Arial; font-size: 24px; color: rgb(0, 0, 0);">' +
            '<span>Texto marcável</span>' +
            '</div>' +
            '</div>');

        $('#poster-editor').append($new_element);
        $('.relative-component').draggable({containment: 'parent'});
        jscolor.installByClassName('jscolor');

    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.main_description = (function($) {

    var make = function() {
        var
            component_name = 'main_description',
            component_fields = {
                'desciption': 'Descrição Principal',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.main_description2 = (function($) {

    var make = function() {
        var
            component_name = 'main_description2',
            component_fields = {
                'desciption': 'Descrição Principal 2',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.minor_description = (function($) {

    var make = function() {
        var
            component_name = 'minor_description',
            component_fields = {
                'desciption': 'Descrição Secundária',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.minor_description2 = (function($) {

    var make = function() {
        var
            component_name = 'minor_description2',
            component_fields = {
                'desciption': 'Descrição Secundária 2',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.parcel_paid = (function($) {

    var make = function() {
        var
            component_name = 'parcel_paid',
            component_fields = {
                'integer': '99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.parceled_inline = (function($) {

    var make = function() {
        var
            component_name = 'parceled_inline',
            component_fields = {
                'value': '99x',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.parceled_interest_inline = (function($) {

    var make = function() {
        var
            component_name = 'parceled_interest_inline',
            component_fields = {
                'value': '99x',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.parceled_interest = (function($) {

    var make = function() {
        var
            component_name = 'parceled_interest',
            component_fields = {
                'integer': '99',
                'times': 'x',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.parceled = (function($) {

    var make = function() {
        var
            component_name = 'parceled',
            component_fields = {
                'integer': '99',
                'times': 'x',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.product_code = (function($) {

    var make = function() {
        var
            component_name = 'product_code',
            component_fields = {
                'code': '#999999',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.promotion_description = (function($) {

    var make = function() {
        var
            component_name = 'promotion_description',
            component_fields = {
                'description': 'Descrição Promocional.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.promotion_main_description = (function($) {

    var make = function() {
        var
            component_name = 'promotion_main_description',
            component_fields = {
                'main_description': 'Descrição Principal Promocional.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.promotion_minor_description = (function($) {

    var make = function() {
        var
            component_name = 'promotion_minor_description',
            component_fields = {
                'minor_description': 'Descrição Secundária Promocional.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.promotion_product = (function($) {

    var make = function() {
        var
            component_name = 'promotion_product',
            component_fields = {
                'product': 'Produto Promocional.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.promotion_unit = (function($) {

    var make = function() {
        var
            component_name = 'promotion_unit',
            component_fields = {
                'unit': 'Unidade de Venda Promocional.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.promotion_unit2 = (function($) {

    var make = function() {
        var
            component_name = 'promotion_unit2',
            component_fields = {
                'unit': 'Unidade de Venda Promocional 2.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.promotional_product_value = (function($) {

    var make = function() {
        var component_name = 'promotional_product_value',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.quantity = (function($) {

    var make = function() {
        var
            component_name = 'quantity',
            component_fields = {
                'integer': 'Quantidade.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.quantity2 = (function($) {

    var make = function() {
        var
            component_name = 'quantity2',
            component_fields = {
                'integer': 'Quantidade 2.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.rates_info = (function($) {

    var make = function() {
        var
            component_name = 'rates_info',
            component_fields = {
                'text': 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla dapibus.',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.sales_unit_wholesale = (function($) {

    var make = function() {
        var
            component_name = 'sales_unit_wholesale',
            component_fields = {
                'unit': 'Unidade de venda no atacado',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.sales_unit = (function($) {

    var make = function() {
        var
            component_name = 'sales_unit',
            component_fields = {
                'unit': 'Unidade de venda',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.sales_unit2 = (function($) {

    var make = function() {
        var
            component_name = 'sales_unit2',
            component_fields = {
                'unit': 'Unidade de venda 2',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.spare_inline = (function($) {

    var make = function() {
        var component_name = 'spare_inline';
        var component_fields = {
            'value': '99,99',
        };

        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.spare = (function($) {

    var make = function() {
        var
            component_name = 'spare',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);
PosterEditor.Components.TextComponent = (function($) {

    var make = function() {

        var $new_element = $('<div class="relative-component text-component" data-role="text-component" style="width: 149px; height:24px;">' +
            '<div class="component-content text-left vertical-top text-normal" style="font-family: Arial; font-size: 24px; color: rgb(0, 0, 0);">' +
            '<span>Texto editável</span>' +
            '</div>' +
            '</div>');

        $('#poster-editor').append($new_element);
        $('.relative-component').draggable({containment: 'parent'});
        jscolor.installByClassName('jscolor');

    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.total_term = (function($) {

    var make = function() {
        var
            component_name = 'total_term',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.valid_date_inline = (function($) {

    var make = function() {
        var component_name = 'valid_date_inline',
            component_fields = {
                'text': '01/01/2000 a 01/01/2010',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.valid_from = (function($) {

    var make = function() {
        var
            component_name = 'valid_from',
            component_fields = {
                'date': '00/00/0000',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.valid_until = (function($) {

    var make = function() {
        var
            component_name = 'valid_until',
            component_fields = {
                'date': '00/00/0000',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_cash_inline = (function($) {

    var make = function() {
        var component_name = 'value_cash_inline';
        var component_fields = {
            'value': '99,99',
        };

        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_cash = (function($) {

    var make = function() {
        var
            component_name = 'value_cash',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_cash2 = (function($) {

    var make = function() {
        var
            component_name = 'value_cash2',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_bundle = (function($) {

    var make = function() {
        var
            component_name = 'value_bundle',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_divided = (function($) {

    var make = function() {
        var component_name = 'value_divided',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_old_inline = (function($) {

    var make = function() {
        var component_name = 'value_old_inline';
        var component_fields = {
            'value': '99,99',
        };

        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_old = (function($) {

    var make = function() {
        var component_name = 'value_old',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_old2 = (function($) {

    var make = function() {
        var component_name = 'value_old2',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_old3 = (function($) {

    var make = function() {
        var component_name = 'value_old3',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_plot_interest = (function($) {

    var make = function() {
        var component_name = 'value_plot_interest',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_plot = (function($) {

    var make = function() {
        var component_name = 'value_plot',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_remaining = (function($) {

    var make = function() {
        var component_name = 'value_remaining',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_retail = (function($) {

    var make = function() {
        var component_name = 'value_retail',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_sum = (function($) {

    var make = function() {
        var component_name = 'value_sum',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_wholesale = (function($) {

    var make = function() {
        var component_name = 'value_wholesale',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.Components.value_total_wholesale = (function($) {

    var make = function() {
        var component_name = 'value_total_wholesale',
            component_fields = {
                'integer': '99',
                'decimal': ',99',
            };
        return PosterEditor.Components.RelativeComponent.make(component_name,
            component_fields);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.GeometricComponents.FormComponent = (function($) {
    var make = function(
        component_name, component_svg, width, height, isImage = false) {
        return (!isImage)
            ?
            '<div class="geometric-component" data-role="' + component_name +
            '" style="width:' + width + 'px; height:' + height +
            'px; fill:#000;"><div class="form-content">' + component_svg +
            '</div></div>'

            :
            '<div class="geometric-component" data-role="' + component_name +
            '" style="border: none; width:' + width + 'px; height:' + height +
            'px; fill:#000;"><div class="form-content" style="display:grid;">' +
            component_svg + '</div></div>';
    };
    return {
        make: make,
    };
})(jQuery);
PosterEditor.GeometricComponents.line = (function($) {
    var make = function() {
        var component_name = 'line',
            component_svg = '<svg viewBox="0 0 4 200" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink= "http://www.w3.org/1999/xlink" width="100%" height="100%" stroke="#000" stroke-width="0"><rect width="100%" height="100%" rx="0" ry="0" /></svg>';
        return PosterEditor.GeometricComponents.FormComponent.make(component_name,
            component_svg, 4, 200);
    };
    return {
        make: make,
    };
})(jQuery);
PosterEditor.GeometricComponents.rectangle = (function($) {

    var make = function() {
        var
            component_name = 'rectangle',
            component_svg = '<svg viewBox="0 0 100 40" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink= "http://www.w3.org/1999/xlink" width="100%" height="100%" stroke="#000" stroke-width="0"><rect width="100%" height="100%" rx="0" ry="0" /></svg>';
        return PosterEditor.GeometricComponents.FormComponent.make(component_name,
            component_svg, 100, 40);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.GeometricComponents.square = (function($) {

    var make = function() {
        var
            component_name = 'square',
            component_svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink= "http://www.w3.org/1999/xlink" height="100%" width="100%" stroke="#000" stroke-width="0" viewBox="0 0 100 100"><rect id="redrect" width="100%" height="100%" rx="0" ry="0" /></svg>';
        return PosterEditor.GeometricComponents.FormComponent.make(component_name,
            component_svg, 100, 100);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.GeometricComponents.image = (function($) {

    let make = function() {
        $('[name="has_images"]').val(1);
        let component_name = `image-${++imageCounter}`;
        let img = `<img id="image-${imageCounter}" style="max-width: 100%; max-height: 100%; margin: auto; transform: rotate(0deg)" />`;
        return PosterEditor.GeometricComponents.FormComponent.make(component_name,
            img, 100, 100, true);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.GeometricComponents.ellipse = (function($) {
    var make = function() {
        var component_name = 'ellipse',
            component_svg = ' <svg viewBox="0 0 300 100" height="100%" width="100%" stroke="#000" stroke-width="0"><ellipse cx="50%" cy="50%" rx="50%" ry="50%" /></svg>';
        return PosterEditor.GeometricComponents.FormComponent.make(component_name,
            component_svg, 300, 100);
    };
    return {
        make: make,
    };
})(jQuery);
PosterEditor.GeometricComponents.circle = (function($) {
    var make = function() {
        var component_name = 'circle',
            component_svg = '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink= "http://www.w3.org/1999/xlink" width="100%" height="100%" stroke="#000" stroke-width="0" viewBox="0 0 40 40"><circle cx="50%" cy="50%" r="50%" /></svg>';
        return PosterEditor.GeometricComponents.FormComponent.make(component_name,
            component_svg, 40, 40);
    };
    return {
        make: make,
    };
})(jQuery);
PosterEditor.GeometricComponents.polygon = (function($) {

    var make = function() {
        var
            component_name = 'polygon',
            component_svg = '<svg height="80" width="80" stroke="#000" stroke-width="0"><polygon points="40,0 80,20 80,60 40,80 0,60 0,20" /></svg>';
        return PosterEditor.GeometricComponents.FormComponent.make(component_name,
            component_svg);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.GeometricComponents.star = (function($) {

    var make = function() {
        var
            component_name = 'star',
            component_svg = '<svg viewBox="0 0 300 300" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink= "http://www.w3.org/1999/xlink" width="100%" height="100%" stroke="#000" stroke-width="0"><polygon points="197.553,165.451 245.106,119.098 179.389,109.549 150,50 120.611,109.549 54.8943,119.098 102.447,165.451 91.2215,230.902 150,200 208.779,230.902"/></svg>';
        return PosterEditor.GeometricComponents.FormComponent.make(component_name,
            component_svg, 300, 300);
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.ComponentsFactory = (function($) {

    var getCampaingFieldBorderBottomColor = function(componentName) {
        return $('[data-component="' + componentName + '"]').
        css('border-bottom-color');
    };

    var setWidth = function(componentName) {
        var w, h;
        $('[data-role="' + componentName + '"]').each(function(index, element) {
            w = $(element).children('.component-content').outerWidth();
            h = $(element).children('.component-content').outerHeight();
            $(element).css('width', w + 6);
            $(element).css('height', h);
        });
    };

    var setComponentTitle = function(componentName) {
        $('[data-role="' + componentName + '"]').
        attr('title', 'Campo: ' + getCampaingFieldHtmlText(componentName));
    };

    var getCampaingFieldHtmlText = function(componentName) {
        return $('[data-component="' + componentName + '"]').html();
    };

    var disableCampaignField = function(componentName) {
        $('[data-component="' + componentName + '"]').
        prop('disabled', true).
        addClass('disabled');
    };

    var pushComponent = function(newElement) {
        $('#poster-editor').append(newElement);
    };

    var initNewComponent = function() {
        $('.relative-component').draggable({containment: 'parent'});
    };

    let make = function(element) {
        const componentName = element.data('component');
        const $new_element = PosterEditor.Components[componentName].make();

        disableCampaignField(componentName);
        pushComponent($new_element);
        setComponentTitle(componentName);
        setWidth(componentName);
        initNewComponent();

    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.GeometricComponentsFactory = (function($) {

    var pushComponent = function(newElement) {
        $('#poster-editor').append(newElement);
    };

    var initNewComponent = function() {
        $('.geometric-component').draggable({containment: 'parent'});
    };

    let make = function(element) {
        let componentName = element.val();
        const $new_element = PosterEditor.GeometricComponents[componentName].make();
        pushComponent($new_element);
        initNewComponent();
    };

    return {
        make: make,
    };

})(jQuery);

PosterEditor.BodyMask.event = (function($) {

    var onlyNumber = function(e) {
        var keybottom = e.which;
        if ((keybottom > 47 && keybottom < 58) ||
            (keybottom > 95 && keybottom < 106)) {
            return true;
        } else {
            var keybottomAllowed = [8, 0, 9, 91, 37, 38, 39, 40];
            if (keybottomAllowed.indexOf(keybottom) > -1) {
                return true;
            } else {
                return false;
            }
        }
    };

    return {
        onlyNumber: onlyNumber,
    };

})(jQuery);

PosterEditor.Behaviors.PosterZoom = (function($) {

    var currentZoom = function() {
        if ($('.poster-editor').css('transform') != 'none') {
            var transform = $('.poster-editor').css('transform').split(',');
            return (transform[3] <= .1) ? 1 : parseFloat(transform[3]);
        }
        return 1;
    };

    var zoomReset = function() {
        let posterEditor = $('.poster-editor');
        posterEditor.css('transform', 'scale(1)');
        var scale = currentZoom();

        $('.ruler-h').css('width', `${posterEditor.width() * scale} !important`);
        $('.ruler-v').css('height', `${posterEditor.height() * scale} !important`);

        $('.grid-rulers').css('transform', 'scale(' + scale + ')');
    };

    var zoomIn = function() {
        let posterEditor = $('.poster-editor');
        let rulerH = $('.ruler-h');
        let rulerV = $('.ruler-v');
        var scale = currentZoom() + .1;

        rulerH.css('width', `${posterEditor.width() * scale} !important`);
        rulerV.css('height', `${posterEditor.height() * scale} !important`);

        posterEditor.css('transform', 'scale(' + scale + ')');

        $('.grid-rulers').css('transform', 'scale(' + scale + ')');

    };

    var zoomOut = function() {
        let posterEditor = $('.poster-editor');
        let rulerH = $('.ruler-h');
        let rulerV = $('.ruler-v');
        var scale = currentZoom() - .1;

        rulerH.css('width', `${posterEditor.width() * scale} !important`);
        rulerV.css('height', `${posterEditor.height() * scale} !important`);

        posterEditor.css('transform', 'scale(' + scale + ')');

        $('.grid-rulers').css('transform', 'scale(' + scale + ')');

    };

    var dragWithZoom = function(element) {
        var click = {
            x: 0,
            y: 0,
        };

        element.draggable({
            start: function(event) {
                click.x = event.clientX;
                click.y = event.clientY;
            },

            drag: function(event, ui) {
                let zoom = currentZoom();
                let originalPosition = ui.originalPosition;

                let left = (event.clientX - click.x + originalPosition.left) / zoom;
                let componentWidthPx = +ui.helper[0].style.width.replace('px', '');
                let widthParentPx = +$('#poster-editor').width();

                let top = (event.clientY - click.y + originalPosition.top) / zoom;
                let componentHeightPx = +ui.helper[0].style.height.replace('px', '');
                let heightParentPx = +$('#poster-editor').height();

                let limitY = heightParentPx - componentHeightPx;
                let limitX = widthParentPx - componentWidthPx;

                if (ui.position.left > 0) {
                    ui.position.left = (left <= limitX) ? left : limitX;
                }

                if (ui.position.top > 0) {
                    ui.position.top = (top <= limitY) ? top : limitY;
                }
            },

        });
    };

    return {
        zoomIn: zoomIn,
        zoomOut: zoomOut,
        zoomReset: zoomReset,
        dragWithZoom: dragWithZoom,
    };

})(jQuery);
PosterEditor.CampaignSelect.event = (function($, fields) {

    var onChangeCampaign = function() {
        fields.addFieldList().then(function(data) {
            let selected_campaign_fields = JSON.parse(data);
            selected_campaign_fields = $.map(selected_campaign_fields,
                function(element) {
                    return element.field_id;
                });

            $('.relative-component').map(function(index, element) {
                const field_id = element.getAttribute('data-role');
                const contains_field_in_campaign = ($.inArray(field_id,
                    selected_campaign_fields) >= 0);
                if (!contains_field_in_campaign &&
                    !element.classList.contains('component-line') &&
                    !element.classList.contains('text-component') &&
                    !element.classList.contains('marked-text-component')) {
                    const $relative_component = $(element);
                    $relative_component.remove();
                }
            });
        });
    };

    return {
        onChangeCampaign: onChangeCampaign,
    };

})(jQuery, PosterEditor.Fields);

PosterEditor.ThemeSelect.event = (function($, panel) {

    var onChangeTheme = function(e) {
        panel.addBackgroundImage(e);
    };

    return {
        onChangeTheme: onChangeTheme,
    };

})(jQuery, PosterEditor.Panel);

PosterEditor.Behaviors.GridRuler = (function($) {

    var toggleGrid = function() {
        if ($('#poster-editor').hasClass('grid-off') ||
            $('#poster-editor').hasClass('grid-plus')) {
            addGrid();
        } else {
            removeGrid();
        }
    };

    var toggleGridPlus = function() {
        if ($('#poster-editor').hasClass('grid-plus')) {
            removeGrid();
        } else {
            addGridPlus();
        }
    };

    var addGrid = function() {
        $('button[name="show-grid-plus"]').removeClass('active');
        $('button[name="show-grid"]').addClass('active');
        $('#poster-editor').removeClass('grid-plus grid-off');
    };

    var addGridPlus = function() {
        $('button[name="show-grid"]').removeClass('active');
        $('button[name="show-grid-plus"]').addClass('active');
        $('#poster-editor').removeClass('grid-off').addClass('grid-plus');
    };

    var removeGrid = function() {
        $('button[name="show-grid-plus"]').removeClass('active');
        $('button[name="show-grid"]').removeClass('active');
        $('#poster-editor').removeClass('grid-plus');
        $('#poster-editor').addClass('grid-off');
    };

    var removeRulers = function() {
        removeGrid();
        $('.grid-rulers').html('');
    };

    var addVerticalRuler = function() {
        $('.grid-rulers').
        append(
            '<div class="ruler-v" style="left:10px; z-index: 2000;" title="Dê dois cliques para excluir"></div>');
        $('.ruler-v').draggable({containment: 'parent'});
    };

    var addHorizontalRuler = function() {
        $('.grid-rulers').
        append(
            '<div class="ruler-h" style="top:10px; z-index: 2000;" title="Dê dois cliques para excluir"></div>');
        $('.ruler-h').draggable({axis: 'y'});
    };

    var removeRuler = function(element) {
        $(element).remove();
    };

    return {
        toggleGrid: toggleGrid,
        toggleGridPlus: toggleGridPlus,
        addGrid: addGrid,
        removeGrid: removeGrid,
        removeRulers: removeRulers,
        addVerticalRuler: addVerticalRuler,
        addHorizontalRuler: addHorizontalRuler,
        removeRuler: removeRuler,
    };

})(jQuery);

PosterEditor.Behaviors.ComponentSelected = (function($, ajax) {
    let removeHiddenCondition = function(element) {
        let componentSelected = $('.component-selected');
        const dataId = componentSelected.attr('data-id');
        $('.component-properties').
        children('.input-group-btn').
        children('input[name="condition"]').
        val('');
        $('.component-properties [name~=operator-conditional]').val(0);
        $('.component-properties [name~=dataroles-conditional]').val(0);

        if (dataId !== undefined) {
            $('meta[data-id=' + dataId + ']').remove();
            componentSelected.removeAttr('data-id');
            var flash_message = $('.flash-message');
            flash_message.html(
                `<div class="alert alert-success">Condição removida com sucesso
  		              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  		                  <span aria-hidden="true">×</span>
  		              </button>
  		          </div>`);
            flash_message.show(50);
            setTimeout(function() {
                flash_message.slideUp(400);
            }, 1500);
        }
    };

    let addNewHiddenConditional = function(element) {
        const dataroleCondiional = $(
            '.component-properties #dataroles-conditional').val();
        const operatorCondiional = $('.component-properties #operator-conditional').
        val();
        const conditionValue = $('.component-properties #condition').val();

        const condition = dataroleCondiional + ' ' + operatorCondiional + ' \'' +
            conditionValue + '\'';

        const test_condition = /([a-z0-9_]*)\s{1}([!=<>][=]?[=]?)\s{1}([^\s])/;
        let flash_message = $('.flash-message');
        if (test_condition.test(condition)) {
            let divMetaData = $('div #meta-data');

            if (divMetaData.length === 0) {
                $('#poster-editor').
                append('<div id="meta-data" style="display: none;"></div>');
                divMetaData = $('div #meta-data');
            }

            let componentSelected = $('.component-selected');
            const oldDataId = componentSelected.attr('data-id');

            if (oldDataId === undefined) {
                const dataId = generateRandomId('data-id');
                const dataElementId = generateRandomId('data-element-id');
                componentSelected.attr('data-id', dataId);
                divMetaData.append('<meta data-id="' + dataId + '" data-element-id="' +
                    dataElementId + '" data-trigger="' + condition + '">');
            } else {
                $('meta[data-id=' + oldDataId + ']').attr('data-trigger', condition);
            }
            flash_message.html(
                `<div class="alert alert-success">Condição salva com sucesso
  		              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  		                  <span aria-hidden="true">×</span>
  		              </button>
  		          </div>`);
            flash_message.show(50);
        } else {
            flash_message.html(
                `<div class="alert alert-danger">Selecione valores válidos para condição para esconder
  		                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  		                    <span aria-hidden="true">×</span>
  		                </button>
  		            </div>`);
            flash_message.show(50);
        }
        setTimeout(function() {
            flash_message.slideUp(400);
        }, 1500);
    };

    var generateRandomId = function(attribute) {
        while (true) {
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';
            var randomId = '';
            for (var i = 0; i < 6; i++) {
                var rnum = Math.floor(Math.random() * letters.length);
                randomId += letters.substring(rnum, rnum + 1);
            }
            if ($('[' + attribute + ' = ' + randomId + ']').length === 0)
                return randomId;
        }
    };

    var markAsSelected = function(element) {
        if (!hasClassRelativeComponent(element)) {
            closeAllComponents();
        } else {
            toggleComponentSelected(element);
        }
    };

    var closeAllComponents = function() {
        if (checkComponentSelected()) {
            deselectAllComponents();
        }
    };

    var toggleComponentSelected = function(element) {
        if (hasClassComponentSelected(element)) {
            closeComponent(element);
        } else {
            initComponent(element);
        }
    };

    var closeComponent = function(element) {
        setTextToComponent(element);
        destroyComponentProperties(element);
        disableResizable(element);
        disableRotatable(element);
        removeClassComponentSelected(element);
    };

    var destroyComponentProperties = function(element) {
        $('.component-properties').remove();
    };

    var checkComponentSelected = function() {
        return ($('.component-selected').length > 0);
    };

    var initComponent = function(element) {
        closeAllComponents();
        addComponentProperties(element);
        setComponentProperties(element);
        enableResizable(element);
        enableRotatable(element);
        enableJsColor();
        addClassComponentSelected(element);
        setInitialPosition(element);
    };

    var addComponentProperties = function(element) {
        if ($('.poster-block').hasClass('component-properties')) {
            $('.component-properties').remove();
        }
        let role = $(element).attr('data-role');
        var classInput = (role === 'discount' || role === 'discount_bundle') ?
            'checkPercent' :
            '';
        if (role === 'line') {
            $('.poster-block').append(componentLineProperties());
        } else {
            $('.poster-block').append(componentProperties());
        }
    };

    let setHiddenConditionalsProperty = function() {
        let element = $('.component-selected');
        if ($(element).attr('data-id')) {
            const oldDataId = $(element).attr('data-id');
            const textsCondition = $('meta[data-id=' + oldDataId + ']').
            attr('data-trigger');
            let condition = textsCondition.split(' ');
            condition[2] = textsCondition.split('\'')[1];
            $('.component-properties').
            children('.input-group-btn').
            children('input[name="condition"]').
            val(condition[2].replace(/'/g, ''));
            $('.component-properties [name~=operator-conditional]').val(condition[1]);
            $('.component-properties [name~=dataroles-conditional]').
            val(condition[0]);
        }
    };

    var setComponentProperties = function(element) {

        const $componentContent = $(element).children('.component-content');
        const $componentProperties = $('.component-properties').
        children('.input-group-btn');
        if ($componentContent.hasClass('bold')) {
            $componentProperties.children('button[name="bold"]').addClass('active');
        }

        if ($componentContent.hasClass('italic')) {
            $componentProperties.children('button[name="italic"]').addClass('active');
        }

        if ($componentContent.hasClass('underline')) {
            $componentProperties.children('button[name="underline"]').
            addClass('active');
        }

        if ($componentContent.hasClass('strikethrough')) {
            $componentProperties.children('button[name="strikethrough"]').
            addClass('active');
        }

        if ($componentContent.hasClass('vertical-top')) {
            $componentProperties.children('.btn-up').addClass('active');
        }

        if ($componentContent.hasClass('vertical-bottom')) {
            $componentProperties.children('.btn-down').addClass('active');
        }

        if ($componentContent.hasClass('vertical-center')) {
            $componentProperties.children('.btn-center').addClass('active');
        }

        if ($componentContent.hasClass('text-subscript')) {
            $componentProperties.children('button[name="text-subscript"]').
            addClass('active');
        }
        if ($componentContent.hasClass('text-superscript')) {
            $componentProperties.children('button[name="text-superscript"]').
            addClass('active');
        }

        const textAlign = $componentContent.css('text-align');
        $componentProperties.children('button[value="' + textAlign + '"]').
        addClass('active');

        const fontFamily = $componentContent.css('font-family').
        replace(/['"]+/g, '');
        $('.component-properties [name~=font-family]').val(fontFamily);

        const fontSize = $componentContent.css('font-size').replace(/[^0-9]/g, '');
        $componentProperties.children('input[name="font-size"]').val(fontSize);

        const fontColor = $componentContent.css('color');
        $('.jscolor').css('background-color', fontColor).attr('value', fontColor);

        const diagonalColor = $componentContent.children('.text-diagonal-striped').
        css('background-color');
        $('input[name="diagonal-color"]').
        css('background-color', diagonalColor).
        attr('value', diagonalColor);
        if ($componentContent.children('.text-diagonal-striped').length > 0) {
            $('.component-properties').
            children('.input-group').
            children('.btn-diagonal').
            addClass('active');
        }

        let spanTexts = '';
        $componentContent.children('span').each(function(index, element) {
            spanTexts += $(element).html();
        });
        spanTexts = spanTexts.replace(/<br>/g, '\n');
        if ($(element).hasClass('marked-text-component')) {
            spanTexts = transformAliasTagInMarkup(spanTexts);
        }

        $componentProperties.children('textarea[name="html"]').val(spanTexts);
    };

    var enableJsColor = function() {
        jscolor.installByClassName('jscolor');
    };

    let transformAliasTagInMarkup = function(spanText) {
        let $span = $('<span>' + spanText + '</span>');
        $('alias', $span).each(function(index, element) {
            let value = $(element).attr('value');
            let text = $(element).attr('text');
            if (text) {
                $(element).text('{' + value + ':' + text + '}');
            } else {
                $(element).text('{' + value + '}');
            }
        });

        $($span).unwrap('alias');

        return $span.text();
    };

    let transformMarkupInAliasTag = function(text) {
        if (text) {
            let regex_delimited_tag_with_preview = /\{([0-9A-Z._]+?):(.+?)\}/g;
            let regex_delimited_tag_without_preview = /\{([0-9A-Z._]+?)\}/g;

            let replace_with_html_tag_preview = '<alias value="$1" text="$2" title="$1">$2</alias>';
            let replace_with_html_tag_no_preview = '<alias value="$1">{$1}</alias>';

            let manipulated_text = text.replace(regex_delimited_tag_with_preview,
                replace_with_html_tag_preview);
            manipulated_text = manipulated_text.replace(
                regex_delimited_tag_without_preview, replace_with_html_tag_no_preview);

            return manipulated_text;
        }
    };

    var deselectAllComponents = function() {
        $('.component-selected').each(function(index, element) {
            closeComponent(element);
        });
    };

    var initResizable = function(element) {
        var maxWidth = $('#poster-editor').width(),
            resizable_options = {
                containment: 'parent',
                maxWidth: maxWidth,
                minWidth: 1,
                minHeight: 1,
            };
        $(element).resizable(resizable_options);
    };

    var checkIsResizable = function(element) {
        return $(element).hasClass('ui-resizable');
    };

    var enableResizable = function(element) {
        if (checkIsResizable(element)) {
            $('.ui-resizable-handle').remove();
        }
        initResizable(element);
    };

    var disableResizable = function(element) {
        if (checkIsResizable(element)) {
            $('.ui-resizable-handle').remove();
            $(element).resizable('destroy');
        }
    };

    var initRotatable = function(element) {
        var rotatable_options = {
            wheelRotate: false,
        };
        $(element).children('.component-content').rotatable(rotatable_options);
    };

    var checkIsRotatable = function(element) {
        return ($(element).
        children('.component-content').
        children('div').
        hasClass('ui-rotatable-handle'));
    };

    var enableRotatable = function(element) {
        if (checkIsRotatable(element)) {
            $('.ui-rotatable-handle').remove();
        }
        initRotatable(element);

    };

    var disableRotatable = function(element) {
        if (checkIsRotatable(element)) {
            $('.ui-rotatable-handle').remove();
            $(element).children('.component-content').rotatable('destroy');
        }
    };

    var setTextToComponent = function(element) {
        const text_component = document.querySelector(
            '.component-properties textarea[name="html"]');
        let text_component_value = '';
        if (text_component) {
            text_component_value = text_component.value;
        }
        const spans = $(element).children('.component-content').children('span');

        if (spans.length > 1) {
            let integer = '0';
            if ($(spans[1]).hasClass('decimal')) {
                let decimal = '00', value = text_component_value.split(',');
                integer = (value[0]) ? value[0] : integer;
                $(spans[0]).html(integer);
                decimal = (value[1]) ? value[1] : decimal;
                if (spans[1]) {
                    $(spans[1]).html(',' + decimal);
                }
            } else {
                let value = text_component_value.replace(/[^0-9]/g, '');
                $(spans[0]).html(value);
                $(spans[1]).html(text_component_value.replace(value, ''));
            }
        } else {
            if ($(element).hasClass('marked-text-component')) {
                text_component_value = transformMarkupInAliasTag(text_component_value);
            }
            text_component_value = text_component_value.replace(/[\n]/g, '<br>');
            $(spans[0]).html(text_component_value);
        }
    };

    var hasClassComponentSelected = function(element) {
        return $(element).hasClass('component-selected');
    };

    var hasClassRelativeComponent = function(element) {
        return $(element).hasClass('relative-component');
    };

    var removeClassComponentSelected = function(element) {
        $(element).removeClass('component-selected');
    };

    var addClassComponentSelected = function(element) {
        $(element).addClass('component-selected');
    };

    var setInitialPosition = function(element) {
        const componentAttributes = document.querySelector('.component-attributes');
        const componentProperties = $('.component-properties');
        const topComponent = componentAttributes.getBoundingClientRect().top;
        const leftComponent = componentAttributes.getBoundingClientRect().left;

        componentProperties.css({top: topComponent});
        componentProperties.css({left: leftComponent});
    };

    var componentFonts = function() {
        var fonts = JSON.parse($('#fonts').val());

        return fonts.map(function(item) {
            return '<option value="' + item.name + '" >' + item.name + '</option>';
        }).join('');
    };

    var componentProperties = function(isLine) {
        let result = '' +
            '<div class="component-properties">' +
            '    <div class="input-group-btn">' +
            '        <textarea type="text" name="html" class="form-control textarea-editor" value=""></textarea>' +
            '        <select class="form-control" name="font-family" title="Fonte">' +
            componentFonts() + '</select>' +
            '        <input type="text" class="form-control onlyNumber" name="font-size" title="Tamanho de fonte" />' +
            '        <button name="bold" type="button" class="btn btn-default btn-xs" aria-label="Bold" title="Bold">' +
            '            <span class="fa fa-bold"></span>' +
            '        </button>' +
            '        <button name="italic" type="button" class="btn btn-default btn-xs" aria-label="Italic" title="Itálico">' +
            '            <span class="fa fa-italic"></span>' +
            '        </button>' +
            '        <button name="underline" type="button" class="btn btn-default btn-xs" aria-label="Underline" title="Underline">' +
            '            <span class="fa fa-underline"></span>' +
            '        </button>' +
            '        <button name="strikethrough" type="button" class="btn btn-default btn-xs" aria-label="Strikethrough" title="Strikethrough">' +
            '            <span class="fa fa-strikethrough"></span>' +
            '        </button>' +
            '        <button name="text-normal" type="button" class="btn btn-default btn-xs text-sup-sub" aria-label="Texto linear" title="Texto linear">' +
            '            0,00' +
            '        </button>' +
            '        <button name="text-superscript" type="button" class="btn btn-default btn-xs text-sup-sub" aria-label="Texto Sobrescrito" title="Texto sobrescrito">' +
            '            0<sup>,00</sup>' +
            '        </button>' +
            '        <button name="text-subscript" type="button" class="btn btn-default btn-xs text-sup-sub" aria-label="Texto subescrito" title="Texto subescrito">' +
            '            0<sub>,00</sub>' +
            '        </button>' +
            '        <button name="up-cent" type="button" class="btn btn-default btn-xs" aria-label="Ajustar centavos para cima" title="Ajustar cantavos para cima">' +
            '           <i class="fa fa-angle-up"></i>' +
            '        </button>' +
            '        <button name="down-cent" type="button" class="btn btn-default btn-xs" aria-label="Ajustar centavos para baixo" title="Ajustar cantavos para baixo">' +
            '           <i class="fa fa-angle-down"></i>' +
            '        </button>' +
            '        <button type="button" name="text-align" class="btn btn-default btn-xs" aria-label="Alinhamento a esquerda" title="Alinhamento a esquerda" value="left">' +
            '            <i class="fa fa-align-left"></i>' +
            '        </button>' +
            '        <button type="button" name="text-align" class="btn btn-default btn-xs" aria-label="Alinhamento centralizado" title="Alinhamento centralizado" value="center">' +
            '            <i class="fa fa-align-center"></i>' +
            '        </button>' +
            '        <button type="button" name="text-align" class="btn btn-default btn-xs" aria-label="Alinhamento direita" title="Alinhamento direita" value="right">' +
            '            <i class="fa fa-align-right"></i>' +
            '        </button>' +
            '        <span class="btn btn-primary btn-xs btn-up" title="Alinhar para cima">' +
            '            <i class="fa fa-long-arrow-up"></i>' +
            '        </span>' +
            '        <span class="btn btn-primary btn-xs btn-down" title="Alinhar para baixo">' +
            '            <i class="fa fa-long-arrow-down"></i>' +
            '        </span>' +
            '        <span class="btn btn-primary btn-xs btn-center" title="Alinhar ao centro">' +
            '            <i class="fa fa-arrows-v"></i>' +
            '        </span>' +
            '        <input type="text" class="jscolor {hash:true}" value="000000" name="color" title="Cor da fonte">' +
            '        <span class="btn btn-default btn-xs btn-diagonal" title="Linha Diagonal">' +
            '            <i class="fa fa-minus" aria-hidden="true"></i>' +
            '        </span>' +
            '        <input type="text" class="jscolor {hash:true}" value="000000" name="diagonal-color" title="Cor Linha Diagonal">' +
            '        <span class="btn btn-danger btn-xs btn-trash" title="Excluir elemento">' +
            '            <i class="fa fa-trash"></i>' +
            '        </span>' +
            '        <span class="btn btn-warning btn-xs btn-close" title="Fechar caixa de ferramenta">' +
            '            <i class="fa fa-close"></i>' +
            '        </span>' +
            '        <select class="form-control" name="dataroles-conditional" id="dataroles-conditional" title="Condição">' +
            datarolesCampaign() + '</select>' +
            '        <select class="form-control" name="operator-conditional" id="operator-conditional" title="Condição">' +
            '           <option value="" disabled selected></option>' +
            '           <option value="==">Igual a</option>' +
            '           <option value="!=">Diferente de</option>' +
            '           <option value="<">Menor que</option>' +
            '           <option value=">">Maior que</option>' +
            '           <option value=">=">Maior igual que</option>' +
            '           <option value="<=">Menor igual que</option>' +
            '        </select>' +
            '        <input type="text" id="condition" name="condition" class="form-control" value="">' +
            '        <span class="btn btn-warning btn-xs btn-display-condition" title="Salvar condição de visualização">' +
            '            <i class="fa fa-plus"></i>' +
            '        </span>' +
            '        <span class="btn btn-danger btn-xs btn-remove-condition" title="Remover condição de visualização">' +
            '            <i class="fa fa-close"></i>' +
            '        </span>' +
            '    </div>' +
            '</div>';

        return result;
    };

    var datarolesCampaign = function() {
        const fieldsJson = ajax.getDatarolesByCampaign();
        let fields;
        let options = [];
        return fieldsJson.then((response) => {
            fields = JSON.parse(response);
            options = fields.map(function(item) {
                return `<option value="${item.field_id}">${item.name}</option>`;
            });
            options.unshift('<option value="" disabled selected></option>');
            options.push(
                '<option value="with_down_payment_condition">Com entrada</option>');
            $('#dataroles-conditional').html(options);
            setHiddenConditionalsProperty();
        });
    };

    var componentLineProperties = function() {
        return '<div class="component-properties">' +
            '<div class="input-group-btn">' +
            '<span class="btn btn-danger btn-xs btn-trash">' +
            '<i class="fa fa-trash"></i>' +
            '</span>' +
            '<span class="btn btn-warning btn-xs btn-close">' +
            '<i class="fa fa-close"></i>' +
            '</span>' +
            '</div>' +
            '<div class="input-group">' +
            '<input type="text" class="jscolor {hash:true}" value="000000" name="color" title="Cor da fonte">' +
            '</div>' +
            '</div>';
    };

    return {
        markAsSelected: markAsSelected,
        addNewHiddenConditional: addNewHiddenConditional,
        removeHiddenCondition: removeHiddenCondition,
        closeAllComponents: closeAllComponents,
    };

})(jQuery, PosterEditor.CampaignFieldsAjax);

PosterEditor.Behaviors.FormSelected = (function($, ajax) {
    let removeHiddenCondition = function(element) {
        let formSelected = $('.form-selected');
        const dataId = formSelected.attr('data-id');
        $('.form-properties').
        children('.input-group-btn').
        children('input[name="form-condition"]').
        val('');
        $('.form-properties [name~=form-operator-conditional]').val(0);
        $('.form-properties [name~=form-dataroles-conditional]').val(0);

        if (dataId !== undefined) {
            $('meta[data-id=' + dataId + ']').remove();
            formSelected.removeAttr('data-id');
            var flash_message = $('.flash-message');
            flash_message.html(
                `<div class="alert alert-success">Condição removida com sucesso
  		              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  		                  <span aria-hidden="true">×</span>
  		              </button>
  		          </div>`);
            flash_message.show(50);
            setTimeout(function() {
                flash_message.slideUp(400);
            }, 1500);
        }
    };

    let addNewHiddenConditional = function(element) {
        const dataroleCondiional = $(
            '.form-properties #form-dataroles-conditional').val();
        const operatorCondiional = $('.form-properties #form-operator-conditional').
        val();
        const conditionValue = $('.form-properties #form-condition').val();

        const condition = dataroleCondiional + ' ' + operatorCondiional + ' \'' +
            conditionValue + '\'';

        const test_condition = /([a-z0-9_]*)\s{1}([!=<>][=]?[=]?)\s{1}([^\s])/;
        let flash_message = $('.flash-message');
        if (test_condition.test(condition)) {
            let divMetaData = $('div #meta-data');

            if (divMetaData.length === 0) {
                $('#poster-editor').
                append('<div id="meta-data" style="display: none;"></div>');
                divMetaData = $('div #meta-data');
            }

            let formSelected = $('.form-selected');
            const oldDataId = formSelected.attr('data-id');

            if (oldDataId === undefined) {
                const dataId = generateRandomId('data-id');
                const dataElementId = generateRandomId('data-element-id');
                formSelected.attr('data-id', dataId);
                divMetaData.append('<meta data-id="' + dataId + '" data-element-id="' +
                    dataElementId + '" data-trigger="' + condition + '">');
            } else {
                $('meta[data-id=' + oldDataId + ']').attr('data-trigger', condition);
            }
            flash_message.html(
                `<div class="alert alert-success">Condição salva com sucesso
  		              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  		                  <span aria-hidden="true">×</span>
  		              </button>
  		          </div>`);
            flash_message.show(50);
        } else {
            flash_message.html(
                `<div class="alert alert-danger">Selecione valores válidos para condição para esconder
  		                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  		                    <span aria-hidden="true">×</span>
  		                </button>
  		            </div>`);
            flash_message.show(50);
        }
        setTimeout(function() {
            flash_message.slideUp(400);
        }, 1500);
    };

    var generateRandomId = function(attribute) {
        while (true) {
            const letters = 'ABCDEFGHIJKLMNOPQRSTUVWXTZabcdefghiklmnopqrstuvwxyz';
            var randomId = '';
            for (var i = 0; i < 6; i++) {
                var rnum = Math.floor(Math.random() * letters.length);
                randomId += letters.substring(rnum, rnum + 1);
            }
            if ($('[' + attribute + ' = ' + randomId + ']').length === 0)
                return randomId;
        }
    };
    var markAsSelected = function(element) {
        if (!hasClassGeometricComponent(element)) {
            closeAllForms();
        } else {
            toggleFormSelected(element);
        }
    };
    var closeAllForms = function() {
        if (checkFormSelected()) {
            deselectAllForms();
        }
    };
    var toggleFormSelected = function(element) {
        if (hasClassFormSelected(element)) {
            closeForm(element);
        } else {
            initForm(element);
        }
    };
    var closeForm = function(element) {
        destroyFormProperties(element);
        disableResizable(element);
        disableRotatable(element);
        removeClassFormSelected(element);
    };
    var destroyFormProperties = function(element) {
        $('.form-properties').remove();
    };
    var checkFormSelected = function() {
        return ($('.form-selected').length > 0);
    };
    var initForm = function(element) {
        closeAllForms();
        addFormProperties(element);
        setFormProperties(element);
        enableResizable(element);
        enableRotatable(element);
        enableJsColor();
        addClassFormSelected(element);
        setInitialPosition(element);
    };

    var setInitialPosition = function(element) {
        var componentAttributes = document.querySelector('.component-attributes');
        var formProperties = $('.form-properties');
        var topComponent = componentAttributes.getBoundingClientRect().top;
        var leftComponent = componentAttributes.getBoundingClientRect().left;

        formProperties.css({top: topComponent});
        formProperties.css({left: leftComponent});
    };

    var addFormProperties = function(element) {
        if ($(element).children().hasClass('form-properties')) {
            $(element).children('.form-properties').remove();
        }
        $('.poster-block').append(formProperties($(element).attr('data-role')));
    };
    var setFormProperties = function(element) {
        let inputGroup = $('.form-properties').children('.input-group');
        var svg = $(element).children('.form-content').children('svg');
        if ($(svg).css('fill') == 'rgba(0, 0, 0, 0)') {
            $('.form-properties').
            children('.input-group-btn').
            children('.btn-transparent').
            addClass('active');
        } else {
            $('.form-properties').
            children('.input-group').
            children('input[name="fill"]').
            val($(svg).css('fill'));
        }
        if (svg.length > 0) {
            inputGroup.children('input[name="stroke-width"]').
            val($(svg).css('stroke-width').replace(/[^0-9]/g, ''));

            inputGroup.children('input[name="border-radius"]').
            val($(svg).children().attr('rx'));

            inputGroup.children('input[name="width"]').
            val($(element).css('width').replace(/[^0-9]/g, ''));
            inputGroup.children('input[name="height"]').
            val($(element).css('height').replace(/[^0-9]/g, ''));
            inputGroup.children('input[name="stroke"]').val($(svg).css('stroke'));
        }
    };
    var enableJsColor = function() {
        jscolor.installByClassName('jscolor');
    };
    var deselectAllForms = function() {
        $('.form-selected').each(function(index, element) {
            closeForm(element);
        });
    };
    var initResizable = function(element) {
        var maxWidth = $('#poster-editor').width(),
            dataRole = $(element).attr('data-role'),
            resizable_options = {
                containment: 'parent',
                maxWidth: maxWidth,
                minWidth: 1,
                minHeight: 1,
            };
        if (dataRole == 'circle' || dataRole == 'square' || dataRole == 'star') {
            resizable_options.aspectRatio = true;
        }
        $(element).resizable(resizable_options);
    };
    var checkIsResizable = function(element) {
        return $(element).hasClass('ui-resizable');
    };
    var enableResizable = function(element) {
        if (checkIsResizable(element)) {
            $(element).resizable('enable');
        } else {
            initResizable(element);
        }
    };
    var disableResizable = function(element) {
        if (checkIsResizable(element)) {
            $(element).resizable('destroy');
        }
    };
    var initRotatable = function(element) {
        var rotatable_options = {
            wheelRotate: false,
        };
        $(element).children('.form-content').rotatable(rotatable_options);
    };
    var checkIsRotatable = function(element) {
        return ($(element).
        children('.form-content').
        children('div').
        hasClass('ui-rotatable-handle'));
    };
    var enableRotatable = function(element) {
        if (checkIsRotatable(element)) {
            $(element).children('.form-content').rotatable('enable');
        } else {
            initRotatable(element);
        }
    };
    var disableRotatable = function(element) {
        if (checkIsRotatable(element)) {
            $(element).children('.form-content').rotatable('destroy');
        }
    };
    var hasClassFormSelected = function(element) {
        return $(element).hasClass('form-selected');
    };
    var hasClassGeometricComponent = function(element) {
        return $(element).hasClass('geometric-component');
    };
    var removeClassFormSelected = function(element) {
        $(element).removeClass('form-selected');
    };
    var addClassFormSelected = function(element) {
        $(element).addClass('form-selected');
    };
    var formProperties = function(format) {
        var propertiesBox = '<div class="form-properties">' +
            '<div class="input-group-btn pull-left">' +
            '<span class="btn btn-default btn-xs btn-transparent" name="transparent" title="Remover cor de fundo">X</span>' +
            '</div>' +
            '<div class="input-group">' +
            '<input type="text" class="jscolor {hash:true}" value="000000" name="fill" title="Cor de fundo">' +
            '<input type="text" class="form-control" value="0" name="width" title="Largura">' +
            '<input type="text" class="form-control" value="0" name="height" title="Altura">' +
            '</div>';

        if (format != 'line') {
            propertiesBox += '<div class="input-group pull-left">' +
                '<input type="text" class="form-control" value="0" name="stroke-width" title="Tamanho da borda">';

            if (format != 'circle' && format != 'ellipse') {
                propertiesBox += '<input type="text" class="form-control" value="0" name="border-radius" title="Raio da borda">';
            }

            propertiesBox += '<input type="text" class="jscolor {hash:true}" value="000000" name="stroke" title="Cor de borda">' +
                '</div>';
        }

        propertiesBox += '<div class="input-group-btn">' +
            '<span class="btn btn-danger btn-xs btn-trash" title="Excluir elemento">' +
            '<i class="fa fa-trash"></i>' +
            '</span>' +
            '<span class="btn btn-warning btn-xs btn-close" title="Fechar caixa de ferramenta">' +
            '<i class="fa fa-close"></i>' +
            '</span>' +
            '<select class="form-control" name="form-dataroles-conditional" id="form-dataroles-conditional" title="Condição">' +
            datarolesCampaign() + '</select>' +
            '<select class="form-control" name="form-operator-conditional" id="form-operator-conditional" title="Condição">' +
            '   <option value="" disabled selected></option>' +
            '   <option value="==">Igual a</option>' +
            '   <option value="!=">Diferente de</option>' +
            '   <option value="<">Menor que</option>' +
            '   <option value=">">Maior que</option>' +
            '   <option value=">=">Maior igual que</option>' +
            '   <option value="<=">Menor igual que</option>' +
            '</select>' +
            '<input type="text" id="form-condition" name="form-condition" class="form-control" value="">' +
            '<span class="btn btn-warning btn-xs btn-display-condition" title="Salvar condição de visualização">' +
            '   <i class="fa fa-plus"></i>' +
            '</span>' +
            '<span class="btn btn-danger btn-xs btn-remove-condition" title="Remover condição de visualização">' +
            '   <i class="fa fa-close"></i>' +
            '</span>' +
            '</div>' +
            '</div>';

        return propertiesBox;
    };

    let setHiddenConditionalsProperty = function() {
        let element = $('.form-selected');
        if (element.attr('data-id')) {
            const oldDataId = element.attr('data-id');
            var condition = $('meta[data-id=' + oldDataId + ']').
            attr('data-trigger').
            split(' ');
            $('.form-properties').
            children('.input-group-btn').
            children('input[name="form-condition"]').
            val(condition[2].replace(/'/g, ''));
            $('.form-properties [name~=form-operator-conditional]').val(condition[1]);
            $('.form-properties [name~=form-dataroles-conditional]').
            val(condition[0]);
        }
    };

    var datarolesCampaign = function() {
        const fieldsJson = ajax.getDatarolesByCampaign();
        let fields;
        let options = [];
        return fieldsJson.then((response) => {
            fields = JSON.parse(response);
            options = fields.map(function(item) {
                return `<option value="${item.field_id}">${item.name}</option>`;
            });
            options.unshift('<option value="" disabled selected></option>');
            options.push(
                '<option value="with_down_payment_condition">Com entrada</option>');
            $('#form-dataroles-conditional').html(options);
            setHiddenConditionalsProperty();
        });
    };

    return {
        markAsSelected: markAsSelected,
        addNewHiddenConditional: addNewHiddenConditional,
        removeHiddenCondition: removeHiddenCondition,
        closeAllForms: closeAllForms,
    };
})(jQuery, PosterEditor.CampaignFieldsAjax);
PosterEditor.Behaviors.DeleteComponent = (function($) {
    var destroy = function() {
        var
            $component = $('.component-selected'),
            component_name = $component.data('role'),
            total_elements = $('#poster-editor [data-role="' + component_name +
                '"]').length;
        bootbox.confirm({
            title: 'Excluir Registro',
            message: 'Você tem certeza que deseja excluir esse elemento?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default pull-left',
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary pull-right',
                },
            },
            callback: function(result) {
                if (result) {
                    let data_id = $component.attr('data-id');
                    if (data_id) {
                        $('meta[data-id=' + data_id + ']').remove();
                    }
                    $component.remove();
                    $('.component-properties').remove();
                    if (total_elements === 1) {
                        $('[data-component="' + component_name + '"]').
                        prop('disabled', false).
                        removeClass('disabled');
                    }
                }
            },
        });
    };

    return {
        destroy: destroy,
    };

})(jQuery);

PosterEditor.Behaviors.DeleteForm = (function($) {

    var destroy = function() {
        var
            $component = $('.form-selected'),
            component_name = $component.data('role'),
            total_elements = $('#poster-editor [data-role="' + component_name +
                '"]').length;
        bootbox.confirm({
            title: 'Excluir Registro',
            message: 'Você tem certeza que deseja excluir esse elemento?',
            buttons: {
                'cancel': {
                    label: 'Não',
                    className: 'btn-default pull-left',
                },
                'confirm': {
                    label: 'Sim',
                    className: 'btn-primary pull-right',
                },
            },
            callback: function(result) {
                if (result) {
                    let isDestroyingAnImage = _.includes($component.attr('data-role'),
                        'image-');

                    $('.form-properties').remove();
                    $component.remove();

                    if (isDestroyingAnImage) {
                        let images = $('[id*=image-]').map(function(index, image) {
                            return _.replace($(image).attr('id'), 'image-', '');
                        });

                        let hasImages = (!!images && images.length > 0);
                        $('[name="has_images"]').val(hasImages | 0);
                    }
                }
            },
        });
    };

    return {
        destroy: destroy,
    };

})(jQuery);

PosterEditor.Behaviors.CreatePoster = (function($) {

    function beforeSend() {
        var $form = $('#form-poster');
        prepareAllComponents();
        setHtmlContentValue();
        setInlineImageDimensions();
        $form.submit();
    }

    function setAllBorderTransparent() {
        $('.relative-component').each(function(index, element) {
            $(element).css('border-color', 'transparent');
        });
    }

    function setInlineImageDimensions() {
        $('[data-role="backgroundImage"]').
        attr('style', $('#poster-editor').attr('style'));
    }

    function prepareAllComponents() {
        PosterEditor.Behaviors.PosterZoom.zoomReset();
        PosterEditor.Behaviors.ComponentSelected.closeAllComponents();
        PosterEditor.Behaviors.FormSelected.closeAllForms();
        PosterEditor.Behaviors.GridRuler.removeGrid();
        setAllBorderTransparent();
        removeThemeInformationsIfExists();
    }

    function setHtmlContentValue() {
        $('input[name="content"]').val($('#poster-editor').html());
    }

    function removeThemeInformationsIfExists() {
        $('ul.theme-informations').remove();
    }

    return {
        beforeSend: beforeSend,
    };

})(jQuery);

PosterEditor.ThemesScroll.event = (function($, themes) {

    var onScrollThemes = function(element) {
        if (scrollValidate(element)) {
            themes.addThemes();
        }
    };

    var isTheBottom = function(element) {
        return ($(element).scrollTop() + $(element).innerHeight() >=
            $(element)[0].scrollHeight - 10);
    };

    var thereIsMoreThemes = function() {
        var total_themes = $('.themes-list').attr('data-total');
        return (!total_themes || total_themes > $('.thumbnail').length);
    };

    var searchIsEmpty = function() {
        return ($('input[name="searchTheme"]').val());
    };
    var scrollValidate = function(element) {
        return (isTheBottom(element) && thereIsMoreThemes() && !searchIsEmpty());
    };

    return {
        onScrollThemes: onScrollThemes,
    };

})(jQuery, PosterEditor.Themes);

PosterEditor.ThemeSearch.event = (function($, themes) {

    var timer;

    var searchThemeKeyup = function() {
        cleanThemeList();
        if (searchIsNotEmpty()) {
            timingRequest('searchThemes');
        } else {
            timingRequest('addThemes');
        }
    };

    function timingRequest(methodName) {
        clearTimeout(timer);
        timer = setTimeout(function() {
            themes[methodName]();
        }, 500);
    }

    function searchIsNotEmpty() {
        return ($('input[name=searchTheme]').val().trim().length > 0);
    }

    function cleanThemeList() {
        $('.themes-list').removeClass('themes-ready').children().remove();
    }

    return {
        searchThemeKeyup: searchThemeKeyup,
    };

})(jQuery, PosterEditor.Themes);

PosterEditor.Behaviors.TextStyling = (function($) {
    var make = function(element) {
        var name = $(element).attr('name'), type = $(element).attr('type');
        if (type === 'button') {
            if (name === 'text-align') {
                $('[name="text-align"]').removeClass('active');
                $(element).addClass('active');
                $('.component-selected').
                children().
                removeClass('text-center text-right text-left').
                addClass('text-' + element.val());
            } else if (name === 'up-cent') {
                let componentSelected = $('.component-selected span.decimal');
                if (componentSelected.length > 0) {
                    adjustCent(componentSelected, false);
                }
            } else if (name === 'down-cent') {
                let componentSelected = $('.component-selected span.decimal');
                if (componentSelected.length > 0) {
                    adjustCent(componentSelected, true);
                }
            } else {
                if (name == 'text-superscript' || name == 'text-subscript' || name ==
                    'text-normal') {
                    $('.text-sup-sub').removeClass('active');
                    let decimalSpan = $('.component-selected span.decimal');
                    decimalSpan.removeData('displaced-cent');
                    decimalSpan.css({position: 'relative'});
                    decimalSpan.css({top: '0'});
                    $('.component-selected').
                    children().
                    removeClass('text-normal text-superscript text-subscript');
                }
                $(element).toggleClass('active');
                $('.component-selected').children().toggleClass(name);
            }
        } else {
            if (name === 'font-family') {
                $('.component-selected').
                children().
                css(name, ' \'' + $(element).val() + '\'');
            } else if (name === 'diagonal-color') {
                $('.component-selected').
                children().
                children('.text-diagonal-striped').
                css('background-color', $(element).val());
                $(element).attr('value', $(element).val());
            } else if (name === 'font-size') {
                var fontSizeValue = $(element).val().replace(/[^0-9]/g, '');
                $('.component-selected').
                children().
                first().
                css(name, fontSizeValue + 'px');
                $(element).attr('value', fontSizeValue);
                $(element).val(fontSizeValue);
            } else if ($(element).parent().parent().parent().data('role') ===
                'line') {
                $('.component-selected').
                children().
                css('background-color', $(element).val());
                $(element).attr('value', $(element).val());
            } else {
                $('.component-selected').children().css(name, $(element).val());
                $(element).attr('value', $(element).val());
            }
        }
    };

    var adjustCent = function(componentSelected, sum) {
        if (!componentSelected.data('displaced-cent')) {
            componentSelected.css({top: '0.06em'});
            componentSelected.data('displaced-cent', true);
        }
        componentSelected.css({position: 'relative'});
        let topCent = +document.querySelector('.component-selected span.decimal').
        style.
        top.
        replace('em', '');
        let newTop = (sum == true) ? topCent + 0.02 : topCent - 0.02;
        componentSelected.css({top: newTop + 'em'});
    };

    var setText = function(element) {
        const spans = document.querySelectorAll(
            'div [class~=component-selected] span');
        if (spans.length > 1) {
            let integer = '0';
            if ($(spans[1]).hasClass('decimal')) {
                let decimal = '00', value = $(element).val().split(',');
                integer = (value[0]) ? value[0] : integer;
                $(spans[0]).html(integer);
                decimal = (value[1]) ? value[1] : decimal;
                if (spans[1]) {
                    $(spans[1]).html(',' + decimal);
                }
            } else {
                let value = $(element).val().replace(/[^0-9]/g, '');
                $(spans[0]).html(value);
                $(spans[1]).html($(element).val().replace(value, ''));
            }
        } else {
            let value = $(element).val();
            value = value.replace(/[\n]/g, '<br>');
            $(spans[0]).html(value);
        }
    };

    var setFontSize = function() {
        var fontSizeValue = element.val();

        if (fontSizeValue.slice(-2) !== 'px') {
            fontSizeValue += 'px';
        }

        element.parent().parent().prev().css(name, fontSizeValue);
        element.attr('value', fontSizeValue);
        element.val(fontSizeValue);
    };

    var setTextAlign = function(element) {
        $('[name="text-align"]').removeClass('active');
        element.addClass('active');
        element.parent().parent().prev().css(name, element.val());
    };
    var setBorderTransparent = function(element) {
        $(element).css('border-color', 'transparent');
    };
    var setBorderColor = function(element) {
        $(element).
        css('border-color',
            $('[data-component="' + $(element).attr('data-role') + '"]').
            css('border-bottom-color'));
    };

    var toggleDiagonalStriped = function(element) {
        let textDiagonalStriped = $('.component-selected').
        children().
        children('.text-diagonal-striped');
        if (textDiagonalStriped.length > 0) {
            textDiagonalStriped.remove();
            $(element).
            parent().
            next('input[name="diagonal-color"]').
            css('background-color', '#000000').
            attr('value', '#000000');
            $(element).parent().removeClass('active');
        } else {
            $('.component-selected').
            children().
            append('<div class="text-diagonal-striped"></div>');
            $(element).parent().addClass('active');
        }
    };

    return {
        make: make,
        setText: setText,
        setBorderColor: setBorderColor,
        setBorderTransparent: setBorderTransparent,
        toggleDiagonalStriped: toggleDiagonalStriped,
    };

})(jQuery);

PosterEditor.Behaviors.FormStyling = (function($) {

    var modifiedElement, name, geometricComponent, formContent, svg, format,
        value;

    var setElement = function(element) {
        modifiedElement = $(element);
        name = modifiedElement.attr('name');
        value = modifiedElement.val();
        geometricComponent = $('.form-selected');
        formContent = geometricComponent.children();
        svg = formContent.children('svg');
        format = geometricComponent.attr('data-role');
    };

    var make = function(element) {
        setElement(element);
        switch (name) {
            case 'fill':
                $('.btn-transparent').removeClass('active');
            case 'stroke-width':
                geometricComponent.css('padding-right', value + 'px').
                css('padding-bottom', value + 'px');
                formContent.css('padding', value / 2);
                svg.css('padding', value / 2).
                css('margin-left', -value / 2).
                css('margin-top', -value / 2);
            case 'stroke':
                svg.css(name, value);
                break;
            case 'transparent':
                element.addClass('active');
                svg.css('fill', 'rgba(0,0,0,0)');
                break;
            case 'border-radius':
                svg.css(name, value + 'px');
                svg.children().attr('rx', value);
                svg.children().attr('ry', value);
                break;
            case 'width':
            case 'height':
                resizeForm();
                break;
        }

    };

    var isProportional = function() {
        return (format == 'circle' || format == 'square');
    };

    var resizeForm = function() {
        if (isProportional()) {
            resizesProportionally();
        } else {
            var viewBox;
            svg.each(function() {
                if (name == 'width') {
                    viewBox = '0 0 ' + value + ' ' +
                        geometricComponent.css('height').replace(/[^0-9]/g, '');
                } else {
                    viewBox = '0 0 ' +
                        geometricComponent.css('width').replace(/[^0-9]/g, '') + ' ' +
                        value;
                }
                $(this)[0].setAttribute('viewBox', viewBox);
            });
            geometricComponent.css(name, value + 'px');
        }
    };

    var resizesProportionally = function() {

        svg.each(function() {
            $(this)[0].setAttribute('viewBox', '0 0 ' + value + ' ' + value);
        });
        geometricComponent.css('width', value + 'px').css('height', value + 'px');
        if (name == 'width') {
            modifiedElement.next('input[name="height"]').val(value);
        } else {
            modifiedElement.prev('input[name="width"]').val(value);
        }
    };

    var resize = function(element) {
        var geometricComponent = $(element),
            svg = geometricComponent.children('.form-content').children('svg');
        let inputGroup = $('.form-properties').children('.input-group');
        inputWidth = inputGroup.children('input[name="width"]'),
            inputHeight = inputGroup.children('input[name="height"]'),
            width = geometricComponent.css('width').replace(/[^0-9]/g, ''),
            height = geometricComponent.css('height').replace(/[^0-9]/g, '');

        svg.each(function() {
            $(this)[0].setAttribute('viewBox', '0 0 ' + width + ' ' + height);
        });
        inputWidth.val(width);
        inputHeight.val(height);
    };

    return {
        make: make,
        resize: resize,
    };

})(jQuery);

PosterEditor.Behaviors.VerticalAlign = (function($) {

    var resetVerticalAlign = function(button) {
        $('.btn-up, .btn-down, .btn-center').removeClass('active');
        $('.component-selected').
        children().
        removeClass('vertical-top vertical-bottom vertical-center');
    };

    var up = function(button) {
        resetVerticalAlign(button);
        $(button).toggleClass('active');
        $('.component-selected').children().addClass('vertical-top');
    };

    var down = function(button) {
        resetVerticalAlign(button);
        $(button).toggleClass('active');
        $('.component-selected').children().addClass('vertical-bottom');
    };

    var center = function(button) {
        resetVerticalAlign(button);
        $(button).toggleClass('active');
        $('.component-selected').children().addClass('vertical-center');
    };

    return {
        up: up,
        down: down,
        center: center,
    };

})(jQuery);

PosterEditor.Behaviors.PosterScroll = (function($) {

    var scrolling = function() {
        var offset = $('.box-editor').offset().top;
        var headerTop = $('.page-head').offset().top + 60;

        var $menuEditor = $(
            '.component-properties, .auxiliary-components, .component-attributes');
        if (offset <= headerTop) {
            $menuEditor.addClass('affix-menu ');
        } else {
            $menuEditor.removeClass('affix-menu ');
        }

        if (offset <= ($(window).scrollTop())) {
            $menuEditor.addClass('affix-on-top ');
        } else {
            $menuEditor.removeClass('affix-on-top ');
        }

        var componentAttributes = document.querySelector('.component-attributes');
        var componentProperties = $('.component-properties');
        var topComponent = componentAttributes.getBoundingClientRect().top;
        var leftComponent = componentAttributes.getBoundingClientRect().left;

        componentProperties.css({top: topComponent});
        componentProperties.css({left: leftComponent});
        var formAttributes = $('.form-properties');

        componentProperties.css({top: topComponent});
        componentProperties.css({left: leftComponent});
        formAttributes.css({top: topComponent});
        formAttributes.css({left: leftComponent});

    };

    return {
        scrolling: scrolling,
    };

})(jQuery);

$(document).ready(function() {

    var popover_options = {
        trigger: 'hover',
        placement: 'right',
        container: 'body',
        selector: '.thumbnail',
        html: true,
    };

    $('body').popover(popover_options);

    $('body').delegate('.onlyNumber', 'keydown', function(e) {
        return PosterEditor.BodyMask.event.onlyNumber(e);
    });

    $('select[name="campaign_id"]').change(function() {
        PosterEditor.CampaignSelect.event.onChangeCampaign();
    });

    $('div.editor-panel div.themes-panel').scroll(function() {
        PosterEditor.ThemesScroll.event.onScrollThemes($(this));
    });

    $('div.panel-components-list').delegate('a', 'click', function() {
        PosterEditor.ComponentsFactory.make($(this));
    });

    $('div.themes-list').delegate('a.thumbnail', 'click', function() {
        PosterEditor.ThemeSelect.event.onChangeTheme($(this));
    });

    $('input[name="searchTheme"]').keyup(function() {
        PosterEditor.ThemeSearch.event.searchThemeKeyup();
    });

    $('button[name="show-grid"]').click(function() {
        PosterEditor.Behaviors.GridRuler.toggleGrid();
    });

    $('button[name="show-grid-plus"]').click(function() {
        PosterEditor.Behaviors.GridRuler.toggleGridPlus();
    });

    $('button[name="add-horizontal-ruler"]').click(function() {
        PosterEditor.Behaviors.GridRuler.addHorizontalRuler();
    });

    $('button[name="add-vertical-ruler"]').click(function() {
        PosterEditor.Behaviors.GridRuler.addVerticalRuler();
    });

    $('.grid-rulers').delegate('.ruler-h, .ruler-v', 'dblclick', function() {
        PosterEditor.Behaviors.GridRuler.removeRuler($(this));
    });

    $('button[name="remove-ruler"]').click(function() {
        PosterEditor.Behaviors.GridRuler.removeRulers();
    });

    $('button[name="add-line"]').click(function() {
        PosterEditor.Components.LineComponent.make();
    });

    $('button[name="add-form"]').click(function() {
        PosterEditor.GeometricComponentsFactory.make($(this));
    });

    $('button[name="add-text"]').click(function() {
        PosterEditor.Components.TextComponent.make();
    });

    $('button[name="add-marked-text"]').click(function() {
        PosterEditor.Components.MarkedTextComponent.make();
    });

    $('button[name="create-poster"]').on('click',
        PosterEditor.Behaviors.CreatePoster.beforeSend,
    );

    $('button[name="zoom-reset"]').on('click',
        PosterEditor.Behaviors.PosterZoom.zoomReset,
    );

    $('button[name="zoom-out"]').on('click',
        PosterEditor.Behaviors.PosterZoom.zoomOut,
    );

    $('button[name="zoom-in"]').on('click',
        PosterEditor.Behaviors.PosterZoom.zoomIn,
    );

    $(document).on('scroll', function() {
        PosterEditor.Behaviors.PosterScroll.scrolling();
    });
    $('.poster-block').
    delegate('select', 'change', function() {
        PosterEditor.Behaviors.TextStyling.make($(this));
    }).
    delegate('button', 'click', function() {
        PosterEditor.Behaviors.TextStyling.make($(this));
    }).
    delegate('.component-properties input[name="diagonal-color"]', 'change',
        function() {
            PosterEditor.Behaviors.TextStyling.make($(this));
        }).
    delegate('.component-properties .btn-display-condition', 'click',
        function() {
            PosterEditor.Behaviors.ComponentSelected.addNewHiddenConditional();
        }).
    delegate('.component-properties .btn-remove-condition', 'click',
        function() {
            PosterEditor.Behaviors.ComponentSelected.removeHiddenCondition();
        }).
    delegate('.component-properties input[name="color"]', 'change', function() {
        PosterEditor.Behaviors.TextStyling.make($(this));
    }).
    delegate('.component-properties input[name="font-size"]', 'keyup',
        function() {
            PosterEditor.Behaviors.TextStyling.make($(this));
        }).
    delegate('.component-properties textarea[name="html"]', 'keyup',
        function() {
            PosterEditor.Behaviors.TextStyling.setText($(this));
        }).
    delegate('.component-properties .btn-close *', 'click', function() {
        PosterEditor.Behaviors.ComponentSelected.markAsSelected();
    }).
    delegate('.component-properties .btn-diagonal *', 'click', function() {
        PosterEditor.Behaviors.TextStyling.toggleDiagonalStriped($(this));
    }).
    delegate('.component-properties .btn-trash *', 'click', function() {
        PosterEditor.Behaviors.DeleteComponent.destroy();
    }).
    delegate('.geometric-component', 'resize', function(event, ui) {
        PosterEditor.Behaviors.FormStyling.resize($(this));
    }).
    delegate('.form-properties .btn-transparent', 'click', function() {
        PosterEditor.Behaviors.FormStyling.make($(this));
    }).
    delegate('.form-properties .btn-close *', 'click', function() {
        PosterEditor.Behaviors.FormSelected.markAsSelected();
    }).
    delegate('.form-properties .btn-trash *', 'click', function() {
        PosterEditor.Behaviors.DeleteForm.destroy();
    }).
    delegate('.form-properties input', 'change', function() {
        PosterEditor.Behaviors.FormStyling.make($(this));
    }).
    delegate('img[data-role="backgroundImage"]', 'dblclick', function() {
        PosterEditor.Behaviors.ComponentSelected.closeAllComponents();
        PosterEditor.Behaviors.FormSelected.closeAllForms();
    }).
    delegate('div.relative-component', 'dblclick', function() {
        PosterEditor.Behaviors.ComponentSelected.markAsSelected($(this));
    }).
    delegate('div.relative-component, div.geometric-component', 'dragcreate',
        function() {
            PosterEditor.Behaviors.PosterZoom.dragWithZoom($(this));
        }).
    delegate('.relative-component:not(.text-component):not(.line-component)',
        'mouseover', function() {
            PosterEditor.Behaviors.TextStyling.setBorderColor($(this));
        }).
    delegate('.relative-component:not(.text-component):not(.line-component)',
        'mouseout', function() {
            PosterEditor.Behaviors.TextStyling.setBorderTransparent($(this));
        }).
    delegate('div.geometric-component', 'dblclick', function() {
        PosterEditor.Behaviors.FormSelected.markAsSelected($(this));
    }).
    delegate('.form-properties .btn-display-condition', 'click', function() {
        PosterEditor.Behaviors.FormSelected.addNewHiddenConditional($(this));
    }).
    delegate('.form-properties .btn-remove-condition', 'click', function() {
        PosterEditor.Behaviors.FormSelected.removeHiddenCondition();
    }).
    delegate('.component-properties .btn-up', 'click', function() {
        PosterEditor.Behaviors.VerticalAlign.up($(this));
    }).
    delegate('.component-properties .btn-down', 'click', function() {
        PosterEditor.Behaviors.VerticalAlign.down($(this));
    }).
    delegate('.component-properties .btn-center', 'click', function() {
        PosterEditor.Behaviors.VerticalAlign.center($(this));
    });
});

$(document).ready(function() {
    PosterEditor.Panel.loadBackgroundImage();
    PosterEditor.Panel.setVerticalAlign();
    PosterEditor.Fields.addFieldList();
});
