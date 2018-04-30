 <?php  if($_POST['GMKD_hidden'] == 'Y') {
 //Form data sent
     $keyword = $_POST['GMKD_keyword'];
     isset($keyword)?update_option('GMKD_keyword', $keyword):"";

     $desc = $_POST['GMKD_desc'];
     isset($desc)?update_option('GMKD_desc', $desc):"";

     $robots = $_POST['GMKD_robots'];
     isset($robots)?update_option('GMKD_robots', $robots):"";

     $meta = $_POST['GMKD_meta'];
     isset($meta)?update_option('GMKD_meta', $meta):"";

     $hide = $_POST['GMKD_hide'];     
     foreach ($hide as $variable) {
        $hideArr[] = $variable;
     }        
     update_option('GMKD_hide', implode(",", $hideArr));
     ?>
<div class="updated"><p><strong><?php _e('GMKD options saved.' ); ?></strong></p></div>   
 <?php }  else {
 //Normal page display
     $keyword = get_option('GMKD_keyword');
     $desc = get_option('GMKD_desc');
     $robots = get_option('GMKD_robots')?get_option('GMKD_robots'):"1";
     $meta = get_option('GMKD_meta');
     $hideStr = get_option('GMKD_hide');
     if(isset($hideStr)) { $hideArr = explode(",", $hideStr);}
     
 }?>
<div class="wrap">
     <?php echo "<h2>" . __( 'Global Meta Keyword & Description', 'GMKD_option' ) . "</h2>"; ?>
    <form name="GMKD_form" method="post" action="<?php echo str_replace( '%7E', '~', $_SERVER['REQUEST_URI']); ?>">
        <input type="hidden" name="GMKD_hidden" value="Y">        
        <table border="0" cellpadding="0" cellspacing="5" class="GMKD-container">
            <tbody>
                <tr>
                    <td valign="top" class="GMKD-label"><?php _e("Meta Keyword: " ); ?></td>
                    <td width="534"><input class="GMKD-fields" type="text" name="GMKD_keyword" value="<?php echo $keyword; ?>" size="20"></td>
                    <td align="left" class="GMKD-help"><?php _e(" Add comma seperated keywords. </br>(eg: Keyword1,Keyword2,Keyword3...)" ); ?></td>
                </tr>
                <tr>
                    <td valign="top" class="GMKD-label"><?php _e("Meta Descrption: " ); ?></td>
                    <td><textarea class="GMKD-fields" rows="5" cols="60" name="GMKD_desc"><?php echo $desc; ?></textarea></td>
                    <td align="left" valign="top" class="GMKD-help"><?php _e(" Add description." ); ?></td>
                </tr>
                <tr>
                    <td valign="top" class="GMKD-label"><?php _e("Meta Robots: " ); ?></td>
                    <td>
                        <select name="GMKD_robots" class="GMKD-fields">
                            <option value="1" <?php echo ($robots == "1")?"selected":"";?>>Noindex, Nofollow</option>
                            <option value="2" <?php echo ($robots == "2")?"selected":"";?>>Index, Nofollow</option>
                            <option value="3" <?php echo ($robots == "3")?"selected":"";?>>Noindex, Follow</option>
                            <option value="4" <?php echo ($robots == "4")?"selected":"";?>>Index, Follow</option>
                        </select>                      
                    </td>
                    <td align="left" valign="top" class="GMKD-help"></td>
                </tr>
                <tr>
                    <td valign="top" class="GMKD-label"><?php _e("Add Meta Tags: " ); ?></td>
                    <td><textarea class="GMKD-fields" rows="10" cols="60" name="GMKD_meta"><?php echo stripslashes($meta); ?></textarea></td>
                    <td align="left" valign="top" class="GMKD-help"><?php _e(" Add meta tags on new line." ); ?></td>
                </tr>
                <tr>
                    <td valign="top" class="GMKD-label"><?php _e("Hide Meta On: " ); ?></td>
                    <td>
                         <?php foreach (get_pages() as $page_data) {
                             $hideChk = false;
                             foreach ($hideArr as $hideVal) {                             
                             if($page_data->ID==$hideVal){
                                 $hideChk = true;
                             }}?>
                        <input type="checkbox" name="GMKD_hide[]" <?php echo $hideChk?"checked":""; ?> value="<?php echo $page_data->ID; ?>" /><?php echo $page_data->post_title;?>&nbsp;&nbsp;&nbsp;&nbsp;
                         <?php } ?>
                    </td>
                    <td align="left" valign="top" class="GMKD-help"><?php _e("Meta will not be displayed on selected Pages." ); ?></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td colspan="2" align="left" valign="top">
                        <input type="submit" name="Submit" class="button-primary" value="<?php _e('Save', 'GMKD_option' ) ?>" />

                    </td>                   
                </tr>
            </tbody>
        </table>
    </form>
</div>
