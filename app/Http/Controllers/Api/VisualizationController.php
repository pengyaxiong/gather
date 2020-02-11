<?php

namespace App\Http\Controllers\Api;

use App\Models\Cms\Customer;
use App\Models\Shop\Product;
use App\Models\System\User;
use App\Models\Tool\Supermarket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB, Cache;
use Spatie\Activitylog\Models\Activity;

class VisualizationController extends Controller
{
    //本周起止时间unix时间戳
    private $week_start;
    private $week_end;

    //本月起止时间unix时间戳
    private $month_start;
    private $month_end;

    function __construct()
    {
        $this->week_start = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));
        $this->week_end = mktime(23, 59, 59, date("m"), date("d") - date("w") + 7, date("Y"));

        $this->month_start = mktime(0, 0, 0, date("m"), 1, date("Y"));
        $this->month_end = mktime(23, 59, 59, date("m"), date("t"), date("Y"));
    }

    /**
     * 本周销售额
     * @return array
     */
    function sales_amount()
    {
        return Cache::remember('xApi_visualization_sales_amount', 60, function () {
            $amount = [];
            for ($i = 0; $i < 7; $i++) {
                $start = date('Y-m-d H:i:s', strtotime("+" . $i . " day", $this->week_start));
                $end = date('Y-m-d H:i:s', strtotime("+" . ($i + 1) . " day", $this->week_start));
                $amount['create'][] = Order::whereBetween('created_at', [$start, $end])->where('status', 1)->sum('total_price');
                $amount['pay'][] = Order::whereBetween('pay_time', [$start, $end])->where('status', '>', 1)->sum('total_price');
            }

            $data = [
                'week_start' => date("Y年m月d日", $this->week_start),
                'week_end' => date("Y年m月d日", $this->week_end),
                'amount' => $amount,
            ];
            return $data;
        });


    }

    /**
     *
     * /**
     * @return array
     */
    function statistics_customer()
    {
        $year = date("Y", time());
        $num = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = strlen($i) == 1 ? '0' . $i : $i;
            $like = $year . '_' . $month . '%';
            $num[] = Customer::where('created_at', 'like', $like)->count();
        }

        $data = [
            'this_year' => $year,
            'num' => $num
        ];
        return $data;
    }


    /**
     * 贷超浏览情况
     * @return array
     */
    function statistics_supermarket()
    {
        Supermarket::clear();
        $supermarkets = Supermarket::get_supermarkets();

        if (!empty($supermarkets)) {
            foreach ($supermarkets as $key => $supermarket) {

                $supermarkets[$key]['num'] = Activity::where(array('log_name' => 'supermarket', 'subject_id' => $supermarket['id']))->count();

            }
        }

        return $supermarkets;
    }

    function statistics_product()
    {
        $products = Product::all();
        if (!empty($products)) {
            foreach ($products as $key => $product) {

                $products[$key]['num'] = Activity::where(array('log_name' => 'product', 'subject_id' => $product['id']))->count();

            }
        }
        return $products;
    }

    /**
     * @param $user_id
     * @param $start_date
     * @param $end_date
     * @return mixed
     */
    function product_pv($user_id, $start_date, $end_date)
    {
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        if ($user_id == 1) {
            $product_pvs = Product::withCount(['pvs' => function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }])->get();
        } else {
            $user = User::find($user_id);
            $rate = $user->rate;
            $product_pvs = Product::withCount(['pvs' => function ($query) use ($user_id, $start, $end) {
                $query->where('user_id', $user_id);
                $query->whereBetween('created_at', [$start, $end]);
            }])->get();

            foreach ($product_pvs as $key => $product_pv) {
                $product_pvs[$key]['pvs_count'] = intval($rate * $product_pv['pvs_count']);
            }
        }

        return $product_pvs;
    }

    function supermarket_pv($user_id, $start_date, $end_date)
    {
        $start = $start_date . ' 00:00:00';
        $end = $end_date . ' 23:59:59';

        if ($user_id == 1) {
            $product_pvs = Supermarket::withCount(['pvs' => function ($query) use ($start, $end) {
                $query->whereBetween('created_at', [$start, $end]);
            }])->get();
        } else {
            $user = User::find($user_id);
            $rate = $user->rate;
            $product_pvs = Supermarket::withCount(['pvs' => function ($query) use ($user_id, $start, $end) {
                $query->where('user_id', $user_id);
                $query->whereBetween('created_at', [$start, $end]);
            }])->get();

            foreach ($product_pvs as $key => $product_pv) {
                $product_pvs[$key]['pvs_count'] = intval($rate * $product_pv['pvs_count']);
            }
        }

        return $product_pvs;
    }
}
