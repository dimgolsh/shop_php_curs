
<?php

include_once ROOT . '/models/Category.php';
include_once ROOT . '/models/Product.php';
include_once ROOT . '/components/Pagination.php';

class CatalogController {

    public function actionIndex() {
        $categories = array();
        $categories = Category::getCategoriesList();


        $latestProduct = array();
        $latestProduct = Product::getLatestProducts(12);
        require_once(ROOT . '/views/catalog/index.php');
        // require_once(ROOT . '/models/Category.php');
        return true;
    }

   /* public function actionCategory($categoryId, $page = 1) {
        //echo $page;
        $categories = array();
        $categories = Category::getCategoriesList();
        $categoryProducts = array();
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);
        $total = Product::getTotalProductInCategory($categoryId);

        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');
        require_once (ROOT . '/views/catalog/category.php');
        return true;
    }
*/
    
     public function actionCategory($categoryId, $page = 1)
    {
        // Список категорий для левого меню
        $categories = Category::getCategoriesList();

        // Список товаров в категории
        $categoryProducts = Product::getProductsListByCategory($categoryId, $page);

        // Общее количетсво товаров (необходимо для постраничной навигации)
        $total = Product::getTotalProductInCategory($categoryId);
        
       // echo $total;
//echo '<pre>' ;print_r($categoryProducts);echo '<pre>' ;

        /*$arr = array(1, 2, 3);

        echo '<pre>';
        print_r($arr);
        echo '</pre>';

        print_r($arr);*/
        
        // Создаем объект Pagination - постраничная навигация
        $pagination = new Pagination($total, $page, Product::SHOW_BY_DEFAULT, 'page-');

        // Подключаем вид
        require_once(ROOT . '/views/catalog/category.php');
        return true;
    }
}
