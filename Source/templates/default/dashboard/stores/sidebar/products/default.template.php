<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<div class="row">
	<div class="col-sm-6">
    	<h4>Store Prducts</h4>
		<p>Add or edit products to your store here.</p>
    </div>
    <div class="col-sm-6">
    	<div class="pull-right">
    		<a href="<?php echo DOMAIN; ?>/?page=dashboard&view=store&action=manage&option=manage-products&filter=sold_products&pages=<?php echo lib::get('page'); ?>" class="btn btn-default">Products Sold (<?php echo db::nrows("SELECT * FROM `".config::$db_prefix."adverts` WHERE `advert_store`='1' AND `advert_userid`='".session::data('user_id')."' AND `advert_store_sold`='1'"); ?>)</a> <a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=manage-products&do=add_product" class="btn btn-default">Add Product</a>
        </div>
    </div>
</div>

<?php if($SQLRows) { ?>
<div class="table-reponsive">
	<table class="table table-bordered table-striped">
    	<thead>
        <tr>
        	<td>Image</td>
        	<td>Title</td>
            <td>Price</td>
            <td>Sold/Paid</td>
            <td>Option</td>
        </tr>
        </thead>
        <tbody>
        <?php while($prodData = db::fetch($SQLQuery)) { ?>
        <script type="text/javascript">
			$(document).ready(function() {
				$('#deleteAdvert<?php echo $prodData['advert_id']; ?>').click(function() {
					$.ajax({
						url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=adverts&action=ajax&request=delete-advert',
						type: 'POST',
						data: '&advert_id=<?php echo $prodData['advert_id']; ?>',
						success: function(data) {
							window.location='<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=manage-products';
						}
					}, 'json');
				});
			});
		</script>
        <tr>
        	<td><div class="thumbnail"> <img src="<?php echo $advert->getDashboardImage($prodData['advert_id']); ?>" alt="..." style="max-height:90px;"> </div></td>
        	<td><?php echo lib::san($prodData['advert_title']); ?></td>
        	<td><?php echo lib::getDefaultCurrencySymbol(); ?><?php echo number_format($prodData['advert_price'],2); ?></td>
            <td><?php if($prodData['advert_store_sold']) { ?><span class="label label-success">Yes</span><?php } else { ?><span class="label label-danger">No</span><?php } ?></td>
            <td>
            	<a href="<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=manage&option=manage-products&do=edit_product&product_id=<?php echo $prodData['advert_id']; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-pencil"></span></a>
                <a href="#" id="deleteAdvert<?php echo $prodData['advert_id']; ?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove"></span></a>  
            	<?php if($prodData['advert_store_sold']) { ?>
                	<a href="#" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-barcode"></span></a> 
				<?php } ?>
            </td>
        </tr>
        <?php } ?>
        </tbody>
        
    </table>
</div>

<ul class="pagination pull-right">
	<?php echo $paginate->renderPages(); ?>
</ul>

<?php } else { ?>
	<div class="alert alert-warning">No products to be shown.</div>
<?php } ?>