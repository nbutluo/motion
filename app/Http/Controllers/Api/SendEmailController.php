<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Mail\LoctekMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SendEmailController extends ApiController
{
    public function sendEmail(Request $request)
    {
        try {
            $email = trim($request->username);
            if (filter_var($email,FILTER_VALIDATE_EMAIL)) {
                //发送邮件
                $verifiCode = str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH);
                $sendData = [
                    'user' => $request->username,
                    'code' => $verifiCode
                ];
                $sessionCode = md5(str_pad(mt_rand(0, 999999), 6, "0", STR_PAD_BOTH));
                session([$sessionCode => $verifiCode]);
                $data = [
                    'user' => $request->username,
                    'code' => $sessionCode
                ];
                Mail::to([$email])->send(new LoctekMail($sendData));
                return $this->success('send email successful!',$data);
            } else {
                throw new \Exception($request->username.' is not a email!');
            }
        } catch (\Exception $exception) {
            return $this->fail($exception->getMessage(),$exception->getCode());
        }
    }
}
