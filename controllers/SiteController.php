<?php
include_once ROOT. '/models/Category.php';
include_once ROOT. '/models/Product.php';
class SiteController 
{
    public function actionIndex()
    {
        $categories = array();
        $categories = Category::getCategoriesList();
        
        
        $latestProduct = array();
        $latestProduct = Product::getLatestProducts(3);
        
                // Список товаров для слайдера
        $sliderProducts = Product::getRecommendedProducts();
        require_once(ROOT . '/views/site/index.php'); 
       // require_once(ROOT . '/models/Category.php');
        return true;
    }
    
    public function actionContact() {
        /* $mail ='@mail.ru';
          $subject = 'TEMA';
          $message = 'DESCTIP'; */

        //$result = mail($mail, $subject, $message);
        // var_dump($result);
        //  die;
        $userEmail = '';
        $userText = '';
        $result = '';
        if (isset($_POST['submit'])) {
            $userEmail = $_POST['userEmail'];
            $userText = $_POST['userText'];
            
            $errors = false;
            
            //valide
            
            if(!User::checkEmail($userEmail)){
                $errors[]='ERROR EMAIl';
                
                if($errors==false){
                    $adminEmail='admn@mai.ru';
                    $message ="TEX: {$userText}. Ot {$userEmail}";
                    $subject = 'TEMA';
                    $result = mail($adminEmail, $subject, $message);
                    $result = true;
                }
            }
        }
        require_once(ROOT . '/views/site/contact.php');
        return true;
    }

}
