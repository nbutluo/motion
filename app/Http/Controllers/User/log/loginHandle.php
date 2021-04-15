<?php

namespace App\Http\Controllers\User\log;

use App\Model\User\LoginLog;
use Illuminate\Support\Carbon;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use App\Http\Controllers\User\log\Ipserver;

class loginHandle extends AbstractProcessingHandler
{
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        $user = auth()->user();

        $model = LoginLog::create([
            'uid' => $user->id,
            'ip' => IpServer::getRealIp(),
            'method' => request()->method(),
            'user_agent' => request()->header('User-Agent'),
            'message' => $record['message'],
            'login_time' => Carbon::now(),
        ]);

        // 保存登录日志 id，退出时使用
        session(['login_id' => $model->id]);
    }
}
