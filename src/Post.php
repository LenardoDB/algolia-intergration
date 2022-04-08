<?php

namespace LenardoDB\AlgoliaIntergration;

use LenardoDB\AlgoliaIntergration\Algolia;

class Post
{
    /**
     * Save post to Algolia
     * 
     * @param string $post_id
     * @param obj $post
     */
    public static function savePost($post_id, $post)
    {
        $algolia = new Algolia();
        if($post && $post->post_status == 'publish') {
            $algolia->addPost($post);
        } elseif ( $post->post_status == 'private' ) {
            $post_array[] = $post_id;
            $algolia->deletePost($post_array);
        }
    }

    /**
     * Delete post from Algolia
     * 
     * @param string $post_id
     * @param obj $post
     */
    public static function deletePost($post_id)
    {
        // dd($post);
        $post[] = $post_id;
        $algolia = new Algolia();
        $algolia->deletePost($post);
    }
}
