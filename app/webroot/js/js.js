	function centredOverlayBlock(){
		$('.overlayBlock').css({
			'left':$(window).width()/2-($('.overlayBlock').width())/2+'px', 
			'top':$(window).height()/4-($('.overlayBlock').height())/4+'px'}
		);
	}
	
  	 function centerSlider () { 
  		 var topBorder  = ($(window).height()-$('#header').outerHeight())/5+"px";
  		 $('.sliderContent').css({top: topBorder});  		 
  		 $('#slider').css({top: topBorder});
  	 }
	 
$(document).ready(function() {
	
	 var ua = navigator.userAgent.toLowerCase();
	 if (ua.indexOf("msie") != -1 && ua.indexOf("opera") == -1 && ua.indexOf("webtv") == -1) {
		 var historyOptions = {};  
	 }else{
		 var historyOptions = { unescape: "/,%" }; 
	 }
	
	 $.history.init(loadContent, historyOptions);
	 	 
 	$('.item a').click(function() {
 		$('.overlayBlock').width(300);
 		$('.overlayBlock').height(250);
 		centredOverlayBlock(); 		
		$.history.load($(this).attr('href'));
		return false;
	});

	
	$('.sampleCollection a').live('click', function() {
		$.history.load($(this).attr('href'));
		return false;
	});
	
	$('.image').live('click', function() {
		var clicker = $('.sampleCollection a.select').next().next().next(); 
		if (clicker.length) {			
			clicker.trigger('click');
		}else{
			$('.sampleCollection a').first().trigger('click');
		}
	});
	
	$(".item").hover(
			  function () {$(this).children('span').fadeTo("fast",1)},
			  function () {$(this).children('span').fadeTo("fast",0)}
			);
});



function loadContent(hash) {

	if(hash != "") {		
		show_overlay(0.7);		
		$('.overlayBlock').fadeIn();			
        $('.overlayBlock').load(hash, function(){
        	"_gaq" in window && _gaq.push(['_trackPageview', hash]);
        });
    }else{    	
    	closeLightbox();
    }
} 

function closeLightbox() {
	$('.overlayBlock').fadeOut(200, function() {
			$(this).empty().width('auto').height('auto');
			}
		);
	
	var href = window.location.href;
	
	if(href.indexOf("#")!=-1) {
		var posHash =  href.indexOf("#");
		var newHref = href.slice(0, posHash);
        window.location.href = newHref+'#';
    };

       
	$('#overlay').fadeOut(200);
	
	return false;
}


var jqueryslidemenu={
	animateduration: {over: 0, out: 0}, //duration of slide in/ out animation, in milliseconds
	
	buildmenu:function(menuid){
		jQuery(document).ready(function($){
			var $mainmenu=$("#"+menuid+">ul")
			var $headers=$mainmenu.find("ul").parent()
			$headers.each(function(i){
				var $curobj=$(this)
				var $subul=$(this).find('ul:eq(0)')
				this._dimensions={w:this.offsetWidth, h:this.offsetHeight, subulw:$subul.outerWidth(), subulh:$subul.outerHeight()}
				this.istopheader=$curobj.parents("ul").length==1? true : false
				$subul.css({top:this.istopheader? this._dimensions.h+"px" : 0})

				$curobj.hover(
					function(e){
						var $targetul=$(this).children("ul:eq(0)")
						this._offsets={left:$(this).offset().left, top:$(this).offset().top}
						var menuleft=this.istopheader? 0 : this._dimensions.w
						menuleft=(this._offsets.left+menuleft+this._dimensions.subulw>$(window).width())? (this.istopheader? -this._dimensions.subulw+this._dimensions.w : -this._dimensions.w) : menuleft
						$targetul.css({left:menuleft+"px", width:this._dimensions.subulw+'px'}).slideDown(jqueryslidemenu.animateduration.over)
					},
					function(e){
						var $targetul=$(this).children("ul:eq(0)")
						$targetul.slideUp(jqueryslidemenu.animateduration.out)
					}
				) //end hover
			}) //end $headers.each()
			$mainmenu.find("ul").css({display:'none', visibility:'visible'})
		}) //end document.ready
	}
}

//build menu with ID="myslidemenu" on page:
jqueryslidemenu.buildmenu("myslidemenu")


/*
$('html').bind('keydown', function(e) {
    if(e.ctrlKey && e.keyCode == 39 && $('.projectText a.next').length){
    	var href = $('.projectText a.next').attr('href')
    	window.location = href;
    }
    if(e.ctrlKey && e.keyCode == 37 && $('.projectText a.prev').length){
		var href = $('.projectText a.prev').attr('href')
    	window.location = href;	
    }

    if(e.ctrlKey && e.keyCode == 38){
	     $('.preViewSample a.samplepreview').each(function() {
		     var obj = $(this);
		     if (obj.hasClass('currentSample') && obj.prev("a").length) {
		    		 obj.prev("a").trigger('click');
		     }
	     })
    } 
    
    if(e.ctrlKey && e.keyCode == 40){ 
	     $('.preViewSample a.samplepreview').each(function() {
		     var obj = $(this);
		     if (obj.hasClass('currentSample') && obj.next("a").length) {
		    		 obj.next("a").trigger('click');
		    		 return false;
	    	 }
	     })
    }
}); */

function resizeTextarea(textarea){
	var diff = textarea.scrollHeight - textarea.clientHeight;
	
	$(textarea).css('overflow-y', 'hidden');
	
    if (diff && diff > 0){
        if (isNaN(parseInt(textarea.style.height))){
            newsize = textarea.scrollHeight+diff;
        }else{
            newsize = parseInt(textarea.style.height) + diff*2;
        }
        textarea.style.height = newsize + "px"
        return (newsize);
    }
}

function setCookie( name, value, expires, path, domain, secure ) {

	var today = new Date();
	today.setTime(today.getTime());
	if ( expires )		{
		expires = expires * 1000;
	}
	
	var expires_date = new Date(today.getTime() + (expires));
	
	document.cookie = name + "=" +escape( value ) +
		(( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
		(( path ) ? ";path=" + path : "" ) +
		(( domain ) ? ";domain=" + domain : "" ) +
		(( secure ) ? ";secure" : "" );
}

function getCookie(name) {
	var cookie = " " + document.cookie;
	var search = " " + name + "=";
	var setStr = null;
	var offset = 0;
	var end = 0;
	if (cookie.length > 0) {
		offset = cookie.indexOf(search);
		if (offset != -1) {
			offset += search.length;
			end = cookie.indexOf(";", offset)
			if (end == -1) {
				end = cookie.length;
			}
			setStr = unescape(cookie.substring(offset, end));
		}
	}
	return(setStr);
}