<?php
/**
 * Add actions related to wp users.
 *
 * @package astra-child-theme
 */

 /**
  * Remove application password from user.
  */
 add_filter( 'wp_is_application_passwords_available', '__return_false' );

