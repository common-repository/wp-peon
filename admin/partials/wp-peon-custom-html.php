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

$key = "wp-peon-custom-html";

if ( 
    isset( $_POST['nonceField'] ) 
    && wp_verify_nonce( $_POST['nonceField'], 'nonceAction' ) 
) {
    $data = array(
        'header'     => $_POST['header'],
        'footer'     => $_POST['footer'],
        'after_post' => $_POST['after_post'],
        'before_post' => $_POST['before_post']
    );
    if (get_option($key) == $data || update_option($key, $data)) {
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
    $data = get_option($key);
    if (!$data) $data = array();
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

						<h3 class="hndle"><span>Custom HTML</span></h3>

						<div class="inside">
                            <form action="" method="POST">
                                <table class="form-table">
                                    <tr>
                                        <td style="vertical-align:top;">
                                            <label>In Header:</label>
                                        </td>
                                        <td>
                                            <textarea placeholder="Html/scripts goes here." name="header" rows="5" class="large-text"><?php echo $data['header']; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">
                                            <label>In Footer:</label>
                                        </td>
                                        <td>
                                            <textarea placeholder="Html/scripts goes here." name="footer" rows="5" class="large-text"><?php echo $data['footer']; ?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="vertical-align:top;">
                                            <label>After Post:</label>
                                        </td>
                                        <td>
                                            <textarea placeholder="Html/scripts goes here." name="after_post" rows="5" class="large-text"><?php echo $data['after_post']; ?></textarea>
                                        </td>
                                    </tr>  
                                    <tr>
                                        <td style="vertical-align:top;">
                                            <label>Before Post:</label>
                                        </td>
                                        <td>
                                            <textarea placeholder="Html/scripts goes here." name="before_post" rows="5" class="large-text"><?php echo $data['before_post']; ?></textarea>
                                        </td>
                                    </tr>                                       
                                    <tr>
                                        <td>                                       
                                            <input type="submit" class="button-primary" value="Apply">
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

						<h3 class="hndle"><span>Help</span></h3>

						<div class="inside">
							<b>In header</b>
                            <p>
                                Add code before &lt;/head&gt; in all pages.
                            </p>
							<b>In footer</b>
                            <p>
                                Add code before &lt;/body&gt; in all pages.
                            </p>
							<b>After post</b>
                            <p>
                                Add code after post content best for adding advertisements or share button.
                            </p>                            
							<b>Before post</b>
                            <p>
                                Add code before post content best for adding share button or share button.
                            </p>
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
