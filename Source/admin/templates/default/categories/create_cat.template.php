<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<div class="container">
  <div class="row">
    <div class="col-sm-12">
    	<h4>Edit Category</h4>
        <p>Please use the form below to edit your category.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body"> 
          <!-- PANEL START --> 
          
          <script type="text/javascript">
			  $(document).ready(function() {			 
				 $('#cat_id').change(function() {
					if($('#cat_id').val() != '') {
						$('#image-wrap').hide();
					} else {
						$('#image-wrap').show();	
					}
				 });
				  
			  });
		  </script>
            
          <!--ERROR-->
          <?php if(isset($message)) { ?>
          	<div class="alert alert-danger" id="advert-error"><?php echo $message; ?></div>
          <?php } ?>
          
          <form action="" method="post" enctype="multipart/form-data">
           
			   <div class="form-group">
                <label>Main Category</label>
                <select name="cat_id" class="form-control" id="cat_id">
                  <option value="">-- None --</option>
                  <?php foreach($categories AS $key => $parent) { ?>
                    <option value="<?php echo lib::san($parent['cat_id']); ?>"><?php echo lib::san($parent['cat_name']); ?></option>
                  <?php } ?>
                </select>
              </div>
                                   
              <div class="form-group">
                <label>Category Title:</label>
                <input type="text" class="form-control" name="cat_title" value="" placeholder="Category Title"/>
              </div>
                      
              <div id="image-wrap">      
                  <div class="form-group">
                    <label>Current Image (554px / 194px)</label><br />
                    <?php if(isset($catData['cat_image']) && $catData['cat_image'] != '' && @file_exists(ROOT.'/uploads/cat_images/'.$catData['cat_image'])) { ?>
                        <img src="<?php echo DOMAIN; ?>/uploads/cat_images/<?php echo $catData['cat_image']; ?>" alt="" class="img-thumbnail">
                    <?php } else { ?>
                        <img src="<?php echo DOMAIN; ?>/templates/default/images/mega-demo-image.jpg" alt="" class="img-thumbnail">
                    <?php } ?>
                  </div>
                  
                  <div class="form-group">
                    <label>Upload Image (554px / 194px)</label><br />
                    <input type="file" name="cat_image">
                  </div>
              </div>
                                               
              <!-- SPACER -->
              <div class="form-group"></div>
              <div class="form-group">
                <input type="submit" class="btn btn-default" value="Create" name="_submit"/>
              </div>
          
          </form>
          
          <!-- PANEL END --> 
        </div>
      </div>
    </div>
  </div>
</div>
