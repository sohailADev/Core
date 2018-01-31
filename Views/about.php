<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="keywords" content=""/>
    <meta name="description" content="We provide strategies, expertise, and technology to business who want to succeed on the web." />

    <title>About Us</title>

    <!-- set html base path -->
    <base href="<?=hrefbase?>">

    <link rel="stylesheet" href="<?=$this->linkFile('style','css');?>" type="text/css" />
    <link rel="stylesheet" href="<?=$this->linkFile('menu-styles','css');?>" type="text/css" />
    <link rel="icon" href="http://www.wyredin.com/sites/wyredin/images/fav.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">


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
        <h1>About Us</h1>
    </div>
</div>
<div class="community col-xs-12 no-padding">
    <h2>What is <span class="accent-color">Wyred [Insights]?</span></h2>
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-sm-4 main-text1" >
        We are a team of experienced developers and designers with the toolsets, programming interfaces and frameworks to make rapid application development a reality.
    </div>
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-sm-4 main-text">
    Our ambition is to provide internet businesses the services and expertise they need to easily deploy their vision on the web.
    </div>
</div>

<!-- Images will go in the following div -->
<div class="col-xs-12">
    

</div>


<div class="col-xs-12 no-padding alt-body-container">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-sm-10">
        <h1 class="com-h1">
            Is there some technical challenge holding your company back from its full potential? 
        </h1>
        <h2 class="com-h2">
            Wyred [Insights] offers support with development, network security, design, social marketing and more.
        </h2>
        <div class="flush-center">
            <a href="http://www.wyredinsights.com/contact" target="_blank" class="button-light">Contact Us</a>
        </div>
    </div>
</div>
<?include($this->linkFile('footer','php'));?>
</body>




</html>