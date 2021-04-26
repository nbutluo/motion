<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class BlogCategory extends Model
{
    protected $table = 'blog_category';
    protected $primaryKey = 'category_id';

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

    public function getCategoriesInHome()
    {
        // is_active \ include_in_menu \ position DESC
        return $this->select('category_id', 'title', 'identifier', 'content', 'position')->where('is_active', '1')->where('include_in_menu', '1')->orderBy('position', 'DESC')->get()->toArray();
    }

    // 更新激活状态
    public function updateActiveStatus($ids, $status = 1)
    {
        return $this->whereIn('category_id', $ids)->update(['is_active' => $status]);
    }
}
