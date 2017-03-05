;(function ( $, window, document, undefined ) {

	$(document).ready(function(){

		var Galleries = {
			_init : function(){
				baguetteBox.run('.gallery-galleries-gallery');
			},
		}

		if($('.gallery').length !== 0){
			Galleries._init();
		}

		var HeroSlider = {
			// multiplier of random pan delta
			panDistance : 10,
			// fade between slides speed
			fadeSpeed : 700,
			// slide on screen time in ms
			screenTime : 4500,
			// scale multiplier
			scaleAmount : 1.15,

			slidesContainer : $('.home-hero-slides'),
			slides : $('.home-hero-slides-slide'),
			currentSlide : 0,
			currentlyAnimating : false,
			
			_init : function(pd, fs, st, sr){
				if(pd !== undefined) HeroSlider.panDistance = pd;
				if(fs !== undefined) HeroSlider.fadeSpeed = fs;
				if(st !== undefined) HeroSlider.screenTime = st;
				if(sr !== undefined) HeroSlider.scaleAmount = sr;				
				HeroSlider.slidesContainer.on('NEXT_HEROSLIDE', function(e){
					HeroSlider._nextSlide();
				});

				HeroSlider._animateCurrentSlide();
			},	
			_animateCurrentSlide : function(){
				var randX = 0;
				var randY = 0;
				$(HeroSlider.slides[HeroSlider.currentSlide]).animate(
					{
					// top : 50 + ((Math.random() * 2 - 1) * HeroSlider.panDistance) + '%',
					// left : 50 + ((Math.random() * 2 - 1) * HeroSlider.panDistance) + '%',
					textIndent : 1,
					}, 
					{
					duration : HeroSlider.screenTime,
					start : function(){
						randX = (Math.random() * 2) - 1;
						randY = (Math.random() * 2) - 1;
					},
					step : function(fx, now){
						now = now.now;
						var valX = -50 + Number((randX * HeroSlider.panDistance)*now) + '%';
						var valY = -50 /*+ Number((randY * HeroSlider.panDistance)*now)*/ + '%';
						$(this).css('-webkit-transform', 'translate3d(' + valX + ', ' + valY + ',0)');
						$(this).css('-moz-transform', 'translate3d(' + valX + ', ' + valY + ',0)');
						$(this).css('transform', 'translate3d(' + valX + ', ' + valY + ',0)');
					},
					progress : function(animation, progress, remaining){
						if(remaining <= 450 && HeroSlider.currentlyAnimating != true){
							HeroSlider.slidesContainer.trigger('NEXT_HEROSLIDE');
							HeroSlider.currentlyAnimating = true;
						}
					},
					complete : function(){
						HeroSlider.currentlyAnimating = false;
					},
				});
			},
			_nextSlide : function(){
				// grab old currentslide
				var previousSlide = HeroSlider.currentSlide;
				// update currentslide
				if(HeroSlider.currentSlide == 3){
					HeroSlider.currentSlide = 0;
				}
				else{
					HeroSlider.currentSlide++;
				}
				// fade slides & reset previous slide's css
				$(HeroSlider.slides[previousSlide]).fadeOut(HeroSlider.fadeSpeed, function(){
					$(HeroSlider.slides[previousSlide]).removeAttr('style');
				});
				$(HeroSlider.slides[HeroSlider.currentSlide]).fadeIn(HeroSlider.fadeSpeed);
				// animate next slide
				HeroSlider._animateCurrentSlide();
			}
		}
		HeroSlider._init();


		var MobileNav = {
			currentDevice : null,
			barTint : $('.mobileheader-bar-tint'),
			menuToggle : $('.mobileheader-bar-menutoggle-icon'),
			menuTint : $('.mobileheader-tint'),
			menu : $('.mobileheader-menus'),
			_init : function(){
				$(window).on('resize load', MobileNav._resizeLoadHandler);
				if(DisableNavTintFadein == 'false'){
					$(window).on('scroll load', MobileNav._scrollHandler);	
				}
				MobileNav.menuToggle.on('click', MobileNav._menuToggleHandler);
			},
			_resizeLoadHandler : function(e){
				if(e.type == 'load'){
					// phones
					if($(window).width() < 641){
						MobileNav.currentDevice = 'phone';
						MobileNav._doPhones();
					}
					// tablet
					else if($(window).width() < 1025 && $(window).width() > 640){
						MobileNav.currentDevice = 'tablet';
						MobileNav._doTablet();
					}
					// desktop
					else{
						MobileNav.currentDevice = 'desktop';
						MobileNav._doDesktop();
					}
				}
				// phones
				if($(window).width() < 641 && MobileNav.currentDevice != 'phone'){
					MobileNav.currentDevice = 'phone';
					MobileNav._doPhones();
				}
				// tablet
				else if( ($(window).width() < 1025 && $(window).width() > 640) && MobileNav.currentDevice != 'tablet' ){
					MobileNav.currentDevice = 'tablet';
					MobileNav._doTablet();
				}
				// desktop
				else if($(window).width() >= 1025 && MobileNav.currentDevice != 'desktop'){
					MobileNav.currentDevice = 'desktop';
					MobileNav._doDesktop();
				}
			},
			_doPhones : function(){

			},
			_doTablet : function(){

			},
			_doDesktop : function(){
				MobileNav._closeMenu();
			},
			_map : function(n,i,o,r,t){return i>o?i>n?(n-i)*(t-r)/(o-i)+r:r:o>i?o>n?(n-i)*(t-r)/(o-i)+r:t:void 0;},
			_scrollHandler : function(e){
				MobileNav.barTint.css('opacity', MobileNav._map($(window).scrollTop(), 0, 100, 0, 1));
			},
			_menuToggleHandler : function(e){
				if(MobileNav.menuToggle.hasClass('fa-bars')){
					MobileNav._openMenu();
				}
				else{
					MobileNav._closeMenu();
				}
			},
			_closeMenu : function(){
				MobileNav.menuToggle.removeClass('fa-times');
				MobileNav.menuToggle.addClass('fa-bars');

				MobileNav.menu.removeClass('mobileheader-menus--show');
				MobileNav.menuTint.removeClass('mobileheader-tint--show');
			},
			_openMenu : function(){
				MobileNav.menuToggle.removeClass('fa-bars');
				MobileNav.menuToggle.addClass('fa-times');

				MobileNav.menu.addClass('mobileheader-menus--show');
				MobileNav.menuTint.addClass('mobileheader-tint--show');
			},
		};

		MobileNav._init();


		var DesktopNav = {
			tint : $('.header-tint'),
			estimate : $('.header-content-quickquote'),
			estimatePopup : $('.estimate'),
			estimateClose : $('.estimate.popupcontainer, .estimate-content-times.popupcontainer-times'),
			_init: function(){

				if(DisableNavTintFadein == 'false'){
					$(window).on('scroll load', DesktopNav._scrollLoadHandler);		
				}
				DesktopNav.estimate.click(DesktopNav._estimateClickHandler);
				DesktopNav.estimateClose.click(DesktopNav._estimateCloseClickHandler);
			},
			_map : function(n,i,o,r,t){return i>o?i>n?(n-i)*(t-r)/(o-i)+r:r:o>i?o>n?(n-i)*(t-r)/(o-i)+r:t:void 0;},
			_scrollLoadHandler : function(e){
				DesktopNav.tint.css('opacity', DesktopNav._map($(window).scrollTop(), 0, 100, 0, 1));
			},
			_estimateClickHandler : function(e){
				e.preventDefault();
				DesktopNav.estimatePopup.fadeIn(250);
			},
			_estimateCloseClickHandler : function(e){
				if($(e.target).hasClass('estimate') || $(e.target).hasClass('estimate-content-times')){
					e.preventDefault();
					DesktopNav.estimatePopup.fadeOut(250);	
				}
			}
		}

		DesktopNav._init();


		var AnimateNavScrolling = {
			links : $('.header-content-menus-pages-menu-item-link'),
			_init : function(){
				if((window.location.origin + window.location.pathname).slice(0,-1) == Home_URL){
					AnimateNavScrolling.links.click(AnimateNavScrolling._linkClickHandler);
					$(window).on('load', AnimateNavScrolling._linkClickHandler);
				}
			},
			_linkClickHandler : function(e){
				e.preventDefault();
				var hash = e.target.hash == undefined ? window.location.hash : e.target.hash;
				if(hash !== undefined && hash !== ""){
					setTimeout(function(){
						$('html, body').animate({
							scrollTop: $(hash).offset().top - $('.header-tint')[0].clientHeight,
						}, 500, function(){
							window.location.hash = hash;
						});
					}, 100);
				}
			},
		}

		AnimateNavScrolling._init();


		var HomeTestimonialsSlider = {
			slides : $('.home-testimonials-grid-item'),
			arrowLeft : $('.home-testimonials-arrows-left'),
			arrowRight : $('.home-testimonials-arrows-right'),
			arrows : $('.home-testimonials-arrows i'),
			slideMax : null,
			currentSlide : 0,
			_init : function(){
				// if there are slides
				if(HomeTestimonialsSlider.slides.length != 0){
					HomeTestimonialsSlider.slideMax = HomeTestimonialsSlider.slides.length - 1;
					// if 1 slide
					if(HomeTestimonialsSlider.slideMax == 0){
						HomeTestimonialsSlider.arrows.addClass('grey');
					}
					HomeTestimonialsSlider.arrows.on('click', HomeTestimonialsSlider._arrowsClickHandler);	
				}
				else{
					$('.home-testimonials').hide();
				}
			},
			_arrowsClickHandler : function(e){
				if(e.target == HomeTestimonialsSlider.arrowLeft[0]){
					if(HomeTestimonialsSlider.currentSlide != 0){
						HomeTestimonialsSlider._updateCurrentSlide(-1);
					}
				}
				if(e.target == HomeTestimonialsSlider.arrowRight[0]){
					if(HomeTestimonialsSlider.currentSlide != HomeTestimonialsSlider.slideMax){
						HomeTestimonialsSlider._updateCurrentSlide(1);	
					}
				}
				// if more than 3 slides
				if(HomeTestimonialsSlider.slideMax >= 2){
					if(HomeTestimonialsSlider.currentSlide == 0){
						HomeTestimonialsSlider.arrowLeft.addClass('grey');
					}
					else if(HomeTestimonialsSlider.currentSlide != 0 && HomeTestimonialsSlider.currentSlide != HomeTestimonialsSlider.slideMax){
						HomeTestimonialsSlider.arrows.removeClass('grey');	
					}
					else if(HomeTestimonialsSlider.currentSlide == HomeTestimonialsSlider.slideMax){
						HomeTestimonialsSlider.arrowRight.addClass('grey');	
					}	
				}
				// if 2 slides
				if(HomeTestimonialsSlider.slideMax == 1){
					if(HomeTestimonialsSlider.currentSlide == 0){
						HomeTestimonialsSlider.arrowLeft.addClass('grey');
						HomeTestimonialsSlider.arrowRight.removeClass('grey');
					}
					else{
						HomeTestimonialsSlider.arrowRight.addClass('grey');
						HomeTestimonialsSlider.arrowLeft.removeClass('grey');	
					}
				}
			},
			_updateCurrentSlide : function(amount){
				$(HomeTestimonialsSlider.slides[HomeTestimonialsSlider.currentSlide]).fadeOut();
				HomeTestimonialsSlider.currentSlide += amount;
				$(HomeTestimonialsSlider.slides[HomeTestimonialsSlider.currentSlide]).fadeIn();
			}
		}

		if($('.home-testimonials').length > 0){
			HomeTestimonialsSlider._init();
		}


		var Estimate = {
			link : $('.header-estimate-link'),
			_init : function(){
				Estimate.link.on('click', Estimate._clickHandler);
			},
			_clickHandler : function(e){
				e.preventDefault();
				if(PA.container.css('display') == 'none'){
					if( $(window).width() >= 1025 ){
						PA._showPA();	
					}
				}
			}
		}

		Estimate._init();


		var PA = {
			container : $('.pa.popupcontainer'),
			submit : $('.pa.popupcontainer input[type="submit"]'),
			_init : function(){
				PA.container.click(PA._clickHandler);
			},
			_clickHandler : function(e){
				if($(e.target).hasClass('pa') || $(e.target).hasClass('popupcontainer-times')){
					if($(e.target).has('.ginput_container').length == 0){
						CookieMonster._setCookie('ad_set', 'active', 30, true);
						CookieMonster._deleteCookie('ad_notset');
						CookieMonster._deleteCookie('ad_firsttime');	
						PA.container.off('click');
					}					
					PA._hidePA();	
				}
			},
			_hidePA : function(){
				PA.container.fadeOut(250);
				if(CookieMonster._cookieExists('ad_set') == false){
					CookieMonster._setCookie('ad_notset', 'active', 3600, false);
					CookieMonster._listenCookieExpire('ad_notset', CookieMonster._firstTimeExpire);	
				}
			},
			_showPA : function(){
				if(PA.container.css('display') == 'none'){
					PA.container.fadeIn(250);	
				}
			}
		}

		PA._init();

		var CookieMonster = {
			_init : function(){
				// CookieMonster._deleteCookie('ad_firsttime');
				// CookieMonster._deleteCookie('ad_notset');
				if(CookieMonster._cookieExists('ad_notset') == false && CookieMonster._cookieExists('ad_set') == false && CookieMonster._cookieExists('ad_firsttime') == false){
					CookieMonster._setCookie('ad_firsttime', 'active', 30, false);
				}
				if(CookieMonster._cookieExists('ad_set') == false && CookieMonster._cookieExists('ad_notset') == false){
					CookieMonster._listenCookieExpire('ad_firsttime', CookieMonster._firstTimeExpire);	
				}
			},
			_listenCookieExpire : function(cookieName, callback) {
			    var si = setInterval(function() {
			        if (CookieMonster._cookieExists(cookieName) === false) {
			        	clearInterval(si);
		                return callback();
			        } 
			    }, 100);
			},
			_setCookie : function(cname,cvalue,ctime,days){
				var d = new Date();
				// if days is set to false use seconds
				if(days == undefined || days){
					days = true;
					d.setTime(d.getTime() + (ctime*24*60*60*1000));
				}
				else if(days == false){
					d.setTime(d.getTime() + (ctime*1000));
				}			    
			    var expires = "expires="+ d.toUTCString();
			    document.cookie = cname + "=" + cvalue + "; " + expires;
			},
			_getCookieValue : function(cname){
				var nameEQ = cname + "=";
			    var ca = document.cookie.split(';');
			    for (var i = 0; i < ca.length; i++) {
			        var c = ca[i];
			        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
			        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
			    }
			    return null;
			},
			_cookieExists : function(cname){
			    if (CookieMonster._getCookieValue(cname) != null) {
			        return true;
			    } 
			    else {
			        return false;
			    }
			},
			_deleteCookie : function( name ) {
				document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
			},
			_firstTimeExpire : function(){
				PA._showPA();
			},
		};

		CookieMonster._init();


		var MenuGrid = {
			grid : $('.menu-menu-grid-category-grid'),
			_init : function(){
				for(var i = 0; i < MenuGrid.grid.length; i++){
					$(MenuGrid.grid[i]).masonry({
						itemSelector : '.menu-menu-grid-category:nth-child(' + (i+1) + ') .menu-menu-grid-category-grid-item',
					});
				}
			},
		}

		MenuGrid._init();

	});

})( jQuery, window, document );

