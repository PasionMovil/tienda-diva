(function(c){var w=65,G={eventName:"click",onShow:function(){},onBeforeShow:function(){},onHide:function(){},onChange:function(){},onSubmit:function(){},color:"ff0000",livePreview:!0,flat:!1},j=function(a,b){var d=h(a);c(b).data("colorpicker").fields.eq(1).val(d.r).end().eq(2).val(d.g).end().eq(3).val(d.b).end()},p=function(a,b){c(b).data("colorpicker").fields.eq(4).val(a.h).end().eq(5).val(a.s).end().eq(6).val(a.b).end()},l=function(a,b){c(b).data("colorpicker").fields.eq(0).val(k(h(a))).end()},
    q=function(a,b){c(b).data("colorpicker").selector.css("backgroundColor","#"+k(h({h:a.h,s:100,b:100})));c(b).data("colorpicker").selectorIndic.css({left:parseInt(150*a.s/100,10),top:parseInt(150*(100-a.b)/100,10)})},r=function(a,b){c(b).data("colorpicker").hue.css("top",parseInt(150-150*a.h/360,10))},t=function(a,b){c(b).data("colorpicker").currentColor.css("backgroundColor","#"+k(h(a)))},s=function(a,b){c(b).data("colorpicker").newColor.css("backgroundColor","#"+k(h(a)))},H=function(a){a=a.charCode||
        a.keyCode||-1;if(a>w&&90>=a||32==a)return!1;!0===c(this).parent().parent().data("colorpicker").livePreview&&m.apply(this)},m=function(a){var b=c(this).parent().parent(),d;if(0<this.parentNode.className.indexOf("_hex")){d=b.data("colorpicker");var f=this.value,e=6-f.length;if(0<e){for(var g=[],x=0;x<e;x++)g.push("0");g.push(f);f=g.join("")}f=n(u(f));d.color=d=f}else 0<this.parentNode.className.indexOf("_hsb")?b.data("colorpicker").color=d=v({h:parseInt(b.data("colorpicker").fields.eq(4).val(),10),
        s:parseInt(b.data("colorpicker").fields.eq(5).val(),10),b:parseInt(b.data("colorpicker").fields.eq(6).val(),10)}):(d=b.data("colorpicker"),f=parseInt(b.data("colorpicker").fields.eq(1).val(),10),e=parseInt(b.data("colorpicker").fields.eq(2).val(),10),g=parseInt(b.data("colorpicker").fields.eq(3).val(),10),f={r:Math.min(255,Math.max(0,f)),g:Math.min(255,Math.max(0,e)),b:Math.min(255,Math.max(0,g))},d.color=d=n(f));a&&(j(d,b.get(0)),l(d,b.get(0)),p(d,b.get(0)));q(d,b.get(0));r(d,b.get(0));s(d,b.get(0));
        b.data("colorpicker").onChange.apply(b,[d,k(h(d)),h(d)])},I=function(){c(this).parent().parent().data("colorpicker").fields.parent().removeClass("colorpicker_focus")},J=function(){w=0<this.parentNode.className.indexOf("_hex")?70:65;c(this).parent().parent().data("colorpicker").fields.parent().removeClass("colorpicker_focus");c(this).parent().addClass("colorpicker_focus")},K=function(a){var b=c(this).parent().find("input").focus();a={el:c(this).parent().addClass("colorpicker_slider"),max:0<this.parentNode.className.indexOf("_hsb_h")?
        360:0<this.parentNode.className.indexOf("_hsb")?100:255,y:a.pageY,field:b,val:parseInt(b.val(),10),preview:c(this).parent().parent().data("colorpicker").livePreview};c(document).bind("mouseup",a,y);c(document).bind("mousemove",a,z)},z=function(a){a.data.field.val(Math.max(0,Math.min(a.data.max,parseInt(a.data.val+a.pageY-a.data.y,10))));a.data.preview&&m.apply(a.data.field.get(0),[!0]);return!1},y=function(a){m.apply(a.data.field.get(0),[!0]);a.data.el.removeClass("colorpicker_slider").find("input").focus();
        c(document).unbind("mouseup",y);c(document).unbind("mousemove",z);return!1},L=function(){var a={cal:c(this).parent(),y:c(this).offset().top};a.preview=a.cal.data("colorpicker").livePreview;c(document).bind("mouseup",a,A);c(document).bind("mousemove",a,B)},B=function(a){m.apply(a.data.cal.data("colorpicker").fields.eq(4).val(parseInt(360*(150-Math.max(0,Math.min(150,a.pageY-a.data.y)))/150,10)).get(0),[a.data.preview]);return!1},A=function(a){j(a.data.cal.data("colorpicker").color,a.data.cal.get(0));
        l(a.data.cal.data("colorpicker").color,a.data.cal.get(0));c(document).unbind("mouseup",A);c(document).unbind("mousemove",B);return!1},M=function(){var a={cal:c(this).parent(),pos:c(this).offset()};a.preview=a.cal.data("colorpicker").livePreview;c(document).bind("mouseup",a,C);c(document).bind("mousemove",a,D)},D=function(a){m.apply(a.data.cal.data("colorpicker").fields.eq(6).val(parseInt(100*(150-Math.max(0,Math.min(150,a.pageY-a.data.pos.top)))/150,10)).end().eq(5).val(parseInt(100*Math.max(0,Math.min(150,
        a.pageX-a.data.pos.left))/150,10)).get(0),[a.data.preview]);return!1},C=function(a){j(a.data.cal.data("colorpicker").color,a.data.cal.get(0));l(a.data.cal.data("colorpicker").color,a.data.cal.get(0));c(document).unbind("mouseup",C);c(document).unbind("mousemove",D);return!1},N=function(){c(this).addClass("colorpicker_focus")},O=function(){c(this).removeClass("colorpicker_focus")},P=function(){var a=c(this).parent(),b=a.data("colorpicker").color;a.data("colorpicker").origColor=b;t(b,a.get(0));a.data("colorpicker").onSubmit(b,
        k(h(b)),h(b),a.data("colorpicker").el)},F=function(){var a,b,d,f=c("#"+c(this).data("colorpickerId"));f.data("colorpicker").onBeforeShow.apply(this,[f.get(0)]);var e=c(this).offset(),g="CSS1Compat"==document.compatMode;a=window.pageXOffset||(g?document.documentElement.scrollLeft:document.body.scrollLeft);b=window.pageYOffset||(g?document.documentElement.scrollTop:document.body.scrollTop);d=window.innerWidth||(g?document.documentElement.clientWidth:document.body.clientWidth);var h=e.top+this.offsetHeight,
        e=e.left;h+176>b+(window.innerHeight||(g?document.documentElement.clientHeight:document.body.clientHeight))&&(h-=this.offsetHeight+176);e+356>a+d&&(e-=356);f.css({left:e+"px",top:h+"px"});!1!=f.data("colorpicker").onShow.apply(this,[f.get(0)])&&f.show();c(document).bind("mousedown",{cal:f},E);return!1},E=function(a){Q(a.data.cal.get(0),a.target,a.data.cal.get(0))||(!1!=a.data.cal.data("colorpicker").onHide.apply(this,[a.data.cal.get(0)])&&a.data.cal.hide(),c(document).unbind("mousedown",E))},Q=function(a,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    b,d){if(a==b)return!0;if(a.contains)return a.contains(b);if(a.compareDocumentPosition)return!!(a.compareDocumentPosition(b)&16);for(b=b.parentNode;b&&b!=d;){if(b==a)return!0;b=b.parentNode}return!1},v=function(a){return{h:Math.min(360,Math.max(0,a.h)),s:Math.min(100,Math.max(0,a.s)),b:Math.min(100,Math.max(0,a.b))}},u=function(a){a=parseInt(-1<a.indexOf("#")?a.substring(1):a,16);return{r:a>>16,g:(a&65280)>>8,b:a&255}},n=function(a){var b={h:0,s:0,b:0},d=Math.min(a.r,a.g,a.b),c=Math.max(a.r,a.g,a.b),
        d=c-d;b.b=c;b.s=0!=c?255*d/c:0;b.h=0!=b.s?a.r==c?(a.g-a.b)/d:a.g==c?2+(a.b-a.r)/d:4+(a.r-a.g)/d:-1;b.h*=60;0>b.h&&(b.h+=360);b.s*=100/255;b.b*=100/255;return b},h=function(a){var b,d,c;b=Math.round(a.h);var e=Math.round(255*a.s/100);a=Math.round(255*a.b/100);if(0==e)b=d=c=a;else{var e=(255-e)*a/255,g=(a-e)*(b%60)/60;360==b&&(b=0);60>b?(b=a,c=e,d=e+g):120>b?(d=a,c=e,b=a-g):180>b?(d=a,b=e,c=e+g):240>b?(c=a,b=e,d=a-g):300>b?(c=a,d=e,b=e+g):360>b?(b=a,d=e,c=a-g):c=d=b=0}return{r:Math.round(b),g:Math.round(d),
        b:Math.round(c)}},k=function(a){var b=[a.r.toString(16),a.g.toString(16),a.b.toString(16)];c.each(b,function(a,c){1==c.length&&(b[a]="0"+c)});return b.join("")},R=function(){var a=c(this).parent(),b=a.data("colorpicker").origColor;a.data("colorpicker").color=b;j(b,a.get(0));l(b,a.get(0));p(b,a.get(0));q(b,a.get(0));r(b,a.get(0));s(b,a.get(0))};c.fn.extend({ColorPicker:function(a){a=c.extend({},G,a||{});if("string"==typeof a.color)a.color=n(u(a.color));else if(void 0!=a.color.r&&void 0!=a.color.g&&
    void 0!=a.color.b)a.color=n(a.color);else if(void 0!=a.color.h&&void 0!=a.color.s&&void 0!=a.color.b)a.color=v(a.color);else return this;return this.each(function(){if(!c(this).data("colorpickerId")){var b=c.extend({},a);b.origColor=a.color;var d="collorpicker_"+parseInt(1E3*Math.random());c(this).data("colorpickerId",d);d=c('<div class="colorpicker"><div class="colorpicker_color"><div><div></div></div></div><div class="colorpicker_hue"><div></div></div><div class="colorpicker_new_color"></div><div class="colorpicker_current_color"></div><div class="colorpicker_hex"><input type="text" maxlength="6" size="6" /></div><div class="colorpicker_rgb_r colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_g colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_h colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_s colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_submit"></div></div>').attr("id",
    d);b.flat?d.appendTo(this).show():d.appendTo(document.body);b.fields=d.find("input").bind("keyup",H).bind("change",m).bind("blur",I).bind("focus",J);d.find("span").bind("mousedown",K).end().find(">div.colorpicker_current_color").bind("click",R);b.selector=d.find("div.colorpicker_color").bind("mousedown",M);b.selectorIndic=b.selector.find("div div");b.el=this;b.hue=d.find("div.colorpicker_hue div");d.find("div.colorpicker_hue").bind("mousedown",L);b.newColor=d.find("div.colorpicker_new_color");b.currentColor=
    d.find("div.colorpicker_current_color");d.data("colorpicker",b);d.find("div.colorpicker_submit").bind("mouseenter",N).bind("mouseleave",O).bind("click",P);j(b.color,d.get(0));p(b.color,d.get(0));l(b.color,d.get(0));r(b.color,d.get(0));q(b.color,d.get(0));t(b.color,d.get(0));s(b.color,d.get(0));b.flat?d.css({position:"relative",display:"block"}):c(this).bind(b.eventName,F)}})},ColorPickerHide:function(){return this.each(function(){c(this).data("colorpickerId")&&c("#"+c(this).data("colorpickerId")).hide()})},
    ColorPickerShow:function(){return this.each(function(){c(this).data("colorpickerId")&&F.apply(this)})},ColorPickerSetColor:function(a){if("string"==typeof a)a=n(u(a));else if(void 0!=a.r&&void 0!=a.g&&void 0!=a.b)a=n(a);else if(void 0!=a.h&&void 0!=a.s&&void 0!=a.b)a=v(a);else return this;return this.each(function(){if(c(this).data("colorpickerId")){var b=c("#"+c(this).data("colorpickerId"));b.data("colorpicker").color=a;b.data("colorpicker").origColor=a;j(a,b.get(0));p(a,b.get(0));l(a,b.get(0));
        r(a,b.get(0));q(a,b.get(0));t(a,b.get(0));s(a,b.get(0))}})}})})(jQuery);