<?php

/**
 * FC Widgets My Account: Account.
 *
 * @package FCW
 */
 
namespace FCPlugin;

if ( ! defined( 'ABSPATH' ) ) 
{
	exit;   // Exit if accessed directly.
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
Use Elementor\Core\Schemes\Typography;
use Elementor\Group_Control_Border;
use Elementor\Plugin;
use Elementor\Widget_Base;

class fc_wc_my_account_account extends Widget_Base 
{
    public function __construct($data = [], $args = null) 
    {
        parent::__construct($data, $args);
      
        wp_register_style( 'fc-account-style', plugin_dir_url( __FILE__ ) . '../css/fc-account.css');
      
        wp_register_style( 'fc-account-tabs', plugin_dir_url( __FILE__ ) . '../css/fc-account-tabs.css');
        
        wp_register_style( 'fc-account-icons', plugin_dir_url( __FILE__ ) . '../css/fc-account-icons.css');
      
        wp_register_style( 'wickedpicker', plugin_dir_url( __FILE__ ) . '../css/wickedpicker.css');
      
        wp_register_style( 'sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css');
        
        wp_register_style( 'fc-accordion', plugin_dir_url( __FILE__ ) . '../css/fc-account-accordion.css');

        wp_register_script( 'fc-account-js', plugin_dir_url( __FILE__ ) . '../js/fc-account.js');
      
        wp_register_script( 'wickedpicker-js', plugin_dir_url( __FILE__ ) . '../js/wickedpicker.js');
      
        wp_register_script( 'multipicker-js', plugin_dir_url( __FILE__ ) . '../js/jquery.multifield.js');
      
        wp_register_script( 'sweetalert', 'https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.js');
      
        wp_register_script( 'sweetalert-promise', 'https://cdn.jsdelivr.net/npm/promise-polyfill');
      
        wp_register_script( 'chart-js', 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.min.js');
        
        wp_register_script( 'font-awesome5', 'https://kit.fontawesome.com/137e2959bb.js');
    }
    
    public function get_name() 
    {
        return 'fc-account';
    }
    
    public function get_title() 
    {
        return __( 'FC: Account Page', smw_slug );
    }

    public function get_icon() 
    {
        return 'eicon-elementor';
    }

    public function get_categories() 
    {
        return [ 'fc-category' ];
    }

    public function get_style_depends()
    {
        return [ 
            'fc-account-style',
            'fc-account-tabs',
            'fc-bootstrap',
            'wickedpicker',
            'sweetalert',
            'fc-account-icons',
            'fc-accordion'
        ];
    }
    
    public function get_script_depends()
    {
        return [ 
            'fc-account-js',
            'fc-bootstrap-js',
            'wickedpicker-js',
            'media-upload',
            'sweetalert',
            'sweetalert-promise',
            'chart-js',
            'font-awesome5'
        ];
    }
    
    protected function register_controls() 
    {
        $this->user_info_show();

        $this->my_account_user_style();
        
        $this->my_account_menu_style();

        $this->my_account_content_style();
    }
    
    protected function user_info_show()
    {
        $this->start_controls_section(
            'myaccount_content_setting',
            [
                'label' => esc_html__( 'Settings', smw_slug ),
            ]
        );
            
            $this->add_control(
                'user_info_show',
                [
                    'label' => esc_html__( 'User Info', smw_slug ),
                    'type' => Controls_Manager::SWITCHER,
                    'label_on' => esc_html__( 'Yes', smw_slug ),
                    'label_off' => esc_html__( 'No', smw_slug ),
                    'return_value' => 'yes',
                    'default' => 'no',
                ]
            );

        $this->end_controls_section();
    }
    
    protected function my_account_user_style()
    {
        // My Account User Info Style
        $this->start_controls_section(
            'myaccount_user_info_style',
            array(
                'label' => __( 'User Info', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
                'condition'=>[
                    'user_info_show'=>'yes'
                ]
            )
        );
                    
            $this->add_control(
                'myaccount_usermeta_text_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-user-info' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'myaccount_usermeta_link_color',
                [
                    'label' => __( 'Logout Link', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-logout a' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_control(
                'myaccount_usermeta_link_hover_color',
                [
                    'label' => __( 'Logout Link Hover', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-logout a:hover' => 'color: {{VALUE}}',
                    ],
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'myaccount_usermeta_name_typography',
                    'label' => __( 'Name Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .stiles_my_account_page .stiles-username',
                ]
            );

            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'myaccount_usermeta_logout_typography',
                    'label' => __( 'Logout Typography', smw_slug ),
                    'scheme' => Typography::TYPOGRAPHY_1,
                    'selector' => '{{WRAPPER}} .stiles_my_account_page .stiles-logout',
                ]
            );

            $this->add_responsive_control(
                'myaccount_usermeta_image_border_radius',
                [
                    'label' => __( 'Image Border Radius', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-user-image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}} !important;',
                    ],
                ]
            );

            $this->add_responsive_control(
                'myaccount_usermeta_alignment',
                [
                    'label' => __( 'Alignment', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-lefst',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .stiles-user-area' => 'justify-content: {{VALUE}}',
                    ],
                ]
            );


        $this->end_controls_section();
    }
    
    protected function my_account_menu_style()
    {
        // My Account Menu Style
        $this->start_controls_section(
            'myaccount_menu_style',
            array(
                'label' => __( 'Menu', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );

            $this->add_control(
                'myaccount_menu_type',
                [
                    'label'   => __( 'Menu Type', smw_slug ),
                    'type'    => Controls_Manager::CHOOSE,
                    'options' => [
                        'hleft' => [
                            'title' => __( 'Horizontal Left', smw_slug ),
                            'icon'  => 'eicon-h-align-left',
                        ],
                        'hright' => [
                            'title' => __( 'Horizontal Right', smw_slug ),
                            'icon'  => 'eicon-h-align-right',
                        ],
                        'vtop' => [
                            'title' => __( 'Vertical Top', smw_slug ),
                            'icon'  => 'eicon-v-align-top',
                        ],
                        'vbottom' => [
                            'title' => __( 'Vertical Bottom', smw_slug ),
                            'icon'  => 'eicon-v-align-bottom',
                        ],
                    ],
                    'default'     => is_rtl() ? 'hright' : 'hleft',
                    'toggle'      => false,
                ]
            );

            $this->add_responsive_control(
                'myaccount_menu_area_margin',
                [
                    'label' => __( 'Menu Area Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'myaccount_menu_alignment',
                [
                    'label' => __( 'Alignment', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

            $this->start_controls_tabs('myaccount_menu_style_tabs');

                $this->add_responsive_control(
                    'myaccount_menu_area_width',
                    [
                        'label' => __( 'Menu Area Width', smw_slug ),
                        'type' => Controls_Manager::SLIDER,
                        'size_units' => [ 'px', '%' ],
                        'range' => [
                            'px' => [
                                'min' => 0,
                                'max' => 1000,
                                'step' => 1,
                            ],
                            '%' => [
                                'min' => 0,
                                'max' => 100,
                            ],
                        ],
                        'default' => [
                            'unit' => '%',
                            'size' => 30,
                        ],
                        'condition'=>[
                            'myaccount_menu_type' => array( 'hleft','hright' ),
                        ],
                        'selectors' => [
                            '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation' => 'width: {{SIZE}}{{UNIT}};',
                        ],
                    ]
                );

                // Menu Normal Color
                $this->start_controls_tab(
                    'myaccount_menu_style_normal_tab',
                    [
                        'label' => __( 'Normal', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'myaccount_menu_text_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Typography::get_type(),
                        [
                            'name' => 'myaccount_menu_text_typography',
                            'label' => __( 'Typography', smw_slug ),
                            'scheme' => Typography::TYPOGRAPHY_1,
                            'selector' => '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li a',
                        ]
                    );

                    $this->add_responsive_control(
                        'myaccount_menu_padding',
                        [
                            'label' => __( 'Padding', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'myaccount_menu_margin',
                        [
                            'label' => __( 'Margin', smw_slug ),
                            'type' => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors' => [
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_group_control(
                        Group_Control_Border::get_type(),
                        [
                            'name' => 'myaccount_menu_border',
                            'label' => __( 'Border', smw_slug ),
                            'selector' => '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li',
                        ]
                    );

                $this->end_controls_tab();

                // Menu Hover
                $this->start_controls_tab(
                    'myaccount_menu_style_hover_tab',
                    [
                        'label' => __( 'Hover', smw_slug ),
                    ]
                );
                    
                    $this->add_control(
                        'myaccount_menu_text_hover_color',
                        [
                            'label' => __( 'Color', smw_slug ),
                            'type' => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li a:hover' => 'color: {{VALUE}}',
                                '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-navigation ul li.is-active a' => 'color: {{VALUE}}',
                            ],
                        ]
                    );

                $this->end_controls_tab();

            $this->end_controls_tabs();

        $this->end_controls_section();
    }
    
    protected function my_account_content_style()
    {
        // Style
        $this->start_controls_section(
            'myaccount_content_style',
            array(
                'label' => __( 'Content', smw_slug ),
                'tab' => Controls_Manager::TAB_STYLE,
            )
        );
            
            $this->add_responsive_control(
                'myaccount_content_area_width',
                [
                    'label' => __( 'Content Area Width', smw_slug ),
                    'type' => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range' => [
                        'px' => [
                            'min' => 0,
                            'max' => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'default' => [
                        'unit' => '%',
                        'size' => 68,
                    ],
                    'condition'=>[
                        'myaccount_menu_type' => array( 'hleft','hright' ),
                    ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_control(
                'myaccount_text_color',
                [
                    'label' => __( 'Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_control(
                'myaccount_link_color',
                [
                    'label' => __( 'Link Color', smw_slug ),
                    'type' => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content a' => 'color: {{VALUE}}',
                    ],
                ]
            );
            
            $this->add_group_control(
                Group_Control_Typography::get_type(),
                [
                    'name' => 'myaccount_text_typography',
                    'selector' => '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content',
                ]
            );

            $this->add_responsive_control(
                'myaccount_content_padding',
                [
                    'label' => __( 'Padding', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'myaccount_content_margin',
                [
                    'label' => __( 'Margin', smw_slug ),
                    'type' => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                ]
            );
            
            $this->add_responsive_control(
                'myaccount_alignment',
                [
                    'label' => __( 'Alignment', smw_slug ),
                    'type' => Controls_Manager::CHOOSE,
                    'options' => [
                        'left' => [
                            'title' => __( 'Left', smw_slug ),
                            'icon' => 'fa fa-align-left',
                        ],
                        'center' => [
                            'title' => __( 'Center', smw_slug ),
                            'icon' => 'fa fa-align-center',
                        ],
                        'right' => [
                            'title' => __( 'Right', smw_slug ),
                            'icon' => 'fa fa-align-right',
                        ],
                        'justify' => [
                            'title' => __( 'Justified', smw_slug ),
                            'icon' => 'fa fa-align-justify',
                        ],
                    ],
                    'default'      => 'left',
                    'selectors' => [
                        '{{WRAPPER}} .stiles_my_account_page .woocommerce-MyAccount-content' => 'text-align: {{VALUE}}',
                    ],
                ]
            );

        $this->end_controls_section();
    }
    
    protected function render() 
    {
        $settings = $this->get_settings_for_display();

        if ( Plugin::instance()->editor->is_edit_mode() ) 
        {
            $this->my_account_content( $settings['navigation_list'], $settings['user_info_show'], $settings['myaccount_menu_type'] );
        }else{
            if ( ! is_user_logged_in() ) 
            { 
                return __('You need to log in to view this page', smw_slug); 
            }
            
            $this->my_account_content( $settings['navigation_list'], $settings['user_info_show'], $settings['myaccount_menu_type'] );
        }
    }

    public function my_account_content( $settings, $userinfo, $menutype )
    {
        $items       = array();
        $item_url    = array();
        
        $user = wp_get_current_user();
        
        if( $user && in_array( 'store_manager', $user->roles ) || $user && in_array( 'multi_manager', $user->roles ) )
        {
            if( $user && isset( $user->user_login ) && 'dprice' == $user->user_login) 
            {
                $items = [
                    'dashboard'       => esc_html__( 'Home', smw_slug ),
                    'employee-details'=> esc_html__( 'Your Details', smw_slug ),
                    '/../../staff-news' => esc_html__( 'Staff News', smw_slug ),
                    'reports'          => esc_html__( 'Reports', smw_slug ),
                    '/../../scorecard-kpis' => esc_html__( 'Scorecard KPI\'s', smw_slug ),
                    'store-targets'  => esc_html__( 'Store Targets', smw_slug ),
                    'store-commission'  => esc_html__( 'Store Commission', smw_slug ),
                    'advisor-nps' => esc_html__( 'Advisor NPS', smw_slug ),
                    'input-banking'  => esc_html__( 'Input Banking', smw_slug ),
                    'store-cover'    => esc_html__( 'Assign Store Cover', smw_slug ),
                    'manage-sales'       => esc_html__( 'Manage Sales Info', smw_slug ),
                    'manage-users'    => esc_html__( 'Manage Users', smw_slug ),
                    'manage-assets'    => esc_html__( 'Manage Assets', smw_slug ),
                ];
            }
            else
            {
                $items = [
                    'dashboard'       => esc_html__( 'Home', smw_slug ),
                    'employee-details'=> esc_html__( 'Your Details', smw_slug ),
                    '/../../staff-news' => esc_html__( 'Staff News', smw_slug ),
                    'reports'          => esc_html__( 'Reports', smw_slug ),
                    '/../../scorecard-kpis' => esc_html__( 'Scorecard KPI\'s', smw_slug ),
                    'store-targets'  => esc_html__( 'Store Targets', smw_slug ),
                    'store-commission'  => esc_html__( 'Store Commission', smw_slug ),
                    'advisor-nps' => esc_html__( 'Advisor NPS', smw_slug ),
                    'input-banking'  => esc_html__( 'Input Banking', smw_slug ),
                    'store-cover'    => esc_html__( 'Assign Store Cover', smw_slug ),
                    'manage-sales'       => esc_html__( 'Manage Sales Info', smw_slug ),
                    'manage-users'    => esc_html__( 'Manage Users', smw_slug ),
                ];
            }
        }
        elseif( $user && in_array( 'senior_manager', $user->roles ) )
        {
            if($user->user_login == 'test' || $user->user_login == 'MFamily' || $user->user_login == 'GCarter' ) {
                $items = [
                    'dashboard'       => esc_html__( 'Home', smw_slug ),
                    'employee-details'=> esc_html__( 'Your Details', smw_slug ),
                    '/../../staff-news' => esc_html__( 'Staff News', smw_slug ),
                    'reports'          => esc_html__( 'Reports', smw_slug ),
                    '/../../scorecard-kpis' => esc_html__( 'Scorecard KPI\'s', smw_slug ),
                    'sales-reports'       => esc_html__( 'Generate Sales Reports', smw_slug ),
                    'input-targets'       => esc_html__( 'Input Targets', smw_slug ),
                    'store-targets'       => esc_html__( 'Store Targets', smw_slug ),
                    'store-commission'    => esc_html__( 'Store Commission', smw_slug ),
                    'advisor-nps' => esc_html__( 'Advisor NPS', smw_slug ),
                    'view-banking'    => esc_html__( 'View Banking', smw_slug ),
                    'store-cover'    => esc_html__( 'Assign Store Cover', smw_slug ),
                    'manage-sales'       => esc_html__( 'Manage Sales Info', smw_slug ),
                    'sales-multipliers'    => esc_html__( 'Enter Sales Multipliers', smw_slug ),
                    'search-sales'       => esc_html__( 'Search Sales', smw_slug ),
                    'unapproved-sales'       => esc_html__( 'View Unapproved Sales', smw_slug ),
                    'manage-users'    => esc_html__( 'Manage Users', smw_slug ),
                    'manage-assets'    => esc_html__( 'Manage Assets', smw_slug ),
                ];
            } else {
                $items = [
                'dashboard'       => esc_html__( 'Home', smw_slug ),
                'employee-details'=> esc_html__( 'Your Details', smw_slug ),
                '/../../staff-news' => esc_html__( 'Staff News', smw_slug ),
                'reports'          => esc_html__( 'Reports', smw_slug ),
                '/../../scorecard-kpis' => esc_html__( 'Scorecard KPI\'s', smw_slug ),
                '/../../scorecard-kpis' => esc_html__( 'Scorecard KPI\'s', smw_slug ),
                'input-targets'       => esc_html__( 'Input Targets', smw_slug ),
                'store-targets'       => esc_html__( 'Store Targets', smw_slug ),
                'store-commission'    => esc_html__( 'Store Commission', smw_slug ),
                'advisor-nps' => esc_html__( 'Advisor NPS', smw_slug ),
                'view-banking'    => esc_html__( 'View Banking', smw_slug ),
                'store-cover'    => esc_html__( 'Assign Store Cover', smw_slug ),
                'manage-sales'       => esc_html__( 'Manage Sales Info', smw_slug ),
                'search-sales'       => esc_html__( 'Search Sales', smw_slug ),
                'unapproved-sales'       => esc_html__( 'View Unapproved Sales', smw_slug ),
                'manage-users'    => esc_html__( 'Manage Users', smw_slug ),
                'manage-assets'    => esc_html__( 'Manage Assets', smw_slug ),
            ];
            }
        }
        else if( $user && in_array( 'senior_advisor', $user->roles ) )
        {
            $items = [
                'dashboard'       => esc_html__( 'Home', smw_slug ),
                'employee-details'=> esc_html__( 'Your Details', smw_slug ),
                '/../../staff-news' => esc_html__( 'Staff News', smw_slug ),
                'reports'          => esc_html__( 'Store Reports', smw_slug ),
                '/../../scorecard-kpis' => esc_html__( 'Scorecard KPI\'s', smw_slug ),
                'sales-input'       => esc_html__( 'Input Sales', smw_slug ),
                'employee-sales'       => esc_html__( 'View Your Sales', smw_slug ),
                'sales-targets'   => esc_html__( 'Sales Targets', smw_slug ),
                'store-targets'       => esc_html__( 'Daily Store Targets', smw_slug ),
                //'your-commission'    => esc_html__( 'Your Commission', smw_slug ),
            ];
        }
        else
        {
            $items = [
                'dashboard'       => esc_html__( 'Home', smw_slug ),
                'employee-details'=> esc_html__( 'Your Details', smw_slug ),
                '/../../staff-news' => esc_html__( 'Staff News', smw_slug ),
                '/../../scorecard-kpis' => esc_html__( 'Scorecard KPI\'s', smw_slug ),
                'sales-input'       => esc_html__( 'Input Sales', smw_slug ),
                'employee-sales'       => esc_html__( 'View Your Sales', smw_slug ),
                'sales-targets'   => esc_html__( 'Sales Targets', smw_slug ),
                'store-targets'       => esc_html__( 'Daily Store Targets', smw_slug ),
                //'your-commission'    => esc_html__( 'Your Commission', smw_slug ),
            ];
        }
        
        new \Stiles_MyAccount( $items, $item_url, $userinfo );

        echo '<div class="stiles_my_account_page stiles_my_account_menu_pos_' . $menutype . '">';
        
            if( $menutype === 'vtop' || $menutype === 'hleft' )
            { 
                do_action( 'woocommerce_account_navigation' );
            }
            
            echo '<div class="woocommerce-MyAccount-content">';
                do_action( 'woocommerce_account_content' );
            echo '</div>';
            
            if( $menutype === 'vbottom' || $menutype === 'hright' )
            { 
                do_action( 'woocommerce_account_navigation' ); 
            }
            
        echo '</div>';
    }
}

Plugin::instance()->widgets_manager->register_widget_type( new fc_wc_my_account_account() );