<?php
include_once ROOT. '/models/News.php';

class NewsController {
    
    public  function actionIndex()
    {
        //echo 'NewsController actionIndex ';
        $newList = array();
        $newsList = News::getNewsList();
        require_once(ROOT.'/views/news/index.php');
        
       /* echo '<pre>';
        print_r($newsList);
        echo '</pre>';
        echo 'Список новостей'; */
        
       
        return true;
    }
    //public function actionView($category, $id)
     public function actionView($id)
     {
         if($id) {
             $newsItem = News::getNewsItemById($id);
             require_once(ROOT.'/views/news/view.php');
            /* echo '<pre>';
             print_r($newsItem);
             echo '</pre>';
             echo 'actionView';*/
         }
  /*   echo '<br>'.$category;
       echo '<br>'.$id;
        echo '<br>'.$params[0];
        echo '<br>'.$params[1];
        echo '<br>Просмотр одной новости';*/
        return true;
    }
    
    
}