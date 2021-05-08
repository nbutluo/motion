<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Model\FooterLinks;
use App\Http\Controllers\ApiController;
use Exception;

class FooterLinksController extends ApiController
{
    public function getLinks()
    {
        try {
            $data = [];
            $links = FooterLinks::orderBy('parent_id','ASC')->orderBy('sort','ASC')->get();
            if (!empty($links->toArray())) {
                foreach ($links as $link) {
                    $newData = [];
                    if ($link->parent_id == 0) {
                        $newData['label'] =  $link->label;
                        $newData['value'] =  $link->value;
                        $newData['sort'] =  $link->sort;
                        $list = [];
                        foreach ($links as $li) {
                            if ($li->parent_id == $link->id) {
                                $list[] = [
                                    'label' => $li->label,
                                    'value' => $li->value,
                                    'sort' => $li->sort,
                                ];
                            }
                        }
                        $newData['child'] = $list;
                        $data[] = $newData;
                    }
                }
            } else {
                throw new Exception('empty','404');
            }
            return $this->success('successful',$data);
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }
    }
}
