<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="author" content="">

    <!-- favicon Icon -->
    <!--<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">-->

    <!-- Google Fonts -->
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!--ф-я для отображения JS i CSS, а также стандартных WP css i js -->
<?php wp_head(); ?>

</head>
<!--body_class()- для вывода всех классов в боди-->
<body <?php body_class();?>>


<header class="navbar-fixed-top">
    <div class="container">
        <div class="row">
            <div class="header_top">
                <div class="col-md-2">
                    <div class="logo_img">
                        <!--ф-я для отображения картинки в лого-->
                        <a href="#"><?php the_custom_logo(0); ?>"
                        </a>
                    </div>
                </div>

                <div class="col-md-10">
                    <div class="menu_bar">
                        <nav role="navigation" class="navbar navbar-default">
                            <div class="navbar-header">
                                <button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                            </div>

                            <div class="collapse navbar-collapse" id="navbar">
<!--                                --><?php
                                //ф-я для вывода меню. в аргументах - название меню
                                wp_nav_menu(array(
                                    //созданная локация
                                    'theme_location' => 'primary',
                                    //выводит html разметку меню
                                    'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
                                    'menu_class' => 'nav navbar-nav',
                                    //задем айди
                                    'menu_id' => '',
                                    //глуина пунктов меню
                                    'depth' => 1
                                ));
                                ?>
<!--                                <ul class="nav navbar-nav">-->
<!--                                    <li><a href="#">Home</a></li>-->
<!--                                    <li><a href="#"> Features </a></li>-->
<!--                                    <li><a href="#">Services </a></li>-->
<!--                                    <li><a href="#"> How it work</a></li>-->
<!--                                    <li><a href="#"> Priceing </a></li>-->
<!--                                    <li><a href="#">Team </a></li>-->
<!--                                    <li><a href="#"> Testimonial </a></li>-->
<!--                                    <li><a href="#"> Blog  </a></li>-->
<!--                                    <li><a href="#">  Contact  </a></li>-->
<!--                                </ul>-->
                            </div>



                        </nav>
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>