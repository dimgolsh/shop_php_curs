  <div class="page-buffer"></div>
</div>

<footer id="footer" class="page-footer"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <p class="pull-left">2018</p>
                <p class="pull-right"></p>
            </div>
        </div>
    </div>
</footer><!--/Footer-->



<script src="/template2/js/jquery.js"></script>
<script src="/template2/js/jquery.cycle2.min.js"></script>
<script src="/template2/js/jquery.cycle2.carousel.min.js"></script>
<script src="/template2/js/bootstrap.min.js"></script>
<script src="/template2/js/jquery.scrollUp.min.js"></script>
<script src="/template2/js/price-range.js"></script>
<script src="/template2/js/jquery.prettyPhoto.js"></script>
<script src="/template2/js/main.js"></script>
<script>
    $(document).ready(function(){
        $(".add-to-cart").click(function () {
            var id = $(this).attr("data-id");
            $.post("/cart/addAjax/"+id, {}, function (data) {
                $("#cart-count").html(data);
            });
            return false;
        });
    });
</script>

</body>
</html>