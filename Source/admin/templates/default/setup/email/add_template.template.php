<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<div class="container content-wrapper">
    <div class="row header-row">
    	<div class="col-sm-6 left">
        	<h3>Add Template</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
            	<div class="btn-group">
                	<a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=email_templates" class="btn btn-default"><span class="glyphicon glyphicon-arrow-left"></span> Go Back</a>
                </div>
            </div>
        </div>
    </div>    
    <?php if(@$message) { ?>
    <div class="row">
    	<div class="col-sm-12">
            <div class="alert alert-danger">
                <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $message; ?>
            </div> 
        </div>
    </div>
    <?php } ?>
    <div class="row">
    	<form action="" method="post">
        <div class="col-sm-12">
        	
            <div class="form-group">
            	<label>Template Name:</label>
                <input type="text" name="template_name" value="<?php echo lib::post('template_name',false,false,true); ?>" placeholder="" class="form-control">
            </div> 
            
            <div class="form-group">
            	<label>Template Subject:</label>
                <input type="text" name="template_subject" value="<?php echo lib::post('template_subject',false,false,true); ?>" placeholder="" class="form-control">
            </div>
            
            <div class="form-group">
            	<label>Description:</label>
                <input type="text" name="template_description" value="<?php echo lib::post('template_description',false,false,true); ?>" placeholder="" class="form-control">
            </div>
                         
            <div class="form-group">
            	<script src="<?php echo ADMINDOMAIN; ?>/extended/ckeditor/ckeditor.js"></script>
            	<label>HTML:</label>
                <textarea cols="" rows="15" class="form-control" id="editor1" name="template_html"><?php echo lib::post('template_html'); ?></textarea>
                <script>
					// Replace the <textarea id="editor1"> with a CKEditor
					// instance, using default configuration.
					CKEDITOR.config.startupMode = 'source';
					CKEDITOR.replace( 'editor1' );
				</script> 
            </div>
             
            <div class="form-group">
            	<input type="submit" class="btn btn-default" value="Add Template" name="_submit">
            </div>
            
        </div>
        <div class="col-sm-6">
    		
    	</div>
        </form>
    </div>       
</div>