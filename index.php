<?php session_start();?>
<head>
    <link rel="shortcut icon" type="x-icon" href="img/Dabe-logos_black2.png">
    <title>DabeShop</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>


<?php include 'header.php'?>

<?php include 'main.php'?>

<?php include 'footer.php'?>




<script>
    //swiper
    const swiper = new Swiper('.sliderbox', {
        loop: true,
        effect: 'fade',
        autoHeight: true,

        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });

    //carousel
    // const carousel = new Swiper('.carouselbox', {
    //
    //     spaceBetween: 30,
    //     slidesPerView:'auto',
    //     centeredSlides: true,
    //
    //     navigation: {
    //         nextEl: '.swiper-button-next',
    //         prevEl: '.swiper-button-prev',
    //     },
    //     breakpoints: {
    //         481:{
    //             slidesPerView: 2,
    //             slidesPerGroup: 1,
    //             centeredSlides: false,
    //         },
    //         640:{
    //             slidesPerView: 3,
    //             slidesPerGroup: 3,
    //             centeredSlides: false,
    //         },
    //         992:{
    //             slidesPerView: 4,
    //             slidesPerGroup: 4,
    //             centeredSlides: false,
    //         },
    //     }
    // });
</script>
<script src="js/script.js"></script>
</body>
</html>
