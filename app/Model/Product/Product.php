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
        'meta_title', 'meta_description', 'url_key', 'price', 'relate_ids', 'set_product_ids', 'position', 'is_active',
        'is_new_arrival', 'image', 'image_label', 'small_image', 'small_image_label', 'video_url', 'video_poster', 'parameters_mobile',
        'meta_keywords', 'new_arrival_order',
    ];

    protected $casts = [
        'is_new_arrival' => 'boolean',
        'is_active' => 'boolean',
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

    public function paginateTwo($perPage = null, $columns = ['*'], $page = null, $pageName = 'page', $where = [])
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        if (!empty($where)) {
            $toBaseCollection = $this->toBase();

            if (is_array($where['category_id'])) {
                $toBaseCollection = $toBaseCollection->where('is_active', 1)->whereIn('category_id', $where['category_id']);
            } else {
                $toBaseCollection = $toBaseCollection->where('is_active', 1)->where('category_id', 'like', '%' . $where['category_id'] . '%');
            }

            if ($total = $toBaseCollection->getCountForPagination()) {
                $forPageCollection = $this->forPage($page, $perPage);

                if (is_array($where['category_id'])) {
                    $forPageCollection = $forPageCollection->where('is_active', 1)->whereIn('category_id', $where['category_id']);
                } else {
                    $forPageCollection = $forPageCollection->where('is_active', 1)->where('category_id', 'like', '%' . $where['category_id'] . '%');
                }

                $results = $forPageCollection->get($columns);

                if (!is_array($where['category_id'])) {

                    $results = $results->filter(function ($product) use ($where) {

                        $category_ids = explode(',', $product->category_id);
                        return in_array($where['category_id'], $category_ids);
                    });
                }
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

    public function getPageListTwo($page, $pageSize, $where = [], $selects = ['*'])
    {
        return $this->paginateTwo($pageSize, $selects, $page, 'page', $where);
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
