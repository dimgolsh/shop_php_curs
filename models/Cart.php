<?php

class Cart {

    public static function addProduct($id) {

        $id = intval($id);
        $productsInCart = array();
        if (isset($_SESSION['products'])) {
            $productsInCart = $_SESSION['products'];
        }
        if (array_key_exists($id, $productsInCart)) {
            $productsInCart[$id] ++;
        } else {
            $productsInCart[$id] = 1;
        }
        $_SESSION['products'] = $productsInCart;
        //echo '<pre>';    print_r($_SESSION['products']); die();

        return self::countItem();
    }

  /*  public static function countItem() {
        if (isset($_SESSION['products'])) {
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            return 0;
        }
    }*/
    public static function countItem()
    {
        // Проверка наличия товаров в корзине
        if (isset($_SESSION['products'])) {
            // Если массив с товарами есть
            // Подсчитаем и вернем их количество
            $count = 0;
            foreach ($_SESSION['products'] as $id => $quantity) {
                $count = $count + $quantity;
            }
            return $count;
        } else {
            // Если товаров нет, вернем 0
            return 0;
        }
    }

    public static function getProducts() {

        if (isset($_SESSION['products'])) {
            return $_SESSION['products'];
        }
        return false;
    }

    /*public static function getTotalPrice($products) {
        $productsInCart = self::getProducts();
        if ($productsInCart) {
            $total = 0;
            foreach ($products as $item) {
                $total += $item['price'] * $productsInCart[$item['id_product']];
            }
        }
    }
*/
     public static function getTotalPrice($products)
    {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();

        // Подсчитываем общую стоимость
        $total = 0;
        if ($productsInCart) {
            // Если в корзине не пусто
            // Проходим по переданному в метод массиву товаров
            foreach ($products as $item) {
                // Находим общую стоимость: цена товара * количество товара
                $total += $item['price'] * $productsInCart[$item['id_product']];
            }
        }

        return $total;
    }
    /**
     * Очищает корзину
     */
    public static function clear() {
        if (isset($_SESSION['products'])) {
            unset($_SESSION['products']);
        }
    }

    /**
     * Удаляет товар с указанным id из корзины
     * @param integer $id <p>id товара</p>
     */
    public static function deleteProduct($id) {
        // Получаем массив с идентификаторами и количеством товаров в корзине
        $productsInCart = self::getProducts();
        // Удаляем из массива элемент с указанным id
        unset($productsInCart[$id]);
        // Записываем массив товаров с удаленным элементом в сессию
        $_SESSION['products'] = $productsInCart;

        /*
          $productsInCart = [];
          $productsInCart = $_SESSION['products'];
          if(array_key_exists($id, $productsInCart)) {
          $productsInCart[$id]--;
          }
          if($productsInCart[$id]<=0){
          unset($productsInCart[$id]);
          }
          $_SESSION['products'] = $productsInCart;
          return self::countItems(); */
    }

}
