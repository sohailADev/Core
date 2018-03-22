<?php require APPROOT.'/Views/PartialViews/header.php' ?>


<div class="row">
    <div class="col-md-6 mx-auto">


        <div class="card card-body bg-dark mt-5 text-white">
            <?php ; flash('rgisterSuccess'); ?>
            <h4 class="card-title">Login</h4>
            <p class="card-text">Please fill in your credentials to login </p>
        </div>
        <form action="<?php echo URLROOT; ?>/Users/login" method="post" >

            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control  <?php echo (!empty($data['emailError'])) ? 'is-invalid' : '' ?>" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $data['email'] ; ?>">
                <span class="invalid-feedback"><?php echo $data['emailError']?></span>

            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password:<sup>*</sup></label>
                <input type="password" name="password" class="form-control  <?php echo (!empty($data['passwordError'])) ? 'is-invalid' : '' ?>" id="exampleInputPassword1" placeholder="Password" value="<?php echo $data['password'] ; ?>">
                <span class="invalid-feedback"><?php echo $data['passwordError']?></span>
            </div>

            <div class="row">
                <div class="col">
                    <input type="submit" value="Login" class="btn btn-success btn-lg btn-block">
                </div>

                <div class="col">
                    <a type="button" href="<?php echo URLROOT; ?>/Users/register" class="btn text-white btn-lg btn-block" style="background-color: #002B36">No account? Register</a>
                </div>
            </div>

        </form>
    </div>

</div>


<?php require APPROOT.'/Views/PartialViews/footer.php' ?>