<?php

// Do not allow direct access to the file.
if( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Register Widgets & Sidebars
 * 
 * @since 1.0
 */
if( ! class_exists( 'Agama_Widgets' ) ) {
	class Agama_Widgets {
        
        /**
         * Class Constructor
         */
		public function __construct() {
			
            add_action( 'widgets_init', array( $this, 'init' ) );
            
		}
		
        /**
         * Register Widgets
         *
         * @since 1.0
         */
		function init() {
			register_sidebar( array(
				'name' => __( 'Main Sidebar', 'agama' ),
				'id' => 'sidebar-1',
				'description' => __( 'Appears on posts and pages.', 'agama' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );

			register_sidebar( array(
				'name' => __( 'Footer Widget 1', 'agama' ),
				'id' => 'footer-widget-1',
				'description' => __( 'Appears on footer area.', 'agama' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
			
			register_sidebar( array(
				'name' => __( 'Footer Widget 2', 'agama' ),
				'id' => 'footer-widget-2',
				'description' => __( 'Appears on footer area.', 'agama' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
			
			register_sidebar( array(
				'name' => __( 'Footer Widget 3', 'agama' ),
				'id' => 'footer-widget-3',
				'description' => __( 'Appears on footer area.', 'agama' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
			
			register_sidebar( array(
				'name' => __( 'Footer Widget 4', 'agama' ),
				'id' => 'footer-widget-4',
				'description' => __( 'Appears on footer area.', 'agama' ),
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget' => '</aside>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>',
			) );
		}
	}
	new Agama_Widgets;
}

/* Omit closing PHP tag to avoid "Headers already sent" issues. */
