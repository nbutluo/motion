<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;

class MediumSource extends Model
{
    use SoftDeletes;

    protected $table = 'medium_source';
    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    //考虑到性能问题，通常$columns我们不以*号为值。可传入需要查询的字段替代。这里只做演示。无此要求
    public function paginate($perPage = null, $columns = ['*'], $page = null, $pageName = 'page', $where = [])
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        if (!empty($where)) {
            $toBaseCollection = $this->toBase();
            foreach ($where as $k => $w) {
                if (is_array($w)) {
                    $toBaseCollection = $toBaseCollection->whereIn($k, $w);
                } else{
                    $toBaseCollection = $toBaseCollection->where($k, $w);
                }
            }
            if ($total = $toBaseCollection->getCountForPagination()) {
                $forPageCollection = $this->forPage($page, $perPage);
                foreach ($where as $k => $w) {
                    if (is_array($w)) {
                        $forPageCollection = $forPageCollection->whereIn($k, $w);
                    } else{
                        $forPageCollection = $forPageCollection->where($k, $w);
                    }
//                    $forPageCollection = $forPageCollection->where($k, $w);
                }
                $results = $forPageCollection->get($columns);
                //资源添加域名
//                foreach ($results as $result) {
//                    if (isset($result->media_links) && $result->media_links != '') {
//                        $result->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$result->media_links;
//                    }
//                    if (isset($result->media_url) && $result->media_url != '') {
//                        $result->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$result->media_url;
//                    }
//                }
                foreach ($results as $res) {
                    if (!isset($res->category_id) || $res->category_id == 0) {
                        $res->category_id = '未分配';
                    } else {
                        $categoryData = MediumSourceCategory::findOrFail($res->category_id);
                        $res->category_id = $categoryData->name;
                    }
                }
            } else {
                $results = [];
            }
        } else {
            if ($total = $this->toBase()->getCountForPagination()) {
                $results = $this->forPage($page, $perPage)->get($columns);
                //资源添加域名
//                foreach ($results as $result) {
//                    if (isset($result->media_links) && $result->media_links != '') {
//                        $result->media_links = HTTP_TEXT.$_SERVER["HTTP_HOST"].$result->media_links;
//                    }
//                    if (isset($result->media_url) && $result->media_url != '') {
//                        $result->media_url = HTTP_TEXT.$_SERVER["HTTP_HOST"].$result->media_url;
//                    }
//                }
                foreach ($results as $res) {
                    if (!isset($res->category_id) || $res->category_id == 0) {
                        $res->category_id = '未分配';
                    } else {
                        $categoryData = MediumSourceCategory::findOrFail($res->category_id);
                        $res->category_id = $categoryData->name;
                    }
                }
            } else {
                $results = [];
            }
        }

        $pages = ceil($total / $perPage);
        $result = ['total' => $total, 'current_page' => $page, 'page_size' => $perPage, 'pages' => $pages, 'list' => $results];
        return $result;
    }

    public function getPageList($page, $pageSize, $where = [], $selects = ['*'])
    {
        return $this->paginate($pageSize, $selects, $page, 'page', $where);
    }

    public function updateMedia($id, $params)
    {
        return $this->where('id', $id)->update($params);
    }
}
