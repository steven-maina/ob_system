(function(r){r.event.special.destroyed||(r.event.special.destroyed={remove:function(l){l.handler&&l.handler()}}),r.fn.extend({maxlength:function(l,n){var b=r("body"),p={showOnReady:!1,alwaysShow:!0,threshold:0,warningClass:"small form-text text-muted",limitReachedClass:"small form-text text-danger",limitExceededClass:"",separator:" / ",preText:"",postText:"",showMaxLength:!0,placement:"bottom-right-inside",message:null,showCharsTyped:!0,validate:!1,utf8:!1,appendToParent:!1,twoCharLinebreak:!0,customMaxAttribute:null,customMaxClass:"overmax",allowOverMax:!1,zIndex:1099};r.isFunction(l)&&!n&&(n=l,l={}),l=r.extend(p,l);function o(a){var t=a.charCodeAt();return t?t<128?1:t<2048?2:3:0}function g(a){return a.split("").map(o).concat(0).reduce(function(t,e){return t+e})}function v(a){var t=a.val();l.twoCharLinebreak?t=t.replace(/\r(?!\n)|\n(?!\r)/g,`\r
`):t=t.replace(/(?:\r\n|\r|\n)/g,`
`);var e=0;return l.utf8?e=g(t):e=t.length,a.prop("type")==="file"&&a.val()!==""&&(e-=12),e}function x(a,t){var e=a.val();if(l.twoCharLinebreak&&(e=e.replace(/\r(?!\n)|\n(?!\r)/g,`\r
`),e[e.length-1]===`
`&&(t-=e.length%2)),l.utf8){for(var s=e.split("").map(o),f=0,c=g(e)-t;f<c;f+=s.pop());t-=t-s.length}a.val(e.substr(0,t))}function y(a,t,e){var s=!0;return!l.alwaysShow&&e-v(a)>t&&(s=!1),s}function m(a,t){var e=t-v(a);return e}function h(a,t){t.css({display:"block"}),a.trigger("maxlength.shown")}function k(a,t){l.alwaysShow||(t.css({display:"none"}),a.trigger("maxlength.hidden"))}function C(a,t,e){var s="";return l.message?typeof l.message=="function"?s=l.message(a,t):s=l.message.replace("%charsTyped%",e).replace("%charsRemaining%",t-e).replace("%charsTotal%",t):(l.preText&&(s+=l.preText),l.showCharsTyped?s+=e:s+=t-e,l.showMaxLength&&(s+=l.separator+t),l.postText&&(s+=l.postText)),s}function w(a,t,e,s){s&&(s.html(C(t.val(),e,e-a)),a>0?y(t,l.threshold,e)?h(t,s.removeClass(l.limitReachedClass+" "+l.limitExceededClass).addClass(l.warningClass)):k(t,s):l.limitExceededClass?a===0?h(t,s.removeClass(l.warningClass+" "+l.limitExceededClass).addClass(l.limitReachedClass)):h(t,s.removeClass(l.warningClass+" "+l.limitReachedClass).addClass(l.limitExceededClass)):h(t,s.removeClass(l.warningClass).addClass(l.limitReachedClass))),l.customMaxAttribute&&(a<0?t.addClass(l.customMaxClass):t.removeClass(l.customMaxClass))}function M(a){var t=a[0];return r.extend({},typeof t.getBoundingClientRect=="function"?t.getBoundingClientRect():{width:t.offsetWidth,height:t.offsetHeight},a.offset())}function R(a,t){if(!(!a||!t)){var e=["top","bottom","left","right","position"],s={};r.each(e,function(f,c){var i=l.placement[c];typeof i<"u"&&(s[c]=i)}),t.css(s)}}function d(a,t){var e=M(a);if(r.type(l.placement)==="function"){l.placement(a,t,e);return}if(r.isPlainObject(l.placement)){R(l.placement,t);return}var s=a.outerWidth(),f=t.outerWidth(),c=t.width(),i=t.height();switch(l.appendToParent&&(e.top-=a.parent().offset().top,e.left-=a.parent().offset().left),l.placement){case"bottom":t.css({top:e.top+e.height,left:e.left+e.width/2-c/2});break;case"top":t.css({top:e.top-i,left:e.left+e.width/2-c/2});break;case"left":t.css({top:e.top+e.height/2-i/2,left:e.left-c});break;case"right":t.css({top:e.top+e.height/2-i/2,left:e.left+e.width});break;case"bottom-right":t.css({top:e.top+e.height,left:e.left+e.width});break;case"top-right":t.css({top:e.top-i,left:e.left+s});break;case"top-left":t.css({top:e.top-i,left:e.left-f});break;case"bottom-left":t.css({top:e.top+a.outerHeight(),left:e.left-f});break;case"centered-right":t.css({top:e.top+i/2,left:e.left+s-f-3});break;case"bottom-right-inside":t.css({top:e.top+e.height,left:e.left+e.width-f});break;case"top-right-inside":t.css({top:e.top-i,left:e.left+s-f});break;case"top-left-inside":t.css({top:e.top-i,left:e.left});break;case"bottom-left-inside":t.css({top:e.top+a.outerHeight(),left:e.left});break}}function u(a){var t=a.attr("maxlength")||l.customMaxAttribute;if(l.customMaxAttribute&&!l.allowOverMax){var e=a.attr(l.customMaxAttribute);(!t||e<t)&&(t=e)}return t||(t=a.attr("size")),t}return this.each(function(){var a=r(this),t,e;r(window).resize(function(){e&&d(a,e)});function s(){var f=C(a.val(),t,"0");t=u(a),e||(e=r('<span class="bootstrap-maxlength"></span>').css({display:"none",position:"absolute",whiteSpace:"nowrap",zIndex:l.zIndex}).html(f)),a.is("textarea")&&(a.data("maxlenghtsizex",a.outerWidth()),a.data("maxlenghtsizey",a.outerHeight()),a.mouseup(function(){(a.outerWidth()!==a.data("maxlenghtsizex")||a.outerHeight()!==a.data("maxlenghtsizey"))&&d(a,e),a.data("maxlenghtsizex",a.outerWidth()),a.data("maxlenghtsizey",a.outerHeight())})),l.appendToParent?(a.parent().append(e),a.parent().css("position","relative")):b.append(e);var c=m(a,u(a));w(c,a,t,e),d(a,e)}l.showOnReady?a.ready(function(){s()}):a.focus(function(){s()}),a.on("maxlength.reposition",function(){d(a,e)}),a.on("destroyed",function(){e&&e.remove()}),a.on("blur",function(){e&&!l.showOnReady&&e.remove()}),a.on("input",function(){var f=u(a),c=m(a,f),i=!0;return l.validate&&c<0?(x(a,f),i=!1):w(c,a,t,e),i})})}})})(jQuery);
