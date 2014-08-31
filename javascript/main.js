$(document).ready(function() {

  //  Layouts 

  function topBarBtn() {
    
    $('.openingHours').on('click', function(e) {
      
      $(this).toggleClass('topBarActive');
      if($('.contact').hasClass('topBarActive')){
        $('.contactModule .footerModule').fadeOut();
        $('.contact').toggleClass('topBarActive');
      }
      $('.openingHoursModule .footerModule').fadeToggle();
      
      e.preventDefault();
      
    });

    $('.loginClose').on('click', function(e) {
      
      $('.openingHoursModule .footerModule').fadeToggle();
      $('.openingHours').toggleClass('topBarActive');
      
      e.preventDefault();
      
    });

    $('.contact').on('click', function(e) {
      if($(this).hasClass('signed_in')){
        $(this).toggleClass('topBarActive');
        if($('.profile').hasClass('topBarActive')){
          $('.profileModule .footerModule').fadeOut();
          $('.profile').toggleClass('topBarActive');
        }
        else if($('.notifications').hasClass('topBarActive')){
          $('.notificationsModule .footerModule').fadeOut();
          $('.notifications').toggleClass('topBarActive');
        }
        $('.contactModule .footerModule').fadeToggle();
        
        e.preventDefault();
      }
      else{
        $(this).toggleClass('topBarActive');
        if($('.openingHours').hasClass('topBarActive')){
          $('.openingHoursModule .footerModule').fadeOut();
          $('.openingHours').toggleClass('topBarActive');
        }
        $('.contactModule .footerModule').fadeToggle();
        
        e.preventDefault();
      }
      
    });
    $('.contactClose').on('click', function(e) {
      
      $('.contactModule .footerModule').fadeToggle();
      $('.contact').toggleClass('topBarActive');
      
      e.preventDefault();
      
    });
    $('.profile').on('click', function(e) {
      
      $(this).toggleClass('topBarActive');
      if($('.contact').hasClass('topBarActive')){
        $('.contactModule .footerModule').fadeOut();
        $('.contact').toggleClass('topBarActive');
      }
      else if($('.notifications').hasClass('topBarActive')){
        $('.notificationsModule .footerModule').fadeOut();
        $('.notifications').toggleClass('topBarActive');
      }
      $('.profileModule .footerModule').fadeToggle();
      
      e.preventDefault();
      
    });

    $('.profileClose').on('click', function(e) {
      
      $('.profileModule .footerModule').fadeToggle();
      $('.profile').toggleClass('topBarActive');
      
      e.preventDefault();
      
    });
    $('.notifications').on('click', function(e) {
      
      $(this).toggleClass('topBarActive');
      if($('.contact').hasClass('topBarActive')){
        $('.contactModule .footerModule').fadeOut();
        $('.contact').toggleClass('topBarActive');
      }
      else if($('.profile').hasClass('topBarActive')){
        $('.profileModule .footerModule').fadeOut();
        $('.profile').toggleClass('topBarActive');
      }
      $('.notificationsModule .footerModule').fadeToggle();
      
      e.preventDefault();
      
    });

    $('.notificationsClose').on('click', function(e) {
      
      $('.notificationsModule .footerModule').fadeToggle();
      $('.notifications').toggleClass('topBarActive');
      
      e.preventDefault();
      
    });
    
  }
  function whiteBar() {
    
    var windowWidth = $(window).width();
    var windowWidthMinusBar = windowWidth - 980;
    var windowWidthMinusBar2 = windowWidth - 790;
    var positionLeft = windowWidthMinusBar / 2;
    var positionLeft2 = windowWidthMinusBar2 / 2;


    $('.whiteTop').css("left", positionLeft);
    $('.whiteTop2').css("left", positionLeft2);
    $('.slidesDescription').css("left", positionLeft);                  
  }
  function questionOpener(){

    $('.question').toggle(function(){
     $(this).parent().find(".answer").fadeIn();
   },
   function() { 
     $(this).parent().find(".answer").fadeOut();
   });

  }
  function loginError(){
    $('#mustLoginMessage').fadeIn(1000);
    $('#mustLoginMessage').delay(4500).fadeOut();
  }
  function mobileMenu() {
    
          // Create the dropdown base
          $("<select />").appendTo("nav .container .sixteen");
          $("nav select").hide();
          
          // Create default option "Go to..."
          $("<option />", {
            "selected": "selected",
            "value"   : "",
            "text"    : "Go to..."
          }).appendTo("nav select");

          // Populate dropdown with menu items
          $("nav a").each(function() {
            var el = $(this);
            $("<option />", {
              "value"   : el.attr("href"),
              "text"    : el.text()
            }).appendTo("nav select");
          });

          $("nav select").change(function() {
            window.location = $(this).find("option:selected").val();
          });            
        }          
        function select() {
      // FOR EACH SELECT
      $('nav select').each(function() {

          // LET'S PUT OUR MARKUP BEFORE IT
          $(this).before('<div class="select-wrapper">');

          // LETS PUR OUR MARKUP AFTER IT
          $(this).after('<span class="select-container"></span></div>');

          // UPDATES THE INITIAL SELECTED VALUE
          var initialVal = $(this).children('option:selected').text();
          $(this).siblings('span.select-container').text(initialVal);

          // HIDES SELECT BUT LET THE USER STILL CLICK IT
          $(this).css({opacity: 0});  

          // WHEN USER CHANGES THE SELECT, WE UPDATE THE SPAN BOX
          $(this).change(function() {

            // GETS NEW SELECTED VALUE
            var newSelVal = $(this).children('option:selected').text();

            // UPDATES BOX
            $(this).siblings('span.select-container').text(newSelVal);

          });

        });            
    }

  //  Layout Initializer
  function layoutInit(){
    topBarBtn();
    mobileMenu();
    questionOpener();
    select();
    $('.sliderWrapper').fadeIn(); 
    $("body").css("overflow", "hidden");
    var t=setTimeout(function(){
      $("body").css("overflow", "auto");
      whiteBar();
    },100);
  }

  //  Plugins

  function isotopeInit(){
    // cache container
    var $container = $('.pageContentWrapper .dd_classes_widget, .pageContentWrapper .dd_trainers_widget,.homeWidgetModule .dd_trainers_widget');
    // initialize isotope
    $container.isotope({
      // options...
      itemSelector : '.one-third',
      layoutMode : 'masonry'
    });

    // filter items when filter link is clicked
    $('#reset a').click(function(){
      var selector = $(this).attr('data-filter');
      $container.isotope({ filter: selector });
      return false;
    });   
  }
  function prettyPhoto() {
    
    $("area[rel^='prettyPhoto']").prettyPhoto();
    
    $(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'normal',theme:'light_square',slideshow:3000, autoplay_slideshow: false});
    $(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animation_speed:'fast',slideshow:10000, hideflash: true});

    $("#custom_content a[rel^='prettyPhoto']:first").prettyPhoto({
     custom_markup: '<div id="map_canvas" style="width:260px; height:265px"></div>',
     changepicturecallback: function(){initialize();}
   });

    $("#custom_content a[rel^='prettyPhoto']:last").prettyPhoto({
     custom_markup: '<div id="bsap_1259344" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div><div id="bsap_1237859" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6" style="height:260px"></div><div id="bsap_1251710" class="bsarocks bsap_d49a0984d0f377271ccbf01a33f2b6d6"></div>',
     changepicturecallback: function(){_bsap.exec();}
   });      
  }
  function carouselInit(){
    $('#carousel').flexslider({
      animation: "slide",
      controlNav: false,
      animationLoop: false,
      slideshow: false,
      itemWidth: 185,
      touch: false,
      itemMargin: 5,
      asNavFor: '#slider'
    });
    
    $('#slider').flexslider({
      animation: "slide",
      controlNav: false,

      animationLoop: false,
      slideshow: false,
      sync: "#carousel"
    });
  }

  //   Plugin Initializers
  function pluginInit(){
    forminit();
    carouselInit();
    isotopeInit();
    $('ul.sf-menu').superfish();
  }





  //  Main Flow
  $(window).load(function() {
    loginError();
    layoutInit();       
    pluginInit();
    adapterInit();

  });

  // Resizing (Responsiveness)
  $(window).resize(function() { 
    $('.reset').click();
    whiteBar(); 
  });

});
