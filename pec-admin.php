<?php
//must check that the user has the required capability
if (!current_user_can('manage_options'))
{
wp_die( __('You do not have sufficient permissions to access this page.') );
}

// variables for the field and option names

$hidden_field_name = 'mt_submit_hidden';
$data_file_name = 'fupload';
$data_file_name_url = 'urlupload';
$upload_dir ='uploads';
$upload_dir_params = wp_upload_dir();
//$dir = plugin_dir_path( __FILE__ ).$upload_dir; //plugin directory can not be used for uploading files
$dir = $upload_dir_params['path']; //this has to be WP's upload dir

function getHeaders($url)
{
$ch = curl_init($url);
curl_setopt( $ch, CURLOPT_NOBODY, true );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
curl_setopt( $ch, CURLOPT_HEADER, false );
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
curl_setopt( $ch, CURLOPT_MAXREDIRS, 3 );
curl_exec( $ch );
$headers = curl_getinfo( $ch );
curl_close( $ch );

return $headers;
}

function download($url, $path)
{
# open file to write
$fp = fopen ($path, 'w+');
# start curl
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $url );
# set return transfer to false
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, false );
curl_setopt( $ch, CURLOPT_BINARYTRANSFER, true );
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: text/calendar','Depth: 1'));
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
curl_setopt( $ch, CURLOPT_SSLVERSION,3);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');//New added. Removed curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PROPFIND')
# increase timeout to download big file
curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 60 );
# write data to local file
curl_setopt( $ch, CURLOPT_FILE, $fp );
# execute curl
curl_exec( $ch );
$error = curl_error($ch);
# close curl
curl_close( $ch );
# close local file
fclose( $fp );

if (filesize($path) > 0) return true;
}
//Upload data from url
if(isset($_POST[$data_file_name_url])){
$url = $_POST[$data_file_name_url];
$path = $dir.'/mycal.ics';
$status_flag=0;
$headers = getHeaders($url);
//echo $headers['http_code'].'- http code </br>';
//echo 'Download content length : '.$headers['download_content_length'].'</br>';
if (($headers['http_code'] === 0 || $headers['http_code'] === 200 || $headers['http_code'] === 2000 || $headers['http_code'] === 302) and $headers['download_content_length'] < 1024*1024) {
if (download($url, $path)){
//echo 'Download complete!';
$status_flag=1;
}
}
if ($status_flag==0){
?>
<div class="updated"><p><strong><?php _e('Your selected file could not download. Server may not give the HTTP Header permission or requesting session time may Expired.   Try again.', 'menu-pec' ); ?></strong></p></div>
<?php
}else{
    ?>
    <div class="updated"><p><strong><?php _e('File Downloading complete.', 'menu-pec' );  ?></strong></p></div>
<?php
}
include("icalreader.php"); // Run parser and insert into DB
}
// File upload through Browse local file
if( isset($_FILES['fupload'])) {
    // Read posted file information
    $file_name = $_FILES['fupload']['name'];
    $file_type = $_FILES['fupload']['type'];
    $file_temp_path = $_FILES['fupload']['tmp_name'];
    $file_size = $_FILES['fupload']['size'];
    $static_file_name = 'mycal';
    $status_flag = 0;

    //Put the file in directory with checking
    if ($file_type == "text/calendar" || $file_type == "application/octet-stream") {
        if(!is_writable($dir)){
            chmod($dir, 0777);
        }
        copy($file_temp_path, "$dir/$static_file_name.ics");// removed  'or die("Couldn't copy")'
        $status_flag = 1;
    }
    // Put an settings updated message on the screen
    if ($status_flag==0){
        ?>
        <div class="updated"><p><strong><?php _e('Your selected file is not *.ics format. Try again'.$file_type, 'menu-pec' ); ?></strong></p></div>
    <?php
    }else{
        ?>
        <div class="updated"><p><strong><?php _e('File uploading complete successfully.', 'menu-pec' );  ?></strong></p></div>
    <?php
    }
    include("icalreader.php"); // Run parser and insert into DB
}


// top
echo '<h2> <img class="pec-logo" src="'.  plugins_url( 'images/pec-logo.png',  __FILE__ ) .'" /> PHP Event Calendar Imports</h2>';

// container

echo '<div id="pec-settings" style="width:1000px;">';

// main

echo '<div id="pec-settings-main" style="width:800px;float:left">';

