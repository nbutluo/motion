<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
//use Spatie\Newsletter\Newsletter;


class SubscriptionController extends ApiController
{
    public function store(Request $request)
    {
        $name = isset($request->name) ? $request->name : '';
        try {
            if (!isset($request->email) || $request->email == '') {
                throw new \Exception('email is empty!');
            }
            if ( ! Newsletter::isSubscribed($request->email) )
            {
                Newsletter::subscribe($request->email,['FNAME'=>$name, 'LNAME'=>'']);
                return $this->success('send email successful!','Thanks For Subscribe');
            } else {
                throw new \Exception('failure');
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(), 'Sorry! You have already subscribed ');
        }
//        Newsletter::delete($request->email);
    }
}
