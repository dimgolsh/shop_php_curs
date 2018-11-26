<?php include ROOT . '/views/layouts/header.php'; ?>

 <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="left-sidebar">
                            <h2>Каталог</h2>
                            <div class="panel-group category-products">
                                <?php foreach ($categories as $categoryItem):?>
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title">
                                            <a href="/category/<?php echo $categoryItem['id_category'];?>"
                                                
                                                >
                                                <?php echo $categoryItem['name'];?></a></h4>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                               
                                
                                
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-9 padding-right">
                        <div class="features_items"><!--features_items-->
                            <h2 class="title text-center">Корзина</h2>  
                            <?php if($productsInCart): ?>
                             <table class="table-bordered table-striped table">
                                    <tr>
                                        <th>KOD TOVA</th>
                                        <th>NAME</th>
                                        <th>STOIMOt</th>
                                        <th>kolov</th>
                                        <th>DEL</th>
                                    </tr>
                                    <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo $product['code'];?></td>
                                        <td>
                                            <a href="/product/<?php echo $product['id_product'];?>">
                                            <?php echo $product['name_product'];?></a>
                                        </td>
                                        <td><?php echo $product['price'];?></td>
                                        <td><?php echo $productsInCart[$product['id_product']];?></td>
                                        <td>
                                        <a href="/cart/delete/<?php echo $product['id_product'];?>">
                                            <i class="fa fa-times"></i>
                                        </a>
                                    </tr>
                                    <?php endforeach;?>
                                    <tr>
                                        <td colspan="3">SUMMA</td>
                                        <td><?php echo $totalPrice;?></td>
                                    </tr>
                                </table>
                         <a href="/cart/checkout/"
                            class="btn btn-default ">
                             <i class="fa fa-bell"></i>Оформить заказ</a>
                            <?php else: ?>
                            <p>PYSTO</p>
                            <?php endif?>
                            
<!-- <php echo $pagination->get(); ?> -->
                        </div><!--features_items-->

                        

                    </div>
                </div>
            </div>
        </section>


<?php include ROOT . '/views/layouts/footer.php'; ?>