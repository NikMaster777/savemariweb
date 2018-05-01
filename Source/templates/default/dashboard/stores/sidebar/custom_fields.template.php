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

<?php if(db::nRows("SELECT `field_id` FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$store['store_id']."'") > 0) { ?>
<div class="table-reponsive">
	<table class="table table-bordered table-striped">
    	<thead>
        <tr>
        	<td>Field Name</td>
        	<td>Field Type</td>
            <td>Field Options</td>
        </tr>
        </thead>
        <tbody>
        <?php $fieldSQL = db::query("SELECT * FROM `".config::$db_prefix."store_fields` WHERE `field_storeid`='".$store['store_id']."'"); ?>
        <?php while($fieldData = db::fetch($fieldSQL)) { ?>
        <script type="text/javascript">
        	$(document).ready(function() {
				$('#deleteField<?php echo $fieldData['field_id']; ?>').click(function() {
					$.ajax({
						url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_deletecustomfield',
						type:'POST',
						data: '&field_id=<?php echo $fieldData['field_id']; ?>',
						success: function(data) {
							location.reload();
						}
					}, 'json');
				});
			});
        </script>
        <tr>
        	<td><?php echo lib::san($fieldData['field_name']); ?></td>
        	<td><?php $fieldTypes = array(1 => 'Textbox', 2 => 'Textarea', 3 => 'Dropdown', 4 => 'Checkbox'); echo $fieldTypes[$fieldData['field_type']]; ?></td>
            <td><a href="#" id="deleteField<?php echo $fieldData['field_id']; ?>" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
        </tr>
        <?php } ?>
        </tbody>
        
    </table>
</div>
<?php } else { ?>
	<div class="alert alert-warning">This store does not yet have any custom product fields.</div>
<?php } ?>

<h4>Add Custom Field</h4>
<p>Use the form below to add custom fields to your products.</p>

<script type="text/javascript">
	$(document).ready(function() {
		$('.option-fields').hide();
		$('#fieldtype').change(function() {
			switch($('#fieldtype').val()) {
				case '1': {
					$('.option-fields').hide();
					break;
				}
				case '2': {
					$('.option-fields').hide();
					break;
				}
				case '3': {
					$('.option-fields').show();
					break;
				}
				case '4': {
					$('.option-fields').show();
					break;
				}
			}
		});
	});
</script>

<script type="text/javascript">
	$(document).ready(function() {
		$('#addCustomField').click(function() {
			$.ajax({
				url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_addcustomfield',
				type:'POST',
				data: $('#customFieldForm').serialize(),
				success: function(data) {
					location.reload();
				}
			},'json');
		});
	});
</script>

<form action="" method="post" id="customFieldForm">
    <div class="form-group">
        <label>Field Name</label>
        <input type="text" name="field_name" class="form-control" placeholder="e.g. Color">
    </div>
    
    <div class="form-group">
        <label>Placeholder</label>
        <input type="text" name="field_placeholder" placeholder="e.g. Please enter your name" class="form-control">
    </div>
    
    <div class="form-group">
        <label>Field Type</label>
        <select name="field_type" class="form-control" id="fieldtype">
            <option value="1">Textbox</option>
            <option value="2">Textarea</option>
            <option value="3">Dropdown</option>
            <option value="4">Checkbox</option>
        </select>
    </div>
        
    <?php for($i=1;$i<=6;$i++) { ?>
        <div class="form-group option-fields">
            <label>Option <?php echo $i; ?></label>
            <input type="text" value="" class="form-control" placeholder="Option Name <?php echo $i; ?>" name="field_option<?php echo $i; ?>">
        </div>
    <?php } ?>
    
    <div class="form-group pull-right">
        <input type="button" name="" value="Add Field" class="btn btn-default" id="addCustomField">
    </div>
</form>