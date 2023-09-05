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

</script>
<script src="js/script.js"></script>
</body>
</html>
