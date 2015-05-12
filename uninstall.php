<?php
//if uninstall not called from WordPress exit
/*if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();
*/

function table_uninstall()
{
    global $wpdb, $table_prefix;
    $sql = "DROP TABLE `pec_admin_user_cals`, `pec_default_reminders`, `pec_event_calendar_settings`, `pec_guests`, `pec_mobile_calendar_settings`, `pec_reminders`, `pec_settings`, `pec_shared_calendars`, `pec_user_permissions`, `pec_user_share_free_busy`, `pec_events`, `pec_calendars`, `pec_users`;";
    $wpdb->query($sql);
   // delete_option("db_version");
}
?>