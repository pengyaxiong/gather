<?php

namespace App\Http\Controllers\Api\System;

use App\Models\System\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $config = Config::first();
        return success_data('成功', $config);
    }

}
