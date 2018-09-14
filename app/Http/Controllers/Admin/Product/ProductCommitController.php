<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\User_Order_Commit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductCommitController extends Controller
{
    /**
     * 评论列表
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $status=['待审核', '已审核'];
        $commtype = ['shop' => '商品购买','offline_st' => '店内买单', 'offline_qrcode' => '线下扫码'];
        $uoc_obj = new User_Order_Commit();
        $lists = $uoc_obj->orderBy('CreateTime', 'desc')->paginate(15);

        return view('admin.product.commit', compact('status', 'commtype', 'lists'));
    }

    /**
     * 删除评论
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function del($id)
    {
        $uoc_obj = new User_Order_Commit();
        $flag = $uoc_obj->destroy($id);
        if($flag){
            return redirect()->back()->with('success', '删除成功');
        }else{
            return redirect()->back()->with('errors', '删除失败');
        }
    }

    /**
     * 修改审核状态
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function audit($id)
    {
        $uoc_obj = new User_Order_Commit();
        $commit = $uoc_obj->find($id);
        if($commit->Status == 1){
            $commit->Status = 0;
            $flag = $commit->save();
        }else{
            $commit->Status = 1;
            $flag = $commit->save();
        }
        if($flag){
            return redirect()->back()->with('success', '修改成功');
        }else{
            return redirect()->back()->with('errors', '修改失败');
        }
    }

}
