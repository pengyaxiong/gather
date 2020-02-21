<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;

use Exception;
use Goutte\Client as GoutteClient;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request as GuzzleRequest;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Redis;
class HomeController extends Controller
{
    private $link;
    private $links = [];

    private $detail = [];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customer.index');
    }

    public function customer()
    {
        $this->link=Redis::get('torrentkittyurl');
        $this->links=Redis::lrange ('torrentkittyurls', 0, -1);

        return view('customer.customer');
    }


    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function torrent(Request $request)
    {
        $messages = [
            'keyword.required' => '关键词不能为空!',
        ];
        $rules = [
            'keyword' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            $error = $validator->errors()->first();
            try {
                throw new Exception($error);
            } catch (Exception $e) {
                throw ValidationException::withMessages(['keyword' => $e->getMessage()]);
            }
        }
        $keyword = $request->keyword;
        $url = "http://www.torrentkitty.vip/search/" . $keyword;
        $goutte_client = new GoutteClient();
        $crawler = $goutte_client->request('GET', $url);
        
        $crawler->filter('.name')->slice(1)
            ->each(function ($node, $key) use ($goutte_client) {
                $this->detail[$key]['name'] = $node->text();
                $this->detail[$key]['size'] = $node->siblings()->filter('.size')->text();
                $this->detail[$key]['date'] = $node->siblings()->filter('.date')->text();
                $this->detail[$key]['url'] = $node->siblings()->filter('.action')->children('a')->attr('href');
                //        echo $name . '--' . $size . '--' . $date  . '--' . $detail_url  . '<br>';
            });
        return back()->with('detail',$this->detail);
    }

    /**
     * @return string
     * @throws \GuzzleHttp\GuzzleException
     */
    public function test()
    {
        $url = "http://www.5di.tv/";
//        $request = new GuzzleRequest('GET', $url);
//        $guzzle_client=new GuzzleClient();
//        $response = $guzzle_client->send($request, ['timeout' => 5]);
//        $content = $response->getBody()->getContents();


        $goutte_client = new GoutteClient();
        $crawler = $goutte_client->request('GET', $url);
        $navs = $crawler->filter('.qcontainer');

//        $navs->each(function ($node) use ($goutte_client, $url) {
//
//            $title = $node->filter('.link-hover')->first()->attr('title');//文章标题
//            $image_url = $node->filter('.link-hover>img')->first()->attr('data-original');  //图片
//            $type = substr(strrchr($image_url, '.'), 1);
//
//            $path = public_path() . '/imgs';
//            File::isDirectory($path) or File::makeDirectory($path, 0777, true, true);
//
//            $goutte_client->getClient()->get($image_url, ['save_to' => $path . '/' . $title . '.' . $type,
//                'headers' => ['Referer' => $image_url]
//            ]);//下载图片
//
//
//            $link = $node->filter('.link-hover')->first()->attr('href');        //文章链接
//            $article = $goutte_client->request('GET', $url . $link);       //进入文章
//            $content = $article->filter('#stab2')->first()->text();     //获取内容
//
//
//            Log::info($title, ['url' => $image_url]);
//            echo $image_url . '<br>';
//
//            Storage::disk('my_file')->put('content/' . $title, $content);           //储存在本地
//
//        });

////点击链接：
//        $link = $crawler->selectLink('动作片')->link();
//        $crawler = $goutte_client->click($link);
////提取数据：
//        $crawler->filter('.qcontainer')->each(function ($node) {
//            $title = $node->filter('.link-hover')->first()->attr('title');//文章标题
//            echo $title . '<br>';
//        });
//提交表单：
        //    $crawler = $goutte_client->click($crawler->selectLink('Sign in')->link());
        $form = $crawler->filter('.sj-nav-down-search form')->form();
        $crawler = $goutte_client->submit($form, array('wd' => '2019'));
        $crawler->filter('.index-area>ul>li')->each(function ($node) {
            $title = $node->filter('.link-hover')->first()->attr('title');//文章标题
            echo $title . '<br>';
        });
    }
}
