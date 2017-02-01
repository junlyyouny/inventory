<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sale;

class SalesController extends Controller
{
	protected $sale_mod;

    public function __construct()
    {
        $this->sale_mod = new Sale;
    }

    /**
	 * 流水列表
	 * 
	 * @return [void]
	 */
	public function index(Request $request)
	{
		$data = $this->sale_mod->getSalesData($request);

		return view('sale.index', $data);
	}

	/**
     * 删除一条流水信息
     *
     * @param int $id
     * @return Response
     */
    public function delete($id)
    {
        $this->sale_mod->deleteSalesData($id);

        return redirect('stocks')
                        ->withSuccess("库存编号 $id 删除成功");
    }

    /**
	 * 出库列表
	 * 
	 * @return Response
	 */
	public function delivering(Request $request) 
	{
		$data = $this->sale_mod->insertData($request);
		
		if (isset($data['error'])) {
			return redirect()->back()
	                ->withErrors($data['error']);
		}

        return view('sale.delivering', $data);
	}

	/**
     * 删除一条待出库信息
     *
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->sale_mod->setInsertDataById($id);

        return redirect('sales/delivering')
                        ->withSuccess("库存编号 $id 处理成功");
    }

    /**
     * 出库
     *
     * @return Response
     */
    public function store()
    {
        $this->sale_mod->insertDatas();
        
        return redirect('sales')
                        ->withSuccess('出库成功');
    }


}