window._initContactMap = function(){
	

	var latlangs = [];

	ContactAddresses.forEach(function(el, index, parent){
		latlangs.push({lat: Number(el.lat), lng: Number(el.lng)});
	});

	var element = document.querySelector('.contact-hero-map');
	if(element != null){


		// build bounds & make center of map coords
		var bounds  = new google.maps.LatLngBounds();
		var map_center = [];
		var x = 0;
		var y = 0;


		var map = new google.maps.Map(element, {
	      zoom: 28,
	      mapTypeId: 'terrain',
	      disableDefaultUI: true,
	      scrollwheel: false,
	      draggable: false,
	    });

		latlangs.forEach(function(el){

			x += Number(el.lat);
			y += Number(el.lng);

			var marker = new google.maps.Marker({
			  position: el,
			  map: map,
			});	

			bounds.extend(el);

		});

		map_center[0] = x / latlangs.length;
		map_center[1] = y / latlangs.length;

		map.setCenter({lat: map_center[0], lng: map_center[1]});


		google.maps.event.addListener(map, 'zoom_changed', function() {
		    zoomChangeBoundsListener = 
		        google.maps.event.addListener(map, 'bounds_changed', function(event) {
		            if (this.getZoom() > 15 && this.initialZoom == true) {
		                // Change max/min zoom here
		                this.setZoom(15);
		                this.initialZoom = false;
		            }
		        google.maps.event.removeListener(zoomChangeBoundsListener);
		    });
		});
		map.initialZoom = true;


	 	// zoom to bounds
	 	if(latlangs.length > 1){
	 		map.fitBounds(bounds);
	 		var listener = google.maps.event.addListener(map, "idle", function() { 
	 		  map.setZoom(map.getZoom() - 1); 
	 		  google.maps.event.removeListener(listener); 
	 		});
	 		
	 	}	
	    map.panToBounds(bounds);
		
	}
	
}

