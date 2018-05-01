<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<!-- ADS -->
<?php 
	if(lib::get('category') != '' && is_numeric(lib::get('category')) && lib::get('subcat') != '' && is_numeric(lib::get('subcat'))) {
		$SQLQuery2 = db::query("SELECT * FROM `".config::$db_prefix."adverts` WHERE (`advert_status`='1' AND `advert_packid`='1' AND `advert_subcatid`='".lib::get('subcat',true)."') ORDER BY RAND() LIMIT 0,3"); 
	} else {
		if(lib::get('category') != '') {
			$SQLQuery2 = db::query("SELECT * FROM `".config::$db_prefix."adverts` WHERE (`advert_status`='1' AND `advert_catid`='".lib::get('category',true)."' AND `advert_packid`='1') ORDER BY RAND() LIMIT 0,3"); 
		} else {
			$SQLQuery2 = db::query("SELECT * FROM `".config::$db_prefix."adverts` WHERE (`advert_status`='1' AND `advert_packid`='1') ORDER BY RAND() LIMIT 0,2"); 
		}
	}
?>
<?php $active=0; while($SQLData2 = db::fetch($SQLQuery2)) { ?>

    <div class="row adlisting-template <?php if($active) { echo 'active-row'; $active=0;} else { $active=1; } ?>">
      <div class="col-sm-2">
        <div class="thumbnail"><a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($SQLData2['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($SQLData2['advert_id'],false,true,true); ?>">
          <?php if($advert->getDashboardImage($SQLData2['advert_id'])) { ?>
          <img src="<?php echo $advert->getDashboardImage($SQLData2['advert_id']); ?>" alt="">
          <?php } else { ?>
          <img src="<?php echo DOMAIN; ?>/templates/default/images/75x75noimage.png" alt="">
          <?php } ?>
          </a></div>
      </div>
      <div class="col-sm-6 desc">
        <div class="caption">
          <!-- <h3><a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($SQLData2['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($SQLData2['advert_id'],false,true,true); ?>"><?php echo lib::san($SQLData2['advert_title'],false,true,true); ?></a></h3> -->
          <p><?php echo substr(htmlentities(strip_tags($SQLData2['advert_html'])),0,250); if(strlen($SQLData2['advert_html']) > 250) { echo '...'; } ?></p>
        </div>
      </div>
      <div class="col-sm-2 stats">
        <p>Expires: <?php echo date('Y/m/d',strtotime($SQLData2['advert_expiredate'])); ?></p>
        <p>Created: <?php echo date('Y/m/d',strtotime($SQLData2['advert_datetime'])); ?></p>
        <p><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo number_format($SQLData2['advert_price'],2); ?></p>
        <?php if($SQLData2['advert_packid'] == 1) { ?>
        <p>
        <div class="label label-danger">
          <?php $adpack2 = $advert->getAdpack($SQLData2['advert_packid']); echo $adpack2['pack_title']; ?>
        </div>
        </p>
        <?php } ?>
        <!-- <p><?php echo $SQLData2['advert_id']; ?></p> --> 
      </div>
    </div>

<?php } ?>

<!-- LISTINGS -->
<?php if($SQLRows) { ?>

<?php $active=0; while($SQLData = db::fetch($SQLQuery)) { ?>

    <div class="row adlisting-template <?php if($active) { echo 'active-row'; $active=0;} else { $active=1; } ?>">
      <div class="col-sm-2">
        <div class="thumbnail"><a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($SQLData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($SQLData['advert_id'],false,true,true); ?>">
          <?php if($advert->getDashboardImage($SQLData['advert_id'])) { ?>
          <img src="<?php echo $advert->getDashboardImage($SQLData['advert_id']); ?>" alt="">
          <?php } else { ?>
          <img src="<?php echo DOMAIN; ?>/templates/default/images/75x75noimage.png" alt="">
          <?php } ?>
          </a></div>
      </div>
      <div class="col-sm-6 desc">
        <div class="caption"> 
          <!-- <h3><a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($SQLData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($SQLData['advert_id'],false,true,true); ?>"><?php echo lib::san($SQLData['advert_title'],false,true,true); ?></a></h3> -->
          <p><?php echo substr(htmlentities(strip_tags($SQLData['advert_html'])),0,250); if(strlen($SQLData['advert_html']) > 250) { echo '...'; } ?></p>
        </div>
      </div>
      <div class="col-sm-2 stats">
        <p>Expires: <?php echo date('Y/m/d',strtotime($SQLData['advert_expiredate'])); ?></p>
        <p>Created: <?php echo date('Y/m/d',strtotime($SQLData['advert_datetime'])); ?></p>
        <p><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo number_format($SQLData['advert_price'],2); ?></p>
        <?php if($SQLData['advert_packid'] == 1) { ?>
        <p>
        <div class="label label-danger">
          <?php $adpack = $advert->getAdpack($SQLData['advert_packid']); echo $adpack['pack_title']; ?>
        </div>
        </p>
        <?php } ?>
        <!-- <p><?php echo $SQLData['advert_id']; ?></p> --> 
      </div>
    </div>

<?php } ?>

<?php } else { ?>
<h4>Nothing to see here!</h4>
<p>You have not yet created a listing, hit the button above to start now.</p>
<?php } ?>
