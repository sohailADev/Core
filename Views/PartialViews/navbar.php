<?php
/**
 * Created by PhpStorm.
 * Users: sohail
 * Date: 1/25/2018
 * Time: 3:03 PM
 */?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
    <div class="container">
        <a class="navbar-brand" href="<?php echo URLROOT?>"><?php echo SITENAME?></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarColor02">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item ">
                    <a class="nav-link" href="<?php echo URLROOT?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT?>/Posts/index">Tutorials</a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto ">
                <?php if(isset($_SESSION['userId'])):  ?>
                    <li class="nav-item ">
                        <a class="nav-link" href="<?php echo URLROOT ?>/Posts/index">Welcome    <?php echo $_SESSION['userName'];  ?> </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo URLROOT?>/Users/logout">Log out</a>
                    </li>
                <?php else:  ?>
                <li class="nav-item ">
                    <a class="nav-link" href="<?php echo URLROOT ?>/Users/register">Register </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo URLROOT?>/Users/Login">Login</a>
                </li>
                <?php endif;  ?>
            </ul>
        </div>
    </div>
</nav>

