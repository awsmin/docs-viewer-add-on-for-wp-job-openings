<?php
/*
Plugin Name: Awsm Job Openings Docs Viewer
Plugin URI: http://wordpress.org/plugins/job-openings/
Description: Awsm Job Openings Docs Viewer is an add-on for Awsm Job Openings plugin. This plugin allows you to view the applicant resume.
Author: AWSM Innovations
Version: 1.0
Text domain : awsm-job-openings
Licence :GPLv2
*/
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class AWSM_Jobs_Docs_Viewer {
    private static $_instance = null;

    public static function init() {
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function __construct() {
        add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
        add_action( 'admin_init', array( $this, 'handle_plugin_activation' ) );
    }

    public function register_meta_boxes()
    {
        add_meta_box( 'Resume Viewer', __( 'Resume Preview', 'awsm-job-openings' ), array( $this, 'docs_viewer_handle' ), 'awsm_job_application', 'advanced', 'low' );
    }

    public function docs_viewer_handle(){
        $awsm_application_id = get_post_meta( get_the_ID(), 'awsm_attachment_id', true );
        $attachment_url = wp_get_attachment_url( $awsm_application_id );
        if ( $attachment_url ) {
        ?>
            <iframe src="<?php echo esc_url( 'https://docs.google.com/viewer?embedded=true&url=' . $attachment_url ); ?>" style="width: 100%; height: 400px; border: none;">
            </iframe>
         <?php
        } else {?>
            <div class="awsm-resume-none">
                <h2><?php esc_html_e( 'File not found!', 'awsm-job-openings' ); ?></h2>
            </div>
        <?php  }
    }

    public function handle_plugin_activation(){
        include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
        if ( ! is_plugin_active( 'awsm-job-openings/awsm-job-openings.php' ) || ! class_exists( 'AWSM_Job_Openings' ) ) {
                add_action( 'admin_notices', function() {
        ?>
            <div class="updated error">
                <p>
                    <?php
                        printf( __( 'The plugin <strong>"%2$s"</strong> needs the plugin <strong>"%1$s"</strong> active.<br />Please install or activate <strong>"%1$s"</strong>', ' awsm-job-openings' ), 'Awsm Job Openings', 'Awsm Job Openings Docs Viewer' );
                    ?>
                </p>
            </div>
        <?php
            });
        }
    }
}
add_action( 'plugins_loaded', 'AWSM_Jobs_Docs_Viewer::init' );