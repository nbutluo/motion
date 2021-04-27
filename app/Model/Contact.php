<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\Paginator;

class Contact extends Model
{
    use SoftDeletes;

    protected $table = 'contact';
    protected $primaryKey = 'id';

    protected $dates = ['deleted_at'];

    //考虑到性能问题，通常$columns我们不以*号为值。可传入需要查询的字段替代。这里只做演示。无此要求
    public function paginate($perPage = null, $columns = ['*'], $page = null, $pageName = 'page', $where = [])
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        if ($total = $this->toBase()->getCountForPagination()) {
            if (!empty($where)) {
                $forPageCollection = $this->forPage($page, $perPage);
                foreach ($where as $k => $w) {
                    $forPageCollection = $forPageCollection->where($k, $w);
                }
                $results = $forPageCollection->get($columns);
            } else {
                $results = $this->forPage($page, $perPage)->get($columns);
            }
        } else {
            $results = $this->model->newCollection();
        }

        $pages = ceil($total / $perPage);
        $result = ['total' => $total, 'current_page' => $page, 'page_size' => $perPage, 'pages' => $pages, 'list' => $results];
        return $result;
    }

    public function getPageList($page, $pageSize, $where = [], $selects = ['*'])
    {
        return $this->paginate($pageSize, $selects, $page, 'page', $where);
    }


}
