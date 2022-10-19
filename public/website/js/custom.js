let nav = document.querySelector(".navigation-wrap");
window.onscroll = function() {
    if (document.documentElement.scrollTop > 100) {
        nav.classList.add("scroll-on");
    } else {
        nav.classList.remove("scroll-on");
    }
}


// product slider 
// $('.product-slider').owlCarousel({
//     loop: true,
//     nav: false,
//     autoplay: false,
//     callbacks:false,
//     autoplayTimeout: 1000,
//     autoplayHoverPause: true,
//     dots: true,
//     responsive: {
//         0: {
//             items: 1,
//             nav: true
//         },
//         320: {
//             items: 1,
//             nav: true
//         },
//         767: {
//             items: 2,
//             nav: true
//         },
//         768: {
//             items: 2,
//             nav: true
//         },
//         1200: {
//             items: 5,
//             nav: true
//         }
//     }
// });


















