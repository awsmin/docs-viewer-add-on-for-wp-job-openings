<?php
/*
Plugin Name: AWSM Docs Viewer
Plugin URI: http://wordpress.org/plugins/job-openings/
Description: Google Docs Viewer Add-on.
Author: AWSM Innovations
Version: 1.0
Text domain : awsm-job-openings
Licence :GPLv2
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}


class Awsm_google_docs_viewer {

        public static function init() {
            $class = __CLASS__;
            new $class;
        }

        public function __construct() {

            add_action( 'add_meta_boxes', array( $this, 'awsm_register_meta_boxes' ) );
            add_action( 'admin_init', array(  $this, 'handle_plugin_activation') );


        }

        public function awsm_register_meta_boxes()
        {
            add_meta_box( 'Resume Viewer', __('Resume Preview', 'awsm-job-openings'), array( $this, 'docs_viewer_handle'), 'awsm_job_application','advanced','low' );
        }

        public function docs_viewer_handle(){

            $awsm_app = get_post_meta(  get_the_ID(),'attachment_id',true );
            $attachment_url = wp_get_attachment_url( $awsm_app );

            if ( $attachment_url ) {
            ?>
                <iframe src="https://docs.google.com/viewer?embedded=true&url=<?php echo $attachment_url; ?>" style="width: 100%; height: 400px; border: none;">
                </iframe>
             <?php
            } else {?>
                <iframe src="<?php echo plugin_dir_url( __FILE__ ) . 'file-not-found.html'; ?>" style="width: 100%; height: 400px; border: none;">
                </iframe>
            <?php  }

        }

        public function handle_plugin_activation(){
            include_once( ABSPATH . 'wp-admin/includes/plugin.php');
            if ( ! is_plugin_active( 'awsm-job-openings/awsm-job-openings.php' ) || ! class_exists( 'AWSM_Job_Openings' ) ) {


                    // deactivate_plugins( plugin_basename( __FILE__ ) );
                    add_action('admin_notices', function(){
                    ?>
                <div class="updated error">
                    <p>
                        <?php
                            echo sprintf(
                                    __( 'The plugin <strong>"%s"</strong> needs the plugin <strong>"%s"</strong> active.', ' awsm-job-openings' ),
                                'Docs-viewer', 'Awsm Job Openings'
                            );

                            echo '<br>';
                            echo sprintf(
                                    __( 'Please install or activate <strong> %s</strong>', 'awsm-job-openings' ),  'Awsm Job Openings'
                            );
                        ?>
                    </p>
                </div>
                <?php
                });
            }
        }
}

add_action( 'plugins_loaded', array( 'Awsm_google_docs_viewer', 'init' ) );