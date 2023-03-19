# Astra Child Theme

Create Astra theme related child theme.
This child theme is based on object oriented. In this child them we created usefull files to develop a new website from scratch.

### Basic Folder structure

    ├── ...
    ├── assets
    │   ├── css
    │     ├── style.css                             # You can add extra style.
    │   ├── images                                  # You can upload images.
    │     ├── wpgenius_logo.png
    │   ├── js
    │     ├── custom.js                             # You can add extra javascript.
    ├── includes
    │   ├──Modules
    │     ├── uae-modules.php                       # Activate UAE modules.
    │   ├──post-types
    │     ├── testimonial.php                       # Create a new post type.
    │   ├── widgets
    │     ├── widget-testimonial.php                # Create a new widget.
    │   ├── widgets-elementor
    │     ├── widget-testimonial.php                # Create a new elementor widget.
    │   ├── admin-actions.php                       # Add admin related actions.
    │   ├── ajax-actions.php                        # Add ajax related actions.
    │   ├── cleanup-action.php                      # Add wordpress or other cleaning related actions.
    │   ├── security-actions.php                    # Add security related action.
    │   ├── seo-actions.php                         # Add seo related action.
    │   ├── theme-actions.php                       # Add theme related action.
    │   ├── theme-functions.php                     # Add theme functions.
    │   ├── theme-settings.php                      # Add theme settings.
    │   ├── user-actions.php                        # Add user related action.
    │   ├── widget-elementor.php                    # Add or remove elementor files from here
    │   ├── woo-actions.php                         # Add woocommerce related action.
    ├── funtion.php                                 # You can include new files here.
    ├── screenshot.png                              # Show screenshot image to the child theme.
    ├── style.css                                   # Add custom css.
    │   └── ...
    └── ...


#### Steps to register a new post type.
Create a 'post-type name'.php file into the includes/post-type/.
you can copy the code from testimonial.php.
after that copy your post type name or file name and add it into the $post_types array located in theme-action.php

```
		private $post_types = array(
			'testimonial',
		);
```

#### Steps to register a new Elementor widget.
Create a new file as widget-'widget name'.php into the includes/widgets-elementor/.
You can copy basic structure of elementor widget code from includes/widgets-elementor/widget-testimonial.php
after that add file path in register_widget function located in widgets-elementor.php

```
public function register_widgets() {
		// register widget here
		require_once __DIR__ . '/widgets-elementor/widget-testimonial.php';
		\Elementor\Plugin::instance()->widgets_manager->register_widget_type( new \Elementor\WPG_Elementor_Testimonial_Widget() );
	}
 ```

#### Use of admin-actions.php

In this file you can add admin related actions.

* Disable Gutenberg on the back end.
* Disable Gutenberg for widgets.
* Allow SVG uploads.
* Remove comments support for all post types. Remove comment menu, widget from admin.
* Add duplicate button to post/page list of actions.
* White label admin footer.
* Lowercase Filenames for Uploads.
* Redirect any user trying to access comments page.
* Remove comments metabox from dashboard.
* Disable support for comments and trackbacks in post types.
* Remove comments page in menu.
* Remove comments links from admin bar.
* Add duplication post link in action links to the admin.
* Handle the custom action when clicking the button we added above.

#### ajax-action.php

In this file you can add Ajax related actions.

#### cleanup-action.php

This file use for to clean wordpress dashboard or other this as follows.
* Remove unwanted JS & CSS from front end.
   * Remove Gutenberg Block Library CSS from loading on the frontend.
* Remove all dashboard widgets from admin panel.
* Remove Slider Revolution Meta Generator Tag.
* Disable the emojis in WordPress.
* Disable all embeds in WordPress.
   * Remove the REST API endpoint.
   * Turn off oEmbed auto discovery.
   * Don't filter oEmbed results.
   * Remove oEmbed discovery links.
   * Remove all embeds rewrite rules.
   * Remove filter of the oEmbed result before any HTTP requests are made.
* Remove oEmbed-specific JavaScript from the front-end and back-end.
* Disable RSS FEEDS.
* Clean WordPress admin.

#### security-action.php

This file use for wordpress security actions.

* Remove WordPress Meta Generator Tag.
* Disable XMLRPC.
* Remove link to the Really Simple Discovery service endpoint.
* Disable wlwmanifest link.
* Close comments on the front-end and Hide existing comments.
* Disable Comment Form Website URL.
* Disable pings on the front end.
* Disable core auto-updates.
* Disable auto-updates for plugins.
* Disable auto-updates for themes.
* Disable auto-update emails for core.
* Disable auto-update emails for plugins.
* Disable auto-update emails for themes.

#### seo-actions.php

This file use for SEO related actions.

* Disable Attachment Pages.
* Disable Attachment Pages.
* Add filter to remove Query Strings From Static Files.
* Split Query Strings From urls.

#### theme-action.php

This file use for Theme related actions

* Enqueue stylesheet file on front end.
   * We will not use default stylesheet file. Only write CSS to style.css file under assets/css folder.
* Includes post type files. Check if file exist or not and then include it.
* Includes widget files. Check if file exist or not and then include it.
* Register elementor widgets by creating instance of class WPGenius_Elementor_Widgets.
* Register elementor widgets by creating instance of class WPGenius_Elementor_Widgets.

#### theme-configurator.php

In this file we create an wpcli command as easy_setup.

* Register new wp cli command as easy_setup.
* Activate astra addon options, UAE options, change white lables of asta theme and While activate child theme.

#### theme-functions.php

In this file you can includes theme files.

#### theme-settings.php

In this file we create a sub page under the astra named as settings. In this file we write a simple setting class. By using this class you can easyly make a setting.

#### theme-shortcodes.php

In this file you can registers a new custom shortcodes.

#### user-actions.php

This file use for user related actions.

* Remove application password settings from user profile.
* Remove Login Shake Animation.
* Hide Login Errors in WordPress. Add custom login error message.

#### widgets-elementor.php

This file use for to create a new elementor widgets.

#### woo-actions.php

This file use for WooCommerce related actions.

#### function.php

In this file we include only theme-functions.php and decleare some function as follows.

* DISABLE_COMMENTS - Disable comments from comments. Removes comments menu from admin. Default : true
* DISABLE_EMOJI - Disable the emojis in WordPress from backend & front end. Default : true
* DISABLE_OEMBED - Disable all embeds in WordPress. Default : true
* DISABLE_FEEDS - Disable RSS FEEDS. Default : true
* DISABLE_ATTACHMENT_PAGES - Disable Attachment Pages. Default : true
* DISABLE_AUTOMATIC_UPDATES - Disable automatic updates : false
* DISABLE_AUTOMATIC_UPDATE_EMAIL - Disable automatic updates email. Default : false
* REMOVE_QUERY_STRINGS - Remove Query Strings From Static Files. Default : true
* ENABLE_DUPLICATE_POST - Enable option to duplicate posts : true
* STRICY_ADMIN_MODE - Strict admin mode. : true
* WHITE_LABEL_ADMIN_FOOTER - White label admin footer. : true


#### style.css

You can add theme related css here.




