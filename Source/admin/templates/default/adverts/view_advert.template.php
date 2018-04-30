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
    	<h4>View Advert</h4>
        <p>You can review the advert below before approving it.</p>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body"> 
          <!-- PANEL START --> 
                       
          <div class="form-group">
            <label>Title:</label>
            <?php echo lib::san($advertData['advert_title']); ?>
          </div>
          <div class="form-group">
            <label>Category:</label>
			<?php echo $category['cat_name']; ?>
          </div>
          <div class="form-group">
            <label>Price:</label>
            <?php echo lib::getDefaultCurrencySymbol(); ?><?php echo $advertData['advert_price']; ?>
          </div>
          <div class="form-group">
            <label>City/Town:</label>
            <?php echo $city; ?>
          </div>
          <div class="form-group">
            <label>Country:</label>
            <?php echo $country; ?>
          </div>
          <div class="form-group"> 
            <script src="<?php echo DOMAIN; ?>/templates/default/javascript/ckeditor/ckeditor.js"></script>
            <label>Description</label>
            <?php echo strip_tags($advertData['advert_html'], '<strong><ol><em><ul><li><p><br><br/>'); ?>
          </div>
          <div class="form-group">         
            <div class="row">   
            <?php $advert=new advert; ?>
            <?php foreach($advert->getImages($advertData['advert_id']) AS $image_id => $image_name) { ?>
                <div class="col-xs-6 col-md-2">
                    <a href="#" class="thumbnail">
                      <img id="<?php echo $image_id; ?>_main" src="<?php echo DOMAIN.'/index.php?image=adverts&size=364&image_name='.$image_name; ?>" alt="">
                    </a>
                 </div>
            <?php } ?>
            </div>
                
          </div>
          <div class="form-group"></div>
          <div class="form-group">
          
          <script type="text/javascript">
			  $(document).ready(function() {
				  //Approve
				  $('#approve').click(function() {
					  $.ajax({
						  url: '<?php echo ADMINDOMAIN; ?>/index.php?action=ajax&class=adverts&method=approve',
						  type: 'post',
						  data: '&advert_id=<?php echo $advertData['advert_id']; ?>',
						  success: function(data) {
							  if(data.error) { alert(data.error); } else { location.reload(); }	
						  }
					  }, 'json');
				  });
				  //Reject
				  $('#reject').click(function() {
					  $.ajax({
						  url: '<?php echo ADMINDOMAIN; ?>/index.php?action=ajax&class=adverts&method=reject',
						  type: 'post',
						  data: '&advert_id=<?php echo $advertData['advert_id']; ?>',
						  success: function(data) {
							  if(data.error) { alert(data.error); } else { location.reload(); }	
						  }
					  }, 'json');
				  });
			  });
		  </script>
          
          <a href="#" id="approve" class="btn btn-success">Approve Advert</a>  
          <a href="#" id="reject" class="btn btn-danger">Reject Advert</a>
            
          </div> 
          <!-- PANEL END --> 
        </div>
      </div>
    </div>
  </div>
</div>
