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

    <div class="row">
      <div class="col-sm-6">
        <div class="panel panel-default">
          <div class="panel-body">
            <h4>Information</h4>
            <div class="table-responsive">
              <table class="table table-striped table-borded">
                <tbody>
                  <tr>
                    <td>First Name:</td>
                    <td><?php echo lib::san($user['user_firstname']); ?></td>
                  </tr>
                  <tr>
                    <td>Last Name:</td>
                    <td><?php echo lib::san($user['user_lastname']); ?></td>
                  </tr>
                  <tr>
                    <td>Email:</td>
                    <td><?php echo lib::san($user['user_emailaddress']); ?></td>
                  </tr>
                  <tr>
                    <td>Address 1:</td>
                    <td><?php echo lib::san($user['user_address1']); ?></td>
                  </tr>
                  <tr>
                    <td>Address 2:</td>
                    <td><?php echo lib::san($user['user_address2']); ?></td>
                  </tr>
                  <tr>
                    <td>City</td>
                    <td><?php echo lib::san($user['user_city']); ?></td>
                  </tr>
                  <tr>
                    <td>State/Region:</td>
                    <td><?php echo lib::san($user['user_state']); ?></td>
                  </tr>
                  <tr>
                    <td>Postcode:</td>
                    <td><?php echo lib::san($user['user_postcode']); ?></td>
                  </tr>
                  <tr>
                    <td>Country:</td>
                    <td><?php echo lib::getCountry($user['user_country']); ?></td>
                  </tr>
                  <tr>
                    <td>Last Active:</td>
                    <td><?php echo lib::humanTiming($user['user_login_timestamp']); ?> Ago</td>
                  </tr>
                  <tr>
                    <td>IP Address</td>
                    <td><?php echo lib::san($user['user_ipaddress']); ?></td>
                  </tr>
                  <tr>
                    <td>Client Since:</td>
                    <td><?php echo date(lib::getDateFormat(false), strtotime($user['user_created'])); ?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- COL END -->
      
      <div class="col-sm-6">
        
      </div>
      <!-- COL END --> 
      
    </div>
</div>