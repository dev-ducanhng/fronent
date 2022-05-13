/* jshint ignore:start */
// Avoid `console` errors in browsers that lack a console.
(function() {
  'use strict';
  var method;
  var noop = function () {};
  var methods = [
      'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
      'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
      'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
      'timeline', 'timelineEnd', 'timeStamp', 'trace', 'warn'
  ];
  var length = methods.length;
  var console = (window.console = window.console || {});

  while (length--) {
      method = methods[length];

      // Only stub undefined methods.
      if (!console[method]) {
          console[method] = noop;
      }
  }


}());

Number.prototype.formatNumber = function (mark) {
mark = mark || '.';
var number = this;
return number.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1"+mark)
}

// Place any jQuery/helper plugins in here.
if (!String.prototype.trim) {
(function() {
  // Make sure we trim BOM and NBSP
  var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
  String.prototype.trim = function() {
    return this.replace(rtrim, '');
  };
})();
}

if (!Date.now) {
Date.now = function now() {
  return new Date().getTime();
};
}

//CustomEvent
(function () {
function CustomEvent ( event, params ) {
  params = params || { bubbles: false, cancelable: false, detail: undefined };
  var evt = document.createEvent( 'CustomEvent' );
  evt.initCustomEvent( event, params.bubbles, params.cancelable, params.detail );
  return evt;
 }

CustomEvent.prototype = window.Event.prototype;

window.CustomEvent = CustomEvent;
})();


// Production steps of ECMA-262, Edition 5, 15.4.4.14
// Reference: http://es5.github.io/#x15.4.4.14
if (!Array.prototype.indexOf) {
Array.prototype.indexOf = function(searchElement, fromIndex) {

  var k;

  // 1. Let O be the result of calling ToObject passing
  //    the this value as the argument.
  if (this == null) {
    throw new TypeError('"this" is null or not defined');
  }

  var O = Object(this);

  // 2. Let lenValue be the result of calling the Get
  //    internal method of O with the argument "length".
  // 3. Let len be ToUint32(lenValue).
  var len = O.length >>> 0;

  // 4. If len is 0, return -1.
  if (len === 0) {
    return -1;
  }

  // 5. If argument fromIndex was passed let n be
  //    ToInteger(fromIndex); else let n be 0.
  var n = +fromIndex || 0;

  if (Math.abs(n) === Infinity) {
    n = 0;
  }

  // 6. If n >= len, return -1.
  if (n >= len) {
    return -1;
  }

  // 7. If n >= 0, then Let k be n.
  // 8. Else, n<0, Let k be len - abs(n).
  //    If k is less than 0, then let k be 0.
  k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

  // 9. Repeat, while k < len
  while (k < len) {
    // a. Let Pk be ToString(k).
    //   This is implicit for LHS operands of the in operator
    // b. Let kPresent be the result of calling the
    //    HasProperty internal method of O with argument Pk.
    //   This step can be combined with c
    // c. If kPresent is true, then
    //    i.  Let elementK be the result of calling the Get
    //        internal method of O with the argument ToString(k).
    //   ii.  Let same be the result of applying the
    //        Strict Equality Comparison Algorithm to
    //        searchElement and elementK.
    //  iii.  If same is true, return k.
    if (k in O && O[k] === searchElement) {
      return k;
    }
    k++;
  }
  return -1;
};
}

/*! @source http://purl.eligrey.com/github/classList.js/blob/master/classList.js */
if("document" in self){if(!("classList" in document.createElement("_"))){(function(j){"use strict";if(!("Element" in j)){return}var a="classList",f="prototype",m=j.Element[f],b=Object,k=String[f].trim||function(){return this.replace(/^\s+|\s+$/g,"")},c=Array[f].indexOf||function(q){var p=0,o=this.length;for(;p<o;p++){if(p in this&&this[p]===q){return p}}return -1},n=function(o,p){this.name=o;this.code=DOMException[o];this.message=p},g=function(p,o){if(o===""){throw new n("SYNTAX_ERR","An invalid or illegal string was specified")}if(/\s/.test(o)){throw new n("INVALID_CHARACTER_ERR","String contains an invalid character")}return c.call(p,o)},d=function(s){var r=k.call(s.getAttribute("class")||""),q=r?r.split(/\s+/):[],p=0,o=q.length;for(;p<o;p++){this.push(q[p])}this._updateClassName=function(){s.setAttribute("class",this.toString())}},e=d[f]=[],i=function(){return new d(this)};n[f]=Error[f];e.item=function(o){return this[o]||null};e.contains=function(o){o+="";return g(this,o)!==-1};e.add=function(){var s=arguments,r=0,p=s.length,q,o=false;do{q=s[r]+"";if(g(this,q)===-1){this.push(q);o=true}}while(++r<p);if(o){this._updateClassName()}};e.remove=function(){var t=arguments,s=0,p=t.length,r,o=false,q;do{r=t[s]+"";q=g(this,r);while(q!==-1){this.splice(q,1);o=true;q=g(this,r)}}while(++s<p);if(o){this._updateClassName()}};e.toggle=function(p,q){p+="";var o=this.contains(p),r=o?q!==true&&"remove":q!==false&&"add";if(r){this[r](p)}if(q===true||q===false){return q}else{return !o}};e.toString=function(){return this.join(" ")};if(b.defineProperty){var l={get:i,enumerable:true,configurable:true};try{b.defineProperty(m,a,l)}catch(h){if(h.number===-2146823252){l.enumerable=false;b.defineProperty(m,a,l)}}}else{if(b[f].__defineGetter__){m.__defineGetter__(a,i)}}}(self))}else{(function(){var b=document.createElement("_");b.classList.add("c1","c2");if(!b.classList.contains("c2")){var c=function(e){var d=DOMTokenList.prototype[e];DOMTokenList.prototype[e]=function(h){var g,f=arguments.length;for(g=0;g<f;g++){h=arguments[g];d.call(this,h)}}};c("add");c("remove")}b.classList.toggle("c3",false);if(b.classList.contains("c3")){var a=DOMTokenList.prototype.toggle;DOMTokenList.prototype.toggle=function(d,e){if(1 in arguments&&!this.contains(d)===!e){return e}else{return a.call(this,d)}}}b=null}())}};


