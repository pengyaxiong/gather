<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Storage;

class Spider extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:spider {concurrency} {keyWords*}';
    //concurrency为并发数 keyWords为查询关键词
    protected $signature = 'command:spider';

    private $totalPageCount;
    private $counter = 1;
    private $concurrency = 3;  // 同时并发抓取

    private $keyWords = ['css', 'js', 'laravel'];


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '爬虫';

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
        $this->totalPageCount = count($this->keyWords);

        $guzzle_client = new GuzzleClient();

        $goutte_client = new GoutteClient();

        $goutte_client->setClient($guzzle_client);

        $requests = function ($total) use ($goutte_client) {

            foreach ($this->keyWords as $key => $keyWord) {

                $url='https://www.youtube.com/results?search_query='.$key;
                yield function () use ($goutte_client, $url) {
                   // return $client->getAsync($url);
                    return $goutte_client->request('GET',$url);
                };
            }
        };

        $pool = new Pool($guzzle_client, $requests($this->totalPageCount), [
            'concurrency' => $this->concurrency,//并发数
            'fulfilled' => function ($response, $index) use ($goutte_client) {

                $response->filter('h2 > a')->reduce(function($node) use ($goutte_client){
                    if(strlen($node->attr('title'))==0) {
                        $title = $node->text();             //文章标题
                        $link = $node->attr('href');        //文章链接
                        $carwler = $goutte_client->request('GET',$link);       //进入文章
                        $content=$carwler->filter('#emojify')->first()->text();     //获取内容
                        Storage::disk('my_file')->put($title,$content);           //储存在本地
                    }
                });

                $this->countedAndCheckEnded();
            },
            'rejected' => function ($reason, $index) {
                $this->error("rejected");
                $this->error("rejected reason: " . $reason);
                $this->countedAndCheckEnded();
            },
        ]);

        // 开始发送请求
        $promise = $pool->promise();
        $promise->wait();
    }

    public function countedAndCheckEnded()
    {
        if ($this->counter < $this->totalPageCount) {
            $this->counter++;
            return;
        }
        $this->info("请求结束！");
    }
}
