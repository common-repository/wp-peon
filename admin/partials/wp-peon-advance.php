<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */

require ("wp-peon-header.php"); 

if ( 
    isset( $_POST['nonceField'] ) 
    && wp_verify_nonce( $_POST['nonceField'], 'nonceAction' ) 
) {
    try {       
        file_put_contents(ABSPATH . '.htaccess', stripslashes($_POST['htaccess']));
        file_put_contents(ABSPATH . 'wp-config.php', stripslashes($_POST['config']));
        echo '
            <div class="updated">
                <p>Fail to update file.</p>
            </div>
        ';
    }
    catch (Exception $e) {
            print_r($e->getMessage());
        echo '
            <div class="error">
                <p>Fail to update file.</p>
            </div>
        ';
    }
}

$htaccess_file = file_get_contents(ABSPATH . '.htaccess');
if (!$htaccess_file) $htaccess_file = "";
$config_file = file_get_contents(ABSPATH . 'wp-config.php');

?>

            <form method="post">
                <table  class="form-table" border=0>
                    <tbody>
                    <tr>
                        <td style="width:200px;vertical-align:top;">.htaccess</td>
                        <td>
                            <textarea rows="7" name="htaccess" class="large-text"><?php echo $htaccess_file; ?></textarea>
                            <span class="description">Becarefull while editing</span>
                        
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">wp-config.php</td>
                        <td>
                            <textarea rows="7" name="config" class="large-text"><?php echo $config_file; ?></textarea>
                            <span class="description">Becarefull while editing</span>
                        
                        </td>
                    </tr>
                    <tr>
                        <td style="vertical-align:top;">Enable Debugging: </td>
                        <td>
                            <textarea rows="5" disabled class="large-text">define('WP_DEBUG', true);&#13;&#10;define('WP_DEBUG_LOG', true);&#13;&#10;define('WP_DEBUG_DISPLAY', false);&#13;&#10;@ini_set('display_errors',0);</textarea>
                            <span class="description">You must insert this BEFORE /* That's all, stop editing! Happy blogging. */ in the wp-config.php file. Log info will be saved in "/wp-content/debug.log"</span>                       
                            <?php
                            $data = "<h3>Log data in debug.log</h3>";
                            $data_file = @file_get_contents(ABSPATH . 'wp-content/debug.log');
                            if (!$data_file) {
                                $data = '<br /><span style="border:  2px solid grey; display:block; padding: 5px;" class="description">Rendered log data will be printed here.</span>';
                            } else {
                                $data .= $data_file;
                            }
                            ?>
                            <div style="width:100%;">
                            <?php 
                                echo $data;
                            ?>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                
                <?php wp_nonce_field( 'nonceAction', 'nonceField'); ?>
                <br />
                <p class="submit">
                <input type="submit" class="button-primary" value="Save Setting">
                </p>
                
            </form>


<!-- This file should primarily consist of HTML with a little bit of PHP. -->
