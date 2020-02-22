<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class UV extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:uv';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'UV';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //查询所有WebStatistics缓存记录数据
        $count = Redis::LLEN('WebStatistics');
        $redisList = Redis::lrange('WebStatistics', 0, $count);
        $this->info($count);
        //3小时前
        $time = date('Y-m-d H:i:s', strtotime("-3 hours"));
        array_walk($redisList, function ($value, $key) use ($time) {
            //返回并删除名称为key的list中的尾元素
            $lpop = Redis::rpop('WebStatistics');

            $saveParams = json_decode($lpop, true);

            $result = \App\Models\Tool\UV::where('ip', $saveParams['ip'])->where('created_at', '>', $time)->exists();
            if (!$result) {
                \App\Models\Tool\UV::create($saveParams);
            }
        });

    }
}
