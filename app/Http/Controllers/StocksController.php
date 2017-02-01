<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StocksIndexData;
// use App\Http\Requests\StockCreateRequest;
use App\Stock;

class StocksController extends Controller
{
	protected $indexData;

    public function __construct(StocksIndexData $indexData)
    {
        $this->indexData = $indexData;
    }

    /**
     * 库存列表
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $data = $this->indexData->indexData($request);

        return view('stock.index', $data);
    }

    /**
     * 入库列表
     * 
     * @return Response
     */
    public function storage(Request $request)
    {
        $data = $this->indexData->insertData($request);

        return view('stock.storage', $data);
    }
    
    /**
     * 删除一条待入库信息
     *
     * @param int $key
     * @return Response
     */
    public function destroy($key)
    {
        $this->indexData->setInsertDataByKey($key);

        return redirect('stocks/storage')
                        ->withSuccess("条形码 $key 处理成功");
    }

    /**
     * 入库
     *
     * @return Response
     */
    public function store()
    {
        $this->indexData->insertDatas();
        
        return redirect('stocks')
                        ->withSuccess('入库成功');
    }

    /**
     * 删除一条库存信息
     *
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        $stock = Stock::findOrFail($id);
        $stock->delete();

        return redirect('stocks')
                        ->withSuccess("库存编号 $id 删除成功");
    }

}
