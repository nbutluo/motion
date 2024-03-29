<?php

namespace App\Observers;

use App\Model\Blog\Blog;

class BlogObserver
{
    public function saving(Blog $blog)
    {
        if (empty($blog->meta_title)) {
            $blog->meta_title = $blog->title;
        }

        if (empty($blog->meta_description)) {
            $blog->meta_description = make_excerpt($blog->content) ?? '';
        }

        if (empty($blog->featured_img_alt)) {
            $blog->featured_img_alt = $blog->title;
        }

        if (empty($blog->meta_keywords)) {
            $blog->meta_keywords = $blog->keywords;
        }
    }
}
