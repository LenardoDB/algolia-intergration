<?php

namespace LenardoDB\AlgoliaIntergration;

use Algolia\AlgoliaSearch\SearchClient;

class Algolia
{
    public $algolia;
    public $client_id;
    public $admin_api_key;
    public $index;
    public $post_types;

    public function __construct()
    {
        $this->client_id = AdminFields::clientId();
        $this->admin_api_key = AdminFields::adminApiKey();
        $this->index = AdminFields::index();
        $this->post_types = AdminFields::postTypes();

        $this->init();
    }

    /**
     * Setup Algolia client
     */
    protected function init()
    {
        global $algolia;

        $this->algolia = SearchClient::create($this->client_id, $this->admin_api_key);

        if( $this->algolia ) {
            $this->initIndex();
        }
    }

    /**
     * Set Index
     */
    public function initIndex()
    {
        if( $this->algolia && $this->index ) {
            $this->index = $this->algolia->initIndex($this->index);
        }
    }

    /**
     * Add post to Algolia
     * 
     * @param obj $post
     */
    public function addPost($post)
    {
        // Check if post is filled in 
        if (!$post) {
            return;
        }

        // Check if post is allow to be pushed to algolia
        if(!$check = $this->checkPostType($post)) {
            return;
        }
        
        $array = (array) $post;
        $array['objectID'] = $post->ID;
        $array['img'] = get_the_post_thumbnail_url($post->ID);

        $this->saveToAlgolia($array);
    }

    /**
     * Delete post from Algolia
     * 
     * @param int $post_id
     */
    public function deletePost($post)
    {
        $this->index->deleteObjects($post);
    }

    /**
     * Check if post is allow to be pushed to Algolia
     * 
     * @param obj $post
     */
    protected function checkPostType($post)
    {
        return in_array($post->post_type, $this->post_types);
    }

    /**
     * Save to Angolia
     */
    protected function saveToAlgolia($post)
    {
        // $this->index->saveObject($post);
        $this->index->partialUpdateObject($post, [
            'createIfNotExists' => true,
        ]);
    }
    
    /**
     * Save all posts to Algolia
     */
    public function saveAllPostsToAgolia()
    {
        global $algolia;

        $this->algolia = SearchClient::create($this->client_id, $this->admin_api_key);

        if( $this->algolia ) {
            $this->index = $this->algolia->initIndex($this->index);
        }

        foreach ($this->post_types as $post_type) {
            global $wp_query;

            $args = [
                'post_type' => $post_type,
            ];

            $posts = get_posts($args);

            foreach($posts as $post) {
                $array = (array) $post;
                $array['objectID'] = $post->ID;
                $array['img'] = get_the_post_thumbnail_url($post->ID);
    
                $this->index->saveObject($array);
            }
        }
    }
}
