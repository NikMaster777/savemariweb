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
        	<h3>Email Templates</h3>
        </div>
        <div class="col-sm-6 right">
        	<div class="form-group">
            	<div class="btn-group">
                	<a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=email_templates&do=add_template" class="btn btn-default"><span class="glyphicon glyphicon-envelope"></span> Add Template</a>
                </div>
            </div>
        </div>
    </div>    
    <div class="row">
        <div class="col-sm-12">
        	                               
			<?php if($t_records) { ?>
            <div class="panel panel-default">
                <div class="table-responsive">
                    <table class="table table-borded table-striped">
                        <thead>
                            <tr>
                                <td>Template Name</td>
                                <!-- <td>Template Subject</td> -->
                                <td>Description</td>
                                <td>Type</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($t_data = db::fetch($t_sql)) { ?>
                            <tr>
                            	<td><?php echo lib::san($t_data['template_name'],false,false,true); ?></td>
                                <!--<td><?php echo lib::san($t_data['template_subject'],false,false,true); ?></td> -->
                                <td><?php echo lib::san($t_data['template_description'],false,false,true); ?></td>
                                <td><?php if($t_data['template_default']) { echo 'System Template'; } else { echo 'Custom Template'; } ?></td>
                                <td>
                                    <div class="btn-group">
                                    	
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=email_templates&do=edit_template&template_id=<?php echo $t_data['template_id']; ?>" class="btn btn-default btn-xs">
                                        <span class="glyphicon glyphicon-pencil"></span>
                                        </a>
                                        
										<?php if(!$t_data['template_default']) { ?>
                                        <a href="<?php echo ADMINDOMAIN; ?>/?action=setup&option=email_templates&do=delete_template&template_id=<?php echo $t_data['template_id']; ?>" class="btn btn-default btn-xs">
                                        <span class="glyphicon glyphicon-remove"></span>
                                        </a>
                                        <?php } ?>
                                        
                                    </div>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>                                                       
            <?php } else { ?>
              <div class="alert alert-warning">You have not yet added any email templates!</div>
            <?php } ?>
            
            <h4>Global Template Bits</h4>
            <p>The following template bits can be used inside your html templates to generate data such as domain etc.</p>
            <div class="panel panel-default">
                <div class="table-responsive">
                <table class="table table-borded">
                    <thead>
                        <tr>
                            <td>System - Template Bits</td>
                            <td>Description</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>&lt;!--CB_DOMAIN--&gt;</td>
                            <td>This will return the systems domain name.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CB_LOGO--&gt;</td>
                            <td>This will return the systems logo URL.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CB_COMPANYNAME--&gt;</td>
                            <td>This will return the systems company name.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CB_PHONENUMBER--&gt;</td>
                            <td>This will return the systems phone number.</td>
                        </tr>
                      </tbody>
                      <thead>
                        <tr>
                            <td>Client - Template Bits</td>
                            <td>Description</td>
                        </tr>
                    	</thead>
                      <tbody>  
                        <tr>
                            <td>&lt;!--CLIENT_FIRSTNAME--&gt;</td>
                            <td>This will return the clients first name.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_LASTNAME--&gt;</td>
                            <td>This will return the clients last name.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_EMAILADDRESS--&gt;</td>
                            <td>This will return the clients email address.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_ADDRESS1--&gt;</td>
                            <td>This will return the clients first line of address.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_ADDRESS2--&gt;</td>
                            <td>This will return the clients second line of address.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_CITY--&gt;</td>
                            <td>This will return the clients city.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_STATE--&gt;</td>
                            <td>This will return the clients state.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_POSTCODE--&gt;</td>
                            <td>This will return the clients postcode.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_PHONENUMBER--&gt;</td>
                            <td>This will return the clients phone number.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_COUNTRY--&gt;</td>
                            <td>This will return the clients country.</td>
                        </tr>
                        <tr>
                            <td>&lt;!--CLIENT_COMPANYNAME--&gt;</td>
                            <td>This will return the clients company name.</td>
                        </tr>
                        
                        <tr>
                            <td>&lt;!--CLIENT_ACTIVATION_LINK--&gt;</td>
                            <td>Returns the clients activation link.</td>
                        </tr>
                    </tbody>
                </table>
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
                
    		<form action="" method="post">     
            <h4>Header HTML</h4>
            <p>This header will be included in every email template above by default.</p>
            <div class="panel panel-default">
            	<div class="panel-body">
                	<div class="form-group">
                    	<script src="<?php echo ADMINDOMAIN; ?>/extended/ckeditor/ckeditor.js"></script>
                    	<textarea cols="" rows="8" placeholder="" class="form-control" name="email_header" style="font-size:12px;" id="editor1"><?php echo rememberMe('email_header'); ?></textarea>
                        <script>
							// Replace the <textarea id="editor1"> with a CKEditor
							// instance, using default configuration.
							CKEDITOR.config.startupMode = 'source';
							CKEDITOR.replace( 'editor1' );
						</script>
                    </div>
                </div>            	
            </div>
            
            <h4>Footer HTML</h4>
            <p>This footer will be included in every email template above by default.</p>
            <div class="panel panel-default">
            	<div class="panel-body">
                	<div class="form-group">
                    	<textarea cols="" rows="8" placeholder="" class="form-control" name="email_footer" style="font-size:12px;" id="editor2"><?php echo rememberMe('email_footer'); ?></textarea>
                        <script>
							// Replace the <textarea id="editor1"> with a CKEditor
							// instance, using default configuration.
							CKEDITOR.config.startupMode = 'source';
							CKEDITOR.replace( 'editor2' );
						</script>
                    </div>
                </div>            	
            </div>
            
            <h4>Preview Window</h4>
            <p>This window will provide a preview for your header and footer.</p>
            <div class="panel panel-default">
            	<div class="panel-body">
                	<iframe class="form-control" src="<?php echo ADMINDOMAIN; ?>/?action=setup&option=email_templates&do=preview" style="min-height:500px;"></iframe>
                </div>            	
            </div>
            
            <div class="right"><input type="submit" name="_submit" value="Save Settings" class="btn btn-default"/></div>
        	</form>
            
        </div>
    </div>   
</div>