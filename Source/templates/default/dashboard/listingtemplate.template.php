<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<?php if($SQLRows) { ?>
<?php $active=0; while($SQLData = db::fetch($SQLQuery)) { ?>
<div class="row adlisting-template <?php if($active) { echo 'active-row'; $active=0;} else { $active=1; } ?>">
  <div class="col-sm-2">
    <div class="thumbnail"> <img src="<?php echo $advert->getDashboardImage($SQLData['advert_id']); ?>" alt="..."> </div>
  </div>
  <div class="col-sm-6 desc">
    <div class="caption">
      <h3><a href="<?php echo DOMAIN; ?>/advert/<?php echo lib::san($SQLData['advert_seo_url'],false,true,true); ?>/advert-id/<?php echo lib::san($SQLData['advert_id'],false,true,true); ?>"><?php echo lib::san($SQLData['advert_title'],false,true,true); ?></a></h3>
      <p><?php echo substr(htmlentities(strip_tags($SQLData['advert_html'])),0,250); if(strlen($SQLData['advert_html']) > 250) { echo '...'; } ?></p>
    </div>
  </div>
  <div class="col-sm-2 stats">
    <p>Expires: <?php echo date('Y/m/d',strtotime($SQLData['advert_expiredate'])); ?></p>
    <p><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo number_format($SQLData['advert_price'],2); ?></p>
    <p><?php $adpack = $advert->getAdpack($SQLData['advert_packid']); echo $adpack['pack_title']; ?></p>
    <p><?php 
		switch($SQLData['advert_status']) { 
			case 0: {
				echo '<span class="label label-danger">Pending</span>'; 
				break;
			}
			case 1: {
				echo '<span class="label label-success">Active</span>';
				break;
			}
			case 2: {
				echo '<span class="label label-warning">Expired</span>';
				break;
			}
			case 3: {
				echo '<span class="label label-warning">Rejected</span>';
				break;
			}
		}
	?></p>
  </div>
  <div class="col-sm-2">
  	<script type="text/javascript">
    	$(document).ready(function() {
			$('#deleteAdvert<?php echo $SQLData['advert_id']; ?>').click(function() {
				$.ajax({
					url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=delete-advert',
					type: 'POST',
					data: '&advert_id=<?php echo $SQLData['advert_id']; ?>',
					success: function(data) {
						window.location='<?php echo DOMAIN; ?>/index.php?page=dashboard/';
					}
				}, 'json');
			});
		});
    </script>
    <p><a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=edit&advert-id=<?php echo $SQLData['advert_id']; ?>" class="btn btn-xs btn-default" role="button">Edit Advert</a></p>
    <p><a href="#" class="btn btn-xs btn-default" role="button" id="deleteAdvert<?php echo $SQLData['advert_id']; ?>">Delete Advert</a></p>
  </div>
</div>
<?php } ?>
<?php } else { ?>
	<h4>Nothing to see here!</h4>
    <p>You have not yet created a listing, hit the button above to start now.</p>
<?php } ?>