<?php
header("Content-Type:text/css");
$color = "#f0f"; // Change your Color Here
$secondColor = "#ff8"; // Change your Color Here

function checkhexcolor($color){
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if (isset($_GET['color']) AND $_GET['color'] != '') {
    $color = "#" . $_GET['color'];
}

if (!$color OR !checkhexcolor($color)) {
    $color = "#336699";
}


function checkhexcolor2($secondColor){
    return preg_match('/^#[a-f0-9]{6}$/i', $secondColor);
}

if (isset($_GET['secondColor']) AND $_GET['secondColor'] != '') {
    $secondColor = "#" . $_GET['secondColor'];
}

if (!$secondColor OR !checkhexcolor2($secondColor)) {
    $secondColor = "#336699";
}
?>


input:focus {
border: 1px solid <?php echo  $color ?>;
}

input[type="submit"] {
cursor: pointer;
background-color: <?php echo  $color ?>;
}

.bg-3, .deposit-tab .tab-menu .custom-button.active, .contact-form .form-group input[type="submit"], .ask-form .form-group input[type="submit"], .account-form .form-group input[type="submit"], .comment-form .form-group input[type="submit"] {
background-image: -moz-linear-gradient(41deg, <?php echo  $color ?> 30%, <?php echo  $color ?> 67%, <?php echo  $color ?> 88%);
background-image: -webkit-linear-gradient(41deg, <?php echo  $color ?> 30%, <?php echo  $color ?> 67%, <?php echo  $color ?> 88%);
}

.newslater-form .form-group button {
background: <?php echo  $color ?>;
}

.newslater-form .form-group input {
background: <?php echo  $color ?>1a;
color: #777777;
height: 70px;
padding-left: 25px;
-webkit-border-radius: 6px;
-moz-border-radius: 6px;
border-radius: 6px;
}


.newslater-form .form-group input:focus {
border: 1px solid <?php echo  $color ?>;
}

.account-form .form-group a {
color: <?php echo  $color ?>;
}
.footer-widget .social-icons li a i {
color: <?php echo  $color ?>;
}

h1 a:hover, h2 a:hover, h3 a:hover, h4 a:hover, h5 a:hover, h6 a:hover {
color: <?php echo  $color ?>;
}


.faq-wrapper.style-two .faq-item.open .faq-title::after {
background: <?php echo  $color ?>;
}


.scrollToTop {
background:  <?php echo  $color ?>;
}

.scrollToTop:hover {
background: <?php echo  $color ?>;
}

.bg-1, bg-3,
.custom-button .bg-1,
.custom-button .bg-1 {
background-image: -moz-linear-gradient(41deg, <?php echo  $color ?> 30%, <?php echo  $color ?> 75%, <?php echo  $color ?> 100%);
background-image: -webkit-linear-gradient(41deg, <?php echo  $color ?> 30%, <?php echo  $color ?> 75%, <?php echo  $color ?> 100%);
}

.sponsors .owl-prev, .sponsors .owl-next {
color: <?php echo  $color ?> ;
}

.owl-nav .owl-next,
.owl-nav .owl-prev:hover,
.owl-nav .owl-next:hover {
color: <?php echo  $color ?> ;
}

header.active {
	background: #000036;
}