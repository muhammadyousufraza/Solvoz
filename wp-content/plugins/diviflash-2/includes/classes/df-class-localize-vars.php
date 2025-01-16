<?php

/**
 * 
 * Example:
 * DF_Localize_Vars::enqueue( 'df_cpt_filter', array( 
 *      'class' => $order_class,
 *      'layout' => $this->props['layout']
 *  ) );
 */
class DF_Localize_Vars {

    private static $scripts;

    static function enqueue( $handle, $args ){
         if ( ! isset( self::$scripts[$handle] ) ) {
              self::$scripts[$handle] = array();
         }

         self::$scripts[$handle][$args['class']] = $args;

         add_action( 'wp_footer', array( __CLASS__, 'enqueue_scripts' ) );

         return count( self::$scripts );
    }

    static function enqueue_scripts(){
         if ( self::$scripts ) {
              foreach( self::$scripts as $handle => $args ){
                   wp_enqueue_script( $handle );
                   wp_localize_script( $handle, $handle, $args );
              }
         }
    }

}