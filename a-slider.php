<?php
/**
 * Plugin Name: Nice Slider
 * Plugin URI: https://profiles.wordpress.org/mohammedalamreety/
 * Description: slider plugin.
 * Version: 1.0
 * Author: Mohammed Alamreety
 * Author URI: https://www.amreety.com
 */



class AMRET_a_slider
{


    function __construct()
    {
        add_shortcode('a_slider_1', array($this, 'AMRET_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'bootstrap_css'));
        wp_enqueue_script('bootstrap-js', plugin_dir_url(__FILE__).'bootstrap/js/bootstrap.js','','',true);
    }


    public function AMRET_slider_code()
    {

        ?>

        <div class="row">
            <div class="container">
                <div class="col-sm-12 mt-3 mb-3">
                    <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">

                        <?php

                        // the query
                        // get all post types
                        $args = array (
                            'post_type'              => 'post',
                            'post_status'            => 'publish'
                        );
                        $the_query = new WP_Query($args);

                        ?>

						<?php if ( $the_query->have_posts() ) : $i=0; ?>
						<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					  
							<div class="carousel-item <?php echo ($i==0)?'active':''; ?>">
								<?php the_post_thumbnail('full', array('class' => 'd-block w-100')); ?>
                                <div class="carousel-caption d-none d-md-block">
                                    <?php echo '<h5>' . get_the_title() . '</h5>'; ?>
                                </div>
							</div>


					  	<?php $i++; endwhile; ?>
						<?php wp_reset_postdata(); ?>
						<?php else : ?>
							<p><?php _e('please add some slides ..');?></p>
						<?php endif; ?>

                        </div>

                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php _e('Previous');?></span>
                        </button>


                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden"><?php _e('Next');?></span>
                        </button>

                    </div>
                </div>
            </div>
        </div>

        <?php

    }
   

    function bootstrap_css()
    {
        wp_enqueue_style('bootstrap-css', plugin_dir_url(__FILE__).'bootstrap/css/bootstrap.css');

    }

    function AMRET_shortcode(){

        ob_start();

        $this->AMRET_slider_code();

        return ob_get_clean();
    }

}
new AMRET_a_slider;


if(!function_exists('AMRET_admin_menu_setting')){
    add_action('admin_menu', 'AMRET_admin_menu_setting');
    function AMRET_admin_menu_setting(){
        add_menu_page(__('Nice Slider'), __('Nice Slider'), 'manage_options', 'AMRET_option', 'AMRET_admin_page_setting');
    }
}
function AMRET_admin_page_setting(){
    ?>
    <form action="options.php" method="post">
        <div class="input-text-wrap loginas" id="title-wrap">
            <?php
            settings_fields('AMRET_option');
            do_settings_sections('AMRET_option');
            ?>
        </div>
    </form>
    <?php
}

add_action('admin_init', 'AMRET_option_setting');
function AMRET_option_setting(){
    register_setting('AMRET_option', __('AMRET_option'));
    add_settings_section('AMRET_my_id', __('Nice Slider'), '', 'AMRET_option');
    add_settings_field(
        'AMRET_my_name',
        __('slider shortcode :'),
        'AMRET_create_input',
        'AMRET_option',
        'AMRET_my_id',
        array(
            'title'=>'[a_slider_1]',
            'id'=>'text_name',
            'type'=>'text'
        )
    );
}
function AMRET_create_input($arg){
    $val = get_option('AMRET_option');
    ?>
    <label for="<?php esc_attr_e($arg['id']); ?>"><?php esc_html_e($arg['title']); ?></label>

    <?php
}
