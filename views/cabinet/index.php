<?php include ROOT. '/views/layouts/header.php';?>
<section>
    <div class="container">
        <div class="row">
            <h1>
                Каьинет пользователя
            </h1>
            <h3>Привет, <?php echo $user['name'];?> </h3>
            <ul>
                <li>
                    <a href="/cabinet/edit">Редактировать данные</a>
                </li>
                <li>
                    <a href="/cabinet/history">Список покупок</a>
                </li>
                </li>
            </ul>
        </div>
    </div>
</section>



<?php include ROOT. '/views/layouts/footer.php';?>