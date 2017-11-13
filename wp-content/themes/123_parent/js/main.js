var Theme = {};

;(function ( $, Theme, window, document, undefined ) {

	$(document).ready(function(){

		Theme.FadeEffects = {
			elements : $('.fade-up, .fade-left, .fade-right, .fade-in'),
			_init : function(){
				$(window).on('resize load scroll', Theme.FadeEffects._resizeLoadScrollHandler);
			},
			_resizeLoadScrollHandler : function(){
				for(var i = 0; i < Theme.FadeEffects.elements.length; i++){
					if( $(window).scrollTop() + $(window).height() > $(Theme.FadeEffects.elements[i]).offset().top )	{
						$(Theme.FadeEffects.elements[i]).removeClass('fade-up fade-left fade-right fade-in');
					}
				}
			},
		}



		Theme.Galleries = {
			_init : function(){
				if( $('.gallery').length > 0 ){
					baguetteBox.run('.gallery-galleries-gallery');
				}
			},
		}



		Theme.HeroSlider = {
			// slide on screen time in ms
			screenTime : 4500,

			slidesContainer : $('.home-hero-slides'),
			slides : $('.home-hero-slides-slide'),
			currentSlide : 0,
			currentlyAnimating : false,
			
			_init : function(st){
				
				if(st !== undefined) Theme.HeroSlider.screenTime = st;
			
				Theme.HeroSlider.slidesContainer.on('NEXT_HEROSLIDE', function(e){
					Theme.HeroSlider._nextSlide();
				});

				Theme.HeroSlider._animateCurrentSlide();
			},	
			_animateCurrentSlide : function(){
				$(Theme.HeroSlider.slides[Theme.HeroSlider.currentSlide]).animate(
					{
						textIndent : 1,
					}, 
					{
						duration : Theme.HeroSlider.screenTime,
						progress : function(animation, progress, remaining){
							if(remaining <= 450 && Theme.HeroSlider.currentlyAnimating != true){
								Theme.HeroSlider.slidesContainer.trigger('NEXT_HEROSLIDE');
								Theme.HeroSlider.currentlyAnimating = true;
							}
						},
						complete : function(){
							Theme.HeroSlider.currentlyAnimating = false;
						},
					}
				);
			},
			_nextSlide : function(){
				// grab old currentslide
				var previousSlide = Theme.HeroSlider.currentSlide;
				// update currentslide
				if(Theme.HeroSlider.currentSlide == $(Theme.HeroSlider.slides).length - 1){
					Theme.HeroSlider.currentSlide = 0;
				}
				else{
					Theme.HeroSlider.currentSlide++;
				}
				// fade slides
				$(Theme.HeroSlider.slides[previousSlide]).fadeOut(Theme.HeroSlider.fadeSpeed);
				$(Theme.HeroSlider.slides[Theme.HeroSlider.currentSlide]).fadeIn(Theme.HeroSlider.fadeSpeed);
				// animate next slide
				Theme.HeroSlider._animateCurrentSlide();
			}
		}


		Theme.MobileNav = {
			currentDevice : null,
			barTint : $('.mobileheader-bar-tint'),
			menuToggle : $('.mobileheader-bar-menutoggle-icon'),
			menuTint : $('.mobileheader-tint'),
			menu : $('.mobileheader-menus'),
			links : $('.mobileheader-menus-pages-menu-item-link'),
			_init : function(){
				$(window).on('resize load', Theme.MobileNav._resizeLoadHandler);
				if(DisableNavTintFadein == 'false'){
					$(window).on('scroll load', Theme.MobileNav._scrollHandler);	
				}
				Theme.MobileNav.menuToggle.on('click', Theme.MobileNav._menuToggleHandler);
				Theme.MobileNav.links.on('click', Theme.MobileNav._closeMenu);
			},
			_resizeLoadHandler : function(e){
				if(e.type == 'load'){
					// phones
					if($(window).width() < 641){
						Theme.MobileNav.currentDevice = 'phone';
						Theme.MobileNav._doPhones();
					}
					// tablet
					else if($(window).width() < 1025 && $(window).width() > 640){
						Theme.MobileNav.currentDevice = 'tablet';
						Theme.MobileNav._doTablet();
					}
					// desktop
					else{
						Theme.MobileNav.currentDevice = 'desktop';
						Theme.MobileNav._doDesktop();
					}
				}
				// phones
				if($(window).width() < 641 && Theme.MobileNav.currentDevice != 'phone'){
					Theme.MobileNav.currentDevice = 'phone';
					Theme.MobileNav._doPhones();
				}
				// tablet
				else if( ($(window).width() < 1025 && $(window).width() > 640) && Theme.MobileNav.currentDevice != 'tablet' ){
					Theme.MobileNav.currentDevice = 'tablet';
					Theme.MobileNav._doTablet();
				}
				// desktop
				else if($(window).width() >= 1025 && Theme.MobileNav.currentDevice != 'desktop'){
					Theme.MobileNav.currentDevice = 'desktop';
					Theme.MobileNav._doDesktop();
				}
			},
			_doPhones : function(){

			},
			_doTablet : function(){

			},
			_doDesktop : function(){
				Theme.MobileNav._closeMenu();
			},
			_map : function(n,i,o,r,t){return i>o?i>n?(n-i)*(t-r)/(o-i)+r:r:o>i?o>n?(n-i)*(t-r)/(o-i)+r:t:void 0;},
			_scrollHandler : function(e){
				Theme.MobileNav.barTint.css('opacity', Theme.MobileNav._map($(window).scrollTop(), 0, 100, 0, 1));
			},
			_menuToggleHandler : function(e){
				if(Theme.MobileNav.menuToggle.hasClass('fa-bars')){
					Theme.MobileNav._openMenu();
				}
				else{
					Theme.MobileNav._closeMenu();
				}
			},
			_closeMenu : function(){
				Theme.MobileNav.menuToggle.removeClass('fa-times');
				Theme.MobileNav.menuToggle.addClass('fa-bars');

				Theme.MobileNav.menu.removeClass('mobileheader-menus--show');
				Theme.MobileNav.menuTint.removeClass('mobileheader-tint--show');
			},
			_openMenu : function(){
				Theme.MobileNav.menuToggle.removeClass('fa-bars');
				Theme.MobileNav.menuToggle.addClass('fa-times');

				Theme.MobileNav.menu.addClass('mobileheader-menus--show');
				Theme.MobileNav.menuTint.addClass('mobileheader-tint--show');
			},
		};



		Theme.DesktopNav = {
			tint : $('.header-tint'),
			estimate : $('.estimate-toggle'),
			estimatePopup : $('.estimate'),
			estimateClose : $('.estimate.popupcontainer, .estimate-content-times.popupcontainer-times'),
			_init: function(){
				if(DisableNavTintFadein == 'false'){
					$(window).on('scroll load', Theme.DesktopNav._scrollLoadHandler);		
				}
				Theme.DesktopNav.estimate.click(Theme.DesktopNav._estimateClickHandler);
				Theme.DesktopNav.estimateClose.click(Theme.DesktopNav._estimateCloseClickHandler);
			},
			_map : function(n,i,o,r,t){return i>o?i>n?(n-i)*(t-r)/(o-i)+r:r:o>i?o>n?(n-i)*(t-r)/(o-i)+r:t:void 0;},
			_scrollLoadHandler : function(e){
				Theme.DesktopNav.tint.css('opacity', Theme.DesktopNav._map($(window).scrollTop(), 0, 100, 0, 1));
			},
			_estimateClickHandler : function(e){
				e.preventDefault();
				Theme.DesktopNav.estimatePopup.fadeIn(250);
			},
			_estimateCloseClickHandler : function(e){
				if($(e.target).hasClass('estimate') || $(e.target).hasClass('estimate-content-times')){
					e.preventDefault();
					Theme.DesktopNav.estimatePopup.fadeOut(250);	
				}
			}
		}



		Theme.AnimateNavScrolling = {
			links : $('.header-content-menus-pages-menu-item-link, .home-hero-text-button, .mobileheader-menus-pages-menu-item-link'),
			_init : function(){
				if((window.location.origin + window.location.pathname).slice(0,-1) == Home_URL){
					Theme.AnimateNavScrolling.links.click(Theme.AnimateNavScrolling._linkClickHandler);
					$(window).on('load', Theme.AnimateNavScrolling._linkClickHandler);
				}
			},
			_linkClickHandler : function(e){
				e.preventDefault();
				var hash = e.target.hash == undefined ? window.location.hash : e.target.hash;
				if(hash !== undefined && hash !== ""){
					setTimeout(function(){
						$('html, body').animate({
							scrollTop: $(hash).offset().top - ( $(window).width() > 1167 ? $('.header-tint')[0].clientHeight : $('.mobileheader')[0].clientHeight ),
						}, 500, function(){
							window.location.hash = hash;
						});
					}, 1);
				}
			},
		}



		Theme.HomeTestimonialsSlider = {
			slides : $('.home-testimonials-grid-item'),
			arrowLeft : $('.home-testimonials-arrows-left'),
			arrowRight : $('.home-testimonials-arrows-right'),
			arrows : $('.home-testimonials-arrows i'),
			slideMax : null,
			currentSlide : 0,
			_init : function(){
				if($('.home-testimonials').length > 0){
					// if there are slides
					if(Theme.HomeTestimonialsSlider.slides.length != 0){
						Theme.HomeTestimonialsSlider.slideMax = Theme.HomeTestimonialsSlider.slides.length - 1;
						// if 1 slide
						if(Theme.HomeTestimonialsSlider.slideMax == 0){
							Theme.HomeTestimonialsSlider.arrows.addClass('grey');
						}
						Theme.HomeTestimonialsSlider.arrows.on('click', Theme.HomeTestimonialsSlider._arrowsClickHandler);	
					}
					else{
						$('.home-testimonials').hide();
					}
				}
			},
			_arrowsClickHandler : function(e){
				if(e.target == Theme.HomeTestimonialsSlider.arrowLeft[0]){
					if(Theme.HomeTestimonialsSlider.currentSlide != 0){
						Theme.HomeTestimonialsSlider._updateCurrentSlide(-1);
					}
				}
				if(e.target == Theme.HomeTestimonialsSlider.arrowRight[0]){
					if(Theme.HomeTestimonialsSlider.currentSlide != Theme.HomeTestimonialsSlider.slideMax){
						Theme.HomeTestimonialsSlider._updateCurrentSlide(1);	
					}
				}
				// if more than 3 slides
				if(Theme.HomeTestimonialsSlider.slideMax >= 2){
					if(Theme.HomeTestimonialsSlider.currentSlide == 0){
						Theme.HomeTestimonialsSlider.arrowLeft.addClass('grey');
					}
					else if(Theme.HomeTestimonialsSlider.currentSlide != 0 && Theme.HomeTestimonialsSlider.currentSlide != Theme.HomeTestimonialsSlider.slideMax){
						Theme.HomeTestimonialsSlider.arrows.removeClass('grey');	
					}
					else if(Theme.HomeTestimonialsSlider.currentSlide == Theme.HomeTestimonialsSlider.slideMax){
						Theme.HomeTestimonialsSlider.arrowRight.addClass('grey');	
					}	
				}
				// if 2 slides
				if(Theme.HomeTestimonialsSlider.slideMax == 1){
					if(Theme.HomeTestimonialsSlider.currentSlide == 0){
						Theme.HomeTestimonialsSlider.arrowLeft.addClass('grey');
						Theme.HomeTestimonialsSlider.arrowRight.removeClass('grey');
					}
					else{
						Theme.HomeTestimonialsSlider.arrowRight.addClass('grey');
						Theme.HomeTestimonialsSlider.arrowLeft.removeClass('grey');	
					}
				}
			},
			_updateCurrentSlide : function(amount){
				$(Theme.HomeTestimonialsSlider.slides[Theme.HomeTestimonialsSlider.currentSlide]).fadeOut();
				Theme.HomeTestimonialsSlider.currentSlide += amount;
				$(Theme.HomeTestimonialsSlider.slides[Theme.HomeTestimonialsSlider.currentSlide]).fadeIn();
			}
		}

		
		

		Theme.Topbar = {
			link : $('.header-topbar-link'),
			container : $('.topbar.popupcontainer'),
			_init : function(){
				if( Theme.Topbar.link.length > 0 ){	
					Theme.Topbar.link.on('click', Theme.Topbar._clickHandler);
				}
				if( Theme.Topbar.container.length > 0 ){
					Theme.Topbar.container.on('click', Theme.Topbar._containerClickHandler);
				}
			},
			_containerClickHandler : function(e){
				if($(e.target).hasClass('pa') || $(e.target).hasClass('popupcontainer') || $(e.target).hasClass('popupcontainer-times')){
					Theme.Topbar.container.fadeOut(250);
				}
			},
			_clickHandler : function(e){
				e.preventDefault();
				if(Theme.PA.container.css('display') == 'none'){
					if( $(window).width() >= 1025 ){
						Theme.Topbar.container.fadeIn(250);	
					}
				}
			}
		}



		Theme.PA = {
			container : $('.pa.popupcontainer'),
			submit : $('.pa.popupcontainer input[type="submit"]'),
			_init : function(){
				if( Theme.PA.container.length > 0 ){
					Theme.PA.container.click(Theme.PA._clickHandler);
				}
			},
			_clickHandler : function(e){
				if($(e.target).hasClass('pa') || $(e.target).hasClass('popupcontainer-times')){
					if($(e.target).has('.ginput_container').length == 0){
						Theme.CookieMonster._setCookie('ad_set', 'active', 30, true);
						Theme.CookieMonster._deleteCookie('ad_notset');
						Theme.CookieMonster._deleteCookie('ad_firsttime');	
						Theme.PA.container.off('click');
					}					
					Theme.PA._hidePA();	
				}
			},
			_hidePA : function(){
				Theme.PA.container.fadeOut(250);
				if(Theme.CookieMonster._cookieExists('ad_set') == false){
					Theme.CookieMonster._setCookie('ad_notset', 'active', parseInt(PopupTimes.long), false);
					Theme.CookieMonster._listenCookieExpire('ad_notset', Theme.CookieMonster._firstTimeExpire);	
				}
			},
			_showPA : function(){
				if( Theme.PA.container.length > 0 && $(window).width() >= 1025 ){
					if(Theme.PA.container.css('display') == 'none'){
						Theme.PA.container.fadeIn(250);	
					}
				}
			}
		}


		Theme.CookieMonster = {
			_init : function(){
				// Theme.CookieMonster._deleteCookie('ad_firsttime');
				// Theme.CookieMonster._deleteCookie('ad_notset');

				// if there's no cookies ie. first time on the site
				if(Theme.CookieMonster._cookieExists('ad_notset') == false && Theme.CookieMonster._cookieExists('ad_set') == false && Theme.CookieMonster._cookieExists('ad_firsttime') == false){
					Theme.CookieMonster._setCookie('ad_firsttime', 'active', parseInt(PopupTimes.short), false);
				}
				// if the other cookies don't exist then listen for the expiration of the firstitme cookie
				if(Theme.CookieMonster._cookieExists('ad_set') == false && Theme.CookieMonster._cookieExists('ad_notset') == false){
					Theme.CookieMonster._listenCookieExpire('ad_firsttime', Theme.CookieMonster._firstTimeExpire);	
				}
			},
			_listenCookieExpire : function(cookieName, callback) {
			    var si = setInterval(function() {
			        if (Theme.CookieMonster._cookieExists(cookieName) === false) {
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
			    if (Theme.CookieMonster._getCookieValue(cname) != null) {
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
				Theme.PA._showPA();
			},
		};



		Theme.MenuGrid = {
			grid : $('.menu-menu-grid-category-grid'),
			_init : function(){
				$(window).on('load', Theme.MenuGrid._loadHandler);
			},
			_loadHandler : function(){
				for(var i = 0; i < Theme.MenuGrid.grid.length; i++){
					$(Theme.MenuGrid.grid[i]).masonry({
						itemSelector : '.menu-menu-grid-category:nth-child(' + (i+1) + ') .menu-menu-grid-category-grid-item',
					});
				}
			}
		}


		Theme.Parallax = {
			strength : 25,
			stronger : 175,
			imagesections : $('.parallax-image'),
			_init : function(){
				$(window).on('resize scroll load', Theme.Parallax._resizeLoadScrollHandler);
			},
			_map : function(n,i,o,r,t){return i>o?i>n?(n-i)*(t-r)/(o-i)+r:r:o>i?o>n?(n-i)*(t-r)/(o-i)+r:t:void 0;},
			_getAmount : function(el, strength){
				var windowcenter = $(window).scrollTop() + ( $(window).height() / 2 );
				var sectioncenter = $(el).offset().top + ($(el).height() / 2);
				var sectiondelta = windowcenter - sectioncenter;
				var scale = Theme.Parallax._map(sectiondelta, 0, $(window).height(), 0, strength);
				return -50 + scale + '%';
			},
			_resizeLoadScrollHandler : function(){
				for(var i = 0; i < Theme.Parallax.imagesections.length; i++){
					$(Theme.Parallax.imagesections[i]).css('transform', 'translate3d(-50%, ' + Theme.Parallax._getAmount(Theme.Parallax.imagesections[i], Theme.Parallax.strength) + ',0)');
				}
			}
		}

	});

})( jQuery, Theme, window, document );


// var map;
// var MapServer = {
// 	potentialMaps : {
// 		StatesServed:{},
// 		CountiesServed:{},
// 		CountriesServed:{},
// 		AreasServed:{},
// 	},
// 	_init: function(){
// 		if (document.querySelector('.areas-served-hero-map') !== null){
// 			Object.keys(MapServer.potentialMaps).forEach(function(el, index){
// 				try {
// 					if(eval(el)){
// 						if(el !== 'AreasServed'){
// 							MapServer._generateMap(el);
// 						}
// 						if(el == 'AreasServed'){
// 							MapServer._manualGeocoder();
// 						}
// 					}
// 				} catch(e){}
// 			});
// 		}
// 		if( document.querySelector('.contact-hero-map') != null && typeof(ContactAddresses) !== 'undefined'){
// 			MapServer._createContactMap()
// 		}
// 	},
// 	_generateMap: function(el){
// 		mapOptions = {
// 			center: new google.maps.LatLng(30, 0),
// 			zoom: 2,
// 			mapTypeId: google.maps.MapTypeId.ROADMAP,
// 			disableDefaultUI: true,
// 			scrollwheel: false,
// 			draggable: false,
// 		},
// 		map = new google.maps.Map(document.querySelectorAll('.areas-served-hero-map')[0],mapOptions);
// 		MapServer._generateFTL(el);
// 	},
// 	_manualGeocoder: function(){
// 		var geocoder = new google.maps.Geocoder();
// 		var latlangs = [];
// 		var counter = 0;
// 		for(var i = 0; i < AreasServed.length; i++){
// 			(function(i, latlangs){
// 				setTimeout(function(){
// 					geocoder.geocode({address: AreasServed[i]}, setup_latlangs(latlangs));
// 				}, 150);
// 			})(i, latlangs);
// 		}
// 		function setup_latlangs(latlangs){
// 			var build_latlangs = function(results, status){
// 				if( status == google.maps.GeocoderStatus.OK ){
// 					var temparr = [];
// 					temparr.push(results[0].geometry.location.lat());
// 					temparr.push(results[0].geometry.location.lng());
// 					latlangs.push(temparr);
// 					if( counter === AreasServed.length - 1 ){
// 						setupMap(latlangs);
// 					}
// 				}
// 				counter++;
// 			}
// 			return build_latlangs;
// 		}
// 		function setupMap(latlangs){
// 			var map_center = [];
// 			var x = 0;
// 			var y = 0;
// 			// build bounds & make center of map coords
// 			bounds  = new google.maps.LatLngBounds();
// 			for(var i = 0; i < latlangs.length; i++){
// 				x += latlangs[i][0];
// 				y += latlangs[i][1];
// 				bounds.extend({lat: latlangs[i][0], lng: latlangs[i][1]});
// 			}
// 			map_center[0] = x / latlangs.length;
// 			map_center[1] = y / latlangs.length;
// 			// build map
// 			map = new google.maps.Map(document.querySelectorAll('.areas-served-hero-map')[0], {
// 				zoom: 11,
// 				center: {lat: map_center[0], lng: map_center[1]},
// 				mapTypeId: 'terrain',
// 				disableDefaultUI: true,
// 				scrollwheel: false,
// 				draggable: false,
// 			});
// 			// add circles
// 			latlangs.forEach(function(currentValue, i, arr){
// 				var cityCircle = new google.maps.Circle({
// 					strokeColor: '#FF0000',
// 					strokeOpacity: 0.8,
// 					strokeWeight: 2,
// 					fillColor: '#FF0000',
// 					fillOpacity: 0.35,
// 					map: map,
// 					center: {lat: latlangs[i][0], lng: latlangs[i][1]},
// 					radius: 9000,
// 				});
// 				var marker = new google.maps.Marker({
// 					position: {lat: latlangs[i][0], lng: latlangs[i][1]},
// 					map: map,
// 				});
// 			});
// 			// zoom to bounds
// 			if(latlangs.length > 1){
// 				map.fitBounds(bounds);	
// 			}	
// 			map.panToBounds(bounds);
// 		}
// 	},
// 	_generateFTL: function(el){
// 		ftloptions = {
// 			query: {},
// 			heatmap: {
// 				enabled: false
// 			},
// 			suppressInfoWindows: true,
// 			map: map,
// 			options: {
// 				styleId: 2,
// 				templateId: 2
// 			},
// 		}
// 		if(el == 'StatesServed'){
// 			jointCountriesArray = StatesServed.map(function(val, index){
// 				if ( index < StatesServed.length - 1 ){ return '\'' + val + '\', '; }
// 				else { return '\'' + val + '\''; }
// 			});
// 			jointCountriesArray = jointCountriesArray.join('');
// 			ftloptions.query = {
// 				select: 'geometry',
// 				from: '17aT9Ud-YnGiXdXEJUyycH2ocUqreOeKGbzCkUw',
// 				where: "id IN (" + jointCountriesArray + ")",
// 			}
// 			queryText = encodeURIComponent("select geometry from 17aT9Ud-YnGiXdXEJUyycH2ocUqreOeKGbzCkUw where 'id' in (" + jointCountriesArray + ")");
// 		}
// 		if(el == 'CountiesServed'){
// 			jointCountiesArray = CountiesServed.map(function(val, index){
// 				if( index < CountiesServed.length - 1 ){
// 					return '\'' + val.county + '\', ';
// 				}
// 				else{
// 					return '\'' + val.county + '\'';
// 				}
// 			});
// 			jointCountiesArray = jointCountiesArray.join('');
// 			jointStatesArray = CountiesServed.map(function(val, index){
// 				if( index < CountiesServed.length - 1 ){
// 					return '\'' + val.state + '\', ';
// 				}
// 				else{
// 					return '\'' + val.state + '\'';
// 				}
// 			});
// 			jointStatesArray = jointStatesArray.join('');
// 			ftloptions.query = {
// 				select: 'geometry',
// 				from: '1xdysxZ94uUFIit9eXmnw1fYc6VcQiXhceFd_CVKa',
// 				where: "'County Name' IN (" + jointCountiesArray + ") AND 'State Abbr' IN (" + jointStatesArray + ")",
// 			}
// 			queryText = encodeURIComponent("select geometry from 1xdysxZ94uUFIit9eXmnw1fYc6VcQiXhceFd_CVKa where 'County Name' in (" + jointCountiesArray + ") and 'State Abbr' in (" + jointStatesArray + ")");
// 		}
// 		if(el == 'CountriesServed'){
// 			jointCountriesArray = CountriesServed.map(function(val, index){
// 				if( index < CountriesServed.length - 1 ){
// 					return '\'' + val + '\', ';
// 				}
// 				else{
// 					return '\'' + val + '\'';
// 				}
// 			});
// 			jointCountriesArray = jointCountriesArray.join('');
// 			ftloptions.query = {
// 				select: 'geometry',
// 				from: '1N2LBk4JHwWpOY4d9fobIn27lfnZ5MDy-NoqqRpk',
// 				where: "ISO_2DIGIT IN (" + jointCountriesArray + ")",
// 			}
// 			queryText = encodeURIComponent("select geometry from 1N2LBk4JHwWpOY4d9fobIn27lfnZ5MDy-NoqqRpk where 'ISO_2DIGIT' in (" + jointCountriesArray + ")");
// 		}
// 		world_geometry = new google.maps.FusionTablesLayer(ftloptions);
// 		MapServer._generateQuery(el)
// 	},
// 	_generateQuery: function(el){
// 		google.charts.load('current', {
// 		   'packages': ['table']
// 		});
// 		google.charts.setOnLoadCallback(sendQuery);
// 		function sendQuery(){
// 			query = new google.visualization.Query('http://www.google.com/fusiontables/gvizdata?tq=' + queryText);
// 			query.send(receiveQuery);
// 		}
// 		function receiveQuery(response){
// 			if (!response) { console.log('no response'); return;}
// 			if (response.isError()) {console.log('Error in query: ' + response.getMessage() + ' ' + response.getDetailedMessage());return;} 
// 			FTresponse = response;
// 			numRows = FTresponse.getDataTable().getNumberOfRows();
// 			var coordinates = [];
// 			var bounds = new google.maps.LatLngBounds();
// 			for(var i = 0; i < numRows; i++) {
// 				var kml = FTresponse.getDataTable().getValue(i,0);
// 				var coordEls = geoXML3.xmlParse(kml).querySelectorAll('coordinates');
// 				var coordinateString = '';
// 				for(var j = 0; j < coordEls.length; j++){
// 					coordinateString += coordEls[j].innerHTML + ' ';
// 				}
// 				if( el == 'StatesServed' || el == 'CountriesServed'){
// 					var unpairedCoordinates = coordinateString.split(',').map(function(val,index, arr){
// 						if( val == '0.0' ){
// 							arr.splice(index,1);
// 						}
// 						else{
// 							return val.replace('0.0 ', '');
// 						}
// 					});
// 				}
// 				if( el == 'CountiesServed'){
// 					var unpairedCoordinates = coordinateString.split(/[\,\s]/);
// 				}
// 				for(var k = 0; k < unpairedCoordinates.length; k++){
// 					if( (k == 0 || k % 2 == 0) && k < unpairedCoordinates.length - 2 ){
// 						// is even or zero and we're not at the end of the array
// 						bounds.extend({
// 							lat : parseFloat(unpairedCoordinates[k+1]),
// 							lng : parseFloat(unpairedCoordinates[k])
// 						});
// 					}
// 				}
// 			}
// 			if( el == 'StatesServed' || el == 'CountiesServed'){
// 				map.fitBounds(bounds, 0);
// 				map.setCenter(bounds.getCenter());
// 			}
// 			if (el == 'CountriesServed'){
// 				map.fitBounds(bounds, -300);
// 				map.setCenter(bounds.getCenter());
// 			}
// 		}
// 	},
// 	_createContactMap: function(){
// 		var element =  document.querySelector('.contact-hero-map');
// 		var latlangs = [];
// 		ContactAddresses.forEach(function(el, index, parent){
// 			latlangs.push({lat: Number(el.lat), lng: Number(el.lng)});
// 		});
// 		// build bounds & make center of map coords
// 		var bounds  = new google.maps.LatLngBounds();
// 		var map_center = [];
// 		var x = 0;
// 		var y = 0;
// 		var map = new google.maps.Map(element, {
// 		  zoom: 28,
// 		  mapTypeId: 'terrain',
// 		  disableDefaultUI: true,
// 		  scrollwheel: false,
// 		  draggable: false,
// 		});
// 		latlangs.forEach(function(el){
// 			x += Number(el.lat);
// 			y += Number(el.lng);
// 			var marker = new google.maps.Marker({
// 			  position: el,
// 			  map: map,
// 			});	
// 			bounds.extend(el);
// 		});
// 		map_center[0] = x / latlangs.length;
// 		map_center[1] = y / latlangs.length;
// 		map.setCenter({lat: map_center[0], lng: map_center[1]});
// 		google.maps.event.addListener(map, 'zoom_changed', function() {
// 			zoomChangeBoundsListener = 
// 				google.maps.event.addListener(map, 'bounds_changed', function(event) {
// 					if (this.getZoom() > 15 && this.initialZoom == true) {
// 						// Change max/min zoom here
// 						this.setZoom(15);
// 						this.initialZoom = false;
// 					}
// 				google.maps.event.removeListener(zoomChangeBoundsListener);
// 			});
// 		});
// 		map.initialZoom = true;
// 		// zoom to bounds
// 		if(latlangs.length > 1){
// 			map.fitBounds(bounds);
// 			var listener = google.maps.event.addListener(map, "idle", function() { 
// 			  map.setZoom(map.getZoom() - 1); 
// 			  google.maps.event.removeListener(listener); 
// 			});
			
// 		}	
// 		map.panToBounds(bounds);
// 	},
// };

var MapServer = {
	types : ['StatesServed', 'AreasServed', 'CountiesServed', 'CountriesServed2'],
	activeAreasServedMap : '',
	activeAreasServedMapData : null,
	_init : function(){
		MapServer.types.forEach(function(el){
			try {
				if(eval(el)){
					MapServer.activeAreasServedMap = el;
					MapServer.activeAreasServedMapData = eval(el);
					MapServer._buildAreasServedMap();
				}
			} catch(e){}
		});
	},
	_buildAreasServedMap : function(){
		var bounds  = new google.maps.LatLngBounds();
		MapServer.activeAreasServedMapData.forEach(function(el){
			JSON.parse(el.geometry).forEach(function(polygon){
				polygon.forEach(function(latlng){
					latlng['lat'] = parseFloat(latlng['lat']);
					latlng['lng'] = parseFloat(latlng['lng']);
					bounds.extend(latlng);
				});
			});
		});
		var map = new google.maps.Map(document.querySelectorAll('.areas-served-hero-map')[0], {
			zoom: 11,
			center: bounds.getCenter(),
			mapTypeId: 'terrain',
			disableDefaultUI: true,
			scrollwheel: false,
			draggable: false,
		});

		map.fitBounds(bounds, -150);

		if( MapServer.activeAreasServedMap == 'AreasServed' ){

		}
		else{
			var polygons = [];
			MapServer.activeAreasServedMapData.forEach(function(el){
				JSON.parse(el.geometry).forEach(function(polygon){
					var mapped = polygon.map(function(latlng){
						latlng['lat'] = parseFloat(latlng['lat']);
						latlng['lng'] = parseFloat(latlng['lng']);
						return latlng;
					});

					var gmapPoly = new google.maps.Polygon({
						paths: mapped,
						strokeColor: '#FF0000',
			            strokeOpacity: 0,
			            strokeWeight: 2,
			            fillColor: '#FF0000',
			            fillOpacity: 0.5
					});	
					gmapPoly.setMap(map);
				});
			});
		}
	},
};

google.maps.event.addDomListener(window, "load", MapServer._init);

window.Theme = Theme;