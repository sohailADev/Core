<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="keywords" content=""/>
    <meta name="description" content="We provide strategies, expertise, and technology to business who want to succeed on the web." />

    <title>Contact Us</title>

    <!-- set html base path -->
    <base href="<?=hrefbase?>">

    <link rel="stylesheet" href="<?=$this->linkFile('style','css');?>" type="text/css" />
    <link rel="stylesheet" href="<?=$this->linkFile('menu-styles','css');?>" type="text/css" />
    <link rel="stylesheet" href="<?=$this->linkFile('dialog','css');?>" type="text/css" />
    <link rel="icon" href="http://www.wyredin.com/sites/wyredin/images/fav.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- jQuery libs -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <!-- page specific js -->
    <script type='text/javascript' src='<?=$this->linkFile($this->pagename,'js');?>'></script>
    <script type='text/javascript' src='<?=$this->linkFile('tools','jslibs');?>'></script>
    <script type='text/javascript' src='<?=$this->linkFile('jquery.validate','jslibs');?>'></script>
    <? $this->getVars(); ?>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109523896-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-109523896-1');
    </script>

</head>

<body>
<?include($this->linkFile('menu','php'));?>
<div class="header-image-inside col-xs-12 no-padding" style="background-image: url('images/fp-header.png')">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="header-text-inside col-xs-12 col-sm-10">
        <h1>Contact Us</h1>
    </div>
</div>
<div class="col-xs-12 contact no-padding">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-sm-5">
        <h3>direct</h3>

        <h5>Tim Berfield</h5>
        <h6>[CEO] / [CO-FOUNDER]</h6>
        tim@wyredin.com
        <br /><br />
        <h5>Nikki Hillman</h5>
        <h6>[CREATIVE DIRECTOR] / [CO-FOUNDER]</h6>
        nikki@wyredin.com


        <h3>office</h3>
        <div class="contact-extra">
            <span class="fa fa-phone"></span>775-420-5225
            <span class="fa fa-envelope-o"></span> info@wyredinsights.com
        </div>

    </div>
    <div class="col-xs-12 col-sm-5">
        <h3>keep in touch</h3>
        <form id="contactfrm" action="" method="POST" class="form">
            <input type="text" name="fname" id="fname" placeholder="First Name">
            <input type="text" name="lname" id="lname" placeholder="Last Name">
            <input type="text" name="email" id="email" placeholder="Email">
            <input type="text" name="phone" id="phone" placeholder="Phone">
            <textarea name="comment" id="comment" placeholder="Comments"></textarea>
            <button type="submit">Send</button>
        </form>
    </div>
</div>
<div class="col-xs-12 contact no-padding">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-sm-5">
        <h3>location</h3>
        2005 Silverada Blvd. Suite 360
        <br/>
        Reno, NV
        <br/><br/>

        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3076.501026393496!2d-119.78616268478989!3d39.548308979475586!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x809938a6bb1c1b77%3A0x9b972dcc548daced!2s2005+Silverada+Blvd%2C+Reno%2C+NV+89512!5e0!3m2!1sen!2sus!4v1507670204052" width="200" height="200" frameborder="0" style="border:0" allowfullscreen></iframe>

    </div>
</div>
<div class="col-xs-12 no-padding alt-body-container">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-sm-10">
        <h1 class="bottomh1">
            Thanks for visiting!
        </h1>
        <h2>
            We hope to see you again soon.
        </h2>
    </div>
</div>
<?include($this->linkFile('footer','php'));?>
</body>




</html>