<?PHP 
if( !defined( 'ABSPATH') && !defined('WP_UNINSTALL_PLUGIN') )
    exit();
//mom always said, clean up after yourself. 
delete_option('smsnotifications');

?>