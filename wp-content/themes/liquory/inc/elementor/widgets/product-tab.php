<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!liquory_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Repeater;
use Liquory\Elementor\Liquory_Base_Widgets;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Liquory_Elementor_Products_Tabs extends Liquory_Base_Widgets {

    public function get_categories() {
        return array('liquory-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'liquory-products-tabs';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Products Tabs', 'liquory');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-tabs';
    }


    public function get_script_depends() {
        return ['liquory-elementor-product-tab', 'slick'];
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {

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
                'label'       => esc_html__('Tab Title', 'liquory'),
                'type'        => Controls_Manager::TEXT,
                'default'     => esc_html__('#Product Tab', 'liquory'),
                'placeholder' => esc_html__('Product Tab Title', 'liquory'),
            ]
        );

        $repeater->add_control(
            'limit',
            [
                'label'   => esc_html__('Posts Per Page', 'liquory'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );

        $repeater->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'liquory'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $repeater->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order By', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'date',
                'options' => [
                    'date'       => esc_html__('Date', 'liquory'),
                    'id'         => esc_html__('Post ID', 'liquory'),
                    'menu_order' => esc_html__('Menu Order', 'liquory'),
                    'popularity' => esc_html__('Number of purchases', 'liquory'),
                    'rating'     => esc_html__('Average Product Rating', 'liquory'),
                    'title'      => esc_html__('Product Title', 'liquory'),
                    'rand'       => esc_html__('Random', 'liquory'),
                ],
            ]
        );

        $repeater->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => esc_html__('ASC', 'liquory'),
                    'desc' => esc_html__('DESC', 'liquory'),
                ],
            ]
        );

        $repeater->add_control(
            'categories',
            [
                'label'       => esc_html__('Categories', 'liquory'),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $this->get_product_categories(),
                'multiple'    => true,
            ]
        );

        $repeater->add_control(
            'cat_operator',
            [
                'label'     => esc_html__('Category Operator', 'liquory'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'liquory'),
                    'IN'     => esc_html__('IN', 'liquory'),
                    'NOT IN' => esc_html__('NOT IN', 'liquory'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $repeater->add_control(
            'tag',
            [
                'label'       => esc_html__('Tags', 'liquory'),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $this->get_product_tags(),
                'multiple'    => true,
            ]
        );

        $repeater->add_control(
            'tag_operator',
            [
                'label'     => esc_html__('Tag Operator', 'liquory'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'liquory'),
                    'IN'     => esc_html__('IN', 'liquory'),
                    'NOT IN' => esc_html__('NOT IN', 'liquory'),
                ],
                'condition' => [
                    'tag!' => ''
                ],
            ]
        );

        $repeater->add_control(
            'product_type',
            [
                'label'   => esc_html__('Product Type', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => [
                    'newest'       => esc_html__('Newest Products', 'liquory'),
                    'on_sale'      => esc_html__('On Sale Products', 'liquory'),
                    'best_selling' => esc_html__('Best Selling', 'liquory'),
                    'top_rated'    => esc_html__('Top Rated', 'liquory'),
                    'featured'     => esc_html__('Featured Product', 'liquory'),
                ],
            ]
        );

        $repeater->add_control(
            'product_layout',
            [
                'label'   => esc_html__('Product Layout', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grid', 'liquory'),
                    'list' => esc_html__('List', 'liquory'),
                ],
            ]
        );

        $repeater->add_control(
            'list_layout',
            [
                'label'     => esc_html__('List Layout', 'liquory'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '1' => esc_html__('Style 1', 'liquory'),
                ],
                'condition' => [
                    'product_layout' => 'list'
                ]
            ]
        );

        $this->add_control(
            'product_no_gutter',
            [
                'label'        => esc_html__('Border', 'liquory'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'liquory-gutter-'
            ]
        );

        $this->add_control(
            'tabs',
            [
                'label'       => '',
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'tab_title' => esc_html__('#Product Tab 1', 'liquory'),
                    ],
                    [
                        'tab_title' => esc_html__('#Product Tab 2', 'liquory'),
                    ]
                ],
                'title_field' => '{{{ tab_title }}}',
            ]
        );

        $this->add_responsive_control(
            'column',
            [
                'label'   => esc_html__('columns', 'liquory'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'default' => 3,
                'options' => [1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_product',
            [
                'label' => esc_html__('Product', 'liquory'),
            ]
        );
        $this->add_responsive_control(
            'product_gutter',
            [
                'label'      => esc_html__('Gutter', 'liquory'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} ul.products li.product'      => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} ul.products li.product-item' => 'padding-left: calc({{SIZE}}{{UNIT}} / 2); padding-right: calc({{SIZE}}{{UNIT}} / 2); margin-bottom: calc({{SIZE}}{{UNIT}} - 1px);',
                    '{{WRAPPER}} ul.products'                 => 'margin-left: calc({{SIZE}}{{UNIT}} / -2); margin-right: calc({{SIZE}}{{UNIT}} / -2);',
                ],
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'section_tab_header_style',
            [
                'label' => esc_html__('Header', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tab_header_padding',
            [
                'label'      => esc_html__('Padding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'background_tab_header',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'align_items',
            [
                'label'       => esc_html__('Align', 'liquory'),
                'type'        => Controls_Manager::CHOOSE,
                'label_block' => false,
                'options'     => [
                    'flex-start'      => [
                        'title' => esc_html__('Left', 'liquory'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'   => [
                        'title' => esc_html__('Center', 'liquory'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end' => [
                        'title' => esc_html__('Right', 'liquory'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'default'     => '',
                'selectors'   => [
                    '{{WRAPPER}} .elementor-tabs-wrapper' => 'justify-content: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'header_margin',
            [
                'label'      => esc_html__('Spacing Between Item', 'liquory'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 0,
                        'max' => 300,
                    ],
                ],
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title'                                 => 'margin-left: calc( {{SIZE}}{{UNIT}}/2 ); margin-right: calc( {{SIZE}}{{UNIT}}/2 );',
                    '{{WRAPPER}}.products-tabs-style-liquory-yes .elementor-tab-desktop-title' => 'padding-left: calc( {{SIZE}}{{UNIT}}/2 ); padding-right: calc( {{SIZE}}{{UNIT}}/2 ); margin:0',
                    '{{WRAPPER}} .elementor-tab-desktop-title:first-child'                     => 'margin-left:0; padding-left:0',
                    '{{WRAPPER}} .elementor-tab-desktop-title:last-child'                      => 'margin-right:0; padding-right:0',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [


                'name'        => 'border_tabs_header',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-tabs-wrapper',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'products_tabs_style_theme',
            [
                'label'        => esc_html__('Theme Style', 'liquory'),
                'type'         => Controls_Manager::SWITCHER,
                'default'      => '',
                'prefix_class' => 'products-tabs-style-liquory-',
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_title_style',
            [
                'label' => esc_html__('Title', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tab_typography',
                'selector' => '{{WRAPPER}} .elementor-tab-title',
            ]
        );

        $this->add_responsive_control(
            'tab_title_padding',
            [
                'label'      => esc_html__('Padding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'tab_title_margin',
            [
                'label'      => esc_html__('Margin', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_title_style');

        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => esc_html__('Normal', 'liquory'),
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_color',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'background-color: {{VALUE}};'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => esc_html__('Hover', 'liquory'),
            ]
        );

        $this->add_control(
            'title_hover_color',
            [
                'label'     => esc_html__('Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'title_background_hover_color',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:hover' => 'background-color: {{VALUE}}'
                ],
            ]
        );

        $this->add_control(
            'title_hover_border_color',
            [
                'label'     => esc_html__('Border Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title:hover' => 'border-color: {{VALUE}}'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->start_controls_tab(
            'tab_title_active',
            [
                'label' => esc_html__('Active', 'liquory'),
            ]
        );

        $this->add_control(
            'title_active_color',
            [
                'label'     => esc_html__('Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active'        => 'color: {{VALUE}}',
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active:before' => 'background:',
                ],
            ]
        );

        $this->add_control(
            'title_background_active_color',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active' => 'background-color: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'title_active_border_color',
            [
                'label'     => esc_html__('Border Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-tab-desktop-title.elementor-active' => 'border-color: {{VALUE}}!important;'
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'        => 'border_tabs_title',
                'placeholder' => '1px',
                'default'     => '1px',
                'selector'    => '{{WRAPPER}} .elementor-tab-desktop-title',
                'separator'   => 'before',
            ]
        );

        $this->add_control(
            'border_tabs_radius',
            [
                'label'      => esc_html__('Border Radius', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-desktop-title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_content_style',
            [
                'label' => esc_html__('Content', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'tab_content_padding',
            [
                'label'      => esc_html__('Padding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_responsive_control(
            'tab_content_margin',
            [
                'label'      => esc_html__('Margin', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .elementor-tab-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
                ]
            ]
        );

        $this->add_control(
            'tab_content_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .products-wap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'tab_content_border',
                'selector' => '{{WRAPPER}} .products-wap',

            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'tab_content_box_shadow',
                'selector' => '{{WRAPPER}} .products-wap',
            ]
        );

        $this->end_controls_section();


        $this->start_controls_section(
            'product_block_style',
            [
                'label' => esc_html__('Product Block', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'background_product_block',
            [
                'label'     => esc_html__('Background Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-block' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();


        $this->add_control_for_carousel();

    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $tabs    = $this->get_settings_for_display('tabs');
        $setting = $this->get_settings_for_display();

        $id_int = substr($this->get_id_int(), 0, 3);

        $this->add_render_attribute('data-carousel', 'class', 'elementor-tabs-content-wrapper');

        if ($setting['enable_carousel']) {
            $carousel_settings = $this->get_settings_for_carousel();
            $this->add_render_attribute('data-carousel', 'data-settings', wp_json_encode($carousel_settings));
        }

        ?>
        <div class="elementor-tabs" role="tablist">
            <div class="elementor-tabs-wrapper">
                <?php if ($setting['products_tabs_style_theme'] === 'yes') { ?>
                <div class="elementor-tabs-wrapper-inner"><?php } ?>
                    <?php
                    foreach ($tabs as $index => $item) :
                        $tab_count = $index + 1;
                        $class_item = 'elementor-repeater-item-' . $item['_id'];
                        $class = ($index == 0) ? 'elementor-active' : '';

                        $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index);

                        $this->add_render_attribute($tab_title_setting_key, [
                            'id'            => 'elementor-tab-title-' . $id_int . $tab_count,
                            'class'         => [
                                'elementor-tab-title',
                                'elementor-tab-desktop-title',
                                $class,
                                $class_item
                            ],
                            'data-tab'      => $tab_count,
                            'tabindex'      => $id_int . $tab_count,
                            'role'          => 'tab',
                            'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                        ]);
                        ?>
                        <div <?php echo liquory_elementor_get_render_attribute_string($tab_title_setting_key, $this); // WPCS: XSS ok.
                        ?>><?php echo esc_html($item['tab_title']); ?></div>
                    <?php endforeach; ?>
                    <?php if ($setting['products_tabs_style_theme'] === 'yes') { ?></div><?php } ?>
            </div>
            <div <?php echo liquory_elementor_get_render_attribute_string('data-carousel', $this); // WPCS: XSS ok.?>>
                <?php
                foreach ($tabs as $index => $item) :
                    $tab_count = $index + 1;
                    $class_item = 'elementor-repeater-item-' . $item['_id'];
                    $class_content = ($index == 0) ? 'elementor-active' : '';
                    $tab_title_mobile_setting_key = $this->get_repeater_setting_key('tab_title_mobile', 'tabs', $index);
                    $tab_content_setting_key = $this->get_repeater_setting_key('tab_content', 'tabs', $index);

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
                        'tabindex'      => $id_int . $tab_count,
                        'role'          => 'tab',
                        'aria-controls' => 'elementor-tab-content-' . $id_int . $tab_count,
                    ]);

                    $this->add_inline_editing_attributes($tab_content_setting_key, 'advanced');
                    $this->add_inline_editing_attributes($tab_title_mobile_setting_key, 'advanced');
                    ?>
                    <div <?php echo liquory_elementor_get_render_attribute_string($tab_title_mobile_setting_key, $this); ?>> <?php printf('%s', $item['tab_title']); ?></div>
                    <div <?php echo liquory_elementor_get_render_attribute_string($tab_content_setting_key, $this); ?>>
                        <?php $this->woocommerce_default($item, $setting); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }

    private function woocommerce_default($settings, $global_setting) {
        $type = 'products';

        $class = '';

        if ($global_setting['enable_carousel']) {

            $atts['product_layout'] = 'carousel';
            $atts                   = [
                'limit'             => $settings['limit'],
                'orderby'           => $settings['orderby'],
                'order'             => $settings['order'],
                'carousel_settings' => '',
                'columns'           => 1,
                'product_layout'    => 'carousel'
            ];

            if ($settings['product_layout'] == 'list') {
                $atts['product_layout'] = 'list-carousel';
            }
        } else {
            $atts = [
                'limit'             => $settings['limit'],
                'orderby'           => $settings['orderby'],
                'order'             => $settings['order'],
                'carousel_settings' => '',
                'columns'           => $global_setting['column'],
                'product_layout'    => $settings['product_layout']
            ];

            if (!empty($global_setting['column_widescreen'])) {
                $class .= ' columns-widescreen-' . $global_setting['column_widescreen'];
            }

            if (!empty($global_setting['column_laptop'])) {
                $class .= ' columns-laptop-' . $global_setting['column_laptop'];
            }

            if (!empty($global_setting['column_tablet_extra'])) {
                $class .= ' columns-tablet-extra-' . $global_setting['column_tablet_extra'];
            }

            if (!empty($global_setting['column_tablet'])) {
                $class .= ' columns-tablet-' . $global_setting['column_tablet'];
            } else {
                $class .= ' columns-tablet-2';
            }

            if (!empty($global_setting['column_mobile_extra'])) {
                $class .= ' columns-mobile-extra-' . $global_setting['column_mobile_extra'];
            }

            if (!empty($global_setting['column_mobile'])) {
                $class .= ' columns-mobile-' . $global_setting['column_mobile'];
            } else {
                $class .= ' columns-mobile-1';
            }
        }

        if ($settings['product_layout'] == 'list') {
            $class .= ' products-list';
            $class .= ' products-list-' . $settings['list_layout'];
            $class .= ' woocommerce-product-list';
            if (!empty($settings['list_layout']) && $settings['list_layout'] == '1') {
                $atts['show_rating'] = true;
            }
        }

        $atts = $this->get_product_type($atts, $settings['product_type']);
        if (isset($atts['on_sale']) && wc_string_to_bool($atts['on_sale'])) {
            $type = 'sale_products';
        } elseif (isset($atts['best_selling']) && wc_string_to_bool($atts['best_selling'])) {
            $type = 'best_selling_products';
        } elseif (isset($atts['top_rated']) && wc_string_to_bool($atts['top_rated'])) {
            $type = 'top_rated_products';
        }

        if (!empty($settings['categories'])) {
            $atts['category']     = implode(',', $settings['categories']);
            $atts['cat_operator'] = $settings['cat_operator'];
        }

        if (!empty($settings['tag'])) {
            $atts['tag']          = implode(',', $settings['tag']);
            $atts['tag_operator'] = $settings['tag_operator'];
        }

        $atts['class'] = $class;

        echo (new WC_Shortcode_Products($atts, $type))->get_content(); // WPCS: XSS ok.
    }

    protected function get_product_type($atts, $product_type) {
        switch ($product_type) {
            case 'featured':
                $atts['visibility'] = "featured";
                break;

            case 'on_sale':
                $atts['on_sale'] = true;
                break;

            case 'best_selling':
                $atts['best_selling'] = true;
                break;

            case 'top_rated':
                $atts['top_rated'] = true;
                break;

            default:
                break;
        }

        return $atts;
    }

    protected function get_product_tags() {
        $tags    = get_terms(array(
                'taxonomy'   => 'product_tag',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $results[$tag->slug] = $tag->name;
            }
        }

        return $results;
    }

    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }

        return $results;
    }
}

$widgets_manager->register_widget_type(new Liquory_Elementor_Products_Tabs());
