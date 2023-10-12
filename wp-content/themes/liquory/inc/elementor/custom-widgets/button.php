<?php
// Button
use Elementor\Controls_Manager;

add_action('elementor/element/button/section_button/before_section_end', function ($element, $args) {
    $element->add_control(
        'button_link_style',
        [
            'label'     => esc_html__('Enable Button Link', 'liquory'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'button-link-',
            'separator'   => 'before',
        ]
    );
}, 1, 2);

add_action( 'elementor/element/button/section_style/after_section_end', function ($element, $args ) {

    $element->update_control(
        'background_color',
        [
            'global' => [
                'default' => '',
            ],
			'selectors' => [
				'{{WRAPPER}} .elementor-button' => ' background-color: {{VALUE}};',
			],
        ]
    );
}, 10, 2 );

add_action('elementor/element/button/section_style/before_section_end', function ($element, $args) {

    $element->add_control(
        'button_line_style',
        [
            'label'     => esc_html__('Line Button', 'liquory'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'button-line-',
            'separator'   => 'before',
        ]
    );

    $element->add_control(
        'icon_button_size',
        [
            'label' => esc_html__('Icon Size', 'liquory'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 6,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .elementor-button .elementor-button-icon'   => 'display: flex; align-items: center;',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );
    $element->add_control(
        'button_icon_color',
        [
            'label'     => esc_html__('Icon Color', 'liquory'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}}.button-link-yes .elementor-button .elementor-button-content-wrapper:after' => 'background-color: {{VALUE}};',
                '{{WRAPPER}}.button-link-yes .elementor-button .elementor-button-content-wrapper:before' => 'border-top-color: {{VALUE}}; border-right-color: {{VALUE}};',
            ],

        ]
    );

    $element->add_control(
        'button_icon_color_hover',
        [
            'label'     => esc_html__('Icon Color Hover', 'liquory'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}}.button-link-yes .elementor-button:hover .elementor-button-content-wrapper:after' => 'background-color: {{VALUE}};',
                '{{WRAPPER}}.button-link-yes .elementor-button:hover .elementor-button-content-wrapper:before' => 'border-top-color: {{VALUE}}; border-right-color: {{VALUE}};',
            ],

        ]
    );
}, 10, 2);




