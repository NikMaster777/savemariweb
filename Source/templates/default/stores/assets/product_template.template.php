
<!-- PRODUCT START -->
<div class="col-sm-4" style="min-height:390px;">
  <!-- <div class="panel panel-default">
    <div class="panel-body"> -->
      <div class="product-wrapper" style="border:1px solid #eaeaea;padding:10px;">
        <div class="row">
          <div class="col-sm-12">
            <?php
				//Do we have a product image?
				$imageSQL = "SELECT * FROM `".config::$db_prefix."advertimages` WHERE `image_advertid`='".$SQLData['advert_id']."' LIMIT 0,1";
				if(db::nRows($imageSQL) > 0) {
					$imageQuery = db::query($imageSQL);
					while($imageData = db::fetch($imageQuery)) {
			?>
            <!-- Trigger the Modal --> 
            <img id="myImg<?php echo $i; ?>" src="<?php echo DOMAIN; ?>/index.php?image=adverts&size=300&image_name=<?php echo $imageData['image_name']; ?>" alt="" class="img-responsive">
            <?php } ?>
            <?php } else { ?>
            <!-- Trigger the Modal --> 
            <img id="myImg<?php echo $i; ?>" src="https://www.creativemiles-labs.co.uk/savemari/templates/default/images/200x200noimage.png" alt="" width="300" height="200" class="img-responsive">
            <?php } ?>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div class="caption">
              <h4><a href="<?php echo STORE_URL; ?>&page=products&option=view_product&product_id=<?php echo $SQLData['advert_id']; ?>"><?php echo lib::san($SQLData['advert_title']); ?></a></h4>
              <p style="min-height:60px;">
                <?php 
					if(strlen($SQLData['advert_html']) > 80) { 
						echo lib::san(strip_tags(substr($SQLData['advert_html'],0,80).'...')); 
					} else {
						echo lib::san(strip_tags($SQLData['advert_html'])); 	
					}
				?>
              </p>
            </div>
            <a href="<?php echo STORE_URL; ?>&page=products&option=view_product&product_id=<?php echo $SQLData['advert_id']; ?>" class="btn btn-default btn-block"><span class="glyphicon glyphicon-tag"></span> View Listing <span class="label label-danger"><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo number_format($SQLData['advert_price'],2); ?></span></a> </div>
        </div>
      </div>
    <!--  </div>
  </div> -->
</div>
<!-- PRODUCT END -->