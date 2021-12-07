<?php

namespace App\Model\Blog;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;

class Blog extends Model
{
    protected $table = 'blog_post';
    protected $primaryKey = 'post_id';
    protected $fillable = ['title'];

    //考虑到性能问题，通常$columns我们不以*号为值。可传入需要查询的字段替代。这里只做演示。无此要求
    public function paginate($perPage = null, $columns = ['*'], $page = null, $pageName = 'page', $where = [])
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        if ($total = $this->toBase()->getCountForPagination()) {
            $results = $this->forPage($page, $perPage)->where($where)->orderBy('created_at', 'desc')->get($columns);
        } else {
            //            $results = $this->model->newCollection();
            $results = '';
        }

        $pages = ceil($total / $perPage);
        $result = ['total' => $total, 'current_page' => $page, 'page_size' => $perPage, 'pages' => $pages, 'list' => $results];
        return $result;
    }

    public function getPageList($page, $pageSize, $where, $selects = ['*'])
    {
        return $this->paginate($pageSize, $selects, $page, 'page', $where);
    }

    public function getCategoryPostList($category_id, $page, $pageSize)
    {
        $where = [
            'category_id' => $category_id,
            'is_active'   => 1
        ];
        //        $select = ['post_id', 'title', 'identifier', 'content', 'views_count', 'short_content', 'category_id','featured_img','publish_time'];
        $select = ['post_id', 'title', /*'identifier', 'content', 'views_count','category_id',*/ 'short_content', 'featured_img', 'publish_time'];
        return $this->paginate($pageSize, $select, $page, 'page', $where);
    }

    public function getFind($id)
    {
        if ($this->where('post_id', $id)->first()) {
            return $this->where('post_id', $id)->first()->toArray();
        } else {
            return [];
        }
    }

    public function getSelectFind($id)
    {
        if ($this->where('post_id', $id)->first()) {
            //            return $this->select('post_id', 'title', 'meta_title', 'meta_keywords', 'meta_description', 'content', 'views_count', 'category_id')
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

    // 更新激活状态
    public function updateActiveStatus($ids, $status = 1)
    {
        return $this->whereIn('post_id', $ids)->update(['is_active' => $status]);
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }
}
