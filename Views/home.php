<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="keywords" content=""/>
    <meta name="description" content="We provide strategies, expertise, and technology to business who want to succeed on the web." />
    <title>Wyred [Insights]</title>
    <!-- set html base path -->
    <base href="<?=hrefbase?>">

    <script src="<?=$this->linkFile($this->pagename.'.js','jsviews');?>"></script>

    <link rel="stylesheet" href="<?=$this->linkFile('style.css','css');?>" type="text/css" />
    <link rel="stylesheet" href="<?=$this->linkFile('menu-styles.css','css');?>" type="text/css" />
    <link rel="icon" href="/Assets/img/fav.png" type="image/x-icon" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

    <!-- Global site tag (gtag.js) - Google Analytics
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-109523896-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-109523896-1');
    </script>
    -->
</head>

<body>

<?include($this->linkFile('menu.php','includes'));?>



<div class="header-image col-xs-12 no-padding" style="background-image: url('<?=$this->linkFile('fp-header.png','img')?>')">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="header-text col-xs-12 col-sm-10">
        <h1>How's your business doing?</h1>
        <h2>just tell us where it hurts.</h2>
        We provide strategies, expertise, and technology for businesses that want to succeed on the web.

        <div class="flush-center">
            <a href="/contact" class="button-light">contact us</a>
        </div>
    </div>
</div>
<div class="intro-container services col-xs-12 no-padding">
    <h3>[ SERVICES ]</h3>
    <div class="col-xs-12 col-sm-3 service center-text">
        <i class="fa fa-rocket" aria-hidden="true"></i>
        <h4>Expertise</h4>
        Strategies and incubation for startups.
    </div>
    <div class="col-xs-12 col-sm-3 service center-text">
        <i class="fa fa-code" aria-hidden="true"></i>
        <h4>Development</h4>
        From your website, to server hardware, full-stack, full service.
    </div>
    <div class="col-xs-12 col-sm-3 service center-text">
        <i class="fa fa-eye" aria-hidden="true"></i>
        <h4>Design</h4>
        Digital identities, logos, networks and more.
    </div>
    <div class="col-xs-12 col-sm-3 service center-text">
        <i class="fa fa-line-chart" aria-hidden="true"></i>
        <h4>Social Marketing</h4>
        Consultation and campaigns.
    </div>
</div>
<div class="col-xs-12 no-padding alt-body-container">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-sm-10">
        <h1>
            from <span>[&nbsp;IDEA&nbsp;]</span> to <span>[&nbsp;REALITY&nbsp;]</span>
        </h1>
        <h2>
            We have all the tools you need to get your ideas up and running.
        </h2>
        <div class="flush-center">
            <a href="/contact" class="button-light">contact us</a>
        </div>
    </div>
</div>
<div class="col-xs-12 toolset no-padding">
    <h3>[ TOOLSET ]</h3>
    <div class="tool col-xs-12 ">
        <div class="col-xs-0 col-sm-1"></div>
        <div class="col-xs-12 col-sm-5">
            <div style="background-image: url('/Assets/img/start.png')" class="tool-image"></div>
        </div>
        <div class="col-xs-12 col-sm-5">
            <div class="description">
                Have an awesome idea for a startup but not sure where to begin?
                <br /><br />
                <span class="accent-color">Wyred [START]</span> will get you everything you need to launch your startup from incubation and discounted hosting to a full-service web app.
            </div>
        </div>
    </div>
    <div class="tool alt-light-background col-xs-12 ">
        <div class="col-xs-12 col-sm-5 float-right">
            <div style="background-image: url('/Assets/img/foundation.png')" class="tool-image"></div>
        </div>
        <div class="col-xs-0 col-sm-1"></div>
        <div class="col-xs-12 col-sm-5">
            <div class="description">
                Built from the ground up, <span class="accent-color">Wyred [FOUNDATION]</span> provides an API centric application framework to create the best possible environment for your ideas to live.
            </div>
        </div>
    </div>
    <div class="tool col-xs-12 ">
        <div class="col-xs-0 col-sm-1"></div>
        <div class="col-xs-12 col-sm-5">
            <div style="background-image: url('/Assets/img/label.png')" class="tool-image"></div>
        </div>
        <div class="col-xs-12 col-sm-5">
            <div class="description">
                Does your business require any type of white-labeling service?
                <br /><br />
                <span class="accent-color">Wyred [LABEL]</span> gives you our branding engine and front-end templates, which makes white-labeling a snap.
            </div>
        </div>
    </div>
    <div class="tool alt-light-background col-xs-12 ">
        <div class="col-xs-12 col-sm-5 float-right">
            <div style="background-image: url('/Assets/img/flow.png')" class="tool-image"></div>
        </div>
        <div class="col-xs-0 col-sm-1"></div>
        <div class="col-xs-12 col-sm-5">
            <div class="description">
                <span class="accent-color">Wyred [FLOW]</span> is a visual back-end builder. It makes linking APIs and databases into web apps so easy, you’ll never have to code anything.
                <br /><br/>
                This product is currently in beta.
            </div>
        </div>
    </div>
    <div class="tool col-xs-12 ">
        <div class="col-xs-0 col-sm-1"></div>
        <div class="col-xs-12 col-sm-5">
            <div style="background-image: url('/Assets/img/id.png')" class="tool-image"></div>
        </div>
        <div class="col-xs-12 col-sm-5">
            <div class="description">
                So, how do you look?
                <br /><br />
                Your digital identity is extremely important these days. <span class="accent-color">Wyred [ID]</span> is devoted to making sure your business makes the best impressions all around from your logo to your Instagram account.
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12 no-padding alt-body-container">
    <div class="col-xs-0 col-sm-1"></div>
    <div class="col-xs-12 col-sm-10">
        <h1 class="bottomh1">
            Need something custom?
        </h1>
        <h2>
            no problem, lets chat.
        </h2>
        <div class="flush-center">
            <a href="/contact" class="button-light">contact us</a>
        </div>
    </div>
</div>

<?include($this->linkFile('footer.php','includes'));?>

</body>
</html>