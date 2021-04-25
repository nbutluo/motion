<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Blog extends Model
{
    protected $table = 'blog_post';
    protected $primaryKey = 'post_id';

    //考虑到性能问题，通常$columns我们不以*号为值。可传入需要查询的字段替代。这里只做演示。无此要求
    public function paginate($perPage = null, $columns = ['*'], $page = null, $pageName = 'page')
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        $results = ($total = $this->toBase()->getCountForPagination())
            ? $this->forPage($page, $perPage)->get($columns)
            : $this->model->newCollection();
        $pages = ceil($total / $perPage);
        $result = ['total' => $total, 'current_page' => $page, 'page_size' => $perPage, 'pages' => $pages, 'list' => $results];
        return $result;
    }

    public function getPageList($page, $pageSize)
    {
        return $this->paginate($pageSize, ['*'], $page, 'page');
    }

    public function getFind($id)
    {
        if ($this->where('post_id', $id)->first()) {
            return $this->where('post_id', $id)->first()->toArray();
        } else {
            return [];
        }
    }

    public function addPost($data)
    {
        if (!isset($data['show_in_home'])) {
            $data['show_in_home'] = 0;
        }

        if (!isset($data['image_title'])) {
            $data['image_title'] = '';
        }

        if (!isset($data['image_alt'])) {
            $data['image_alt'] = '';
        }

        if (!isset($data['image_description'])) {
            $data['image_description'] = '';
        }

        return $this->insertGetId($data);
    }

    public function updatePost($id, $data)
    {
        if ($this->find($id)) {
            return $this->where('post_id', $id)->update($data);
        } else {
            return false;
        }
    }
}
