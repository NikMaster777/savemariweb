<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/

if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>
<!--CONTENT-->	
<div class="container" id="content">
	<div class="row">
    
    	<div class="col-sm-3">
            <?php require(ROOT.'/templates/default/stores/sidebar.template.php'); //Sidebar ?>
        </div>
        
        <div class="col-sm-9">
        
        	<div class="row">
            	<div class="col-sm-12">
                    <ul class="pagination pull-right">
                        <?php echo $paginate->renderPages(); ?>
                    </ul>
                </div>
            </div>
            
            <!--ROW OF PRODUCTS -->
            <div class="row">
                
                <?php if($review_allowed === true) { ?>
                <?php if(@$message) { ?>
                	<div class="alert alert-danger"><?php echo $message; ?></div>
                <?php } ?>
                <div class="panel panel-default">
                <div class="panel-heading">Leave a review</div>
                    <div class="panel-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label class="radio-inline"><input type="radio" name="user_rating" value="1">1 Star</label>
                            <label class="radio-inline"><input type="radio" name="user_rating" value="2">2 Star</label>
                            <label class="radio-inline"><input type="radio" name="user_rating" value="3">3 Star</label>
                            <label class="radio-inline"><input type="radio" name="user_rating" value="4">4 Star</label>
                            <label class="radio-inline"><input type="radio" name="user_rating" value="5">5 Star</label>
                        </div>
                        <div class="form-group">
                        	<label>Full Name</label>
                            <input type="text" name="review_fullname" value="" class="form-control">
                        </div>
                        <div class="form-group">
                        	<label>Message</label>
                            <textarea cols="" rows="" name="review_comment" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                        	<input type="hidden" name="review_code" value="<?php echo lib::get('review_code'); ?>">
                        	<input type="submit" name="_submit" value="Leave Review" class="btn btn-default">
                        </div>
                    </form>
                    </div>
                </div>
                <?php } ?>
                
                <?php if($SQLRows > 0) { ?>
                <?php while($reviewData = db::fetch($SQLQuery)) { ?>
                <!-- REVIEW -->
                <div class="panel panel-default">
                	<div class="panel-body">
                    	<h4><?php echo lib::san($reviewData['review_fullname']); ?> <small> <?php for($i=1;$i<=$reviewData['review_rating'];$i++) { ?><span class="glyphicon glyphicon-star" style="color:#CC0;"></span><?php } ?></small></h4>
                        <p><?php echo lib::san($reviewData['review_comment']); ?></p>
                    </div>
                </div>
                <!-- REVIEW -->
                <?php } ?>
                <?php } else { ?>
                <div class="panel panel-default">
                	<div class="panel-body">
                        <p>There are not yet any user reviews.</p>
                    </div>
                </div>
                <?php } ?>
                
            </div>
            <!-- END OF ROW OF PRODUCTS -->
     		
            <div class="row">
            	<div class="col-sm-12">
                    <ul class="pagination pull-right">
                        <?php echo $paginate->renderPages(); ?>
                    </ul>
                </div>
            </div>
                   
        </div>
    </div>
    
</div>