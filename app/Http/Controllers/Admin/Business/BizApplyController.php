<?php

namespace App\Http\Controllers\Admin\Business;

use App\Models\Biz;
use App\Models\Biz_Apply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BizApplyController extends Controller
{
    const STATUS = [
        1 => '未审核',
        2 => '审核通过',
        -1 => '已驳回',
    ];

    /**
     * 入驻资质审核列表
     */
    public function index(Request $request)
    {
        $ba_obj = new Biz_Apply();
        $b_obj = new Biz();
        $input = $request->input();

        //搜索
        if (isset($input['search']) && $input['search'] == 1) {
            if ($input['Biz_Account']) {
                $BizInfo = $b_obj->select('Biz_ID')->where('Biz_Account', $input['Biz_Account'])->first();
                if ($BizInfo) {
                    $ba_obj = $ba_obj->where('Biz_ID', $BizInfo['Biz_ID']);
                }else{
                    $ba_obj = $ba_obj->where('Biz_ID', '');
                }
            }
            if ($input['status'] != "all") {
                $ba_obj = $ba_obj->where('status', $input['status']);
            }
        }

        $lists = $ba_obj->where('is_del', 1)->orderByDesc('id')->paginate(15);
        foreach ($lists as $key => $value) {
            $value['_STATUS'] = self::STATUS[$value['status']];
        }

        //审核通过
        if (isset($input['action']) && $input['action'] == 'read') {
            $biz = $ba_obj->find($input['id']);
            $biz->status = 2;
            $Flag = $biz->save();
            $Flag_a = $b_obj->where('Biz_ID', $biz['Biz_ID'])->update(["is_auth" => 2]);
            if ($Flag && $Flag_a) {
                return redirect()->back()->with('success', '审核成功');
            } else {
                return redirect()->back()->with('errors', '审核失败');
            }
        }

        //驳回
        if (isset($input['action']) && $input['action'] == 'back') {
            $biz = $ba_obj->find($input['id']);
            $biz->status = -1;
            $Flag = $biz->save();
            $Flag_a = $b_obj->where('Biz_ID', $biz['Biz_ID'])->update(["is_auth" => -1]);
            if ($Flag && $Flag_a) {
                return redirect()->back()->with('success', '驳回成功');
            } else {
                return redirect()->back()->with('errors', '驳回失败');
            }
        }

        return view('admin.business.biz_apply', compact('lists'));
    }


    /**
     * 查看详情
     * @param $id
     */
    public function show($id)
    {
        $ba_obj = new Biz_Apply();

        $BizInfo = $ba_obj->find($id);

        $baseinfo = json_decode($BizInfo['baseinfo'],true);
        $authinfo = json_decode($BizInfo['authinfo'],true);
        $accountinfo = json_decode($BizInfo['accountinfo'],true);

        return view('admin.business.biz_apply_show', compact('BizInfo', 'baseinfo', 'authinfo', 'accountinfo'));
    }


    /**
     * 删除资质审核申请
     * @param $id
     */
    public function del($id)
    {
        $ba_obj = new Biz_Apply();
        $b_obj = new Biz();

        $biz = $ba_obj->find($id);
        $biz->status = -1;
        $biz->is_del = 0;
        $Flag = $biz->save();
        $Flag_a = $b_obj->where('Biz_ID', $biz['Biz_ID'])->update(["is_auth" => -1]);
        if ($Flag && $Flag_a) {
            return redirect()->back()->with('success', '删除成功');
        } else {
            return redirect()->back()->with('errors', '删除失败');
        }
    }


}
