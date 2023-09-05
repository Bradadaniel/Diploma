<?php session_start();?>
    <head>
        <link rel="shortcut icon" type="x-icon" href="img/Dabe-logos_black2.png">
        <title>DabeShop - Contact</title>
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/contact.css">
    <body>


<?php include "header.php";?>
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if (isset($_POST['submit'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $text = $_POST['text'];

    echo "<div style='display: none;'>";
    $mail = new PHPMailer(true);


    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = "danibrada29@gmail.com";
        $mail->Password = "iuwnykymzxfrmepw";                            //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPSecure = 'tls';

        //Recipients
        $mail->setFrom('danibrada29@gmail.com');
        $mail->addAddress($email);

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'no reply';
        $mail->Body = 'Hello my name is ' . $name. '.Here is the email:' . $email. ' and phone number: ' . $phone . '.<p>' . $text . '</p></a></b>';

        $mail->send();
        echo 'Message has been sent';
        header('Location: index.php');
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<div class="contact_us_6">
    <div class="responsive-container-block container">
        <form class="form-box" method="post">
            <div class="container-block form-wrapper">
                <div class="mob-text">
                    <p class="text-blk contactus-head">
                        Get in Touch
                    </p>
                    <p class="text-blk contactus-subhead">

                    </p>
                </div>
                <div class="responsive-container-block" id="i2cbk">
                    <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="i10mt-3">
                        <p class="text-blk input-title">
                            FIRST NAME
                        </p>
                        <input class="input" id="" name="name" placeholder="Please enter first name..." required>
                    </div>
                    <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="ip1yp">
                        <p class="text-blk input-title">
                            EMAIL
                        </p>
                        <input class="input" id="" name="email" placeholder="Please enter email..." required>
                    </div>
                    <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="ih9wi">
                        <p class="text-blk input-title">
                            PHONE NUMBER
                        </p>
                        <input class="input" id="" name="phone" placeholder="Please enter phone number..." required>
                    </div>
                    <div class="responsive-cell-block wk-tab-12 wk-mobile-12 wk-desk-12 wk-ipadp-12" id="i634i-3">
                        <p class="text-blk input-title">
                            WHAT DO YOU HAVE IN MIND ?
                        </p>
                        <textarea class="textinput" id="" name="text" placeholder="Please enter query..." required></textarea>
                    </div>
                </div>
                <button class="submit-btn" name="submit" id="w-c-s-bgc_p-1-dm-id-2">
                    Submit
                </button>
            </div>
        </form>
        <div class="responsive-cell-block wk-desk-7 wk-ipadp-12 wk-tab-12 wk-mobile-12" id="i772w">
            <div class="map-part">
                <p class="text-blk map-contactus-head" id="w-c-s-fc_p-1-dm-id">
                    Reach us at
                </p>
                <p class="text-blk map-contactus-subhead">

                </p>
                <div class="social-media-links mob">
                    <a class="social-icon-link" href="#" id="ix94i-2-2">
                        <img class="link-img image-block" src="https://workik-widget-assets.s3.amazonaws.com/Footer1-83/v1/images/Icon-twitter.png">
                    </a>
                    <a class="social-icon-link" href="#" id="itixd">
                        <img class="link-img image-block" src="https://workik-widget-assets.s3.amazonaws.com/Footer1-83/v1/images/Icon-facebook.png">
                    </a>
                    <a class="social-icon-link" href="#" id="izxvt">
                        <img class="link-img image-block" src="https://workik-widget-assets.s3.amazonaws.com/Footer1-83/v1/images/Icon-google.png">
                    </a>
                    <a class="social-icon-link" href="#" id="izldf-2-2">
                        <img class="link-img image-block" src="https://workik-widget-assets.s3.amazonaws.com/Footer1-83/v1/images/Icon-instagram.png">
                    </a>
                </div>
                <div class="map-box container-block">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d89044.61903633949!2d19.47946431281033!3d45.77831746236109!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4744aa8c8645a3d5%3A0x22082e91c30ef841!2sBajsa!5e0!3m2!1shu!2srs!4v1692082500253!5m2!1shu!2srs" width="700" height="520" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php";?>
    </body>
