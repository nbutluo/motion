<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_category';
    protected $primaryKey = 'category_id';

    public function getFind($id)
    {
        if ($this->where('category_id', $id)->first()) {
            return $this->where('category_id', $id)->first()->toArray();
        } else {
            return [];
        }
    }

    public function addCategory($data)
    {
        if (!isset($data['include_in_menu'])) {
            $data['include_in_menu'] = 0;
        }

        return $this->insertGetId($data);
    }

    public function updateCategory($id, $data)
    {
        if ($this->find($id)) {
            return $this->where('category_id', $id)->update($data);
        } else {
            return false;
        }
    }
}
