<?php

namespace App\Http\Controllers;

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
                    if ($link->parent_id == 0) {
                        $data[$link->id]['label'] =  $link->label;
                        $data[$link->id]['value'] =  $link->value;
                        $data[$link->id]['sort'] =  $link->sort;
                    } else {
                        $data[$link->parent_id][$link->id]['label'] = $link->label;
                        $data[$link->parent_id][$link->id]['value'] = $link->value;
                        $data[$link->parent_id][$link->id]['sort'] = $link->sort;
                    }
                }
            } else {
                throw new Exception('empty','4003');
            }
            return $this->success('successful',$data);
        } catch (Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }
    }
}
