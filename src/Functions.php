<?php

namespace LenardoDB\AlgoliaIntergration;

use LenardoDB\AlgoliaIntergration\AdminFields;

class Functions
{
    public function __construct()
    {
        new AdminFields();
        add_action('save_post', 'LenardoDB\AlgoliaIntergration\Post::savePost', 100, 2);
        add_action('delete_post', 'LenardoDB\AlgoliaIntergration\Post::deletePost', 100, 1);
    }
}
