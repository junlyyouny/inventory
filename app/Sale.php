<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Stock;

class Sale extends Model
{
	protected $fillable = [
        'goods_num', 'bar_code', 'amount', 
    ];
    
    /**
     * 获取流水数据
     *
     * @return array
     */
    public function getSalesData($request)
    {
        if ($request->startTime && $request->endTime) {
            return $this->getSeachData($request);
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
        $data = Sale::where('created_at', '>=', Carbon::today())
		        	->where('created_at', '<', Carbon::tomorrow())
		            ->get();

        return [
        	'startTime' => Carbon::today(),
        	'endTime' => Carbon::tomorrow(),
        	'sales' => $data
        ];
    }

    /**
     * Return data for seach index page
     *
     * @return array
     */
    protected function getSeachData($request)
    {
    	if ($request->startTime == $request->endTime) {
    		$request->endTime = date('Y-m-d', strtotime('+1 day', strtotime($request->endTime)));
    	}
        $data = Sale::where('created_at', '>=', $request->startTime)
		        	->where('created_at', '<=', $request->endTime)
		            ->get();

        return [
        	'startTime' => $request->startTime,
        	'endTime' => $request->endTime,
        	'sales' => $data
        ];
    }

    /**
     * 删除一条流水数据
     *
     * @param int $id
     * @return void
     */
    public function deleteSalesData($id)
    {
        if ($id) {

            $sale = Sale::findOrFail($id);

        	if ($sale->delete()) {
        		// 还原库存
        		$info = Stock::where('bar_code', $sale->bar_code)->first();
                if ($info) {
                    Stock::where('bar_code', $sale->bar_code)
                            ->update(['amount' => $info->amount + $sale->amount]);
                } else {
                	$data = [
                		'goods_num' => $sale->goods_num,
                		'bar_code' => $sale->bar_code,
                		'amount' => $sale->amount,
                	];

                    Stock::create($data);
                }
        	}
        }
    }

    /**
     * 获取待出库数据
     *
     * @return array
     */
    public function insertData($request = '')
    {
        if ($request->stock_num || $request->bar_code) {
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
        $data = Cache::get('insert-sales', []);
        // 获取库存信息
        $stocks = Stock::where('id', $request->stock_num)
				            ->orWhere('bar_code', $request->bar_code)
				            ->first();
        if (!$stocks) {
            return ['error' => '库存信息不存在！'];
        }

        if (isset($data[$stocks->id])) {
            $amount = $data[$stocks->id]['amount'] + 1;
        } else {
            $amount = 1;
        }
        if ($amount > $stocks->amount) {
        	return ['error' => '库存不足！现余库存数 '.$stocks->amount];
        }
        $data[$stocks->id] = [
            'goods_num' => $stocks->goods_num,
            'bar_code' => $stocks->bar_code,
            'amount' => $amount,
        ];

        Cache::forever('insert-sales', $data);
        return ['sales' => $data];
    }

    /**
     * Return data for add data
     *
     * @return array
     */
    protected function getInsertData()
    {
        return ['sales' => Cache::get('insert-sales', [])];
    }

    /**
     * 清减指定编号的待出库信息
     *
     * @param int $id
     * @return array
     */
    public function setInsertDataById($id = 0)
    {
        $data = Cache::get('insert-sales', []);

        if ($data[$id]['amount'] > 1) {
            $data[$id]['amount'] = $data[$id]['amount'] - 1;
        } else {
            unset($data[$id]);
        }
        
        Cache::forever('insert-sales', $data);
        return ['sales' => $data];
    }

    /**
     * 待出库数据入库
     * 
     * @return void
     */
    public function insertDatas()
    {
        // 获取缓存数据
        $data = Cache::get('insert-sales', []);
        if (! empty($data)) {
            foreach ($data as $key => $value) {
                Sale::create($data[$key]);
                // 清减库存
                $Stock = Stock::find($key);
                $Stock->amount = $Stock->amount - $value['amount'];
                $Stock->save();
            }
            Cache::forget('insert-sales');
        }
    }
}
