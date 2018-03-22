<?php require APPROOT.'/Views/PartialViews/header.php' ?>


<div class="row">
    <div class="col-md-6 mx-auto">


            <div class="card card-body bg-dark mt-5 text-white">
                <h4 class="card-title">Create An Account</h4>
                <p class="card-text">Please fill out this form to register with us</p>
            </div>
        <form action="<?php echo URLROOT; ?>/Users/register" method="post" >
                <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($data['nameError'])) ? 'is-invalid' : '' ?> " id="nameInputEmail1" placeholder="Enter Name" value="<?php echo $data['name'] ; ?>" >
                <span class="invalid-feedback"><?php echo $data['nameError']?></span>
                </div>
                <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" name="email" class="form-control  <?php echo (!empty($data['emailError'])) ? 'is-invalid' : '' ?>" id="exampleInputEmail1" placeholder="Enter email" value="<?php echo $data['email'] ; ?>">
                <span class="invalid-feedback"><?php echo $data['emailError']?></span>
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" name="password" class="form-control  <?php echo (!empty($data['passwordError'])) ? 'is-invalid' : '' ?>" id="exampleInputPassword1" placeholder="Password" value="<?php echo $data['password'] ; ?>">
                <span class="invalid-feedback"><?php echo $data['passwordError']?></span>
                </div>
                <div class="form-group">
                <label for="exampleInputPassword1">Confirm Password</label>
                <input type="password" name="confirmPassword" class="form-control  <?php echo (!empty($data['confirmPasswordError'])) ? 'is-invalid' : '' ?>" id="exampleInputConfirmPassword1" placeholder="Password" value="<?php echo $data['confirmPassword'] ; ?>">
                <span class="invalid-feedback"><?php echo $data['confirmPasswordError']?></span>
                </div>
            <div class="row">
                <div class="col">
                    <input type="submit" value="Register" class="btn btn-success btn-lg btn-block">
                </div>
                <div class="col">
                    <a type="button"  href="<?php echo URLROOT; ?>/Users/login" class="btn text-white btn-lg btn-block" style="background-color: #002B36">Have an account? Login</a>
                </div>
            </div>

        </form>
    </div>

</div>


<?php require APPROOT.'/Views/PartialViews/footer.php' ?>
