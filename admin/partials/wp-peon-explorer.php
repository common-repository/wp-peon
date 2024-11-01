<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Wp_Peon
 * @subpackage Wp_Peon/admin/partials
 */

require ("wp-peon-header.php"); 

define(_ABSPATH, str_replace('\\','/',ABSPATH));

    //http://stackoverflow.com/questions/5501427/php-filesize-mb-kb-conversion
    function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824)
        {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        }
        elseif ($bytes >= 1048576)
        {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        }
        elseif ($bytes >= 1024)
        {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        }
        elseif ($bytes > 1)
        {
            $bytes = $bytes . ' bytes';
        }
        elseif ($bytes == 1)
        {
            $bytes = $bytes . ' byte';
        }
        else
        {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

if (isset($_POST['edit'])) {
    $filename   = $_POST['filename'];
    $data       = htmlspecialchars_decode($_POST['source']);  
    file_put_contents($filename, $data);
    echo '
        <div class="updated"><p>' . basename($filename) . ' updated successfully.' .'</p></div>
    ';
}
else {
    if (isset($_GET['path'])) 
        $path = $_GET['path'] . '\\';
    else 
        $path = _ABSPATH;

    $path = cleanPath($path);
    $dirdata = array();
    foreach (glob($path . "*") as $filename) {
        $dirdata[] = array(
            'name'=> $filename,
            'size'=>filesize($filename),
            'dir'=>is_dir($filename)
        );
    }

    // Sorting
    usort($dirdata, function($a, $b) {
        return $a['dir'] <= $b['dir'];
    });
}

function cleanPath($path) {
    $path       = str_replace('\\','/',$path);
    $path       = preg_replace('#/+#','/', $path);    
    return $path;
}
                        
function printBreadcrumbs() {   
    $path = cleanPath($_GET['path']);
    $path = str_replace(_ABSPATH, '', $path);
    $path = explode('/',$path);    
    $path = array_filter($path);
    
    $tmppath = _ABSPATH;
    if (!empty($path)):
        foreach ($path as $key => $value):
            echo " / ";
            $tmppath .= $value . '/';
            ?>
            <a class="wpn-bread" href="?page=wp-peon-explorer&path=<?php echo $tmppath; ?>"><?php echo $value; ?></a>
            <?php
        endforeach;
    endif;
}                        
?>


<style>
.wpn-bread {
    text-decoration:none;
    padding:5px;
    border: 1px solid grey;
    background-color: #f0f0f0;
    border-radius: 5px;
}
</style>
<div>
    <p>
        <strong>Current directory: </strong><a class="wpn-bread" href="?page=wp-peon-explorer"><?php echo rtrim(_ABSPATH,'/'); ?></a>
        <?php printBreadcrumbs(); ?>
    </p>
</div>
<div class="wrap">
	<div id="icon-options-general" class="icon32"></div>

	<div id="poststuff">

		<div id="post-body" class="metabox-holder columns-2">

			<!-- main content -->
			<div id="post-body-content">

				<div class="meta-box-sortables ui-sortable">

					<div class="postbox">

						<div class="handlediv" title="Click to toggle"><br></div>
						<!-- Toggle -->

						<h3 class="hndle"><span>File Explorer</span></h3>

						<div class="inside">
                            <?php
                            
                            if (isset($_GET['edit'])):
                                $filename = $_GET['path'];
                             ?>
                                <form method="POST" action="">
                                <input name="filename" type="hidden" value="<?php echo $filename ; ?>">
                                <textarea cols="70" rows="30" class="large-text" name="source">
                                    <?php echo htmlspecialchars(file_get_contents($filename)); ?>
                                </textarea>
                                <br />
                                <br />
                                <input class="button-primary" type="submit" name="edit" value="Save">
                                <?php
                            else:
                            ?>                          
                            
                            <table class="widefat">
                              	<tr>
                                    <th class="row-title"><strong>Name</strong></th>
                                    <th><strong>Size</strong></th>
                                    <th><strong>Options</strong></th>
                                </tr>

                                <?php foreach($dirdata as $key => $value): ?>
                                    <tr>
                                        
                                        <?php 
                                            $name = basename($value['name']);
                                            if ($value['dir']): 
                                        ?> 
                                            <td><a href="?page=wp-peon-explorer&path=<?php echo urlencode($value['name']); ?>"><? echo $name ?></a></td>
                                        <?php else: ?>
                                            <td><?php echo $name ?></td>
                                        <?php endif; ?>
                                        
                                        <td><?php echo formatSizeUnits($value['size']); ?></td>
                                        
                                        <?php if ($value['dir']): ?> 
                                            <td><a href="?page=wp-peon-explorer&path=<?php echo urlencode($value['name']); ?>">Open</a></td>
                                        <?php else: ?>
                                            <td><a href="?page=wp-peon-explorer&edit&path=<?php echo urlencode($value['name']); ?>">Edit</a></td>
                                        <?php endif; ?>
                                        
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            <?php endif; ?>
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

						<h3 class="hndle"><span>Information</span></h3>

						<div class="inside">
							<p><b>Root Path:</b><br />
                            <a href="<?php echo ABSPATH; ?>"><?php echo ABSPATH; ?></a></p></p>
                            <p><b>Plugins Path:</b><br />
                            <a href="<?php echo ABSPATH . "wp-content/plugins/"; ?>"><?php echo ABSPATH . "wp-content/plugins/"; ?></a></p>
                            <p><b>Themes Path:</b><br />
                            <a href="<?php echo ABSPATH . "wp-content/themes/"; ?>"><?php echo ABSPATH . "wp-content/themes/"; ?></a></p></p>
                            <!--<p><b>Last Access File:</b><br />
                            </p>-->
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