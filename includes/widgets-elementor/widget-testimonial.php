<?php

namespace Elementor;

class WPG_Elementor_Testimonial_Widget extends Widget_Base {

	public function get_name() {
		return 'testimonial-slider';
	}

	public function get_title() {
		return 'Testimonial Slider';
	}

	public function get_icon() {
		return 'eicon-media-carousel';
	}

	public function get_categories() {
		return array( 'basic' );
	}

	public function get_style_depends() {
		$styles = array( 'swiper' );

		return $styles;
	}

	public function get_script_depends() {
		$scripts = array();
		return $scripts;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title',
			array(
				'label' => __( 'Testimonial Slider', 'astra-child-theme' ),
			)
		);

		$this->add_control(
			'slide_to_show',
			array(
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => esc_html__( 'Slide to Show', 'testimonials' ),
				'options' => array(
					'1' => esc_html__( '1', 'astra-child-theme' ),
					'2' => esc_html__( '2', 'astra-child-theme' ),
					'3' => esc_html__( '3', 'astra-child-theme' ),
					'4' => esc_html__( '4', 'astra-child-theme' ),
					'5' => esc_html__( '5', 'astra-child-theme' ),
					'6' => esc_html__( '6', 'astra-child-theme' ),
					'7' => esc_html__( '7', 'astra-child-theme' ),
					'8' => esc_html__( '8', 'astra-child-theme' ),
				),
				'default' => '3',
			)
		);

		$this->add_control(
			'slide_to_scroll',
			array(
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => esc_html__( 'Slide to Scroll', 'testimonials' ),
				'options' => array(
					'1' => esc_html__( '1', 'astra-child-theme' ),
					'2' => esc_html__( '2', 'astra-child-theme' ),
					'3' => esc_html__( '3', 'astra-child-theme' ),
					'4' => esc_html__( '4', 'astra-child-theme' ),
					'5' => esc_html__( '5', 'astra-child-theme' ),
					'6' => esc_html__( '6', 'astra-child-theme' ),
					'7' => esc_html__( '7', 'astra-child-theme' ),
					'8' => esc_html__( '8', 'astra-child-theme' ),
				),
				'default' => '3',
			)
		);

		$this->add_control(
			'navigation',
			array(
				'type'    => \Elementor\Controls_Manager::SELECT,
				'label'   => esc_html__( 'Navigation', 'testimonials' ),
				'options' => array(
					'dots'   => esc_html__( 'Dots', 'astra-child-theme' ),
					'arrows' => esc_html__( 'Arrows', 'astra-child-theme' ),
					'both'   => esc_html__( 'Arrows and Dots', 'astra-child-theme' ),
					'none'   => esc_html__( 'None', 'astra-child-theme' ),
				),
				'default' => 'dots',
			)
		);

