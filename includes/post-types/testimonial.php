<?php
/**
 * Post type: testimonial
 *
 * @package astra-child-theme/generic class
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Prevent direct access.
}

if ( ! class_exists( 'WPGenius_Testimonial' ) ) :

class WPGenius_Testimonial {

    /**
     * Singleton instance.
     *
     * @var WPGenius_Testimonial
     */
    protected static $instance = null;

    /**
     * Get or create an instance of this class.
     *
     * @return WPGenius_Testimonial
     */
    public static function init() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Constructor.
     */
    private function __construct() {

        // Register custom post type.
        add_action( 'init', [ $this, 'register_post_type' ] );

        // Manage columns in admin list table.
        add_filter( 'manage_testimonial_posts_columns', [ $this, 'manage_column' ] );
        add_action( 'manage_testimonial_posts_custom_column', [ $this, 'manage_custom_column' ], 10, 2 );

        // Change admin placeholder/title for testimonials.
        add_filter( 'enter_title_here', [ $this, 'entry_title_text' ], 10, 2 );
        add_filter( 'default_content', [ $this, 'editor_content' ], 10, 2 );

        // Adjust main query on testimonial archive.
        add_action( 'pre_get_posts', [ $this, 'pre_get_posts_on_archive' ] );

        // Add meta boxes & save logic.
        add_action( 'add_meta_boxes', [ $this, 'add_testimonial_meta_boxes' ] );
        add_action( 'save_post', [ $this, 'save_post_meta' ] );

        // Astra-specific hooks for archive display.
        //add_action( 'wp', [ $this, 'template_hooks' ] );
    }

    /**
     * Register "testimonial" post type.
     */
    public function register_post_type() {
		$public =  false ;

        $labels = [
            'name'               => __( 'Testimonials', 'astra-child-theme' ),
            'singular_name'      => __( 'Testimonial', 'astra-child-theme' ),
            'add_new'            => __( 'Add New', 'astra-child-theme' ),
            'add_new_item'       => __( 'Add new testimonial', 'astra-child-theme' ),
            'edit_item'          => __( 'Edit testimonial', 'astra-child-theme' ),
            'new_item'           => __( 'New testimonial', 'astra-child-theme' ),
            'view_item'          => __( 'View testimonials', 'astra-child-theme' ),
            'search_items'       => __( 'Search testimonials', 'astra-child-theme' ),
            'not_found'          => __( 'No testimonials found', 'astra-child-theme' ),
            'not_found_in_trash' => __( 'No testimonials found in Trash', 'astra-child-theme' ),
            'featured_image'     => __( 'Testimonial author photo', 'astra-child-theme' ),
            'set_featured_image' => __( 'Set testimonial author photo', 'astra-child-theme' ),
        ];

        $args = [
            'labels'             => $labels,
            'menu_icon'          => 'dashicons-format-quote',
            'show_ui'            => true,
            'show_in_menu'       => true,
			'show_in_nav_menus'  => $public,
            'public'             => $public,
            'exclude_from_search'=> ! $public,
            'publicly_queryable' => $public,
            'has_archive'        => $public,
            'rewrite'            => [
                'slug'       => 'testimonials',
                'with_front' => false,
            ],
            'supports'           => [ 'title', 'editor', 'thumbnail' ],
        ];

        register_post_type( 'testimonial', $args );
    }

    /**
     * Manage admin columns.
     *
     * @param array $columns Existing columns.
     * @return array
     */
    public function manage_column( $columns ) {

        $inserted = [
            'editor'    => __( 'Testimonial', 'astra-child-theme' ),
            'thumbnail' => __( 'Author Picture', 'astra-child-theme' ),
        ];

        // Insert custom columns after 'Title' and 'Author' columns, for example.
        return array_merge(
            array_slice( $columns, 0, 2 ),
            $inserted,
            array_slice( $columns, 2 )
        );
    }

    /**
     * Populate custom columns.
     *
     * @param string $column_name Column key.
     * @param int    $post_id     Current post ID.
     */
    public function manage_custom_column( $column_name, $post_id ) {
        if ( 'editor' === $column_name ) {
			echo '<p>' . get_post_meta( $post_id, 'testimonial_title', true ).'</p>' ;
            echo '<blockquote>' . esc_html( get_the_excerpt( $post_id ) ) . '</blockquote>';
        }
        if ( 'thumbnail' === $column_name ) {
            echo get_the_post_thumbnail( $post_id, 'thumbnail' );
        }
    }

    /**
     * Change placeholder text for 'title' input box.
     *
     * @param string $title Default placeholder text.
     * @param object $post  WP_Post object.
     * @return string
     */
    public function entry_title_text( $title, $post ) {
        if ( 'testimonial' === $post->post_type ) {
            $title = __( 'Enter testimonial author name here', 'astra-child-theme' );
        }
        return $title;
    }

    /**
     * Change default content of the editor.
     *
     * @param string $content Default content.
     * @param object $post    WP_Post object.
     * @return string
     */
    public function editor_content( $content, $post ) {
        if ( 'testimonial' === $post->post_type ) {
            $content = __( 'Write testimonial text here...', 'astra-child-theme' );
        }
        return $content;
    }

    /**
     * Modify the main query on the testimonial archive.
     *
     * @param WP_Query $query The WP_Query instance (passed by reference).
     */
    public function pre_get_posts_on_archive( $query ) {
        // Only target the main query on the front-end, for the 'testimonial' archive.
        if ( ! is_admin() && $query->is_main_query() && $query->is_post_type_archive( 'testimonial' ) ) {
            if ( get_option( 'wpg_testimonial_per_page' ) ) {
                $query->set( 'posts_per_page', get_option( 'wpg_testimonial_per_page' ) );
            }
        }
    }

    /**
     * Add meta boxes for the "testimonial" post type.
     */
    public function add_testimonial_meta_boxes() {
        add_meta_box(
            'testimonial-meta',
            __( 'Testimonial Details', 'astra-child-theme' ),
            [ $this, 'testimonial_meta_box_cb' ],
            'testimonial',
            'advanced',
            'high'
        );
    }

    /**
     * Meta box callback for displaying inputs.
     *
     * @param WP_Post $post Current post object.
     */
    public function testimonial_meta_box_cb( $post ) {
        // Add a nonce field for security.
        wp_nonce_field( 'testimonial_meta_box', 'testimonial_meta_box_nonce' );

        // Retrieve existing values (if any).
        $author_name  = get_post_meta( $post->ID, 'testimonial_title', true );
        $author_age   = get_post_meta( $post->ID, 'author_age', true );
        $designation  = get_post_meta( $post->ID, 'designation', true );
        ?>
        <table class="form-table">
            <tr>
                <th scope="row">
                    <label for="testimonial_title"><?php esc_html_e( 'Testimonial title', 'astra-child-theme' ); ?></label>
                </th>
                <td>
                    <input type="text" id="testimonial_title" name="testimonial_title" value="<?php echo esc_attr( $author_name ); ?>" style="width:100%" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="author_age"><?php esc_html_e( 'Author Age', 'astra-child-theme' ); ?></label>
                </th>
                <td>
                    <input type="number" id="author_age" name="author_age" value="<?php echo esc_attr( $author_age ); ?>" style="width:100%" />
                </td>
            </tr>
            <tr>
                <th scope="row">
                    <label for="designation"><?php esc_html_e( 'Designation', 'astra-child-theme' ); ?></label>
                </th>
                <td>
                    <input type="text" id="designation" name="designation" value="<?php echo esc_attr( $designation ); ?>" style="width:100%" />
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * Save meta box data when the post is saved.
     *
     * @param int $post_id Post ID.
     */
    public function save_post_meta( $post_id ) {

        // Check if nonce is set.
        if ( ! isset( $_POST['testimonial_meta_box_nonce'] ) ) {
            return;
        }

        // Verify nonce.
        if ( ! wp_verify_nonce( $_POST['testimonial_meta_box_nonce'], 'testimonial_meta_box' ) ) {
            return;
        }

        // Avoid auto-saves, etc.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        // Check user capabilities (optional but recommended).
        if ( isset( $_POST['post_type'] ) && 'testimonial' === $_POST['post_type'] ) {
            if ( ! current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
        }

        // Now safely handle & sanitize fields.
        if ( isset( $_POST['designation'] ) ) {
            update_post_meta(
                $post_id,
                'designation',
                sanitize_text_field( $_POST['designation'] )
            );
        }

        if ( isset( $_POST['testimonial_title'] ) ) {
            update_post_meta(
                $post_id,
                'testimonial_title',
                sanitize_text_field( $_POST['testimonial_title'] )
            );
        }

        if ( isset( $_POST['author_age'] ) ) {
            // Use sanitize_text_field for simplicity; or use absint() if you want strictly integer ages.
            update_post_meta(
                $post_id,
                'author_age',
                sanitize_text_field( $_POST['author_age'] )
            );
        }
    }

    /**
     * Hook into Astra theme parts for the testimonial archive.
     */
    public function template_hooks() {
        if ( is_post_type_archive( 'testimonial' ) ) {
            // Remove default Astra loop and add our own custom archive header + content.
            add_action( 'astra_archive_header', [ $this, 'archive_header' ] );
            add_action( 'astra_template_parts_content', [ $this, 'template_parts_function' ] );
        }
    }

    /**
     * Add a custom header to the testimonial archive.
     */
    public function archive_header() {
        if ( is_post_type_archive( 'testimonial' ) ) {
            if ( class_exists( 'Astra_Loop' ) ) {
                remove_action( 'astra_template_parts_content', [ Astra_Loop::get_instance(), 'template_parts_default' ] );
            }
            echo '<h1 class="post-title">' . esc_html__( 'Testimonials', 'astra-child-theme' ) . '</h1>';
        }
    }

    /**
     * Output custom template parts for each testimonial on the archive page.
     */
    public function template_parts_function() {
        global $post;
        // Custom loop or HTML to display the testimonial content, meta, etc.
       echo '<div class="testimonial-wrap">' . get_the_content() . '</div>';
    }
}

WPGenius_Testimonial::init();

endif;
