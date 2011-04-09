
	function loadImage(src, blockId) {
		imageLoader++;
		
	    var img = new Image();
	    $(img).load(function () {
	        //$(this).css('display', 'none'); // .hide() doesn't work in Safari when the element isn't on the DOM already
			var imageLoading = $(this);
		
			$(blockId).animate(
				{
					width: this.width,
					height: this.height
				},300 
			);		
			
		   	 $(blockId).fadeOut(300, function(){
		    	imageLoader--;
		    	$(blockId).removeClass('loadingBg').html(imageLoading).fadeIn(300);    			    			
		    });
		   	centerSlider();
	     	
	    }).error(function () {
	        alert('не загрузится');
	        // notify the user that the image could not be loaded
	    }).attr('src', src+'&w='+$(window).width()+'&h='+$(window).height());    
	}

	function loadImage2(src, blockId, id) {
		var idDesc = '#desc_'+id;
		//var idTitle = '#title_'+id;
		
	    var img = new Image();
	    $(img).load(function () {
	        //$(this).css('display', 'none'); // .hide() doesn't work in Safari when the element isn't on the DOM already
			var imageLoading = $(this);		

			$(idDesc).width(this.width);
			var newWidth = this.width;
			var newHeight = this.height+$(idDesc).height()+18+5;

			$('.overlayBlock').animate(
				{
					width: newWidth,
					height: newHeight,
					left: $(window).width()/2-newWidth/2,
					top: ($(window).height()/2-newHeight/2)/2
				},400,function() {
				   	 $(blockId).fadeOut(400, function(){				   	 
				    	$(blockId).removeClass('loadingBg2').html(imageLoading).fadeIn(400);
				    	$(blockId).next().css({color: "white", width: "auto"});
				    });
				}
			);		
	    }).error(function () {
	        alert('не загрузится');
	        // notify the user that the image could not be loaded
	    }).attr('src', src+'&w='+$(window).width()+'&h='+$(window).height());
	    
	}


	function renderScroll() {

		if (imageLoader==0){
			imageIsLoader = true;
		}
		
		if (!imageIsLoader) {
			setTimeout ("renderScroll()",200);
			return;
		}

	    $('.viewer div').each(function(obj){
	    	viewerWidth+=$(this).outerWidth(true);
	    })
	    $('.viewer').width(viewerWidth);
	    
		imageIsLoader = true; 
		 
		if (viewerWidth > $('.sliderContent').width()) {
			$( "#slider" ).slider(
				{
					//stop: function (event, ui) {alert('d');},
				    slide: function(event, ui) {setLeft(ui.value)},
				    step: 0.3
				}
			);		
		}else{
			var left = $('.sliderContent').width()/2 - viewerWidth/2;
			$('.viewer').animate({left: left})
		}
	}


	$(document).ready(function() {

		viewerWidth = 0;
		imageLoader = 0;
		imageIsLoader = false;
		
		setTimeout ("renderScroll()",200);
		setInterval("autoSlider()",20);
					
		toRight = false;
		toLeft = false;
		
		$(".grad-right").hover(
		  function () {window.toRight = true;},
		  function () {window.toRight = false;}
		);

		$(".grad-left").hover(
		  function () {window.toLeft = true;},
		  function () {window.toLeft = false;}
		);
								

		

			
		$('#overlay, #close').click(function() {
			closeLightbox();
		});
					
	});


	$(window).resize(
			function() { 
				centredOverlayBlock();
				centerSlider();
				if (viewerWidth < $('.sliderContent').width()) {
					var left = $('.sliderContent').width()/2 - viewerWidth/2;
					$('.viewer').css({left: left+'px'});
					$('#slider').fadeOut();
				}else{				
					$('#slider').fadeIn();
					setLeft($( "#slider" ).slider( "option", "value" ));
				}					
		})


	function show_overlay(op) {
		var obj = $('#overlay');
		obj.css({'height':$(document).height()+'px', 'opacity':op});
		obj.css('height',$(document).height()+'px');
		obj.fadeIn();
	}





	function setLeft (procent) {
		var left = procent*(viewerWidth - $('.sliderContent').width())/100;
		$('.viewer').css('right',left)
	}

	function autoSlider() {
		
		if (imageLoader!==0) {
			return;
		}
		
		var step = 7
		
		if (window.toLeft) {

			if (parseInt($('.viewer').css('right'))<0) {
				return;
			};		
					
			$('.viewer').css('right', parseInt($('.viewer').css('right'))-step+'px');		
			$( "#slider" ).slider( "option", "value", 100*parseInt($('.viewer').css('right'))/(viewerWidth-$('.sliderContent').width()) );
		}

		if (window.toRight) {
			
			if (viewerWidth-$('.sliderContent').width() < parseInt($('.viewer').css('right')) ) {
				return;
			}
																																					
			$('.viewer').css('right', parseInt($('.viewer').css('right'))+step+'px');		
			$( "#slider" ).slider( "option", "value", 100*parseInt($('.viewer').css('right'))/(viewerWidth-$('.sliderContent').width()) );
		  	
		}  			
	}