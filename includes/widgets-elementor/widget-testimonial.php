<?php

namespace Elementor;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPG_Elementor_Testimonial_Widget extends Widget_Base {

	public function get_name() {
		return 'testimonial-slider';
	}

	public function get_title() {
		return __( 'Testimonial Slider', 'astra-child-theme' );
	}

	public function get_icon() {
		return 'eicon-media-carousel';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_style_depends() {
		// Load necessary CSS (e.g., Swiper).
		return [ 'elementor-icons', 'swiper' ];
	}

	public function get_script_depends() {
		// If Swiper initialization is handled by Elementor, no extra scripts needed here.
		return [ 'swiper' ];
	}

	/**
	 * Register widget controls.
	 */
	protected function register_controls() {

		/*---------------------------------------------------*/
		/* 1. LAYOUT SETTINGS
		/*---------------------------------------------------*/
		$this->start_controls_section(
			'section_layout',
			[
				'label' => __( 'Layout Settings', 'astra-child-theme' ),
			]
		);

		// RESPONSIVE CONTROL: Slides to Show
		$this->add_responsive_control(
			'slides_to_show',
			[
				'label'          => __( 'Slides to Show', 'astra-child-theme' ),
				'type'           => Controls_Manager::NUMBER,
				'default'        => 3,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'min'            => 1,
				'max'            => 6,
			]
		);

		// Slides to Scroll
		$this->add_control(
			'slides_to_scroll',
			[
				'label'   => __( 'Slides to Scroll', 'astra-child-theme' ),
				'type'    => Controls_Manager::NUMBER,
				'default' => 1,
			]
		);

		// Navigation (Arrows, Dots, Both, None)
		$this->add_control(
			'navigation',
			[
				'type'    => Controls_Manager::SELECT,
				'label'   => __( 'Navigation', 'astra-child-theme' ),
				'options' => [
					'dots'   => __( 'Dots', 'astra-child-theme' ),
					'arrows' => __( 'Arrows', 'astra-child-theme' ),
					'both'   => __( 'Arrows and Dots', 'astra-child-theme' ),
					'none'   => __( 'None', 'astra-child-theme' ),
				],
				'default' => 'dots',
			]
		);

		// Transition Duration
		$this->add_control(
			'transition_duration',
			[
				'label'   => __( 'Transition Duration (ms)', 'astra-child-theme' ),
				'type'    => Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 10000,
				'step'    => 50,
				'default' => 500,
			]
		);

		// Autoplay
		$this->add_control(
			'autoplay',
			[
				'label'        => __( 'Autoplay', 'astra-child-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'astra-child-theme' ),
				'label_off'    => __( 'No', 'astra-child-theme' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'autoplay_speed',
			[
				'label' => esc_html__( 'Autoplay Speed', 'astra-child-theme' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 5000,
				'condition' => [
					'autoplay' => 'yes',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);


		// Pause on Hover
		$this->add_control(
			'pause_on_hover',
			[
				'label'        => __( 'Pause on Hover', 'astra-child-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'astra-child-theme' ),
				'label_off'    => __( 'No', 'astra-child-theme' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'autoplay' => 'yes',
				],
			]
		);

		// Pause on Interaction
		$this->add_control(
			'pause_on_interaction',
			[
				'label'        => __( 'Pause on Interaction', 'astra-child-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'astra-child-theme' ),
				'label_off'    => __( 'No', 'astra-child-theme' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'condition'    => [
					'autoplay' => 'yes',
				],
			]
		);

		// Infinite Loop
		$this->add_control(
			'infinite_loop',
			[
				'label'        => __( 'Infinite Loop', 'astra-child-theme' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => __( 'Yes', 'astra-child-theme' ),
				'label_off'    => __( 'No', 'astra-child-theme' ),
				'return_value' => 'yes',
				'default'      => 'no',
			]
		);

		$this->add_control(
			'effect',
			[
				'label' => esc_html__( 'Effect', 'astra-child-theme' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'slide',
				'options' => [
					'slide' => esc_html__( 'Slide', 'astra-child-theme' ),
					'fade' => esc_html__( 'Fade', 'astra-child-theme' ),
				],
				'condition' => [
					'slides_to_show' => '1',
				],
				'frontend_available' => true,
			]
		);

		$this->end_controls_section(); // End Layout


		/*---------------------------------------------------*/
		/* 2. QUERY & SORTING
		/*---------------------------------------------------*/
		$this->start_controls_section(
			'section_query',
			[
				'label' => __( 'Query & Sorting', 'astra-child-theme' ),
			]
		);

		$this->add_control(
			'number_of_testimonials',
			[
				'label'       => __( 'Number of Testimonials to Show', 'astra-child-theme' ),
				'type'        => Controls_Manager::NUMBER,
				'description' => __( 'Leave blank to show all testimonials.', 'astra-child-theme' ),
			]
		);

		$this->add_control(
			'orderby',
			[
				'label'   => __( 'Order By', 'astra-child-theme' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date'  => __( 'Date', 'astra-child-theme' ),
					'title' => __( 'Title', 'astra-child-theme' ),
					'rand'  => __( 'Random', 'astra-child-theme' ),
				],
			]
		);

		$this->add_control(
			'order',
			[
				'label'   => __( 'Order', 'astra-child-theme' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'ASC'  => __( 'Ascending', 'astra-child-theme' ),
					'DESC' => __( 'Descending', 'astra-child-theme' ),
				],
				'default' => 'DESC',
			]
		);

		$this->add_control(
			'excerpt_length',
			[
				'label'       => __( 'Excerpt Length', 'astra-child-theme' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'default'     => 20,
				'min'         => 1,
				'max'         => 200,
				'step'        => 1,
				'description' => __( 'Number of words to display from the testimonial content.', 'astra-child-theme' ),
			]
		);

		$this->end_controls_section(); // End Query & Sorting


		/*---------------------------------------------------*/
		/* 3. STYLE
		/*---------------------------------------------------*/
		// Existing or new Style section
		$this->start_controls_section(
			'section_typography_style',
			[
				'label' => __( 'Typography & Alignment', 'astra-child-theme' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		// -----------------------------
		// A) Title Typography Control
		// -----------------------------
		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name'     => 'testimonial_title_typography',
				'label'    => __( 'Content style', 'astra-child-theme' ),
				'selector' => '{{WRAPPER}} .testimonial-title',
			]
		);

		// ------------------------------------
		// B) Testimonial Content Alignment
		// ------------------------------------
		$this->add_responsive_control(
			'testimonial_content_alignment',
			[
				'label'        => __( 'Content Alignment', 'astra-child-theme' ),
				'type'         => \Elementor\Controls_Manager::CHOOSE,
				'options'      => [
					'left' => [
						'title' => __( 'Left', 'astra-child-theme' ),
						'icon'  => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'astra-child-theme' ),
						'icon'  => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'astra-child-theme' ),
						'icon'  => 'eicon-text-align-right',
					],
					'justify' => [
						'title' => __( 'Justify', 'astra-child-theme' ),
						'icon'  => 'eicon-text-align-justify',
					],
				],
				'default'      => 'left',
				'prefix_class' => 'elementor-align-',
				'selectors'    => [
					'{{WRAPPER}} .content_wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);



		// Title/Text color
		$this->add_control(
			'text_color',
			[
				'label'     => __( 'Heading Text Color', 'astra-child-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .testimonial-title' => 'color: {{VALUE}};',
				],
			]
		);

		// Paragraph Color
		$this->add_control(
			'paragraph_color',
			[
				'label'     => __( 'Paragraph Color', 'astra-child-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} p.testimonial-content' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => __( 'Slider Style', 'astra-child-theme' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		// Background
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name'     => 'background',
				'types'    => [ 'classic', 'gradient', 'video' ],
				'selector' => '{{WRAPPER}} .content_wrapper',
			]
		);

		// Border
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name'     => 'border',
				'selector' => '{{WRAPPER}} .content_wrapper',
			]
		);

		// Box Shadow
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name'     => 'box_shadow',
				'selector' => '{{WRAPPER}} .content_wrapper',
			]
		);

		// Margin
		$this->add_control(
			'margin',
			[
				'label'      => __( 'Margin', 'astra-child-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default' => [
					'top'      => 2,
					'right'    => 0,
					'bottom'   => 2,
					'left'     => 0,
					'unit'     => 'em',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .content_wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Padding
		$this->add_control(
			'padding',
			[
				'label'      => __( 'Padding', 'astra-child-theme' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em', 'rem' ],
				'default' => [
					'top'      => 2,
					'right'    => 2,
					'bottom'   => 2,
					'left'     => 2,
					'unit'     => 'em',
					'isLinked' => false,
				],
				'selectors'  => [
					'{{WRAPPER}} .content_wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Arrow color
		$this->add_control(
			'arrow_color',
			[
				'label'     => __( 'Arrow Color', 'astra-child-theme' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .elementor-swiper-button' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section(); // End Style
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		// Retrieve the testimonials.
		$query_args = [
			'post_type'      => 'testimonial',
			'posts_per_page' => $settings['number_of_testimonials'] ? $settings['number_of_testimonials'] : -1,
			'orderby'        => $settings['orderby'],
			'order'          => $settings['order'],
			'no_found_rows'  => true, // performance enhancement if pagination is not needed
		];

		$slides = get_posts( $query_args );

		if ( ! $slides ) {
			return; // No testimonials found; safely exit.
		}

		$show_dots   = in_array( $settings['navigation'], [ 'dots', 'both' ], true );
		$show_arrows = in_array( $settings['navigation'], [ 'arrows', 'both' ], true );
		$slides_count = count( $slides );
		$excerpt_length = ! empty( $settings['excerpt_length'] ) ? (int) $settings['excerpt_length'] : 20;

		// Prepare slider settings for data attribute.
		$slider_settings = [
			'slides_to_show'		=> $settings['slides_to_show'] ? $settings['slides_to_show'] : 4,
			'slides_to_show_tablet'	=> $settings['slides_to_show_tablet'] ? $settings['slides_to_show_tablet'] : 2,
			'slides_to_show_mobile'	=> $settings['slides_to_show_mobile'] ? $settings['slides_to_show_mobile'] : 1,
			'slides_to_scroll'    	=> $settings['slides_to_scroll'],
			'navigation'          	=> $settings['navigation'],
			'speed'               	=> $settings['transition_duration'],
			'autoplay'            	=> $settings['autoplay'],
			'pause_on_hover'      	=> $settings['pause_on_hover'],
			'pause_on_interaction' 	=> $settings['pause_on_interaction'],
			'infinite'            	=> $settings['infinite_loop'],
			'effect'           		=> $settings['effect'],
			'autoplay_speed'      	=> $settings['autoplay_speed'],
		];

		// Unique slider instance ID (to avoid collisions).
		$widget_id = uniqid( 'testimonial_slider_' );
		?>
		<div class="elementor-element elementor-element-<?php echo esc_attr( $widget_id ); ?> testimonial_slider elementor-widget e-widget-swiper"
		     data-id="<?php echo esc_attr( $widget_id ); ?>"
		     data-element_type="widget"
		     data-settings="<?php echo esc_attr( wp_json_encode( $slider_settings ) ); ?>"
		     data-widget_type="image-carousel.default">

			<div class="elementor-widget-container">
				<div class="elementor-image-carousel-wrapper swiper swiper-initialized swiper-horizontal" dir="ltr">
					<div class="elementor-image-carousel swiper-wrapper <?php echo ( $slides_count < (int) $settings['slides_to_show'] ) ? 'justify-center-d' : ''; ?>">
						<?php
						$i = 0;
						foreach ( $slides as $post ) :
							setup_postdata( $post );

							// Retrieve meta fields if needed
							$testimonial_title = get_post_meta( $post->ID, 'testimonial_title', true );
							$author_age = get_post_meta( $post->ID, 'author_age', true );
							$designation = get_post_meta( $post->ID, 'designation', true );

							// Generate the excerpt using `wp_trim_words()`
							$raw_content    = get_the_content( null, false, $post );
							$trimmed_excerpt = wp_trim_words( $raw_content, $excerpt_length, '...' );
							?>
							<div class="swiper-slide" data-swiper-slide-index="<?php echo esc_attr( $i++ ); ?>">
								<div class="testimonial">
									<div class="content_wrapper">
										<?php if ( $testimonial_title ) : ?>
											<h6 class="testimonial-title"><?php echo esc_html( $testimonial_title ); ?></h6>
										<?php endif; ?>
										<div class="testimonial-content">
											<!-- Display trimmed excerpt -->
											<p class="testimonial-content"><?php echo esc_html( $trimmed_excerpt ); ?></p>
										</div>
										<div class="testimonial-author">
										<p class="testimonial-author"><?php echo esc_html( get_the_title( $post ) ); ?>, <?php echo esc_html( $author_age ); ?></p>
										<p class="designation"><?php echo esc_html( $designation ); ?></p>
										</div>
									</div>
								</div>
							</div>
							<?php
						endforeach;
						wp_reset_postdata();
						?>
					</div>

					<?php if ( $slides_count > 1 ) : ?>
						<?php if ( $show_arrows ) : ?>
							<div class="elementor-swiper-button elementor-swiper-button-prev">
								<i aria-hidden="true" class="eicon-chevron-left"></i>
							</div>
							<div class="elementor-swiper-button elementor-swiper-button-next">
								<i aria-hidden="true" class="eicon-chevron-right"></i>
							</div>
						<?php endif; ?>
						<?php if ( $show_dots ) : ?>
							<div class="swiper-pagination <?php echo esc_attr( $widget_id ); ?>"></div>
						<?php endif; ?>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}

}
