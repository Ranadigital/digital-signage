<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Text_Stroke;
use Elementor\Group_Control_Typography;
use Elementor\Utils;


class Liquory_Elementor_Heading extends Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * Retrieve heading widget name.
     *
     * @return string Widget name.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'liquory-heading';
    }

    /**
     * Get widget title.
     *
     * Retrieve heading widget title.
     *
     * @return string Widget title.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Liquory Heading', 'liquory');
    }

    /**
     * Get widget icon.
     *
     * Retrieve heading widget icon.
     *
     * @return string Widget icon.
     * @since 1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-t-letter';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the heading widget belongs to.
     *
     * Used to determine where to display the widget in the editor.
     *
     * @return array Widget categories.
     * @since 2.0.0
     * @access public
     *
     */
    public function get_categories() {
        return ['basic'];
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
        return ['heading', 'title', 'text'];
    }

    /**
     * Register heading widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since 3.1.0
     * @access protected
     */
    protected function register_controls() {
        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__('Title', 'liquory'),
            ]
        );

        $this->add_control(
            'title',
            [
                'label'       => esc_html__('Title', 'liquory'),
                'type'        => Controls_Manager::TEXTAREA,
                'dynamic'     => [
                    'active' => true,
                ],
                'placeholder' => esc_html__('Enter your title', 'liquory'),
                'default'     => esc_html__('Add Your Heading Text Here', 'liquory'),
            ]
        );

        $this->add_control(
            'link',
            [
                'label'     => esc_html__('Link', 'liquory'),
                'type'      => Controls_Manager::URL,
                'dynamic'   => [
                    'active' => true,
                ],
                'default'   => [
                    'url' => '',
                ],
                'separator' => 'before',
            ]
        );

        $this->add_control(
            'size',
            [
                'label'   => esc_html__('Size', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'default',
                'options' => [
                    'default' => esc_html__('Default', 'liquory'),
                    'small'   => esc_html__('Small', 'liquory'),
                    'medium'  => esc_html__('Medium', 'liquory'),
                    'large'   => esc_html__('Large', 'liquory'),
                    'xl'      => esc_html__('XL', 'liquory'),
                    'xxl'     => esc_html__('XXL', 'liquory'),
                ],
            ]
        );

        $this->add_control(
            'header_size',
            [
                'label'   => esc_html__('HTML Tag', 'liquory'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'h1'   => 'H1',
                    'h2'   => 'H2',
                    'h3'   => 'H3',
                    'h4'   => 'H4',
                    'h5'   => 'H5',
                    'h6'   => 'H6',
                    'div'  => 'div',
                    'span' => 'span',
                    'p'    => 'p',
                ],
                'default' => 'h2',
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'        => esc_html__('Alignment', 'liquory'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'left'    => [
                        'title' => esc_html__('Left', 'liquory'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center'  => [
                        'title' => esc_html__('Center', 'liquory'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'   => [
                        'title' => esc_html__('Right', 'liquory'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                    'justify' => [
                        'title' => esc_html__('Justified', 'liquory'),
                        'icon'  => 'eicon-text-align-justify',
                    ],
                ],
                'default'      => '',
                'selectors'    => [
                    '{{WRAPPER}}' => 'text-align: {{VALUE}};',
                ],
                'prefix_class' => 'elementor%s-align-',
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

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon',
            [
                'label' => esc_html__('Icon Decor', 'liquory'),
            ]
        );

        $this->add_control(
            'icon',
            [
                'label'       => __('Icon', 'liquory'),
                'type'        => Controls_Manager::ICON,
                'label_block' => true,
                'default'     => '',
            ]
        );

        $this->add_control(
            'icon_position',
            [
                'label'        => __('Icon Position', 'liquory'),
                'type'         => Controls_Manager::SELECT,
                'default'      => 'left',
                'options'      => [
                    'left'  => __('Left', 'liquory'),
                    'right' => __('Right', 'liquory'),
                ],
                'prefix_class' => 'elementor-icon-',
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

        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Text Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'global'    => [
                    'default' => Global_Colors::COLOR_PRIMARY,
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title span'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-heading-title a span' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'global'   => [
                    'default' => Global_Typography::TYPOGRAPHY_PRIMARY,
                ],
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Stroke::get_type(),
            [
                'name'     => 'text_stroke',
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_group_control(
            Group_Control_Text_Shadow::get_type(),
            [
                'name'     => 'text_shadow',
                'selector' => '{{WRAPPER}} .elementor-heading-title',
            ]
        );

        $this->add_control(
            'blend_mode',
            [
                'label'     => esc_html__('Blend Mode', 'liquory'),
                'type'      => Controls_Manager::SELECT,
                'options'   => [
                    ''            => esc_html__('Normal', 'liquory'),
                    'multiply'    => 'Multiply',
                    'screen'      => 'Screen',
                    'overlay'     => 'Overlay',
                    'darken'      => 'Darken',
                    'lighten'     => 'Lighten',
                    'color-dodge' => 'Color Dodge',
                    'saturation'  => 'Saturation',
                    'color'       => 'Color',
                    'difference'  => 'Difference',
                    'exclusion'   => 'Exclusion',
                    'hue'         => 'Hue',
                    'luminosity'  => 'Luminosity',
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title' => 'mix-blend-mode: {{VALUE}}',
                ],
                'separator' => 'none',
            ]
        );

        $this->add_control(
            'title-custom-theme',
            [
                'label'        => esc_html__('Theme Style', 'liquory'),
                'type'         => Controls_Manager::SWITCHER,
                'prefix_class' => 'title-background-custom-'
            ]
        );

        $this->add_control(
            'title-custom-background',
            [
                'label'     => __('Background custom', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}}.title-background-custom-yes .elementor-heading-title span' => 'background-color: {{VALUE}};',
                ],
                'condition' => [
                    'title-custom-theme' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'title-custom-_padding',
            [
                'label'      => esc_html__('Padding', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}}.title-background-custom-yes .elementor-heading-title span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
                'condition'  => [
                    'title-custom-theme' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'title-custom_spacing',
            [
                'label'     => esc_html__('Spacing Title', 'liquory'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}.title-background-custom-yes .elementor-heading-title span' => 'margin-left: {{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'title-custom-theme' => 'yes'
                ],
            ]
        );

        $this->add_responsive_control(
            'title-custom_spacing_badge',
            [
                'label'     => esc_html__('Spacing Badge Title', 'liquory'),
                'type'      => Controls_Manager::SLIDER,
                'selectors' => [
                    '{{WRAPPER}}.title-background-custom-yes .elementor-heading-title:after' => 'left:{{SIZE}}{{UNIT}};',
                ],
                'condition' => [
                    'title-custom-theme' => 'yes'
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'section_icon_style',
            [
                'label' => __('Icon Decor', 'liquory'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label'     => __('Icon Color', 'liquory'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title i'   => 'color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-heading-title a i' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'icon_size',
            [
                'label'     => __('Icon Size', 'liquory'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'min' => 6,
                        'max' => 300,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .elementor-heading-title i'   => 'font-size: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-heading-title a i' => 'font-size: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'margin',
            [
                'label'      => esc_html__('Margin', 'liquory'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}}.elementor-icon-left .elementor-heading-title i'  => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}}.elementor-icon-right .elementor-heading-title i' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );


        $this->end_controls_section();
    }

    /**
     * Render heading widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        if ('' === $settings['title']) {
            return;
        }

        $this->add_render_attribute('title', 'class', 'elementor-heading-title');

        if (!empty($settings['size'])) {
            $this->add_render_attribute('title', 'class', 'elementor-size-' . $settings['size']);
        }

        if (!empty($settings['icon'])) {
            $this->add_render_attribute('icon', 'class', $settings['icon']);
        }

        $this->add_inline_editing_attributes('title');
        $title = '';

        if (!empty($settings['icon'])) {
            $title = '<i ' . $this->get_render_attribute_string("icon") . '> </i>';
        }

        $title .= '<span>' . $settings['title'] . '</span>';

        $title_html = '';


        if (!empty($settings['link']['url'])) {
            $this->add_link_attributes('url', $settings['link']);

            $title = sprintf('<a %1$s>%2$s</a>', $this->get_render_attribute_string('url'), $title);
        }

        $title_html = sprintf('<%1$s %2$s>%3$s</%1$s>', Utils::validate_html_tag($settings['header_size']), $this->get_render_attribute_string('title'), $title);

        // PHPCS - the variable $title_html holds safe data.
        echo sprintf('%s', $title_html); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
    }

    /**
     * Render heading widget output in the editor.
     *
     * Written as a Backbone JavaScript template and used to generate the live preview.
     *
     * @since 2.9.0
     * @access protected
     */
    protected function content_template() {
        ?>
        <#
        var title = settings.title;

        if ( settings.icon ) {
        view.addRenderAttribute( 'icon', 'class', settings.icon );
        view.addRenderAttribute( 'icon', 'aria-hidden', 'true' );
        title += '<i ' + view.getRenderAttributeString('icon')+ '> </i>';
        }

        if ( '' !== settings.link.url ) {
        title = '<a href="' + settings.link.url + '">' + title + '</a>';
        }

        view.addRenderAttribute( 'title', 'class', [ 'elementor-heading-title', 'elementor-size-' + settings.size ] );

        view.addInlineEditingAttributes( 'title' );

        var headerSizeTag = elementor.helpers.validateHTMLTag( settings.header_size ),
        title_html = '<' + headerSizeTag  + ' ' + view.getRenderAttributeString( 'title' ) + '>' + title + '</' + headerSizeTag + '>';

        print( title_html );
        #>
        <?php
    }

}

$widgets_manager->register(new Liquory_Elementor_Heading());
