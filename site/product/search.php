        <div class="content">

            <div class="on grid">
                <nav class="left">
                    <a class="tt" href="<?=$SITE_URL;?>">TRANG CHỦ</a>
                    <span class="">/</span>
                    <span class="td">Kết quả tìm kiếm "<?=$keyword;?>"</span>
                </nav>

            </div>
       
            <?php 
                if (!$itemData) {
                    echo '<div class="grid"><div class="alert alert-success">Không tìm thấy kết quả phù hợp</div></div>';
                }
            ?>
            <div class="product_1 grid">
            <?php foreach($itemData as $item):?>
                <div class="pro">
                  <div class="cha">
                      <div class="img">
                        <img src="<?=$IMG_URL . '/' . $item['product_image'];?>" alt="" width="245px" height="245px">
                      </div>
                   <div class="content_con">
                    <button class="bt" name="btn_pro"> <a href="<?=$SITE_URL;?>/product/?detail&id=<?=$item['id'];?>">Xem chi tiết</a></button>
                   </div>
                   
                </div>
                    
                    <div class="content_pro">
                        <a href="<?=$SITE_URL . '/product/?detail&id=' . $item['id'];?>"><?=$item['product_name'];?></a>
                        <div>
                            <span><?=number_format($item['price']);?>đ</span>
                        </div>
                       
                    </div>
                </div>
            <?php endforeach;?>
            </div>
            <!-- Done -->
        </div>
        <!-- END CONTENT -->