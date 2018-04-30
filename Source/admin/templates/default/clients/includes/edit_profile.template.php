<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Creative Miles
 *@Start: 12th June 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<div class="panel-body">

	<?php if(@$message) { ?>
    <div class="row">
      <div class="col-sm-12">
        <div class="alert alert-danger"> <span class="glyphicon glyphicon-exclamation-sign"></span> <?php echo $message; ?> </div>
      </div>
    </div>
    <?php } ?>
    <form action="" method="post">
      <div class="row">
        <div class="col-sm-6">
          <div class="form-group">
            <label>Company Name</label>
            <input type="text" name="user_companyname" value="<?php echo rememberMe($user,'user_companyname', 'text'); ?>" class="form-control" placeholder="Creative Miles">
          </div>
          <div class="form-group">
            <label>Firstname</label>
            <input type="text" name="user_firstname" value="<?php echo rememberMe($user,'user_firstname', 'text'); ?>" class="form-control" placeholder="Shaun">
          </div>
          <div class="form-group">
            <label>Lastname</label>
            <input type="text" name="user_lastname" value="<?php echo rememberMe($user,'user_lastname', 'text'); ?>" class="form-control" placeholder="Childerley">
          </div>
          <div class="form-group">
            <label>Email Address</label>
            <input type="text" name="user_emailaddress" value="<?php echo rememberMe($user,'user_emailaddress', 'text'); ?>" class="form-control" placeholder="shaun@creativemiles.co.uk">
          </div>
          <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="user_phonenumber" value="<?php echo rememberMe($user,'user_phonenumber', 'text'); ?>" class="form-control" placeholder="03300886684">
          </div>
          <div class="form-group">
            <label>New Password</label>
            <input type="password" name="user_password" value="" class="form-control" placeholder="Password">
          </div>
        </div>
        <div class="col-sm-6">
          <div class="form-group">
            <label>Address 1</label>
            <input type="text" name="user_address1" value="<?php echo rememberMe($user,'user_address1', 'text'); ?>" class="form-control" placeholder="14 Belvoir Street">
          </div>
          <div class="form-group">
            <label>Address 2</label>
            <input type="text" name="user_address2" value="<?php echo rememberMe($user,'user_address2', 'text'); ?>" class="form-control" placeholder="Hucknall">
          </div>
          <div class="form-group">
            <label>City</label>
            <input type="text" name="user_city" value="<?php echo rememberMe($user,'user_city', 'text'); ?>" class="form-control" placeholder="Nottingham">
          </div>
          <div class="form-group">
            <label>State/Region</label>
            <input type="text" name="user_state" value="<?php echo rememberMe($user,'user_state', 'text'); ?>" class="form-control" placeholder="East Midlands">
          </div>
          <div class="form-group">
            <label>Postcode</label>
            <input type="text" name="user_postcode" value="<?php echo rememberMe($user,'user_postcode', 'text'); ?>" class="form-control" placeholder="NG156NL">
          </div>
          <div class="form-group">
            <label>Country</label>
            <select name="user_country" class="form-control">
              <?php foreach(lib::getCountries() AS $c_code => $c_name) { ?>
              <option value="<?php echo $c_code; ?>" <?php echo rememberMe($user,'user_country', 'selected', $c_code); ?>><?php echo $c_name; ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-sm-12">
          <div class="form-group">
            <input type="hidden" name="user_id" value="<?php echo lib::get('client_id',false,true,true); ?>" />
            <input type="submit" name="_profile" class="btn btn-default" value="Update Account">
          </div>
        </div>
      </div>
    </form>
    
</div>