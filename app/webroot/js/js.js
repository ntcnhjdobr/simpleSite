$(document).ready(function() {
	  $("a.first, a.second, a.oglava").click(function () {
	  	elementClick = $(this).attr("href");
	  	elementClick= elementClick.replace('#','');
	  	destination = $("[name="+elementClick+"]").offset().top;
	  	$tags = (navigator.appName=='Opera')?'html':'body,html';
	  	$($tags).animate({ scrollTop: destination}, 900 );
	  	return false;
	  });
  });