<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Support\Facades\Redis;
class Torrentkitty extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:torrentkitty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '种子链接地址自动选择';

    private $link;
    private $links = [];
    private $totalCount;

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
        $url = "http://torrentkittyurl.com/tk/";
        $goutte_client = new GoutteClient();
        $crawler = $goutte_client->request('GET', $url);
        $crawler->filter('.text>h2>strong>a')->each(function ($node) {
            $this->links[] = $node->first()->attr('href');
            $this->info($node->first()->attr('href'));
            Redis::rpush('torrentkittyurls', $node->first()->attr('href'));
        });

        $this->totalCount = count($this->links);
        $this->info("请求".$this->totalCount."条链接");
        $client = new GuzzleClient([
            // You can set any number of default request options.
            'timeout' => 2.6,
        ]);
        foreach ($this->links as $key => $link) {

            try {
                //抛出错误的代码
                $client->get($link);
            } catch (ConnectException $ex) {
                //   return $ex->getMessage();
                continue;
            }
            $this->link = $link;
        }
        $this->info($this->link);
        Redis::set('torrentkittyurl',$this->link);
    }
}
