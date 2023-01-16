<script>
        $(window).scroll(function() {
        if ($(this).scrollTop() > 1){  
            $('.header_padd').addClass("navbar-shrink");
          }
          else{
            $('.header_padd').removeClass("navbar-shrink");
          }
        }); 

         $('.ser_slide').slick({
         infinite: true,
         autoplay: true,
             dots: false,
         autoplaySpeed: 3000,
         slidesToShow: 3,
         slidesToScroll: 1,
         speed: 500,
         arrows: true,
         prevArrow:"<button type='button' class='slick-prev slide-btn'><i class='fas fa-chevron-left' aria-hidden='true'></i></button>",
         nextArrow:"<button type='button' class='slick-next slide-btn'><i class='fas fa-chevron-right' aria-hidden='true'></i></button>",    
         responsive: [
                        {
                          breakpoint: 1000,
                          settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                          }
                        },
                        {
                          breakpoint: 568,
                          settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                          }
                        }
                      ]
         });   

           function topFunction() {
             $('html, body').animate({ scrollTop: $("#top").offset().top}, 1500);
            }
       </script>