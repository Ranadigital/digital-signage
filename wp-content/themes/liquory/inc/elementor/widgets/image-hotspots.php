<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Liquory_Elementor_Image_Hotspots_Widget extends Widget_Base {

    public function get_name() {
        return 'liquory-image-hotspots';
    }

    public function is_reload_preview_required() {
        return true;
    }

    public function get_title() {
        return 'Liquory Image Hotspots';
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-image-hotspot';
    }

    public function get_script_depends() {
        return [
            'tooltipster',
            'jquery-scrollbar',
            'liquory-elementor-image-hotspots'
        ];
    }

    public function get_style_depends() {
        return [
            'tooltipster',
            'jquery-scrollbar'
        ];
    }

    public function get_categories() {
        return array('liquory-addons');
    }

    protected function get_products_id() {
        $args    = array(
            'limit' => -1,
        );
        $results = array();
        if (class_exists('WooCommerce')) {
            $products = wc_get_products($args);
            if (!is_wp_error($products)) {
                foreach ($products as $product) {
                    $results[$product->get_id()] = $product->get_name();
                }
            }
        }

        return $results;
    }

    protected function register_controls() {

        /**START Background Image Section  **/
        $this->start_controls_section('image_hotspots_image_section',
            [
                'label' => esc_html__('Image', 'liquory'),
            ]
        );

        $this->add_control('image_hotspots_image',
            [
                'label'       => __('Choose Image', 'liquory'),
                'type'        => Controls_Manager::MEDIA,
                'default'     => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
                'label_block' => true
            ]
        );

        $this->add_group_control(
            Group_Control_Image_Size::get_type(),
            [
                'name'    => 'background_image', // Actually its `image_size`.
                'default' => 'full'
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_icons_settings',
            [
                'label' => esc_html__('Hotspots', 'liquory'),
            ]
        );

        $repeater = new Repeater();


        $repeater->add_control('image_hotspots_title',
            [
                'type'        => Controls_Manager::TEXT,
                'default'     => 'Hotspots tooltips title',
                'dynamic'     => ['active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_responsive_control('preimum_image_hotspots_main_icons_horizontal_position',
            [
                'label'      => esc_html__('Horizontal Position', 'liquory'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default'    => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.liquory-image-hotspots-main-icons' => 'left: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater->add_responsive_control('preimum_image_hotspots_main_icons_vertical_position',
            [
                'label'      => esc_html__('Vertical Position', 'liquory'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 200,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ],
                ],
                'default'    => [
                    'size' => 50,
                    'unit' => '%'
                ],
                'selectors'  => [
                    '{{WRAPPER}} {{CURRENT_ITEM}}.liquory-image-hotspots-main-icons' => 'top: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $repeater->add_control('image_hotspots_content',
            [
                'label'   => esc_html__('Content to Show', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'text_editor'         => esc_html__('Text Editor', 'liquory'),
                    'elementor_templates' => esc_html__('Elementor Template', 'liquory'),
                    'elementor_product'   => esc_html__('Product', 'liquory'),
                ],
                'default' => 'text_editor'
            ]
        );

        $repeater->add_control('image_hotspots_texts',
            [
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Lorem ipsum',
                'dynamic'     => ['active' => true],
                'label_block' => true,
                'condition'   => [
                    'image_hotspots_content' => 'text_editor'
                ]
            ]
        );

        $repeater->add_control('image_hotspots_templates',
            [
                'label'       => esc_html__('Teamplate', 'liquory'),
                'type'        => Controls_Manager::SELECT,
                'options'     => liquory_get_hotspots(),
                'description' => esc_html__('Size chart will take templates name prefix is "Hotspots"', 'liquory'),
                'condition'   => [
                    'image_hotspots_content' => 'elementor_templates'
                ],
            ]
        );

        $repeater->add_control('image_hotspots_product',
            [
                'label'     => __('Product id', 'liquory'),
                'type'      => Controls_Manager::SELECT2,
                'options'   => $this->get_products_id(),
                'condition' => [
                    'image_hotspots_content' => 'elementor_product'
                ],
            ]
        );

        $repeater->add_control('image_hotspots_info',
            [
                'label'       => esc_html__('Infomation', 'liquory'),
                'type'        => Controls_Manager::TEXTAREA,
                'default'     => 'Lorem ipsum',
                'dynamic'     => ['active' => true],
                'label_block' => true,
            ]
        );

        $repeater->add_control('image_hotspots_link_switcher',
            [
                'label'       => esc_html__('Link', 'liquory'),
                'type'        => Controls_Manager::SWITCHER,
                'description' => esc_html__('Add a custom link or select an existing page link', 'liquory'),
            ]
        );

        $repeater->add_control('image_hotspots_url',
            [
                'label'       => esc_html__('URL', 'liquory'),
                'type'        => Controls_Manager::URL,
                'condition'   => [
                    'image_hotspots_link_switcher' => 'yes',
                ],
                'placeholder' => 'https://themelexus.com/',
                'label_block' => true
            ]
        );

        $this->add_control('image_hotspots',
            [
                'label'       => esc_html__('Hotspots', 'liquory'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ image_hotspots_title }}}',
            ]
        );

        $this->add_control('image_hotspots_infomation_show',
            [
                'label' => esc_html__('Show infomation', 'liquory'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->add_control('image_hotspots_icons_animation',
            [
                'label' => esc_html__('Radar Animation', 'liquory'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_tooltips_section',
            [
                'label' => esc_html__('Tooltips', 'liquory'),
            ]
        );

        $this->add_control(
            'image_hotspots_trigger_type',
            [
                'label'   => esc_html__('Trigger', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'click' => esc_html__('Click', 'liquory'),
                    'hover' => esc_html__('Hover', 'liquory'),
                ],
                'default' => 'hover'
            ]
        );

        $this->add_control(
            'image_hotspots_arrow',
            [
                'label'     => esc_html__('Show Arrow', 'liquory'),
                'type'      => Controls_Manager::SWITCHER,
                'label_on'  => esc_html__('Show', 'liquory'),
                'label_off' => esc_html__('Hide', 'liquory'),
            ]
        );

        $this->add_control(
            'image_hotspots_tooltips_position',
            [
                'label'       => esc_html__('Positon', 'liquory'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => [
                    'top'    => esc_html__('Top', 'liquory'),
                    'bottom' => esc_html__('Bottom', 'liquory'),
                    'left'   => esc_html__('Left', 'liquory'),
                    'right'  => esc_html__('Right', 'liquory'),
                ],
                'description' => esc_html__('Sets the side of the tooltip. The value may one of the following: \'top\', \'bottom\', \'left\', \'right\'. It may also be an array containing one or more of these values. When using an array, the order of values is taken into account as order of fallbacks and the absence of a side disables it', 'liquory'),
                'default'     => ['top', 'bottom'],
                'label_block' => true,
                'multiple'    => true
            ]
        );

        $this->add_control('image_hotspots_tooltips_distance_position',
            [
                'label'   => esc_html__('Spacing', 'liquory'),
                'type'    => Controls_Manager::NUMBER,
                'title'   => esc_html__('The distance between the origin and the tooltip in pixels, default is 6', 'liquory'),
                'default' => 6,
            ]
        );

        $this->add_control('image_hotspots_min_width',
            [
                'label'       => esc_html__('Min Width', 'liquory'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                ],
                'description' => esc_html__('Set a minimum width for the tooltip in pixels, default: 0 (auto width)', 'liquory'),
            ]
        );

        $this->add_control('image_hotspots_max_width',
            [
                'label'       => esc_html__('Max Width', 'liquory'),
                'type'        => Controls_Manager::SLIDER,
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 800,
                    ],
                ],
                'description' => esc_html__('Set a maximum width for the tooltip in pixels, default: null (no max width)', 'liquory'),
            ]
        );

        $this->add_responsive_control('image_hotspots_tooltips_wrapper_height',
            [
                'label'       => esc_html__('Height', 'liquory'),
                'type'        => Controls_Manager::SLIDER,
                'size_units'  => ['px', 'em', '%'],
                'range'       => [
                    'px' => [
                        'min' => 0,
                        'max' => 500,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 20,
                    ]
                ],
                'label_block' => true,
                'selectors'   => [
                    '.tooltipster-box.tooltipster-box-{{ID}}' => 'height: {{SIZE}}{{UNIT}} !important;'
                ]
            ]
        );

        $this->add_control('image_hotspots_anim',
            [
                'label'       => esc_html__('Animation', 'liquory'),
                'type'        => Controls_Manager::SELECT,
                'options'     => [
                    'fade'  => esc_html__('Fade', 'liquory'),
                    'grow'  => esc_html__('Grow', 'liquory'),
                    'swing' => esc_html__('Swing', 'liquory'),
                    'slide' => esc_html__('Slide', 'liquory'),
                    'fall'  => esc_html__('Fall', 'liquory'),
                ],
                'default'     => 'fade',
                'label_block' => true,
            ]
        );

        $this->add_control('image_hotspots_anim_dur',
            [
                'label'   => esc_html__('Animation Duration', 'liquory'),
                'type'    => Controls_Manager::NUMBER,
                'title'   => esc_html__('Set the animation duration in milliseconds, default is 350', 'liquory'),
                'default' => 350,
            ]
        );

        $this->add_control('image_hotspots_delay',
            [
                'label'   => esc_html__('Delay', 'liquory'),
                'type'    => Controls_Manager::NUMBER,
                'title'   => esc_html__('Set the animation delay in milliseconds, default is 10', 'liquory'),
                'default' => 10,
            ]
        );

        $this->add_control('image_hotspots_hide',
            [
                'label'        => esc_html__('Hide on Mobiles', 'liquory'),
                'type'         => Controls_Manager::SWITCHER,
                'label_on'     => 'Show',
                'label_off'    => 'Hide',
                'description'  => esc_html__('Hide tooltips on mobile phones', 'liquory'),
                'return_value' => true,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_image_style_settings',
            [
                'label' => esc_html__('Image', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_hotspots_image_border',
                'selector' => '{{WRAPPER}} .liquory-image-hotspots-container .liquory-addons-image-hotspots-ib-img',
            ]
        );

        $this->add_control('image_hotspots_image_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'liquory'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .liquory-image-hotspots-container .liquory-addons-image-hotspots-ib-img' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('image_hotspots_image_padding',
            [
                'label'      => esc_html__('Padding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .liquory-image-hotspots-container .liquory-addons-image-hotspots-ib-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );
        $this->add_responsive_control(
            'image_hotspots_image_align',
            [
                'label'     => __('Text Alignment', 'liquory'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'liquory'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'liquory'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'liquory'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .liquory-image-hotspots-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('image_hotspots_tooltips_style_settings',
            [
                'label' => esc_html__('Tooltips', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control('image_hotspots_tooltips_wrapper_color',
            [
                'label'     => esc_html__('Text Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .liquory-image-hotspots-tooltips-text' => 'color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'image_hotspots_tooltips_wrapper_typo',
                'selector' => '.tooltipster-box.tooltipster-box-{{ID}} .liquory-image-hotspots-tooltips-text, .liquory-image-hotspots-tooltips-text-{{ID}}'
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'image_hotspots_tooltips_content_text_shadow',
                'selector' => '.tooltipster-box.tooltipster-box-{{ID}} .liquory-image-hotspots-tooltips-text'
            ]
        );

        $this->add_control('image_hotspots_tooltips_wrapper_background_color',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content'                                 => 'background: {{VALUE}};',
                    '.tooltipster-base.tooltipster-top .tooltipster-arrow-{{ID}} .tooltipster-arrow-background'    => 'border-top-color: {{VALUE}};',
                    '.tooltipster-base.tooltipster-bottom .tooltipster-arrow-{{ID}} .tooltipster-arrow-background' => 'border-bottom-color: {{VALUE}};',
                    '.tooltipster-base.tooltipster-right .tooltipster-arrow-{{ID}} .tooltipster-arrow-background'  => 'border-right-color: {{VALUE}};',
                    '.tooltipster-base.tooltipster-left .tooltipster-arrow-{{ID}} .tooltipster-arrow-background'   => 'border-left-color: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'image_hotspots_tooltips_wrapper_border',
                'selector' => '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content'
            ]
        );

        $this->add_control('image_hotspots_tooltips_wrapper_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'liquory'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content' => 'border-radius: {{SIZE}}{{UNIT}}'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_hotspots_tooltips_wrapper_box_shadow',
                'selector' => '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content'
            ]
        );

        $this->add_responsive_control('image_hotspots_tooltips_wrapper_margin',
            [
                'label'      => esc_html__('Margin', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content, .tooltipster-arrow-{{ID}}' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('image_hotspots_tooltips_wrapper_padding',
            [
                'label'      => esc_html__('Padding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '.tooltipster-box.tooltipster-box-{{ID}} .tooltipster-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section('img_hotspots_container_style',
            [
                'label' => esc_html__('Container', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control('img_hotspots_container_background',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .liquory-image-hotspots-container' => 'background: {{VALUE}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'img_hotspots_container_border',
                'selector' => '{{WRAPPER}} .liquory-image-hotspots-container',
            ]
        );

        $this->add_control('img_hotspots_container_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'liquory'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .liquory-image-hotspots-container' => 'border-radius: {{SIZE}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'img_hotspots_container_box_shadow',
                'selector' => '{{WRAPPER}} .liquory-image-hotspots-container',
            ]
        );

        $this->add_responsive_control('img_hotspots_container_margin',
            [
                'label'      => esc_html__('Margin', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .liquory-image-hotspots-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('img_hotspots_container_padding',
            [
                'label'      => esc_html__('Paddding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .liquory-image-hotspots-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->end_controls_section();
    }

    protected function render($instance = []) {
        // get our input from the widget settings.
        $settings        = $this->get_settings_for_display();
        $animation_class = '';
        if ($settings['image_hotspots_icons_animation'] == 'yes') {
            $animation_class = 'liquory-image-hotspots-anim';
        }

        $image_src = $settings['image_hotspots_image'];

        $image_src_size = Group_Control_Image_Size::get_attachment_image_src($image_src['id'], 'background_image', $settings);
        if (empty($image_src_size)) {
            $image_src_size = $image_src['url'];
        }

        $image_hotspots_settings = [
            'anim'        => $settings['image_hotspots_anim'],
            'animDur'     => !empty($settings['image_hotspots_anim_dur']) ? $settings['image_hotspots_anim_dur'] : 350,
            'delay'       => !empty($settings['image_hotspots_anim_delay']) ? $settings['image_hotspots_anim_delay'] : 10,
            'arrow'       => ($settings['image_hotspots_arrow'] == 'yes') ? true : false,
            'distance'    => !empty($settings['image_hotspots_tooltips_distance_position']) ? $settings['image_hotspots_tooltips_distance_position'] : 6,
            'minWidth'    => !empty($settings['image_hotspots_min_width']['size']) ? $settings['image_hotspots_min_width']['size'] : 0,
            'maxWidth'    => !empty($settings['image_hotspots_max_width']['size']) ? $settings['image_hotspots_max_width']['size'] : 'null',
            'side'        => !empty($settings['image_hotspots_tooltips_position']) ? $settings['image_hotspots_tooltips_position'] : array(
                'right',
                'left'
            ),
            'hideMobiles' => ($settings['image_hotspots_hide'] == true) ? true : false,
            'trigger'     => $settings['image_hotspots_trigger_type'],
            'id'          => $this->get_id()
        ];
        ?>

        <?php if ($settings['image_hotspots_infomation_show'] == 'yes'): ?>
            <div class="liquory-image-hotspots-accordion">
                <div class="liquory-image-hotspots-accordion-inner">
                    <div class="elementor-accordion scrollbar-inner" role="tablist">
                        <?php
                        foreach ($settings['image_hotspots'] as $index => $item) :
                            $tab_count = $index + 1;

                            $tab_title_setting_key = $this->get_repeater_setting_key('image_hotspots_texts', 'image_hotspots', $index);

                            $tab_content_setting_key = $this->get_repeater_setting_key('image_hotspots_info', 'image_hotspots', $index);

                            $this->add_render_attribute($tab_title_setting_key, [
                                'id'            => 'elementor-tab-title-' . $item['_id'],
                                'class'         => ['elementor-tab-title'],
                                'tabindex'      => $item['_id'],
                                'data-tab'      => $tab_count,
                                'role'          => 'tab',
                                'aria-controls' => 'elementor-tab-content-' . $item['_id'],
                            ]);

                            $this->add_render_attribute($tab_content_setting_key, [
                                'id'              => 'elementor-tab-content-' . $item['_id'],
                                'class'           => ['elementor-tab-content', 'elementor-clearfix'],
                                'data-tab'        => $tab_count,
                                'role'            => 'tabpanel',
                                'aria-labelledby' => 'elementor-tab-title-' . $item['_id'],
                            ]);

                            $this->add_inline_editing_attributes($tab_content_setting_key, 'advanced'); ?>
                            <div class="elementor-accordion-item">
                                <div <?php $this->print_render_attribute_string($tab_title_setting_key); ?>>
                                    <?php $this->print_unescaped_setting($item['image_hotspots_title']); ?>
                                </div>

                                <div <?php $this->print_render_attribute_string($tab_content_setting_key); ?>>
                                    <?php $this->print_unescaped_setting($item['image_hotspots_info']); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div id="liquory-image-hotspots-<?php echo esc_attr($this->get_id()); ?>"
             class="liquory-image-hotspots-container"
             data-settings='<?php echo wp_json_encode($image_hotspots_settings); ?>'>
            <img class="liquory-addons-image-hotspots-ib-img" alt="Background" src="<?php echo esc_url($image_src_size); ?>">
            <?php foreach ($settings['image_hotspots'] as $index => $item) {
                $list_item_key = 'img_hotspot_' . $index;
                $this->add_render_attribute($list_item_key, 'class',
                    [
                        $animation_class,
                        'liquory-image-hotspots-main-icons',
                        'elementor-repeater-item-' . $item['_id'],
                        'tooltip-wrapper',
                        'liquory-image-hotspots-main-icons-' . $item['_id']
                    ]);
                $this->add_render_attribute($list_item_key, 'data-tab', '#elementor-tab-title-' . $item['_id']); ?>
                <div <?php $this->print_render_attribute_string($list_item_key); ?>
                        data-tooltip-content="#tooltip-content-<?php echo esc_attr($index); ?>">
                    <?php
                    if ($item['image_hotspots_url']['url']) {
                        $link_url = $item['image_hotspots_url']['url'];
                    }
                    if ($item['image_hotspots_link_switcher'] == 'yes' && $settings['image_hotspots_trigger_type'] == 'hover') : ?>
                        <a class="liquory-image-hotspots-tooltips-link" href="<?php echo esc_url($link_url); ?>"
                           <?php if (!empty($item['image_hotspots_url']['is_external'])) : ?>target="_blank"
                           <?php endif; ?><?php if (!empty($item['image_hotspots_url']['nofollow'])) : ?>rel="nofollow"<?php endif; ?>>
                            <i class="liquory-image-hotspots-icon"></i>
                        </a>
                    <?php else : ?>
                        <i class="liquory-image-hotspots-icon"></i>
                    <?php endif; ?>

                    <div class="liquory-image-hotspots-tooltips-wrapper">
                        <div id="tooltip-content-<?php echo esc_attr($index); ?>" class="tooltip-content liquory-image-hotspots-tooltips-text liquory-image-hotspots-tooltips-text-<?php echo esc_attr($this->get_id()); ?>">
                            <?php
                            if ($item['image_hotspots_content'] == 'elementor_templates') {
                                $slug         = $item['image_hotspots_templates'];
                                $queried_post = get_page_by_path($slug, OBJECT, 'elementor_library');

                                if (isset($queried_post->ID)) {
                                    echo Plugin::instance()->frontend->get_builder_content($queried_post->ID);
                                }
                            } elseif (($item['image_hotspots_content'] == 'elementor_product') && liquory_is_woocommerce_activated()) {
                                $product = wc_get_product($item['image_hotspots_product']);
                                if ($product) {
                                    echo '<a href="' . $product->get_permalink() . '" title="' . $product->get_title() . '">' . $product->get_image() . '</a>';
                                    echo '<h4><a href="' . $product->get_permalink() . '" title="' . $product->get_title() . '">' . $product->get_title() . '</a></h4>';
                                    echo '<div class="price">' . $product->get_price_html() . '</div>';
                                }
                            } else {
                                $this->print_unescaped_setting($item['image_hotspots_texts']);
                            } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>

        <?php
    }
}

$widgets_manager->register(new Liquory_Elementor_Image_Hotspots_Widget());