// info

echo '<div id="pec-settings-info" class="wrap">
                    <p>
                    This plugin is built with FREE <a href="http://phpeventcalendar.com">PHP Event Calendar</a> Lite edition! 
                    PHP Event Calendar is a modern, AJAX based, multi-user calendar/scheduling application. 
                    It can be used right out of the box as a standalone event calendar/scheduling application or can 
                    be customized easily to seamlessly integrate into your own environment. 
                    </p>

                    <p>
                    The Lite edition is similar to full version with a few limitations. 
                    The Lite edition allows single calendar only; no recurring/repeating events; no email reminder. 
                    The  full version has no those limitations. <a href="http://phpeventcalendar.com">Learn more...</a>
                    </p>
                  </div>';

// export instruction

echo '<div>
                    <h3>1. Learn how to export calendar to .ics file </h3>
                    
                    <p>
                        <ul style="padding-left:12px">
                        <li><a href="'.  plugins_url( 'images/PHP_Event_Calendar_export.png',  __FILE__ ) .'" width="800" height="1000" class="thickbox">PHP Event Calendar</a><br />
                        <li><a href="'.  plugins_url( 'images/gcal_export.png',  __FILE__ ) .'" width="600" height="550" class="thickbox">Google Calendar</a><br />
                        <li><a href="'.  plugins_url( 'images/OSX_iCal_export.png',  __FILE__ ) .'" width="600" height="350" class="thickbox">Apple OSX iCal/Calendar</a><br />
                        <li><a href="'.  plugins_url( 'images/outlook_export.png',  __FILE__ ) .'" width="600" height="550" class="thickbox">Microsoft Outlook</a><br />
                        </ul>
                    </p>

                  </div>';

// form

echo '<div id="pec-settings-form">';

// header upload .ics file

echo "<h3>2. ". __("Upload an iCalendar *.ics file", "menu-pec") ."</h3>";
echo "<table style='padding-left:12px; width:100%'><tr><td>";
echo "<h4>" . __( 'Upload from this computer', 'menu-pec' ) . "</h4>";

// settings form

?>

<form enctype="multipart/form-data" action="" method="post">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

    <p class="submit"><?php _e("File:", 'menu-pec' ); ?>
        <input type="file" name="<?php echo $data_file_name; ?>" >
        <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Upload') ?>" />
    </p>

</form>

<!--######-->

<?php
echo "</td>"; // pec-admin-column1

echo '<td><div class="pec-admin-vertical-hr"></div></td>'; // vertical hr

// header upload via URL

echo "<td>";
echo "<h4>" . __( 'Or upload from web URL', 'menu-pec' ) . "</h4>";

// settings form

?>

<form enctype="multipart/form-data" action="" method="post">
    <input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

    <p class="submit"><?php _e("File:", 'menu-pec' ); ?>
        <input type="url" name="<?php echo $data_file_name_url; ?>" >
        <input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Upload') ?>" />
    </p>

</form>
</td></tr></table>

</div><!-- form container -->

<div>
    <h3>3. Add shortcode to page</h3>
    <p style="padding-left:12px">
        After uploading the file, please create a <a href="<?php echo admin_url();?>post-new.php?post_type=page">new page</a> that will only contain the short-code
        <br /><br />
        <code>[php_event_calendar]</code>
        <br /><br />
    </p>
</div>

<div>
    <h3>All Done! Well, you still need help?</h3>

    <p style="padding-left:12px">
        Feel free to <a href="http://phpeventcalendar.uservoice.com/" target="_new">send us your feedback and suggestions</a>.
    </p>
</div>


</div><!-- pec-settings-main -->

<!-- PEC right sidebar -->
<div id="pec-admin-sidebar" style="width:180px;float:right">
    <h3>More About PHP Event Calendar</h3>

    <a href="http://phpeventcalendar.com/screenshots/" target="_new">Screenshots</a><br />
    <a href="http://quickproductdemo.com/phpeventcal/" target="_new">Full Version Demo</a><br />
    <a href="http://phpeventcalendar.com/category/docs/" target="_new">Quick Guide</a><br />
    <a href="http://phpeventcalendar.com/store/" target="_new">Download</a><br />
    <a href="http://phpeventcalendar.com/contact/" target="_new">Support & Contact</a><br />
</div>

</div><!-- pec-settings -->
