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

$key = "wp-peon-execute";
$path = dirname(__FILE__) . "/execute-code/";

if ( 
    isset( $_POST['nonceField'] ) 
    && wp_verify_nonce( $_POST['nonceField'], 'nonceAction' ) 
) {
    $shortcode = $_POST['shortcode'];
    $code = stripslashes($_POST['code']);
    $data = get_option($key);
    $data[$shortcode] = true;
    update_option($key, $data);
    $code_php = "<?php " . $code . " ?>";
    
    if(file_put_contents($path . md5($shortcode), $code_php)) {    
        echo '
        <div class="updated">
            <p>Successfully updated.</p>
        </div>
        ';
    }
    else {
        echo '
        <div class="error">
            <p>Failed to update.</p>
        </div>
        ';
    }
}
else {
    if (isset($_GET['shortcode'])) {
        if (isset($_GET['delete'])) {
            $data = get_option($key);
            if (isset($data[$_GET['shortcode']])) {
                unset($data[$_GET['shortcode']]);
                update_option($key, $data);
                unlink($path . md5($_GET['shortcode']));
                echo '
                <div class="updated">
                    <p>Successfully deleted.</p>
                </div>
                ';            
            }
            $code = NULL;
            $shortcode = NULL;
        }            
        else {            
            try {
                $data = get_option($key);
                if (isset($data[$_GET['shortcode']])) {
                    $code      = stripslashes(file_get_contents($path . md5($_GET['shortcode'])));
                    $code      = substr($code, 5, -2);
                    $shortcode = $_GET['shortcode'];
                }
                else {
                    $code = NULL;
                    $shortcode = NULL;
                }
            }
            catch (Exception $e) {
                $code = NULL;
                $shortcode = NULL;
            }
        }
    }
    else {
        $code = NULL;
        $shortcode = NULL;
    }
}

function list_shortcodes() {
    $key = "wp-peon-execute";
    $data = get_option($key);
    
    if ($data == false) {
        ?>
        <p>No shortcode available.</p>
        <?php
        return;
    }
    ?>
    <table class="widefat">
     <tr class="row-title">
        <td><p>Shortcode</p></td>
        <td><p>Delete</p></td>
    </tr>
    <?php
    foreach ($data as $value => $key) {
        ?>
        <tr>
        <td><p>[<a style="text-decoration:none;" href="?page=wp-peon-execute&shortcode=<?php echo $value; ?>"><?php echo $value; ?></a>]</p></td>
        <td><p><a style="text-decoration:none;color:red;" href="?page=wp-peon-execute&delete&shortcode=<?php echo $value; ?>">X</a></p></td>
        </tr>
        <?php
    }
    ?>
    </table>
    <?php
    
}

?>

<div class="wrap">
	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h3 class="hndle"><span>Exec PHP</span></h3>

						<div class="inside">
                            <form action="" method="POST">
                                <table class="form-table">
                                    <tr>
                                        <td style="vertical-align:top;">
                                            Shortcode: 
                                        </td>
                                        <td>
                                            <input class="regular-text" type="text" name="shortcode" placeholder='weather_api, table_of_twelve, ...' value="<?php echo $shortcode; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">
                                            PHP Code: 
                                        </td>
                                        <td>
                                            <p>&lt;?php</p>
                                            <textarea placeholder='echo "Hello, World.";' name="code" rows="5" class="large-text"><?php echo $code; ?></textarea>
                                            <p>?&gt;</p>
                                        </td>
                                    </tr>                                                                          
                                    <tr>
                                        <td>                                       
                                            <input type="submit" class="button-primary" value="Add">
                                        </td>
                                    </tr>
                                </table>
                            <?php wp_nonce_field( 'nonceAction', 'nonceField'); ?>
                            </form>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables .ui-sortable -->

			</div>
			<!-- post-body-content -->
                       
			<!-- sidebar -->
			<div id="postbox-container-1" class="postbox-container">

				<div class="meta-box-sortables">

					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h3 class="hndle"><span>Available Shortcodes</span></h3>

						<div class="inside">
                            <?php
                             list_shortcodes();
                            ?>
						</div>
						<!-- .inside -->

					</div>
					<!-- .postbox -->

				</div>
				<!-- .meta-box-sortables -->

			</div>
			<!-- #postbox-container-1 .postbox-container -->          
		</div>
		<!-- #post-body .metabox-holder .columns-2 -->

		<br class="clear">
	</div>
	<!-- #poststuff -->

</div> <!-- .wrap -->
