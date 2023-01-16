
/* Fix Navigation on Scroll
--------------------------*/

$('#navbarPrimary').affix({
      offset: {
        top: $('#navbarPrimary').height() //+ $('.home-intro').height()
      }
});	


/*  For Tooltip
--------------------------*/

$(document).ready(function() {
    $('[data-toggle=tooltip]').tooltip();
}); 


/*  Homepage Hero Module
--------------------------*/
//jQuery is required to run this code
$( document ).ready(function() {

    scaleVideoContainer();

    initBannerVideoSize('.video-container .poster img');
    initBannerVideoSize('.video-container .filter');
    initBannerVideoSize('.video-container video');

    $(window).on('resize', function() {
        scaleVideoContainer();
        scaleBannerVideoSize('.video-container .poster img');
        scaleBannerVideoSize('.video-container .filter');
        scaleBannerVideoSize('.video-container video');
    });

});

function scaleVideoContainer() {

    var height = $(window).height() + 5;
    var unitHeight = parseInt(height) + 'px';
    $('.homepage-hero-module').css('height',unitHeight);

}

function initBannerVideoSize(element){

    $(element).each(function(){
        $(this).data('height', $(this).height());
        $(this).data('width', $(this).width());
    });

    scaleBannerVideoSize(element);

}

function scaleBannerVideoSize(element){

    var windowWidth = $(window).width(),
    windowHeight = $(window).height() + 5,
    videoWidth,
    videoHeight;

    console.log(windowHeight);

    $(element).each(function(){
        var videoAspectRatio = $(this).data('height')/$(this).data('width');

        $(this).width(windowWidth);

        if(windowWidth < 1000){
            videoHeight = windowHeight;
            videoWidth = videoHeight / videoAspectRatio;
            $(this).css({'margin-top' : 0, 'margin-left' : -(videoWidth - windowWidth) / 2 + 'px'});

            $(this).width(videoWidth).height(videoHeight);
        }

        $('.homepage-hero-module .video-container video').addClass('fadeIn animated');

    });
}



/*  Hamburger menu
--------------------------*/

$(".nav_trigger").click(function(e) {
       // e.preventDefault();
      $(".nav_icon").toggleClass("open");
	  	  
	  $("body").toggleClass("isopen_sidenav");
		$( "body" ).hasClass( "isopen_sidenav" )
		if ($('body').hasClass('isopen_sidenav')){
			$(".slideout_wrapper").css({
				"display":"block",
				"z-index":"10000",
				"transform":"matrix(1, 0, 0, 1, 0, 0)"
			});
			$("#wrapper").css({
				"z-index":"3" ,
				"transform":"matrix(1, 0, 0, 1, -220, 0)"
			});
			$("#navbarPrimary").css({
				"z-index":"1000" ,
				"transform":"matrix(1, 0, 0, 1, -220, 0)"
			});
		}else{
			$(".slideout_wrapper").removeAttr("style");	
			$("#wrapper").removeAttr("style");
			$("#navbarPrimary").removeAttr("style");
			
			$(".slideout_wrapper").css({
				"display":"",
				"z-index":"",
				"transform":""
			});
			$("#wrapper").css({
				"z-index":"" ,
				"transform":""
			});
			$("#navbarPrimary").css({
				"z-index":"" ,
				"transform":""
			});
			
		}
});

/*	On Click Side nav Links changes the Trigger text 
---------------------------------------------------------*/

$('.sidenav .nav li a').click(function() {	
	
	$("this").toggleClass("active");
	if ($('body').hasClass('isopen_sidenav')){
		var linkText = $(this).text();	
		$('.change_text').fadeOut("fast");	
		$('.change_text').text(linkText);
		$('.change_text').fadeIn("slow");	
		}
	else{
        return false;
	}
});

/*	For animation 
---------------------------------------------------------*/
$(document).ready(function() {
 wow = new WOW(
			{
			  boxClass:     'wow',      // default
			  animateClass: 'animated', // default
			  offset:       0,          // default
			  mobile:       true,       // default
			  live:         true        // default
			}
		  )
		  wow.init();
 wow_atom = new WOW(
			{
			  boxClass:     'wow_atom',      // default
			  animateClass: 'active-state', // default
			  offset:       0,          // default
			  mobile:       true,       // default
			  live:         true        // default
			}
		  )
		  wow_atom.init();
});
 
	
		/*	form text animation---------------------------------------------------------*/
	jQuery(document).ready(function($){
	if( $('.floating-labels').length > 0 ) floatLabels();

	function floatLabels() {
		var inputFields = $('.floating-labels .cd-label').next();
		inputFields.each(function(){
			var singleInput = $(this);
			//check if user is filling one of the form fields 
			checkVal(singleInput);
			singleInput.on('change keyup', function(){
				checkVal(singleInput);	
			});
		});
	}

	function checkVal(inputField) {
		( inputField.val() == '' ) ? inputField.prev('.cd-label').removeClass('float') : inputField.prev('.cd-label').addClass('float');
	}
});
	
	
	/*	number Counter---------------------------------------------------------*/
(function(d){var q=function(b){return b.split("").reverse().join("")},m={numberStep:function(b,a){var e=Math.floor(b);d(a.elem).text(e)}},h=function(b){var a=b.elem;a.nodeType&&a.parentNode&&(a=a._animateNumberSetter,a||(a=m.numberStep),a(b.now,b))};d.Tween&&d.Tween.propHooks?d.Tween.propHooks.number={set:h}:d.fx.step.number=h;d.animateNumber={numberStepFactories:{append:function(b){return function(a,e){var g=Math.floor(a);d(e.elem).prop("number",a).text(g+b)}},separator:function(b,a,e){b=b||" ";
a=a||3;e=e||"";return function(g,k){var c=Math.floor(g).toString(),t=d(k.elem);if(c.length>a){for(var f=c,l=a,m=f.split("").reverse(),c=[],n,r,p,s=0,h=Math.ceil(f.length/l);s<h;s++){n="";for(p=0;p<l;p++){r=s*l+p;if(r===f.length)break;n+=m[r]}c.push(n)}f=c.length-1;l=q(c[f]);c[f]=q(parseInt(l,10).toString());c=c.join(b);c=q(c)}t.prop("number",g).text(c+e)}}}};d.fn.animateNumber=function(){for(var b=arguments[0],a=d.extend({},m,b),e=d(this),g=[a],k=1,c=arguments.length;k<c;k++)g.push(arguments[k]);
if(b.numberStep){var h=this.each(function(){this._animateNumberSetter=b.numberStep}),f=a.complete;a.complete=function(){h.each(function(){delete this._animateNumberSetter});f&&f.apply(this,arguments)}}return e.animate.apply(e,g)}})(jQuery);

