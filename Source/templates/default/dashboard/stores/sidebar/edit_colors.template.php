<?php

/*@
 *@Author: Shaun Childerley
 *@Email: shaun@creativemiles.co.uk
 *@Name: Save Mari
 *@Start: 15th December 2016
*/
if(!defined('IN_ROOT')) { die('You can not access this file directly!'); }
?>

<h4>Customize Colors</h4>
<p>Use the color picker below to customize the colours of navigation bar and buttons.</p>

<link rel="stylesheet" type="text/css" href="<?php echo DOMAIN; ?>/templates/default/javascript/spectrum.css">
<script src="<?php echo DOMAIN; ?>/templates/default/javascript/spectrum.js"></script>
                                                                                                                    
        <!-- NAVIGATION MENU -->
        <div class="form-inline">
            
            <!--MENU-BACKGROUND-->
            <div class="form-group clearfix">
                <label>Menu Background</label><br />
                <span>Set the background colour of the navigation bar.</span><br />
                <input type='text' id="menu-color" />
                <script type="text/javascript">
                $("#menu-color").spectrum({
                    color: "#<?php echo $store['store_menu_color']; ?>",
                    change: function(color) {
                        var color = color.toHexString();
                            color = color.replace("#","");
                        $.ajax({
                            url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_changecolor',
                            type: 'POST',
                            data: 'store_color-type=menu-color&store_color-code=' + color,
                            success: function(data) {
                                if(data.success) {
                                    location.reload();
                                }
                            }
                        },'json');
                    }
                });
                </script>
            </div>
            
            <!--ACTIVE MENU ITEM-->
            <div class="form-group clearfix">
                <label>Button Background (Active)</label><br />
                <span>The colour of the menu item this is currently being viewed.</span><br />
                <input type='text' id="item-background-active" />
                <script>
                $("#item-background-active").spectrum({
                    color: "#<?php echo $store['store_item_background_active']; ?>",
                    change: function(color) {
                        var color = color.toHexString();
                            color = color.replace("#","");
                        $.ajax({
                            url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_changecolor',
                            type: 'POST',
                            data: 'store_color-type=item-background-active&store_color-code=' + color,
                            success: function(data) {
                                if(data.success) {
                                    location.reload();
                                }
                            }
                        },'json');
                    }
                });
                </script>
            </div>
            
            <!--ACTIVE MENU ITEM-->
            <div class="form-group clearfix">
                <label>Button Font Colour (Active) </label><br />
                <span>The font colour of the menu item this is currently being viewed.</span><br />
                <input type='text' id="item-font-color-active" />
                <script>
                $("#item-font-color-active").spectrum({
                    color: "#<?php echo $store['store_item_font_color_active']; ?>",
                    change: function(color) {
                        var color = color.toHexString();
                            color = color.replace("#","");
                        $.ajax({
                            url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_changecolor',
                            type: 'POST',
                            data: 'store_color-type=item-font-color-active&store_color-code=' + color,
                            success: function(data) {
                                if(data.success) {
                                    location.reload();
                                }
                            }
                        },'json');
                    }
                });
                </script>
            </div>
            
            <!--ACTIVE MENU ITEM-->
            <div class="form-group clearfix">
                <label>Button Font Color (Normal)</label><br />
                <span>The font color of the menu item that is not active.</span><br />
                <input type='text' id="item-font-color-normal" />
                <script>
                $("#item-font-color-normal").spectrum({
                    color: "#<?php echo $store['store_item_font_color_normal']; ?>",
                    change: function(color) {
                        var color = color.toHexString();
                            color = color.replace("#","");
                        $.ajax({
                            url: '<?php echo DOMAIN; ?>/index.php?page=dashboard&view=store&action=ajax&request=edit_changecolor',
                            type: 'POST',
                            data: 'store_color-type=item-font-color-normal&store_color-code=' + color,
                            success: function(data) {
                                if(data.success) {
                                   	location.reload();
                                }
                            }
                        },'json');
                    }
                });
                </script>
            </div>
            
        </div>