window._initHomeMap = function(){
	// build latlangs
	var geocoder = new google.maps.Geocoder();
	var latlangs = [];
	
	for(var i = 0; i < AreasServed.length; i++){
		geocoder.geocode({address: AreasServed[i]}, build_latlangs);
	}
	function build_latlangs(results, status){
		var temparr = [];
		temparr.push(results[0].geometry.location.lat());
		temparr.push(results[0].geometry.location.lng());
		latlangs.push(temparr);
	}
	// setTimeout(build_map, 1000);
	jQuery(window).on('load', build_map);
	function build_map(){
		// build map center
		var map_center = [];
		var x = 0;
		var y = 0;

		// build bounds & make center of map coords
		bounds  = new google.maps.LatLngBounds();

		for(var i = 0; i < latlangs.length; i++){
			x += latlangs[i][0];
			y += latlangs[i][1];
			bounds.extend({lat: latlangs[i][0], lng: latlangs[i][1]});
		}
		
		map_center[0] = x / latlangs.length;
		map_center[1] = y / latlangs.length;

		// build map
		var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 11,
          center: {lat: map_center[0], lng: map_center[1]},
          mapTypeId: 'terrain',
          disableDefaultUI: true,
          scrollwheel: false,
          draggable: false,
        });
		// add circles
		for (var i = 0; i < latlangs.length; i++) {
	         var cityCircle = new google.maps.Circle({
	         	strokeColor: '#FF0000',
	         	strokeOpacity: 0.8,
	         	strokeWeight: 2,
	         	fillColor: '#FF0000',
	         	fillOpacity: 0.35,
	         	map: map,
	         	center: {lat: latlangs[i][0], lng: latlangs[i][1]},
	         	radius: 9000,
	        });
	    }
     	// zoom to bounds
     	if(latlangs.length > 1){
     		map.fitBounds(bounds);	
     	}	
	    map.panToBounds(bounds);
	}	

	window._initContactMap();
}

