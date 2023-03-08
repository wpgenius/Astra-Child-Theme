# Astra-Child-Theme

Create Astra theme related child theme.
This child theme is based on object oriented. In this child them we created usefull files to develop a new website from scratch. 

#### Steps to register a new post type.
Create a 'post-type name'.php file into the includes/post-type/.
you can copy the code from testimonial.php.
after that copy your post type name or file name and add it into the $post_types array located in theme-action.php

![image](https://user-images.githubusercontent.com/74714812/222436599-a9e2b465-40d8-44a2-abe9-4dfdb55111d8.png)

#### Steps to register a new Elementor widget.
Create a new file as widget-'widget name'.php into the includes/widgets-elementor/.
You can copy basic structure of elementor widget code from includes/widgets-elementor/widget-testimonial.php
after that add file path in register_widget function located in widgets-elementor.php

![image](https://user-images.githubusercontent.com/74714812/222438280-a5a00544-8684-4b86-91ae-3cd72e670525.png)

#### Use of admin-actions.php

In this file you can add admin related actions.
Added actions

* Disable Gutenberg on the back end.
* Disable Gutenberg for widgets.
* Allow SVG uploads
* Remove comments support for all post types. Remove comment menu, widget from admin
* Add duplicate button to post/page list of actions.
* White label admin footer
* Lowercase Filenames for Uploads
* Redirect any user trying to access comments page
* Remove comments metabox from dashboard
* Disable support for comments and trackbacks in post types
* Remove comments page in menu
* Remove comments links from admin bar
* Add duplication post link in action links to the admin
* Handle the custom action when clicking the button we added above.



 
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
