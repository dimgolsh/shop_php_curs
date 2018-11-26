<?php

class News 
{
//"include_once ROOT . '/components/Db.php';"
/**
 * Возрат одной новости 
 */
    public static function getNewsItemById($id)
            {
       $id = intval($id);
       if ($id){
             
                $newList = array();
                $db = Db::getConnection();
             
               $result = $db ->query('SELECT* FROM news where id=' . $id);
               //$result->setFetchMode(PDO::FETCH_NUM);
               $result->setFetchMode(PDO::FETCH_ASSOC);
           $newsItem = $result->fetch();
           return $newsItem;
       }
            }
            
    
    /////////////
    public static function  getNewsList()
           {
          
                $newList = array();
                $db = Db::getConnection();
               $result = $db ->query('SELECT id, title, date, short_content '
                        . 'FROM news ' 
                        . 'ORDER BY date DESC '
                        . 'LIMIT 10');
              /*$qu = 'SELECT id, title,date,short_content '
   . 'FROM news '
   . 'ORDER BY date DESC '
   . 'LIMIT 10';
  $result = $db->prepare($qu);
  $result->execute();*/
                $i= 0;
                while ($row= $result->fetch()) {
                    $newList[$i]['id']= $row['id'];
                    $newList[$i]['title'] = $row['title'];
                    $newList[$i]['date'] = $row['date'];
                    $newList[$i]['short_content'] = $row['short_content'];
                    $i++;
                    
                }
                return $newList;
                
                }
    
}