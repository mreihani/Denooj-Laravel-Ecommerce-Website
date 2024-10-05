const defaultStoryDuration = 7000;

// init banners swiper
new Swiper('.image-slider-widget', {
    changeDirection: 'rtl',
    slidesPerView: 1,
    spaceBetween: 0,
    loop:true,
    autoplay: {
        delay: 4000
    },
    navigation: {
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable:true
    },
    breakpoints: {
        // when window width is >= 640px
        992: {
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        }
    }
});

new Swiper('#mainSwiper', {
    changeDirection: 'rtl',
    slidesPerView: 1,
    spaceBetween: 0,
    loop:true,
    autoplay: {
        delay: 4000
    },
    navigation: {
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable:true
    },
    breakpoints: {
        // when window width is >= 640px
        992: {
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        }
    }
});

// init categories swiper
new Swiper('.categories-swiper', {
    changeDirection: 'rtl',
    slidesPerView: 2.5,
    spaceBetween: 12,
    speed: 200,
    freeMode: true,
    navigation:{
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    breakpoints: {
        1240: {
            navigation:{
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
            slidesPerView: 6.7,
        },
        768: {
            navigation:{
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
            slidesPerView:4.7,
        },
        576: {
            navigation:{
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
            slidesPerView: 3.7,
        },
        450: {
            navigation:{
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:false
            },
            slidesPerView: 3.5,
        }
    }
});


// init featured products swiper
let featuredProductsSwipers = $('.featured-products-swiper');
featuredProductsSwipers.each(function (i,swiper){
    new Swiper(swiper, {
        changeDirection: 'rtl',
        slidesPerView: 1.5,
        spaceBetween: 12,
        loop: false,
        speed: 200,
        freeMode: {
            enabled: true,
            sticky: false,
        },
        navigation:{
            nextEl: ".btn-carousel-nav.next[data-swiper-id='"+$(swiper).attr('id')+"']",
            prevEl: ".btn-carousel-nav.prev[data-swiper-id='"+$(swiper).attr('id')+"']",
            enabled:false,
        },
        breakpoints: {
            1240: {
                slidesPerView: 5,
                freeMode: false,
                navigation: {
                    nextEl: ".btn-carousel-nav.next[data-swiper-id='"+$(swiper).attr('id')+"']",
                    prevEl: ".btn-carousel-nav.prev[data-swiper-id='"+$(swiper).attr('id')+"']",
                    enabled:true
                },
            },
            880: {
                slidesPerView:4,
                freeMode: false,
                navigation: {
                    nextEl: ".btn-carousel-nav.next[data-swiper-id='"+$(swiper).attr('id')+"']",
                    prevEl: ".btn-carousel-nav.prev[data-swiper-id='"+$(swiper).attr('id')+"']",
                    enabled:true
                },
            },
            768: {
                freeMode: false,
                slidesPerView: 3,
                navigation: {
                    nextEl: ".btn-carousel-nav.next[data-swiper-id='"+$(swiper).attr('id')+"']",
                    prevEl: ".btn-carousel-nav.prev[data-swiper-id='"+$(swiper).attr('id')+"']",
                    enabled:true
                },
            }
        }
    });

});

// init default products swiper
new Swiper('.products-swiper-categories', {
    changeDirection: 'rtl',
    slidesPerView: 1.5,
    spaceBetween: 12,
    loop: false,
    freeMode: true,
    speed: 200,
    navigation:{
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    breakpoints: {
        1240: {
            slidesPerView: 5,
            freeMode: false,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        880: {
            slidesPerView:4,
            freeMode: false,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        768: {
            freeMode: false,
            slidesPerView: 3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        320: {
            freeMode: false,
            slidesPerView: 3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:false
            },
        }
    }
});

// init posts swiper
new Swiper('.posts-swiper', {
    changeDirection: 'rtl',
    slidesPerView: 1.2,
    spaceBetween: 12,
    loop: false,
    speed: 200,
    centerMode: true,
    navigation:{
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    breakpoints: {
        1100: {
            slidesPerView: 3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        }
    }
});

// init stories swiper
new Swiper('#storiesSwiperSm', {
    changeDirection: 'rtl',
    slidesPerView: 3.3,
    spaceBetween: 0,
    loop:false,
    speed: 200,
    freeMode:true,
    navigation: {
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    breakpoints: {
        // when window width is >= 992px
        1350: {
            slidesPerView: 13.3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        1200: {
            slidesPerView: 11.3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        992: {
            slidesPerView: 8.3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        768: {
            slidesPerView: 6.3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            },
        },
        576: {
            slidesPerView: 5.3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:false
            },
        },
        380: {
            slidesPerView: 4.3,
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:false
            },
        }
    }
});

// init large stories
const largeStoriesSwiper = new Swiper('#storiesSwiperLg', {
    changeDirection: 'rtl',
    effect: 'cube',
    autoplay: {
        delay: defaultStoryDuration,
        disableOnInteraction:false,
    },
    on: {
        afterInit: function () {
            this.autoplay.stop();
        },
        autoplayTimeLeft: function (swiper, timeLeft, percentage) {
            let p = percentage * 100;
            let width = 100 - p;
            if (width > 0 && width < 100 && (this.autoplay.running && !this.autoplay.paused)) {
                $('.large-stories-swiper .swiper-pagination-bullet-active > span').css('width',width + '%');
            }
        },
        autoplayPause:function (){
            console.log('autoplayPause');
            let activeSlide = this.slides[this.activeIndex];
            let btn = $(activeSlide).find('.story-play-pause-btn');
            let storyItem = $(activeSlide).find('.story-item-lg');
            let videoTag = storyItem.find('video').get(0);
            btn.removeClass('playing');
            if (videoTag){
                videoTag.pause();
            }
        },
        autoplayResume: function (){
            console.log('autoplayResume');
            let activeSlide = this.slides[this.activeIndex];
            let btn = $(activeSlide).find('.story-play-pause-btn');
            let storyItem = $(activeSlide).find('.story-item-lg');
            let videoTag = storyItem.find('video').get(0);
            btn.addClass('playing');
            if (videoTag){
                videoTag.play();
            }
        },
        autoplayStart: function (){
            console.log('autoplayStart');
            let activeSlide = this.slides[this.activeIndex];
            let storyItem = $(activeSlide).find('.story-item-lg');
            let videoTag = storyItem.find('video').get(0);
            if(storyItem.hasClass('video') && videoTag && document.readyState === 'complete'){
                videoTag.play();
            }
        },
        autoplayStop: function (){
            console.log('autoplayStop');

        },
        slideChange:function (){
            console.log('slideChange');

            let activeSlide = this.slides[this.activeIndex];
            let storyItem = $(activeSlide).find('.story-item-lg');
            let videoTag = storyItem.find('video').get(0);
            let playBtn = $(activeSlide).find('.story-play-pause-btn');
            let timeout = 0;
            if (!$('.stories-wrapper').hasClass('show')) timeout = 1000;

            // pause all videos
            stopAllVideos();
            // reset autoplay width
            $('.large-stories-swiper .swiper-pagination-bullet > span').css('width',0 + '%');


            if (storyItem.hasClass('video') && videoTag){
                this.params.autoplay.delay = videoTag.duration * 1000;
                setTimeout(function (){
                    videoTag.play();
                    playBtn.addClass('playing');

                },timeout);
                console.log('delay set to video: ' + this.params.autoplay.delay);
            }else{
                this.params.autoplay.delay = defaultStoryDuration;
            }


        }
    },
    cubeEffect: {
        slideShadows: true,
    },
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable:true,
        renderBullet: function (index, className) {
            return '<span class="' + className + '"><span></span></span>';
        }
    },
    navigation: {
        nextEl: '.custom-swiper-button-next',
        prevEl: '.custom-swiper-button-prev',
        enabled:false
    },
    breakpoints:{
        568:{
            navigation: {
                nextEl: '.custom-swiper-button-next',
                prevEl: '.custom-swiper-button-prev',
                enabled:true
            }
        }
    }
})


/////////////////////////////////////
/////////////// Story ///////////////
/////////////////////////////////////

$(document).on('click','.story-item',function (e){
    e.preventDefault();
    let index = $(this).attr('data-story-index');

    // animate
    let circle = $(this).find('.story-item-circle');
    circle.addClass('animated');

    // show story
    setTimeout(function(){
        // slide to clicked story
        largeStoriesSwiper.slideTo(index,0,false);

        // check clicked story type
        let clickedStory = $(largeStoriesSwiper.slides[index]).find('.story-item-lg');
        if (clickedStory.hasClass('video')){
            // video story
            // set autoplay delay to video duration
            let videoTag = clickedStory.find('video');
            if (videoTag){
                let video = videoTag.get(0);
                largeStoriesSwiper.params.autoplay.delay = video.duration * 1000;
                console.log('story delay has been set to video duration: ' + largeStoriesSwiper.params.autoplay.delay);
            }else{
                console.error('video tag tot found!');
            }
        }else{
            largeStoriesSwiper.params.autoplay.delay = defaultStoryDuration;
            console.log('story delay has been set to default: ' + largeStoriesSwiper.params.autoplay.delay);
        }



        $('.stories-wrapper').addClass('show');
        circle.removeClass('animated');
        largeStoriesSwiper.autoplay.start();
    },1000);
});

// video end event
$('video.story-video-tag').on('ended',function(){
    largeStoriesSwiper.slideNext();
});

// story volume button
$(document).on('click','.story-volume-btn',function (){
    let btn = $(this);
    let storyItem = btn.parents('.story-item-lg');
    let videoTag = storyItem.find('video').get(0);
    let allVideos = $(largeStoriesSwiper.slides).find('video');

    if(btn.hasClass('muted')){
        videoTag.volume = 1;
        $('.story-volume-btn').removeClass('muted');
        $(allVideos).each(function() {
            let video = $(this).get(0);
            video.volume = 1;
        });
    }else{
        videoTag.volume = 0;
        $('.story-volume-btn').addClass('muted');
        $(allVideos).each(function() {
            let video = $(this).get(0);
            video.volume = 0;
        });
    }
});

// story play/pause button
$(document).on('click','.story-play-pause-btn',function (){
    if(largeStoriesSwiper.autoplay.paused){
        largeStoriesSwiper.autoplay.resume();
    }else{
        largeStoriesSwiper.autoplay.pause();
    }
});

// story back button
$(document).on('click','.story-item-lg-back',function (){
    // pause all videos
    stopAllVideos();
    // hide stories
    $('.stories-wrapper').removeClass('show');

    // stop swiper autoplay
    largeStoriesSwiper.autoplay.stop();
});

function stopAllVideos(){
    let videos = $(largeStoriesSwiper.slides).find('video');
    $(videos).each(function() {
        let video = $(this).get(0);
        video.pause();
        video.currentTime = 0;
    });
}
