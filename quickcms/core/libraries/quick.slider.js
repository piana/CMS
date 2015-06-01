/* 
Quick.Slider v1.0
License:
  Code in this file (or any part of it) can be used only as part of Quick.Cms v6.0 or later. All rights reserved by OpenSolution.
*/

(function($){
$.fn.quickslider = function( options ){
  return this.each(function() {
    var aDefault = {
      iPause: 4000,        // pause time between the slides
      iAnimateSpeed: 500,  // animation length
      mSliderHeight: null, // slider's height, accepted values: null (first slide), 'auto' (each separately), 150 (manual height in px))
      sPrevious: '',       // Previous button text
      sNext:     '',       // Next button text
      bAutoPlay: true,     // automatically changing slides
      bPauseOnHover: true, // pause after hover over slide
      bNavArrows: true,    // navigation arrows
      bNavDots: true,      // navigation dots
      sAnimation: 'fade',  // slides scrolling visual effect, accepted values: null, 'fade', 'scroll'
      bKeyboard: false,    // keyboard handling
    }
    
    // podstawowe zmienne
    var oQuickSlider = this,
      oConfig = {},
      iFix = 3,                                 // fix for WIN8 slider wrapper size counting problem
      oSlider = {
        oSliderWrapper: $(this),                // container object containing a slider with id used to call the method .quickslider ()
        oSlides: $(this).children().children(), // object of all elements in the list
        iNextSlide: 0,                          // active/next slide
        iPrevSlide: 0,                          // previous slide
        iTimer: 0,                              // references to timer
        iStop: 0,                               // stoping the slider
      }

    // function scrolling slider back
    function prev(){
      if( !$( oSlider.oSlides[oSlider.iPrevSlide] ).is(':animated') ){
        oSlider.iPrevSlide = oSlider.iNextSlide;
        oSlider.iNextSlide--;
        if(oSlider.iNextSlide < 0) 
          oSlider.iNextSlide = oSlider.oSlides.length - 1;
        show( 0 );
      }
    };
    
    // function scrolling slider forward
    function next( ){
      if( !$( oSlider.oSlides[oSlider.iPrevSlide] ).is(':animated') ){
        oSlider.iPrevSlide = oSlider.iNextSlide;
        oSlider.iNextSlide++;
        if(oSlider.iNextSlide >= oSlider.oSlides.length)
          oSlider.iNextSlide = 0;
        show( 1 );      
      }
    };

    // function showing active slider
    function show( iDirection, i ){
      // when the function is called from the initialization function
      if( !$( oSlider.oSlides[oSlider.iPrevSlide] ).is(':animated') && ( i || i == 0 ) ){
        oSlider.iPrevSlide = oSlider.iNextSlide;
        oSlider.iNextSlide = i;
      }

      if( !$( oSlider.oSlides[oSlider.iPrevSlide] ).is(':animated') && oSlider.iNextSlide != oSlider.iPrevSlide ){ // code executed only if the next slide is not the current slide
        // depending on the configuration (changing slides style)
        if( oConfig.sAnimation == 'scroll' )
          slide( iDirection );
        else if( oConfig.sAnimation == 'fade' )
          fading();
        else
          changeSlide();

        if( oConfig.mSliderHeight == 'auto' )
          oSlider.oSliderWrapper.height( oSlider.oSlides.eq(oSlider.iNextSlide).height() );

        if( oConfig.bNavDots )
          setNavigation();
        if( oConfig.bAutoPlay == true && oSlider.iStop == 0 ){
          slideTimer();
        }
      }
    };
    // keyboard handling
    function keyUpHandler(e){
      if( e.keyCode == 37 ) prev(); 
      if( e.keyCode == 39 ) next();
    }

    // function handling slider's timer
    function slideTimer(){
      if(oConfig.iPause && oConfig.iPause > 0 ){
        clearTimeout(oSlider.iTimer);
        oSlider.iTimer = setTimeout(function(){ next( true ); }, oConfig.iPause);
      }
    };
    
    // fading function
    function fading(){
      oSlider.oSlides.fadeOut( oConfig.iAnimateSpeed );
      $( oSlider.oSlides[oSlider.iNextSlide] ).fadeIn( oConfig.iAnimateSpeed );
    }
    
    // standard slide change function
    function changeSlide(){
      oSlider.oSlides.hide( );
      $( oSlider.oSlides[oSlider.iNextSlide] ).show( );
    }

    // scroll function
    function slide( iDirection ){
      var sMinus = ( !iDirection ) ? '-' : '',
          sMinus2 = ( !iDirection ) ? '' : '-';

      // preparing the next slide to show
      $( oSlider.oSlides[oSlider.iNextSlide] ).css( 'left', sMinus+(oSlider.oSliderWrapper.width()+iFix)+'px' );
      // sliding out of the slide from the container and flipping to 'stack'
      $( oSlider.oSlides[oSlider.iPrevSlide] ).animate({ left: sMinus2+oSlider.oSliderWrapper.width()+'px' }, oConfig.iAnimateSpeed, function(){ $(this).css( 'left', sMinus+(oSlider.oSliderWrapper.width()+iFix)+'px' ); } );
      // sliding in of the next slide to the container
      $( oSlider.oSlides[oSlider.iNextSlide] ).animate({ left: "0px" }, oConfig.iAnimateSpeed );
    }; // end slide

    // function updating active slide in the slides list
    function setNavigation(){
      oSlider.oSliderWrapper.find('.quick-slider-nav-dots').removeClass('active');
      $(oSlider.oSliderWrapper.find('.quick-slider-nav-dots').get(oSlider.iNextSlide)).addClass('active');
    }; // end setNavigation

    // function calculating slides positions
    function setStyles(){
      var aStyles = { left : (oSlider.oSliderWrapper.width()+iFix)+'px', display : 'block', opacity: '1' };
      oSlider.oSlides.css( aStyles );
      oSlider.oSlides.eq(oSlider.iNextSlide).addClass('active').css( 'left', '0px' );
    };
    
    // function initializing the slider
    function quickSliderInitialize(){
      oSlider.oSliderWrapper.show();
      // setting the correct styles for the slides scrolling
      oConfig = $.extend({}, aDefault, options);
      // assigning a class to the slider
      oSlider.oSliderWrapper.addClass('quick-slider');
      // assigning a class to each slide
      oSlider.oSlides.addClass('quick-slider-slide');
      // adjusting slide's height
      if( oConfig.mSliderHeight == null ){
        oSlider.oSliderWrapper.height( oSlider.oSlides.eq(0).height() );
        oSlider.oSlides.height( oSlider.oSlides.eq(0).height() );
      }
      else if( oConfig.mSliderHeight == 'auto' )
        oSlider.oSliderWrapper.height( oSlider.oSlides.eq(oSlider.iNextSlide).height() );
      else if( $.isNumeric( oConfig.mSliderHeight ) )
        oSlider.oSliderWrapper.height( oConfig.mSliderHeight );
      
      if( oSlider.oSlides.length > 1 ){
        if( oConfig.sAnimation == 'scroll' )
          setStyles();

        // generating buttons: 'next', 'prev'
        if( oConfig.bNavArrows ){
          var sPreviousButton = $('<a href="#" class="quick-slider-nav-arrows quick-slider-nav-arrows-prev">'+ oConfig.sPrevious +'</a>'),
            sNextButton = $('<a href="#" class="quick-slider-nav-arrows quick-slider-nav-arrows-next">'+ oConfig.sNext +'</a>');
          
          // at the event 'click' function prev will be called
          sPreviousButton.on('click', function(e){
            e.preventDefault();
            oSlider.iStop = 1;
            prev( );
          });

          // at the event 'click' function next will be called
          sNextButton.on('click', function(e){
            e.preventDefault();
            oSlider.iStop = 1;
            next( );
          });

          // adding buttons to html code
          $( oSlider.oSliderWrapper ).append( sPreviousButton, sNextButton ); 
        }

        if( oConfig.bNavDots ){
          // generating dots
          var oDots = $( oSlider.oSliderWrapper ).append( '<ol class="quick-slider-nav-dots-wrapper"></ol>' );

          oSlider.oSlides.each(function(i){
            // generating of the original class for each slide
            $(this).addClass( 'slide'+(i+1) );
            // generowanie listy kontrolek
            var controlNavigation = $('<li><a href="#" class="quick-slider-nav-dots">'+ (i + 1) +'</a></li>');

            // at the event 'click' function show will be called
            controlNavigation.on('click', function(e){
              e.preventDefault();
              oSlider.iStop = 1;
              show(1, i);
            });

            // adding the control to html code
            oDots.find('.quick-slider-nav-dots-wrapper' ).append( controlNavigation );
          });
        }

        // when the optional keyboard handling is switched on, events are assigned
        if( oConfig.bKeyboard ){
          oSlider.oSliderWrapper.focusin(function(){
            $(document).keyup( function( e ){
              keyUpHandler( e );
            });
          }).focusout(function(){
            $(document).unbind('keyup');
          });
        }

        // stop autoPlay on hover event
        if(oConfig.bPauseOnHover && oConfig.iPause && oConfig.iPause > 0){
          oSlider.oSliderWrapper.hover(
            function(){ clearTimeout(oSlider.iTimer); },
            function(){ oSlider.iStop = 0; if( oConfig.bAutoPlay == true ) slideTimer(); }
          );
        }

        // update the active slide in the slides list
        if( oConfig.bNavDots )
          setNavigation();
        if( oConfig.bAutoPlay == true )
          slideTimer();
      }
        
      return oQuickSlider;
    } // end quickSliderInitialize
    
    $(window).load(function(){return quickSliderInitialize(  );});
  });
};
})(jQuery);