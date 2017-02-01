<?php

namespace App\Services;

use App\Stock;
use Illuminate\Support\Facades\Cache;

class StocksIndexData
{
    /**
     * 获取首页数据
     *
     * @return array
     */
    public function indexData($request)
    {
        if ($request->goods_num || $request->bar_code) {
            return $this->getIndexData($request);
        }

        return $this->normalIndexData();
    }

    /**
     * Return data for normal index page
     *
     * @return array
     */
    protected function normalIndexData()
    {
        $data = Stock::where('amount', '>', 0)
            ->orderBy('id', 'desc')
            ->get();

        return ['stocks' => $data];
    }

    /**
     * Return data for a request index page
     *
     * @param string $tag
     * @return array
     */
    protected function getIndexData($request)
    {
        $data = Stock::where('goods_num', $request->goods_num)
            ->orWhere('bar_code', $request->bar_code)
            ->orderBy('id', 'desc')
            ->get();

        return [
            'goods_num' => $request->goods_num,
            'bar_code' => $request->bar_code,
            'stocks' => $data
        ];
    }

    /**
     * 获取待入库数据
     *
     * @return array
     */
    public function insertData($request = '')
    {
        // Cache::forget('insert-stocks');
        if ($request->goods_num && $request->bar_code) {
            return $this->addInsertData($request);
        }

        return $this->getInsertData();
    }

    /**
     * Return data with add data
     *
     * @return array
     */
    protected function addInsertData($request)
    {
        $data = Cache::get('insert-stocks', []);
        if (isset($data[$request->bar_code])) {
            $amount = $data[$request->bar_code]['amount'] + 1;
        } else {
            $amount = 1;
        }
        $data[$request->bar_code] = [
            'goods_num' => $request->goods_num,
            'bar_code' => $request->bar_code,
            'amount' => $amount,
        ];

        Cache::forever('insert-stocks', $data);
        return [
            'goods_num' => $request->goods_num,
            'stocks' => $data
        ];
    }

    /**
     * Return data for add data
     *
     * @return array
     */
    protected function getInsertData()
    {
        return ['stocks' => Cache::get('insert-stocks', [])];
    }

    /**
     * 清减指定key的待入库信息
     *
     * @param int $key
     * @return array
     */
    public function setInsertDataByKey($key = 0)
    {
        $data = Cache::get('insert-stocks', []);
        if ($data[$key]['amount'] > 1) {
            $data[$key]['amount'] = $data[$key]['amount'] - 1;
        } else {
            unset($data[$key]);
        }
        Cache::forever('insert-stocks', $data);
        return ['stocks' => $data];
    }

    /**
     * 待入库数据入库
     * 
     * @return void
     */
    public function insertDatas()
    {
        // 获取缓存数据
        $data = Cache::get('insert-stocks', []);
        if (! empty($data)) {
            foreach ($data as $key => $value) {
                // 检测条形码是否存在
                $info = Stock::where('bar_code', $key)->first();
                if ($info) {
                    Stock::where('bar_code', $key)
                            ->update(['amount' => $info->amount + $data[$key]['amount']]);
                } else {
                    Stock::create($data[$key]);
                }
            }
            Cache::forget('insert-stocks');
        }
    }

}