// getComputedStyle
!('getComputedStyle' in this) && (this.getComputedStyle = (function () {
  function getPixelSize(element, style, property, fontSize) {
      var
      sizeWithSuffix = style[property],
      size = parseFloat(sizeWithSuffix),
      suffix = sizeWithSuffix.split(/\d/)[0],
      rootSize;

      fontSize = fontSize != null ? fontSize : /%|em/.test(suffix) && element.parentElement ? getPixelSize(element.parentElement, element.parentElement.currentStyle, 'fontSize', null) : 16;
      rootSize = property == 'fontSize' ? fontSize : /width/i.test(property) ? element.clientWidth : element.clientHeight;

      return (suffix == 'em') ? size * fontSize : (suffix == 'in') ? size * 96 : (suffix == 'pt') ? size * 96 / 72 : (suffix == '%') ? size / 100 * rootSize : size;
  }

  function setShortStyleProperty(style, property) {
      var
      borderSuffix = property == 'border' ? 'Width' : '',
      t = property + 'Top' + borderSuffix,
      r = property + 'Right' + borderSuffix,
      b = property + 'Bottom' + borderSuffix,
      l = property + 'Left' + borderSuffix;

      style[property] = (style[t] == style[r] == style[b] == style[l] ? [style[t]]
      : style[t] == style[b] && style[l] == style[r] ? [style[t], style[r]]
      : style[l] == style[r] ? [style[t], style[r], style[b]]
      : [style[t], style[r], style[b], style[l]]).join(' ');
  }

  function CSSStyleDeclaration(element) {
      var
      currentStyle = element.currentStyle,
      style = this,
      fontSize = getPixelSize(element, currentStyle, 'fontSize', null);

      for (property in currentStyle) {
          if (/width|height|margin.|padding.|border.+W/.test(property) && style[property] !== 'auto') {
              style[property] = getPixelSize(element, currentStyle, property, fontSize) + 'px';
          } else if (property === 'styleFloat') {
              style['float'] = currentStyle[property];
          } else {
              style[property] = currentStyle[property];
          }
      }

      setShortStyleProperty(style, 'margin');
      setShortStyleProperty(style, 'padding');
      setShortStyleProperty(style, 'border');

      style.fontSize = fontSize + 'px';

      return style;
  }

  CSSStyleDeclaration.prototype = {
      constructor: CSSStyleDeclaration,
      getPropertyPriority: function () {},
      getPropertyValue: function ( prop ) {
          return this[prop] || '';
      },
      item: function () {},
      removeProperty: function () {},
      setProperty: function () {},
      getPropertyCSSValue: function () {}
  };

  function getComputedStyle(element) {
      return new CSSStyleDeclaration(element);
  }

  return getComputedStyle;
})(this));


// addEventListener polyfill https://gist.github.com/jonathantneal/3748027
!window.addEventListener && (function (WindowPrototype, DocumentPrototype, ElementPrototype, addEventListener, removeEventListener, dispatchEvent, registry) {
  WindowPrototype[addEventListener] = DocumentPrototype[addEventListener] = ElementPrototype[addEventListener] = function (type, listener) {
      var target = this;

      registry.unshift([target, type, listener, function (event) {
          event.currentTarget = target;
          event.preventDefault = function () { event.returnValue = false };
          event.stopPropagation = function () { event.cancelBubble = true };
          event.target = event.srcElement || target;

          listener.call(target, event);
      }]);

      this.attachEvent("on" + type, registry[0][3]);
  };

  WindowPrototype[removeEventListener] = DocumentPrototype[removeEventListener] = ElementPrototype[removeEventListener] = function (type, listener) {
      for (var index = 0, register; register = registry[index]; ++index) {
          if (register[0] == this && register[1] == type && register[2] == listener) {
              return this.detachEvent("on" + type, registry.splice(index, 1)[0][3]);
          }
      }
  };

  WindowPrototype[dispatchEvent] = DocumentPrototype[dispatchEvent] = ElementPrototype[dispatchEvent] = function (eventObject) {
      return this.fireEvent("on" + eventObject.type, eventObject);
  };
})(Window.prototype, HTMLDocument.prototype, Element.prototype, "addEventListener", "removeEventListener", "dispatchEvent", []);

/*
* Add Commas to numbers
* @method
* @param  {*} nStr      Numer/String to add comma
* @param  {String} sep Custom separator in place of the comma
* @return {String}           The commas-added string
* @return	String the string of number with commas added
* @static
* @author	unknown
*/
String.addCommas = function (nStr, sep) {
if (nStr === undefined) nStr = '';
var parts = nStr.toString().split('.');
if (!sep) sep = ',';
parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, sep);
var decSep = '';
if (sep === '.') {
  decSep = ',';
} else {
  decSep = '.';
}
return parts.join(decSep);
};