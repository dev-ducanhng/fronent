!function(){
    var t={
        ele:"body",
        type:"info",
        offset:{
            from:"top",
            amount:20
        },
        align:"right",
        width:250,
        delay:6e4,
        allow_dismiss:!0,
        stackup_spacing:10
    };
    $.simplyToast=function(s,e,a){
        function i(){
            o.fadeOut(function(){return o.remove()})
        }
        var o,n,f;
        switch(a=$.extend({},t,a),
        o=$('<div class="simply-toast alert alert-'+s+'"></div>'),
        a.allow_dismiss&&o.append('<span class="close" data-dismiss="alert">&times;</span>'),
        o.append(e),
        a.top_offset&&(a.offset={from:"top",amount:a.top_offset}),
        f=a.offset.amount,
        $(".simply-toast").each(function(){
            return f=Math.max(f,
                parseInt($(this).css(a.offset.from))+$(this).outerHeight()+a.stackup_spacing)}),
                n={
                    position:"body"===a.ele?"fixed":"absolute",
                    margin:0,
                    "z-index":"9999",
                    display:"none",
                    // "top": "20px"
                },
                // n[a.offset.from]=f+"px",o.css(n),"auto"!==a.width&&o.css("width",a.width+"px"),
                n[a.offset.from]="20px",o.css(n),"auto"!==a.width&&o.css("width",a.width+"px"),
                // n[a.offset.from]= "20px",
                $(a.ele).append(o),a.align){
                    case"center":o.css({left:"50%","margin-left":"-"+o.outerWidth()/2+"px"});
                    break;
                    case"left":o.css("left","20px");
                    break;
                    default:o.css("right","20px")
                }
                return o.fadeIn(),
                a.delay>0&&(setTimeout(i,a.delay),
                $(".simply-toast").live("click",function(){
                    i()
                })),
                o.find('[data-dismiss="alert"]').click(i),o}
}();