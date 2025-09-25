(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.sticky-top').addClass('bg-white shadow-sm').css('top', '-1px');
        } else {
            $('.sticky-top').removeClass('bg-white shadow-sm').css('top', '-100px');
        }
    });


    // Facts counter
    $('[data-toggle="counter-up"]').counterUp({
        delay: 10,
        time: 2000
    });


    // Experience
    $('.experience').waypoint(function () {
        $('.progress .progress-bar').each(function () {
            $(this).css("width", $(this).attr("aria-valuenow") + '%');
        });
    }, {offset: '80%'});
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500, 'easeInOutExpo');
        return false;
    });


    // Modal Video
    var $videoSrc;
    $('.btn-play').click(function () {
        $videoSrc = $(this).data("src");
    });
    console.log($videoSrc);
    $('#videoModal').on('shown.bs.modal', function (e) {
        $("#video").attr('src', $videoSrc + "?autoplay=1&amp;modestbranding=1&amp;showinfo=0");
    })
    $('#videoModal').on('hide.bs.modal', function (e) {
        $("#video").attr('src', $videoSrc);
    })
// Our services bar start here 
document.addEventListener('DOMContentLoaded', () => {
            const services = [
                {
                    id: '1',
                    title: 'Strategic Consulting',
                    image: 'https://placehold.co/800x400/4ade80/FFFFFF?text=Strategic+Consulting',
                    description: 'Our expert team provides bespoke strategic consulting to help your business navigate complex markets and achieve sustainable growth. We analyze data, identify opportunities, and craft actionable plans tailored to your unique needs.'
                },
                {
                    id: '2',
                    title: 'Web Development',
                    image: 'https://placehold.co/800x400/38bdf8/FFFFFF?text=Web+Development',
                    description: 'We build stunning, responsive, and high-performing websites using the latest technologies. Our development process focuses on creating a seamless user experience that captivates your audience and drives conversions.'
                },
                {
                    id: '3',
                    title: 'Digital Marketing',
                    image: 'https://placehold.co/800x400/fbbf24/FFFFFF?text=Digital+Marketing',
                    description: 'From SEO and PPC to social media campaigns, our digital marketing services are designed to maximize your online presence. We create data-driven strategies that connect you with your target audience and deliver measurable results.'
                },
                {
                    id: '4',
                    title: 'UI/UX Design',
                    image: 'https://placehold.co/800x400/a855f7/FFFFFF?text=UI%2FUX+Design',
                    description: 'We craft intuitive and beautiful user interfaces that are a joy to use. Our design process is rooted in user research and psychological principles to ensure your product is not only visually appealing but also highly effective.'
                },
                {
                    id: '5',
                    title: 'Cloud Solutions',
                    image: 'https://placehold.co/800x400/f43f5e/FFFFFF?text=Cloud+Solutions',
                    description: 'Accelerate your business with our comprehensive cloud solutions. We provide everything from migration and infrastructure management to custom cloud-native application development, ensuring scalability and security.'
                }
            ];

            const serviceList = document.getElementById('service-list');
            const serviceImage = document.getElementById('service-image');
            const serviceTitle = document.getElementById('service-title');
            const serviceDescription = document.getElementById('service-description');

            function renderServices() {
                serviceList.innerHTML = services.map(service => `
                    <a href="#" data-id="${service.id}" class="service-link block p-4 text-gray-700 font-medium hover:text-blue-600 rounded-lg transition duration-200 mb-2">
                        ${service.title}
                    </a>
                `).join('');
            }

            function displayService(service) {
                serviceImage.src = service.image;
                serviceTitle.textContent = service.title;
                serviceDescription.textContent = service.description;

                document.querySelectorAll('.service-link').forEach(link => {
                    link.classList.remove('active');
                    link.classList.remove('text-white');
                    link.classList.add('text-gray-700');
                });
                document.querySelector(`[data-id="${service.id}"]`).classList.add('active');
            }

            renderServices();

            // Initial display of the first service
            if (services.length > 0) {
                displayService(services[0]);
            }

            serviceList.addEventListener('click', (event) => {
                if (event.target.classList.contains('service-link')) {
                    event.preventDefault();
                    const serviceId = event.target.dataset.id;
                    const selectedService = services.find(s => s.id === serviceId);
                    if (selectedService) {
                        displayService(selectedService);
                    }
                }
            });
        });
    // Testimonial carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: true,
        smartSpeed: 1000,
        items: 1,
        loop: true,
        dots: false,
        nav: true,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ]
    });
    
})(jQuery);

