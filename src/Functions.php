<?php

namespace BlackDesk\AlgoliaIntergration;

use BlackDesk\AlgoliaIntergration\AdminFields;

class Functions
{
    public function __construct()
    {
        new AdminFields();
        add_action('save_post', 'BlackDesk\AlgoliaIntergration\Post::savePost', 100, 2);
        add_action('delete_post', 'BlackDesk\AlgoliaIntergration\Post::deletePost', 100, 1);
    }
}
