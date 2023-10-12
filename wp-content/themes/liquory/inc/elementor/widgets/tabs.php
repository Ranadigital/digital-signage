<?php

namespace Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Core\Schemes;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Liquory_Elementor_Tabs extends Widget_Base {

    public function get_categories() {
        return array('liquory-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'liquory-tabs';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('liquory Tabs', 'liquory');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    /**
     * Get widget keywords.
     *
     * Retrieve the list of keywords the widget belongs to.
     *
     * @return array Widget keywords.
     * @since 2.1.0
     * @access public
     *
     */
    public function get_keywords() {
        return ['tabs', 'accordion', 'toggle'];
    }

    /**
     * Get HTML wrapper class.
     *
     * Retrieve the widget container class. Can be used to override the
     * container class for specific widgets.
     *
     * @since 2.0.9
     * @access protected
     */
    protected function get_html_wrapper_class() {
        return 'elementor-widget-' . $this->get_name() . ' elementor-widget-tabs';
    }

    public function get_script_depends() {
        return ['liquory-elementor-tabs'];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {

        $templates = Plugin::instance()->templates_manager->get_source('local')->get_items();

        $options = [
            '0' => '— ' . esc_html__('Select', 'liquory') . ' —',
        ];

        $types = [];

        foreach ($templates as $template) {
            $options[$template['template_id']] = $template['title'] . ' (' . $template['type'] . ')';
            $types[$template['template_id']]   = $template['type'];
        }

        $this->start_controls_section(
            'section_tabs',
            [
                'label' => esc_html__('Tabs', 'liquory'),
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'tab_title',
            [
                'label'       => esc_html__('Title', 'liquory'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('Tab Title', 'liquory'),
                'placeholder' => esc_html__('Tab Title', 'liquory'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'tab_icon',
            [
                'label'     => esc_html__('Tab Icon', 'liquory'),
                'type'      => Controls_Manager::ICONS,
            ]
        );

        $repeater->add_control(
            'source',
            [
                'label'   => esc_html__('Source', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'html',
                'options' => [
                    'html'     => esc_html__('HTML', 'liquory'),
                    'template' => esc_html__('Template', 'liquory')
                ]
            ]
        );

        $repeater->add_control(
            'tab_template',
            [
                'label'       => esc_html__('Choose Template', 'liquory'),
                'default'     => 0,
                'type'        => Controls_Manager::SELECT,
                'options'     => $options,
                'types'       => $types,
                'label_block' => 'true',
                'condition'   => [
                    'source' => 'template',
                ],
            ]
        );

        $repeater->add_control(
            'tab_content',
            [
                'label'       => esc_html__('Content', 'liquory'),
                'default'     => esc_html__('Tab Content', 'liquory'),
                'placeholder' => esc_html__('Tab Content', 'liquory'),
                'type'        => Controls_Manager::WYSIWYG,
                'show_label'  => false,
                'condition'   => [
                    'source' => 'html',
                ],
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'       => esc_html__('Tabs Items', 'liquory'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'tab_title'   => esc_html__('Tab #1', 'liquory'),
                        'tab_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'liquory'),
                    ],
                    [
                        'tab_title'   => esc_html__('Tab #2', 'liquory'),
                        'tab_content' => esc_html__('Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'liquory'),
                    ],
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_control(
            'view',
            [
                'label'   => esc_html__('View', 'liquory'),
                'type'    => Controls_Manager::HIDDEN,
                'default' => 'traditional',
            ]
        );

        $this->add_control(
            'type',
            [
                'label'        => esc_html__('Type', 'liquory'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'horizontal',
                'options'      => [
                    'horizontal' => esc_html__('Horizontal', 'liquory'),
                    'vertical'   => esc_html__('Vertical', 'liquory'),
                ],
                'prefix_class' => 'elementor-tabs-view-',
                'separator'    => 'before',
            ]
        );

        $this->add_control(
            'tabs_align_horizontal',
            [
                'label' => esc_html__( 'Alignment', 'liquory' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'Start', 'liquory' ),
                        'icon' => 'eicon-h-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'liquory' ),
                        'icon' => 'eicon-h-align-center',
                    ],
                    'end' => [
                        'title' => esc_html__( 'End', 'liquory' ),
                        'icon' => 'eicon-h-align-right',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Justified', 'liquory' ),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'prefix_class' => 'elementor-tabs-alignment-',
                'condition' => [
                    'type' => 'horizontal',
                ],
            ]
        );

        $this->add_control(
            'tabs_align_vertical',
            [
                'label' => esc_html__( 'Alignment', 'liquory' ),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    '' => [
                        'title' => esc_html__( 'Start', 'liquory' ),
                        'icon' => 'eicon-v-align-top',
                    ],
                    'center' => [
                        'title' => esc_html__( 'Center', 'liquory' ),
                        'icon' => 'eicon-v-align-middle',
                    ],
                    'end' => [
                        'title' => esc_html__( 'End', 'liquory' ),
                        'icon' => 'eicon-v-align-bottom',
                    ],
                    'stretch' => [
                        'title' => esc_html__( 'Justified', 'liquory' ),
                        'icon' => 'eicon-v-align-stretch',
                    ],
                ],
                'prefix_class' => 'elementor-tabs-alignment-',
                'condition' => [
                    'type' => 'vertical',
                ],
            ]
        );
        $this->end_controls_section();

        $this->start_controls_section(
            'section_tabs_style',
            [
                'label' => esc_html__('Tabs', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'heading_title',
            [
                'label' => esc_html__('Title', 'liquory'),
                'type'  => Controls_Manager::HEADING,
            ]
        );
        $this->add_control(
            'navigation_width',
            [
                'label'     => esc_html__('Navigation Width', 'liquory'),
                'type'      => Controls_Manager::SLIDER,
                'default'   => [
                    'unit' => '%',
                ],
                'range'     => [
                    '%' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'width: {{SIZE}}{{UNIT}}',
                ],
                'condition' => [
                    'type' => 'vertical',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_typography',
                'selector' => '{{WRAPPER}}.elementor-widget-tabs .elementor-tab-title',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_ACCENT,
                ],
            ]
        );

        $this->start_controls_tabs('tabs_carousel_dots_style');

        $this->start_controls_tab(
            'tab_title_color_normal',
            [
                'label' => esc_html__('Normal', 'liquory'),
            ]
        );

        $this->add_control(
            'tab_color',
            [
                'label'     => esc_html__('Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'tab_title_background_color',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'border_color_title',
            [
                'label' => esc_html__( 'Border Color','liquory' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs .elementor-tab-title' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_type!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'tab_iconcolor',
            [
                'label'     => esc_html__('Icon Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_color_hover',
            [
                'label' => esc_html__('Hover', 'liquory'),
            ]
        );

        $this->add_control(
            'tab_hover_color',
            [
                'label'     => esc_html__('Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title:hover' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'tab_title_background_hover_color',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-titlehover' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'border_color_title_hover',
            [
                'label' => esc_html__( 'Border Color','liquory' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs .elementor-tab-title:hover' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_type!' => 'none',
                ],
            ]
        );



        $this->add_control(
            'tab_iconcolor_hover',
            [
                'label'     => esc_html__('Icon Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title:hover i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_color_active',
            [
                'label' => esc_html__('Active', 'liquory'),
            ]
        );

        $this->add_control(
            'tab_active_color',
            [
                'label'     => esc_html__('Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title.elementor-active' => 'color: {{VALUE}};'
                ],
            ]
        );

        $this->add_control(
            'tab_title_background_active_color',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title.elementor-active' => 'background-color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'border_color_title_active',
            [
                'label' => esc_html__( 'Border Color','liquory' ),
                'type' => Controls_Manager::COLOR,
                'default' => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs .elementor-tab-title.elementor-active' => 'border-color: {{VALUE}};',
                ],
                'condition' => [
                    'border_type!' => 'none',
                ],
            ]
        );

        $this->add_control(
            'tab_iconcolor_active',
            [
                'label'     => esc_html__('Icon Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title.elementor-active i' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__( 'Icon Size', 'liquory' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => [ 'px', '%'],

                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title i' => 'font-size: {{SIZE}}{{UNIT}}',
                ],
            ]
        );



        $this->add_control(
            'border_type',
            [
                'label'      => esc_html__('Border Type', 'liquory'),
                'type' => Controls_Manager::SELECT,
                'options' => [
                    'none' => esc_html__( 'None', 'liquory' ),
                    'solid' => esc_html__( 'Solid', 'liquory' ),
                    'double' => esc_html__( 'Double', 'liquory' ),
                    'dotted' => esc_html__( 'Dotted',  'liquory' ),
                    'dashed' => esc_html__( 'Dashed', 'liquory' ),
                    'groove' => esc_html__( 'Groove', 'liquory' ),
                ],
                'default' => 'none',
                'prefix_class' => 'tabs-border-type-',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs .elementor-tab-title' => 'border-style: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'border_width_title',
            [
                'label' => esc_html__( 'Border Width','liquory' ),
                'type' => Controls_Manager::DIMENSIONS,
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs .elementor-tab-title' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'border_type!' => 'none',
                ],
                'responsive' => true,
            ]
        );


        $this->add_responsive_control(
            'tab_title_padding',
            [
                'label'      => esc_html__('Padding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_title_margin',
            [
                'label'      => esc_html__('Margin', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.elementor-widget-liquory-tabs.elementor-widget-tabs .elementor-tab-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'tab_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'heading_content',
            [
                'label'     => esc_html__('Content', 'liquory'),
                'type'      => Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'content_color',
            [
                'label'     => esc_html__('Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-content' => 'color: {{VALUE}};',
                ],
                'global'    => [
                    'default' => Global_Colors::COLOR_TEXT,
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'content_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-content',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_TEXT,
                ],
            ]
        );


        $this->add_responsive_control('tab_content_padding',
            [
                'label'      => esc_html__('Padding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control('tab_content_margin',
            [
                'label'      => esc_html__('Margin', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'tab_content_border',
                'selector'  => '{{WRAPPER}} .elementor-tabs-content-wrapper',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $tabs = $this->get_settings_for_display('tabs');

        $id_int = substr($this->get_id_int(), 0, 3);
        ?>
        <div class="elementor-tabs" role="tablist">
            <div class="elementor-tabs-wrapper">
                <?php
                foreach ($tabs as $index => $item) :
                    $tab_count = $index + 1;
                    $class_item = 'elementor-repeater-item-' . $item['_id'];
                    $class_content = ($index == 0) ? 'elementor-active' : '';
                    $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index);

                    $this->add_render_attribute($tab_title_setting_key, [
                        'id'            => 'elementor-tab-title-' . $id_int . $tab_count,
                        'class'         => [
                            'elementor-tab-title',
                            'elementor-tab-desktop-title',
                            $class_content,
                            $class_item
                        ],
                        'data-tab'      => $tab_count,
                        'role'          => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ]);
                    ?>
                    <div <?php echo liquory_elementor_get_render_attribute_string($tab_title_setting_key, $this); ?>>
                        <?php Icons_Manager::render_icon($item['tab_icon'], ['aria-hidden' => 'true']); ?>
                        <span class="title"><?php echo esc_html($item['tab_title']); ?></span>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="elementor-tabs-content-wrapper">
                <?php
                foreach ($tabs as $index => $item) :
                    $tab_count = $index + 1;
                    $class_item = 'elementor-repeater-item-' . $item['_id'];
                    $class_content = ($index == 0) ? 'elementor-active' : '';
                    $tab_content_setting_key = $this->get_repeater_setting_key('tab_content', 'tabs', $index);

                    $tab_title_mobile_setting_key = $this->get_repeater_setting_key('tab_title_mobile', 'tabs', $tab_count);

                    $this->add_render_attribute($tab_content_setting_key, [
                        'id'              => 'elementor-tab-content-' . $id_int . $tab_count,
                        'class'           => [
                            'elementor-tab-content',
                            'elementor-clearfix',
                            $class_content,
                            $class_item
                        ],
                        'data-tab'        => $tab_count,
                        'role'            => 'tabpanel',
                        'aria-labelledby' => 'elementor-tab-title-' . $id_int . $tab_count,
                    ]);

                    $this->add_render_attribute($tab_title_mobile_setting_key, [
                        'class'         => [
                            'elementor-tab-title',
                            'elementor-tab-mobile-title',
                            $class_content,
                            $class_item
                        ],
                        'data-tab'      => $tab_count,
                        'role'          => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ]);

                    $this->add_inline_editing_attributes($tab_content_setting_key, 'advanced');
                    ?>
                    <div <?php echo liquory_elementor_get_render_attribute_string($tab_title_mobile_setting_key, $this); // WPCS: XSS ok.
                    ?>>
                        <?php Icons_Manager::render_icon($item['tab_icon'], ['aria-hidden' => 'true']); ?>
                        <span class="title"><?php echo esc_html($item['tab_title']); ?></span>
                    </div>
                    <div <?php echo liquory_elementor_get_render_attribute_string($tab_content_setting_key, $this); // WPCS: XSS ok.
                    ?>>
                        <?php if ('html' === $item['source']): ?>
                            <?php echo liquory_elementor_parse_text_editor($item['tab_content'], $this); // WPCS: XSS ok. ?>
                        <?php else: ?>
                            <?php echo Plugin::instance()->frontend->get_builder_content_for_display($item['tab_template']); ?>
                        <?php endif; ?>
                    </div>

                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}

$widgets_manager->register_widget_type(new Liquory_Elementor_Tabs());
