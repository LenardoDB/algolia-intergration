<?php

namespace LenardoDB\AlgoliaIntergration;

use StoutLogic\AcfBuilder\FieldsBuilder;
use LenardoDB\AlgoliaIntergration\Algolia;

class AdminFields
{
    public static $key = 'algolia_intergration';
    public static $slug = 'algolia-intergration';

    public function __construct()
    {
        $this->addAdminMenu(self::$slug);
        $this->addAdminFields(self::$slug);
    }

    /**
     * Add Admin menu
     * 
     * @param string $slug
     */
    protected function addAdminMenu($slug)
    {
        if (!function_exists('acf_add_options_page')) {
            return;
        }

        acf_add_options_page([
            'page_title' => 'Algolia Intergration Settings',
            'menu_title' => 'Algolia Intergration',
            'menu_slug' => $slug,
            'capability' => 'manage_options',
            'redirect' => false,
        ]);
    }

    /**
     * Add Admin fields to menu page
     * 
     * @param string $slug
     */
    protected function addAdminFields($slug)
    {
        if (!function_exists('acf_add_local_field_group')) {
            return;
        }

        $key = self::$key;
        $builder = new FieldsBuilder('algolia_intergration_fields');
        $builder
            ->addText( $key . '_client_id' , [
               'label' => 'Client ID',
               'wrapper' => [
                   'width' => 33,
               ]
            ])
            ->addText( $key . '_admin_api_key' , [
                'label' => 'Admin Api Key',
                'wrapper' => [
                    'width' => 33,
                ]
            ])
            ->addText( $key . '_index' , [
                'label' => 'Index',
                'wrapper' => [
                    'width' => 33,
                ]
            ])
            ->addRepeater( $key . '_post_types' , [
               'label' => 'Post Types',
               'layout' => 'block'
            ])
                ->addText( 'name' , [
                   'label' => 'Name',
                ])
            ->endRepeater()
        ;

        $builder->setLocation('options_page', '==', $slug);
        $fields = $builder->build();

        acf_add_local_field_group($fields);
    }

    /**
     * Get Client Id
     * 
     * @return null|string
     */
    public static function clientId()
    {
        $key = self::$key;
        $client_id = get_field($key . '_client_id', 'options');

        if (!$client_id) {
            return;
        } 

        return $client_id;
    }

    /**
     * Get Admin api key
     * 
     * @return null|string
     */
    public static function adminApiKey()
    {
        $key = self::$key;
        $admin_api_key = get_field( $key . '_admin_api_key', 'options' );

        if (!$admin_api_key) {
            return;
        }

        return $admin_api_key;
    }

    /**
     * Get Index
     * 
     * @return null|string
     */
    public static function index()
    {
        $key = self::$key;
        $index = get_field( $key . '_index', 'options' );

        if (!$index) {
            return;
        }

        return $index;
    }

    /**
     * Get all post types
     * 
     * @return null|string
     */
    public static function postTypes()
    {
        $key = self::$key;
        $post_types = [];
        $types = get_field( $key . '_post_types', 'options');

        if (!$types) {
            return;
        }

        foreach ($types as $type) {
            $post_types[] = $type['name'];
        }

        return $post_types;
    }
}