		$this->add_control(
			'transition_duration',
			array(
				'label'   => esc_html__( 'Transition Duration', 'plugin-name' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 10000,
				'step'    => 50,
				'default' => 500,
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'plugin-name' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astra-child-theme' ),
				'label_off'    => esc_html__( 'No', 'astra-child-theme' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'infinite_loop',
			array(
				'label'        => esc_html__( 'Infinite Loop', 'plugin-name' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astra-child-theme' ),
				'label_off'    => esc_html__( 'No', 'astra-child-theme' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'pause_on_hover',
			array(
				'label'        => esc_html__( 'Pause on Hover', 'plugin-name' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astra-child-theme' ),
				'label_off'    => esc_html__( 'No', 'astra-child-theme' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->add_control(
			'pause_on_interception',
			array(
				'label'        => esc_html__( 'Pause on Interception', 'plugin-name' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'astra-child-theme' ),
				'label_off'    => esc_html__( 'No', 'astra-child-theme' ),
				'return_value' => 'yes',
				'default'      => 'no',
			)
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		$mypost = get_posts(
			array(
				'post_type'   => 'testimonial',
				'numberposts' => 100,
				'orderby'     => 'rand',
				'order'       => 'rand',
			)
		);

		if ( $mypost ) {
				$setting = array(
					'slides_to_show'       => $settings['slide_to_show'],
					'slides_to_scroll'     => $settings['slide_to_scroll'],
					'navigation'           => $settings['navigation'],
					'speed'                => $settings['transition_duration'],
					'autoplay'             => $settings['autoplay'],
					'infinite'             => $settings['infinite_loop'],
					'pause_on_hover'       => $settings['pause_on_hover'],
					'pause_on_interaction' => $settings['pause_on_interception'],
					'show_arrows'          => 'yes',
					'_animation'           => 'fadeIn',
					'autoplay_speed'       => 2500,
				);

				 $id = 'acs' . rand();
				?>
			<div class="elementor-element elementor-element-<?php echo $id; ?> venues_slider animated-fast elementor-arrows-position-outside elementor-widget elementor-widget-image-carousel animated fadeIn e-widget-swiper" data-id="<?php echo $id; ?>" data-element_type="widget" data-settings=<?php echo json_encode( $setting ); ?> data-widget_type="image-carousel.default">
				<div class="elementor-widget-container">
					<style>/*! elementor - v3.12.2 - 23-04-2023 */
						.elementor-widget-image-carousel .swiper,.elementor-widget-image-carousel .swiper-container{position:static}.elementor-widget-image-carousel .swiper-container .swiper-slide figure,.elementor-widget-image-carousel .swiper .swiper-slide figure{line-height:inherit}.elementor-widget-image-carousel .swiper-slide{text-align:center}.elementor-image-carousel-wrapper:not(.swiper-container-initialized) .swiper-slide,.elementor-image-carousel-wrapper:not(.swiper-initialized) .swiper-slide{max-width:calc(100% / var(--e-image-carousel-slides-to-show, <? echo $settings['slide_to_show']; ?>))}
					</style>
					<div class="elementor-image-carousel-wrapper swiper swiper-initialized swiper-horizontal swiper-pointer-events" dir="ltr">
						<div class="elementor-image-carousel swiper-wrapper">
						<?php
						$i = 0;
						foreach ( $mypost as $post ) {
							setup_postdata( $post );
							$thumbnail = get_the_post_thumbnail_url( $post, 'post-thumbnail' );
							?>
							<div class="swiper-slide" data-swiper-slide-index="<?php echo $i++; ?>">
								<div class="testimonial">
									<div class="content_wrapper">
										<div class="testimonial-content">
											<p><?php echo get_the_content( $post ); ?></p>
										</div>
									<div class="testimonial-title">
										<h5 class="testimonial-title"><?php echo get_the_title( $post ); ?></h5>
									</div>
									</div>
								</div>

							</div>
							<?php
						}
						?>
						</div>
						<div class="elementor-swiper-button elementor-swiper-button-prev"><i aria-hidden="true" class="eicon-chevron-left"></i></div>
						<div class="elementor-swiper-button elementor-swiper-button-next "><i aria-hidden="true" class="eicon-chevron-right"></i></div>
						<div class="swiper-pagination <?php echo $id; ?>"></div>
					</div>
				</div>
			</div>
			<!-- Add Arrows -->
			  <?php
				wp_reset_postdata();
		}

	}

	protected function content_template() {
		$mypost = get_posts(
			array(
				'post_type'   => 'testimonial',
				'numberposts' => 100,
				'orderby'     => 'rand',
				'order'       => 'rand',
			)
		);

		?>

		<div class="elementor-element  venues_slider animated-fast elementor-arrows-position-outside elementor-widget elementor-widget-image-carousel animated fadeIn e-widget-swiper"  data-element_type="widget" data-widget_type="image-carousel.default">

			<div class="elementor-image-carousel-wrapper swiper-container elementor-swiper" dir="ltr">
				<div class="elementor-image-carousel swiper-wrapper">
				<?php
				$i = 0;
				foreach ( $mypost as $post ) {
					setup_postdata( $post );
					$thumbnail = get_the_post_thumbnail_url( $post, 'post-thumbnail' );
					?>
					<div class="swiper-slide" data-swiper-slide-index="<?php echo $i++; ?>">
						<div class="testimonial">
							<div class="content_wrapper">
								<div class="testimonial-content">
									<p><?php echo get_the_content( $post ); ?></p>
								</div>
							<div class="testimonial-title">
								<h5 class="testimonial-title"><?php echo get_the_title( $post ); ?></h5>
							</div>
							</div>
						</div>

					</div>
					<?php
				}
				?>
				</div>
				<div class="elementor-swiper-button elementor-swiper-button-prev"><i aria-hidden="true" class="eicon-chevron-left"></i></div>
				<div class="elementor-swiper-button elementor-swiper-button-next "><i aria-hidden="true" class="eicon-chevron-right"></i></div>

				<div class="swiper-pagination <?php echo $id; ?>"></div>

			</div>

		</div>

		<?php
	}

}
