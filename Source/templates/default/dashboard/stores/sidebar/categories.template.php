<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<h4>Custom Fields</h4>
<p>You are able to add custom fields to your products, use the form below to add more.</p>

<?php if(db::nRows("SELECT `cat_id` FROM `".config::$db_prefix."store_categories` WHERE `cat_storeid`='".$store['store_id']."'") > 0) { ?>
<div class="table-reponsive">
	<table class="table table-bordered table-striped">
    	<thead>
        <tr>
        	<td>Category Name</td>
            <td>Category Options</td>
        </tr>
        </thead>
        <tbody>
        <?php $catSQL = db::query("SELECT * FROM `".config::$db_prefix."store_categories` WHERE `cat_storeid`='".$store['store_id']."'"); ?>
        <?php while($catData = db::fetch($catSQL)) { ?>
        <script type="text/javascript">
        	$(document).ready(function() {
				$('#deleteCat<?php echo $catData['cat_id']; ?>').click(function() {
					$.ajax({
						url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_deletecategory',
						type:'POST',
						data: '&cat_id=<?php echo $catData['cat_id']; ?>',
						success: function(data) {
							location.reload();
						}
					}, 'json');
				});
			});
        </script>
        <tr>
        	<td><?php echo lib::san($catData['cat_name']); ?></td>
            <td><a href="#" id="deleteCat<?php echo $catData['cat_id']; ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
        <?php } ?>
        </tbody>
        
    </table>
</div>
<?php } else { ?>
	<div class="alert alert-warning">This store does not yet have any categories.</div>
<?php } ?>

<h4>Add Category</h4>
<p>Use the form below to add categories to your products.</p>

<script type="text/javascript">
	$(document).ready(function() {
		$('#addCategoryButton').click(function() {
			$.ajax({
				url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_addcategory',
				type:'POST',
				data: $('#addCategoryForm').serialize(),
				success: function(data) {
					location.reload();
				}
			},'json');
		});
	});
</script>

<form action="" method="post" id="addCategoryForm">
    <div class="form-group">
        <label>Category Name</label>
        <input type="text" name="cat_name" class="form-control" placeholder="e.g. Laptops">
    </div>    
    <div class="form-group pull-right">
        <input type="button" name="" value="Add Category" class="btn btn-default" id="addCategoryButton">
    </div>
</form>