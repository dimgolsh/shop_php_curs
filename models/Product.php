<?php

class Product {

    // Количество отображаемых товаров по умолчанию
    const SHOW_BY_DEFAULT = 6;

    public static function getLatestProducts($count = self::SHOW_BY_DEFAULT) {
        $count = intval($count);
        $db = Db::getConnection();
        $productsList = array();
        $result = $db->query('SELECT '
                . 'id_product, '
                . 'name_product, '
                . 'price, '
                . 'image, '
                . 'is_new FROM product WHERE status="1" '
                . 'ORDER BY id_product DESC '
                . 'LIMIT ' . $count);

        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id_product'] = $row['id_product'];
            $productsList[$i]['name_product'] = $row['name_product'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

   /* 
    * public static function getProductsListByCategory($categoryId = false, $page = 1) {
        if ($categoryId) {

            $limit = self::SHOW_BY_DEFAULT;
            $page = intval($page);
            $offset = ($page - 1) * self::SHOW_BY_DEFAULT * (-1);
            $db = Db::getConnection();

            $products = array();
            //  echo $offset;
            // echo $limit;
            $result = $db->query("SELECT id_product, name_product,price, image, is_new FROM product "
                    . "WHERE status = '1' AND id_category = '$categoryId' "
                    . "ORDER BY id_product ASC "
                    . "LIMIT " . self::SHOW_BY_DEFAULT
                    . ' OFFSET ' . $offset);
    */
            // $result = $db->query("SELECT id_product,name_product, price, image, is_new FROM product WHERE status='1' AND id_category = '$categoryId' ORDER BY id_product ASC LIMIT '$limit'");
            // $result = $db->query("SELECT * FROM product WHERE status='1' AND id_category = '$categoryId' OFFSET '6'");
            // Текст запроса к БД
            /**  $sql = 'SELECT id_product, name_product, price, is_new FROM product '
              . 'WHERE status = 1 AND category_id = :category_id '
              . 'ORDER BY id ASC LIMIT :limit OFFSET :offset';
              // Используется подготовленный запрос
              $result = $db->prepare($sql);
              $result->bindParam(':category_id', $categoryId, PDO::PARAM_INT);
              $result->bindParam(':limit', $limit, PDO::PARAM_INT);
              $result->bindParam(':offset', $offset, PDO::PARAM_INT);
              // Выполнение коменды
              $result->execute(); */
         /*
          *    $i = 0;
            while ($row = $result->fetch()) {
                $products[$i]['id_product'] = $row['id_product'];
                $products[$i]['name_product'] = $row['name_product'];
                $products[$i]['image'] = $row['image'];
                $products[$i]['price'] = $row['price'];
                $products[$i]['is_new'] = $row['is_new'];
                $i++;
            }
            return $products;
        }
    }*/

    
    
    /**
     * Возвращает список товаров в указанной категории
     * @param type $categoryId <p>id категории</p>
     * @param type $page [optional] <p>Номер страницы</p>
     * @return type <p>Массив с товарами</p>
     */
    public static function getProductsListByCategory($categoryId, $page = 1)
    {
        $limit = Product::SHOW_BY_DEFAULT;
        // Смещение (для запроса)
        $offset = ($page - 1) * self::SHOW_BY_DEFAULT;
        //echo $limit;

        // Соединение с БД
        $db = Db::getConnection();
       echo $categoryId;
        // Текст запроса к БД
        /* $sql = 'SELECT id_product, name_product, price, is_new FROM product '
          . 'WHERE status = 1 AND id_category = :id_category '
          . 'ORDER BY id ASC LIMIT :limit OFFSET :offset '; */
        $sql = 'SELECT id_product, name_product, id_category, price, is_new FROM product '
                . 'WHERE status = 1 AND id_category = :id_category '
                . 'ORDER BY id_product ASC LIMIT :limit OFFSET :offset ';
        // Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id_category', $categoryId, PDO::PARAM_INT);
        $result->bindParam(':limit', $limit, PDO::PARAM_INT);
        $result->bindParam(':offset', $offset, PDO::PARAM_INT);

        // Выполнение коменды
        $result->execute();

        // Получение и возврат результатов
        $i = 0;
        $products = array();
        while ($row = $result->fetch()) {
            $products[$i]['id_product'] = $row['id_product'];
            $products[$i]['name_product'] = $row['name_product'];
            $products[$i]['price'] = $row['price'];
            $products[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $products;
    }
    
    
    public static function getProductById($id) {
        $id = intval($id);
        if ($id) {
            $db = Db::getConnection();
            $result = $db->query('SELECT * from product WHERE id_product = ' . $id);
            $result->setFetchMode(PDO::FETCH_ASSOC);

            return $result->fetch();
        }
    }

    public static function getTotalProductInCategory($categoryId) {
        $db = Db::getConnection();
        $result = $db->query('SELECT count(id_product) AS count FROM product '
                . 'WHERE status = "1" AND id_category= "' . $categoryId . '"');
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $row = $result->fetch();
        return $row['count'];
    }

    public static function getProductByIds($idsArray) {
        $products = array();

        $db = Db::getConnection();

        $idsString = implode(',', $idsArray);

        $sql = "SELECT * FROM product where status='1' AND id_product IN ($idsString)";
        $result = $db->query($sql);
        $result->setFetchMode(PDO::FETCH_ASSOC);
        $i = 0;
        while ($row = $result->fetch()) {
            $products[$i]['id_product'] = $row['id_product'];
            $products[$i]['code'] = $row['code'];
            $products[$i]['name_product'] = $row['name_product'];
            $products[$i]['price'] = $row['price'];
            $i++;
        }
        return $products;
    }

    public static function getRecommendedProducts() {
        // Соединение с БД
        $db = Db::getConnection();
        // Получение и возврат результатов
        $result = $db->query('SELECT id_product, name_product, price, is_new FROM product '
                . 'WHERE status = "1" AND is_recommended = "1" ');
        // . 'ORDER BY id DESC');
        $i = 0;
        $productsList = array();
        while ($row = $result->fetch()) {
            $productsList[$i]['id_product'] = $row['id_product'];
            $productsList[$i]['name_product'] = $row['name_product'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

    public static function getImage($id) {
        // Название изображения-пустышки
        $noImage = 'no-image.jpg';
        // Путь к папке с товарами
        $path = '/upload/images/products/';
        // Путь к изображению товара
        $pathToProductImage = $path . $id . '.jpg';
        if (file_exists($_SERVER['DOCUMENT_ROOT'] . $pathToProductImage)) {
            // Если изображение для товара существует
            // Возвращаем путь изображения товара
            return $pathToProductImage;
        }
        // Возвращаем путь изображения-пустышки
        return $path . $noImage;
    }

    public static function geProductsList() {

        $db = Db::getConnection();
        $productsList = array();
        $result = $db->query('SELECT '
                . 'id_product, '
                . 'name_product, '
                . 'price, '
                . 'image, '
                . 'code, '
                . 'is_new FROM product '
                . 'ORDER BY id_product ASC ');

        $i = 0;
        while ($row = $result->fetch()) {
            $productsList[$i]['id_product'] = $row['id_product'];
            $productsList[$i]['name_product'] = $row['name_product'];
            $productsList[$i]['image'] = $row['image'];
            $productsList[$i]['price'] = $row['price'];
            $productsList[$i]['code'] = $row['code'];
            $productsList[$i]['is_new'] = $row['is_new'];
            $i++;
        }
        return $productsList;
    }

    public static function deleteProductById($id){
        
        $db= Db::getConnection();
        $sql='DELETE FROM product where id_product=:id_product';
        $result = $db->prepare($sql);
        $result->bindParam('id_product', $id, PDO::PARAM_INT);
        $result->execute();
        
    }
    
     /**
     * Добавляет новый товар
     * @param array $options <p>Массив с информацией о товаре</p>
     * @return integer <p>id добавленной в таблицу записи</p>
     */
    public static function createProduct($options)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        /*$sql = 'INSERT INTO product '
                . '(name_product, id_category, code, price,   availability, brand, '
                . 'description, is_new, is_recommended, status) '
                . 'VALUES '
                . '(:name_product, :code, :price, :id_category, :brand, :availability, '
                . ':description, :is_new, :is_recommended, :status) ';*/
       // $sql = "INSERT INTO product (name_product)  VALUES ('3d') ";
         $sql = ' INSERT INTO product (name_product)  VALUES (:name_product) ';
        //$ee= 'fff';
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        //$result->bindParam(':name_product', $ee, PDO::PARAM_STR);
         $result->bindParam(':name_product', $options['name_product'], PDO::PARAM_STR);
        /*$result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':id_category', $options['id_category'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);*/
        if ($result->execute()) {
            
            
            // Если запрос выполенен успешно, возвращаем id добавленной записи
            return $db->lastInsertId();
        }
        // Иначе возвращаем 0
     
        return 0;
    }

     /**
     * Редактирует товар с заданным id
     * @param integer $id <p>id товара</p>
     * @param array $options <p>Массив с информацей о товаре</p>
     * @return boolean <p>Результат выполнения метода</p>
     */
    public static function updateProductById($id, $options)
    {
        // Соединение с БД
        $db = Db::getConnection();
        // Текст запроса к БД
        $sql = "UPDATE product
            SET 
                name_product = :name, 
                code = :code, 
                price = :price, 
                id_category = :category_id, 
                brand = :brand, 
                availability = :availability, 
                description = :description, 
                is_new = :is_new, 
                is_recommended = :is_recommended, 
                status = :status
            WHERE id_product = :id";
        // Получение и возврат результатов. Используется подготовленный запрос
        $result = $db->prepare($sql);
        $result->bindParam(':id', $id, PDO::PARAM_INT);
        $result->bindParam(':name', $options['name'], PDO::PARAM_STR);
        $result->bindParam(':code', $options['code'], PDO::PARAM_STR);
        $result->bindParam(':price', $options['price'], PDO::PARAM_STR);
        $result->bindParam(':category_id', $options['category_id'], PDO::PARAM_INT);
        $result->bindParam(':brand', $options['brand'], PDO::PARAM_STR);
        $result->bindParam(':availability', $options['availability'], PDO::PARAM_INT);
        $result->bindParam(':description', $options['description'], PDO::PARAM_STR);
        $result->bindParam(':is_new', $options['is_new'], PDO::PARAM_INT);
        $result->bindParam(':is_recommended', $options['is_recommended'], PDO::PARAM_INT);
        $result->bindParam(':status', $options['status'], PDO::PARAM_INT);
        return $result->execute();
    }
}
