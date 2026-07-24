$(document).ready(function () {
   $(".accordion-item-header").click (function (e) {
        $(this).toggleClass("active");
        $(this).parent().children(".accordion-item-body").slideToggle();
    });

   $('ul .header_dropdown_navbar__li').click(function () {
      $(this).siblings().removeClass('active');
      $(this).toggleClass('active');
   });
   $('.sub-menu-ul__li').click(function () {
      $(this).siblings().removeClass('active');
      $(this).toggleClass('active');
   });
   $('.list-group-item').click(function () {
      $(this).siblings().removeClass('active');
      $(this).toggleClass('active');
   });
   $('.navbar-nav .nav-item .nav-link').click(function () {
      $(this).siblings().removeClass('show');
      $(this).toggleClass('show');
   });

   $('.open_close_button').click(function () {
      $(this).siblings().removeClass('active');
      $(this).toggleClass('active');
      $('.list-group').slideToggle(500);
   });


  

   // $('.top-nav_langs .selected_lang').click(function () {
   //    $('.top-nav_langs_switch').fadeToggle(250);
   // });
   $('.eyeblock .eyeblock_title').click(function () {
      $('.dropDown').fadeToggle(250);
   });
   $('.fa-bars').click(function () {
      $(this).fadeOut(200)
      $('.fa-times').fadeIn(200);
   });
   $('.fa-times').click(function () {
      $(this).fadeOut(200)
      $('.fa-bars').fadeIn(200);
   });
   // $(window).scroll(function () {
   //    $('.header_dropdown_navbar').toggleClass('stick');
   // });

});

var swiper = new Swiper(".mySwiper", {
   spaceBetween: 30,
   effect: "fade",
   fadeEffect: {
      crossFade: true
   },
   loop: true,
   navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
   },
   pagination: {
      el: ".swiper-pagination",
      clickable: true,
      dynamicBullets: true,
   },
   autoplay: {
      delay: 5000,
   },
   speed: 1000,
   parallax: true,

});

var swiper2 = new Swiper(".mySwiper2", {
   slidesPerView: 4,
   spaceBetween: 10,
   speed: 1000,
   loop: true,

   breakpoints: {
      // when window width is >= 200px
      50: {
         slidesPerView: 1,
         spaceBetween: 5,
         navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
         }
      },
      // when window width is >= 320px
      320: {
         slidesPerView: 1,
         spaceBetween: 10,
         navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
         }
      },
      // when window width is >= 480px
      480: {
         slidesPerView: 1,
         spaceBetween: 10,
         navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
         }
      },
      // when window width is >= 767px
      767: {
         slidesPerView: 2,
         spaceBetween: 10
      },
      // when window width is >= 991px
      991: {
         slidesPerView: 3,
         spaceBetween: 10
      }
   },
});

$('.owl-carousel').owlCarousel({
   loop: true,
   margin: 10,
   nav: false,
   responsive: {
      0: {
         items: 1
      },
      600: {
         items: 1
      },
      1000: {
         items: 2
      },
      1300: {
         items: 3
      }

   }
})





// window.addEventListener("resize", function () {
//    "use strict"; window.location.reload();
// });

document.addEventListener("DOMContentLoaded", function () {

   // make it as accordion for smaller screens
   if (window.innerWidth < 992) {

      // close all inner dropdowns when parent is closed
      document.querySelectorAll('.navbar .dropdown').forEach(function (everydropdown) {
         everydropdown.addEventListener('hidden.bs.dropdown', function () {
            // after dropdown is hidden, then find all submenus
            this.querySelectorAll('.submenu').forEach(function (everysubmenu) {
               // hide every submenu as well
               everysubmenu.style.display = 'none';
            });
         })
      });

      document.querySelectorAll('.dropdown-menu a').forEach(function (element) {
         element.addEventListener('click', function (e) {

            let nextEl = this.nextElementSibling;
            if (nextEl && nextEl.classList.contains('submenu')) {
               // prevent opening link if link needs to open dropdown
               e.preventDefault();

               if (nextEl.style.display == 'block') {
                  nextEl.style.display = 'none';
               } else {
                  nextEl.style.display = 'block';
               }
            }
         });
      })
   }
   // end if innerWidth

});


document.addEventListener("DOMContentLoaded", function () {

   document.querySelectorAll('[data-trigger]').forEach(function (everyelement) {
      let offcanvas_id = everyelement.getAttribute('data-trigger');
      everyelement.addEventListener('click', function (e) {
         e.preventDefault();
         show_offcanvas(offcanvas_id);
      });
   });

   document.querySelectorAll('.btn-close').forEach(function (everybutton) {
      everybutton.addEventListener('click', function (e) {
         close_offcanvas();
      });
   });


});
  