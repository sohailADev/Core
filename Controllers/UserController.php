<?php
/**
 * Created by PhpStorm.
 * Users: sohail
 * Date: 1/25/2018
 * Time: 7:36 PM
 */
class UserController extends BaseController
{
    public function __construct()
    {
        $this->userModel = $this->model('User');

    }

    //loading our page
    public function register()
    {


        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            //process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'confirmPassword' => trim($_POST['confirmPassword']),
                'nameError' => '',
                'EamilError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''];
            //Validate email
            if (empty($data['email'])) {
                $data['emailError'] = 'Please enter the email';
            } else {
                //check email already exist or not
                if ($this->userModel->findUserByEmail($data['email'])) {
                    $data['emailError'] = 'Email is already exist';
                }
            }
            //Validate name
            if (empty($data['name'])) {
                $data['nameError'] = 'Please enter the name';
            }
            //Validate pass
            if (empty($data['password'])) {
                $data['passwordError'] = 'Please enter the password';
            } elseif (strlen($data['password']) < 6) {
                $data['passwordError'] = 'Password must be at least 6 characters';
            }
            //Validate conf pass
            if (empty($data['confirmPassword'])) {
                $data['confirmPasswordError'] = 'Please enter the password';
            } elseif ($data['password'] != $data['confirmPassword']) {
                $data['confirmPasswordError'] = 'Password do not match';
            }
            //make sure that erros should be empty
            if (empty($data['nameError']) && empty($data['emailError']) && empty($data['passwordError']) && empty($data['confirmPasswordError'])) {
                // $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                //REGISTER USER

                if ($this->userModel->register($data)) {
                    flash('rgisterSuccess', 'You are regitered and can login');
                    redirect('Users/login');

                } else {
                    die("Something went wrong ");
                }


            } else {
                //load view with errors
                $this->view('Users/register', $data);
            }

        } else {

            //init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'confirmPassword' => '',
                'nameError' => '',
                'EamilError' => '',
                'passwordError' => '',
                'confirmPasswordError' => ''];

            //load view
            $this->view('users/register', $data);

        }
    }

    public function login()
    {
        //check for post
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //process form
            //process form
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'EamilError' => '',
                'passwordError' => '',
            ];
            //Validate email
            if (empty($data['email'])) {
                $data['emailError'] = 'Please enter the email';
            }

            //Validate pass
            if (empty($data['password'])) {
                $data['passwordError'] = 'Please enter the password';
            }
            //check for user email
            if ($this->userModel->findUserByEmail($data['email'])) {
                //user found
            } else {
                //set the error user not found
                $data['emailError'] = "No user found ";

            }


            //make sure that erros should be empty
            if (empty($data['emailError']) && empty($data['passwordError'])) {

                //validated
                //check and set logged in user
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);


                if ($loggedInUser) {
                    //create a session
                    $this->createUserSession($loggedInUser);

                } else {
                    $data['passwordError'] = 'Password incorrect ';
                    $this->view('Users/login', $data);
                }
            } else {
                //load view with errors
                $this->view('Users/login', $data);
            }

        } else {
            //init data
            $data = [
                'email' => '',
                'password' => '',
                'EamilError' => '',
                'passwordError' => ''];

            //load view
            $this->view('users/login', $data);

        }
    }

    public function createUserSession($loggedInUser)
    {
        $_SESSION['userId'] = $loggedInUser['_id'];
        $_SESSION['userName'] = $loggedInUser['name'];
        $_SESSION['userEmail'] = $loggedInUser['email'];
        redirect('Posts/index.php');
    }

    public function logout()
    {
        unset($_SESSION['userId']);
        unset($_SESSION['userName']);
        unset($_SESSION['userEmail']);
        redirect('Users/login');
    }


}