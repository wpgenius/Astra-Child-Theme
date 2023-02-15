<?php

namespace Elementor;

class WPG_widget extends Widget_Base {

	public function get_name() {
		return 'wpg-widget';
	}

	public function get_title() {
		return 'WPG widget';
	}

	public function get_icon() {
		return 'eicon-photo-library';
	}

	public function get_categories() {
		return [ 'basic' ];
	}

	public function get_style_depends() {
	  //$styles = [ 'lightgallery-combined' ];

	  return $styles;
	}

	public function get_script_depends() {
	  //$scripts = [ 'lightgallery-medium-zoom' ];

	  return $scripts;
	}

	protected function register_controls() {

		$this->start_controls_section(
			'section_title',
			[
				'label' => __( 'WPG widget', 'elementor' ),
			]
		);

		$this->add_control(
			'gallery_options',
			[
				'label' => esc_html__( 'WPG Control Settings', 'elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'wpg_active_background_color',
			[
				'label' => esc_html__( 'Background Color', 'plugin-name' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => array(
					'.is-checked' => 'background-color: {{VALUE}};',
				),
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();
		$plugins = array();
        //$settings["wpg_active_background_color"] 
	}

	protected function content_template() {
	    echo " Enter template code. ";
       
    }

}
