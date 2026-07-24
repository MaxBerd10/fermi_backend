$(document).ready(function () {

	$('.menuListBtn').on('click', function (e) {
		e.preventDefault();
		$('.overlay').addClass('open')
	})
	$('.overlay-close').on('click', function (e) {
		e.preventDefault();
		$('.overlay').removeClass('open')
	})
	$('.searchBtn').on('click', function () {
		$('.searchBlock').addClass('show')
	})

	$('.menu-list > li > a').hover(
		function () {
			$(this).removeClass("hover");
		}, function () {
			$(this).addClass("hover");
			setTimeout(function () {
				$('.hover').removeClass('hover')
			}, 500)
		}
	);
	$('.searchBlock  .fa-times').on('click', function (e) {
		$('.searchBlock').removeClass('show')
	})

	$(window).on('scroll', function (e) {
		if (document.documentElement.scrollTop > 186) {
			$('body').addClass('fixed')
		} else {
			$('body').removeClass('fixed')
		}
	})

	$('.fixed_button').on('click', function (e) {
		e.preventDefault();
		$("html, body").animate({ scrollTop: 0 }, 800);
	})
	$('.menuListBtn').on('click', function (e) {
		e.preventDefault();
		$('.overlay').addClass('open')
	})

	$('.overlay-close').on('click', function (e) {
		e.preventDefault();
		$('.overlay').removeClass('open')
	})


	$('.top-nav__ul .eyeblock > a').on('click', function (e) {
		e.preventDefault();
		$('.eyeblock').toggleClass('show')
	})
	$('.searchBlock  .ti-close').on('click', function (e) {
		$('.searchBlock').removeClass('show')
	})
	$('#fontRange').on('input', function () {
		let thisVal = $(this).val()
		let currentFontSize = 16 + Number(thisVal)
		$('.fontRange').text(thisVal)
		$("*").css({ fontSize: currentFontSize + 'px' });

	})
	$('#viewRange').on('input', function () {
		let thisVal = $(this).val()
		$('.viewRange').text(thisVal)
		$('body').css({ transform: 'scale(1.' + thisVal + ')', transformOrigin: 'center top' })
	})
	$('.grey').on('click', function (e) {
		e.preventDefault();
		$('html').attr('class', '')
		$('html').addClass('blackAndWhite')
	})
	$('.black').on('click', function (e) {
		e.preventDefault();
		$('html').attr('class', '')
		$('html').addClass('blackAndWhiteInvert')
	})
	$('.blue').on('click', function (e) {
		e.preventDefault();
		$('html').attr('class', '')
	})

	$('#resetAll').on('click', function () {
		window.location.reload(true)
	})

	$('.language-switcher span').append('    <i class="ti-angle-down"></i>')

	$('.language-switcher span').on('click', function (e) {
		$('.language-switcher').toggleClass('open')
	})


	$('.tab-button-group #xizmatlar').click(function () {
		$('.panel.active').fadeOut(0);
		$('.panel.active').removeClass('opened');
		$('.panel1').fadeIn(800);
		$('.panel1').addClass('active');
		$('.tab-button-group a.active').removeClass('active');
		$(this).addClass('active');
	});
	$('.tab-button-group #harakat').click(function () {
		$('.panel.active').fadeOut(0);
		$('.panel.active').removeClass('opened');
		$('.panel2').fadeIn(800);
		$('.panel2').addClass('active');
		$('.tab-button-group a.active').removeClass('active');
		$(this).addClass('active');
	});
	$('.tab-button-group #elektron').click(function () {
		$('.panel.active').fadeOut(0);
		$('.panel.active').removeClass('opened');
		$('.panel3').fadeIn(800);
		$('.panel3').addClass('active');
		$('.tab-button-group a.active').removeClass('active');
		$(this).addClass('active');
	});
});
$(document).ready(function () {
	$("#xizmat").owlCarousel({
		items: 3,
		loop: true,
		margin: 15,
		center: false,
		dots: false,
		nav: true,
		autoplay: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 1,
				dots: false
			},
			600: {
				items: 1
			},
			1000: {
				loop: true,
				items: 3
			}
		}
	});
});
$(document).ready(function () {
	$("#gallery").owlCarousel({
		items: 3,
		loop: true,
		margin: 15,
		center: false,
		dots: false,
		nav: true,
		autoplay: false,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 1,
				dots: false
			},
			600: {
				items: 1
			},
			1000: {
				loop: true,
				items: 3
			}
		}
	});
});

$(document).ready(function () {
	$("#gallery2").owlCarousel({
		items: 3,
		loop: true,
		margin: 15,
		center: false,
		dots: false,
		nav: true,
		autoplay: false,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 1,
				dots: false
			},
			600: {
				items: 1
			},
			1000: {
				loop: true,
				items: 3
			}
		}
	});
});

$(document).ready(function () {
	$("#head-carousel").owlCarousel({
		items: 1,
		loop: true,
		margin: 15,
		center: false,
		dots: false,
		nav: false,
		autoplay: false,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 1,
				dots: false
			},
			600: {
				items: 1
			},
			1000: {
				loop: true,
				items: 1
			}
		}
	});
});
$(document).ready(function () {
	$("#card-carousel").owlCarousel({
		items: 2,
		loop: true,
		margin: 15,
		animateOut: 'fadeOut',
		center: false,
		dots: false,
		nav: false,
		autoplay: false,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2,
				dots: false
			},
			600: {
				items: 2
			},
			768: {
				items: 6
			},
			1000: {
				loop: true,
				items: 6
			}
		}
	});
});
$(document).ready(function () {
	$("#use-carousel").owlCarousel({
		items: 4,
		loop: true,
		margin: 15,
		animateOut: 'fadeOut',
		center: false,
		dots: false,
		nav: false,
		autoplay: true,
		navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
		responsive: {
			0: {
				items: 2,
				dots: false
			},
			600: {
				items: 2
			},
			768: {
				items: 3
			},
			1000: {
				loop: true,
				items: 4
			}
		}
	});
});

var counted = 0;
$(window).scroll(function() {

	var oTop = $('.counter').offset().top - window.innerHeight;
	if (counted == 0 && $(window).scrollTop() > oTop) {
		$('.count').each(function() {
			var $this = $(this),
				countTo = $this.attr('data-count');
			$({
				countNum: $this.text()
			}).animate({
					countNum: countTo
				},

				{

					duration: 2000,
					easing: 'swing',
					step: function() {
						$this.text(Math.floor(this.countNum));
					},
					complete: function() {
						$this.text(this.countNum);
						//alert('finished');
					}

				});
		});
		counted = 1;
	}

});


