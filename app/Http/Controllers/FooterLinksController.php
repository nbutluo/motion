<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\FooterLinks;

class FooterLinksController extends Controller
{
    public function getLinks()
    {
        $data = [];
        $links = FooterLinks::orderBy('parent_id','ASC')->orderBy('sort','ASC')->get();
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
        return Response()->json($data);
    }
}
