<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'catalog_product';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'sku', 'category_id', 'description', 'description_mobile', 'parameters', 'short_description',
        'relate_ids', 'url_key', 'price', 'position', 'is_active', 'image', 'image_label', 'small_image', 'small_image_label',
        'video_url', 'video_poster'
    ];

    protected $casts = [
        'is_new_arrival' => 'boolean',
    ];

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
                } else {
                    $toBaseCollection = $toBaseCollection->where($k, $w);
                }
            }
            if ($total = $toBaseCollection->getCountForPagination()) {
                $forPageCollection = $this->forPage($page, $perPage);
                foreach ($where as $k => $w) {
                    if (is_array($w)) {
                        $forPageCollection = $forPageCollection->whereIn($k, $w);
                    } else {
                        $forPageCollection = $forPageCollection->where($k, $w);
                    }
                }
                $results = $forPageCollection->get($columns);
            } else {
                $results = [];
            }
        } else {
            if ($total = $this->toBase()->getCountForPagination()) {
                $results = $this->forPage($page, $perPage)->orderBy('updated_at', 'desc')->get($columns);
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

    public function getDetailForApi($id, $select)
    {
        if ($this->where('id', $id)->first()) {
            return $this->select($select)->where('id', $id)->first()->toArray();
        } else {
            return [];
        }
    }

    public function updateProduct($id, $params)
    {
        return Product::where('id', $id)->update($params);
    }
}
