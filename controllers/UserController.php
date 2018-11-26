<?php

class UserController{
    
    public function actionRegister()
            {
        
        $name = '';
        $email = '';
        $password = '';
         $result = false;
        
        if (isset($_POST['submit']))
            
            {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            
            /*  if (isset($_POST['name'])){
                  echo '<br>name: ' . $name;
              }
              if (isset($_POST['email'])){
                  echo '<br>email: ' . $email;
              }
              if (isset($_POST['password'])){
                  echo '<br>password: ' . $password;
              }*/
              $errors = false;
            /*  if (User::checkName($name)) {
              echo '<br>$name ok';
              } else { 
                  
              }
        
              if(!User::checkEmail($email)){
                  echo '<br>$email ok';
                  
              } else { $errors[] ='Email error';
                  
              }
              
              if(!User::checkPassword($password)){
                  echo '<br>$password ok';
                  
              } else { $errors[] ='Password error';
                  
              }
              if (User::checkEmailExists($email)){
                  $erros[]= 'dddddddfvbf';
                  
              }
              
              
              if ($errors ==false){
                  
               $result = User::register($name,$email,$password);
              }*/
              
              if (!User::checkName($name)) {
                $errors[] = 'Имя не должно быть короче 2-х символов';
            }
            
            if (!User::checkEmail($email)) {
                $errors[] = 'Неправильный email';
            }
            
            if (!User::checkPassword($password)) {
                $errors[] = 'Пароль не должен быть короче 6-ти символов';
            }
            
            if (User::checkEmailExists($email)) {
                $errors[] = 'Такой email уже используется';
            }
            
            if ($errors == false) {
                $result = array();
                $result = User::register($name, $email, $password);
            }
            
              }
        
        
        
        
        require_once (ROOT . '/views/user/register.php');
        return true;
    }
    
    
    public function actionLogin(){
        $email = '';
        $password ='';
   
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            $errors = false;

            if (!User::checkEmail($email)) {
                $errors[] = 'ERROR_EMAIL';
            }
            if (!User::checkPassword($password)) {
                $errors[] = 'ERROR_PASSWORD';
            }

            $userId = User::checkUserData($email, $password);

            if ($userId == false) {
                $errors[] = 'ERROR NOT FOUND';
            } else {
                User::auth($userId);
                header("Location: /cabinet/");
            }
        }



        require_once (ROOT. '/views/user/login.php');
        return true;
    }
    
    public function actionLogout() {
        session_start();
        unset($_SESSION["user"]);
        header("Location: /");
    }
    
}

