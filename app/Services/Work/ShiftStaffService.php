<?php
/**
 * 商業邏輯 - 工作班別設定 > 人員班表資訊
 */
namespace App\Services\Work;

use App\Repository\StaffShifts as Repository;
use App\Repository\ShiftsInfo as ShiftsRepository;
use Validator;
use Website;
use Config;
use Lang;
use Auth;
use Request;

class ShiftStaffService
{
    protected $oModel;
    private $sRedirect;

    public function __construct(Repository $Model, ShiftsRepository $ShiftsModel)
    {
        $this->oModel = $Model;
        $this->oShiftsModel = $ShiftsModel;
        $this->sRedirect = Request::root().'/Work/Shift/Staff';
    }

    /**
     * 列表頁面
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function getList(array $aParam = array())
    {
        /* Set */
        $aInfo = $aGet = $aSearch = array();
        $aShift = $this->oShiftsModel->getAll()->toArray();
        $aReplace = array('date' => 'shift_date', 'shift' => 'shift_name');

        /* 驗證查詢參數是否正確 */
        $aFormat = array(
            'date'  => 'required|date_format:Y-m-d',
            'shift' => 'required|in:"'.implode('","', $aShift).'"'
        );

        $aError = Validator::make($aParam, $aFormat)->messages();
        foreach ($aFormat as $sKey => $sVal) {
            $aGet[$sKey] = ($aError->has($sKey)) ?  '' : $aParam[$sKey];
            $aSearch[$aReplace[$sKey]] = $aGet[$sKey];
        }
        $aSearch['per_page'] = Config::get('website.per_page');
        $aInfo = $this->oModel->getList($aSearch);

        return array('info' => $aInfo, 'get' => $aGet, 'shift' => $aShift);
    }

    /**
     * 新增資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function add(array $aParam = array())
    {
        try {
            $aCity = Auth::user()->city;
            /* 驗證資料 */
            $aFormat = array(
                'shift_name'       => 'required|max:10',
                'shift_start_time' => 'required|max:10',
                'shift_end_time'   => 'required|max:10'
            );
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aParam['id'] = '';
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }

            /* 寫入資料 */
            $sTime = time();
            $aSaveParam = array(
                'shift_name'       => $aParam['shift_name'],
                'shift_start_time' => $aParam['shift_start_time'],
                'shift_end_time'   => $aParam['shift_end_time'],
                'create_date'      => $sTime,
                'create_user'      => Auth::user()->_id,
                'modify_date'      => $sTime,
                'modify_user'      => Auth::user()->_id
            );
            $this->oModel->create($aSaveParam);

            return array('result' => true, 'message' => Lang::get('back.s_add_data'), 'redirect' => Website::getRedirect($aParam, $this->sRedirect));
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * 修改資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function edit(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            $aFormat = array(
                'id'               => 'required|alpha_num|min:24|max:24',
                'shift_name'       => 'required|max:10',
                'shift_start_time' => 'required|max:10',
                'shift_end_time'   => 'required|max:10'
            );
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            if ($this->oModel->checkSame($aParam) > 0 ) {
                throw new \Exception(Lang::get('back.f_data_same'));
            }

            /* 寫入資料 */
            $aSaveParam = array(
                'shift_name'       => $aParam['shift_name'],
                'shift_start_time' => $aParam['shift_start_time'],
                'shift_end_time'   => $aParam['shift_end_time'],
                'modify_date'        => time(),
                'modify_user'        => Auth::user()->_id
            );
            $this->oModel->updateData($aParam['id'], $aSaveParam);

            return array('result' => true, 'message' => Lang::get('back.s_edit_data'));
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * 刪除資料
     * @param  string $id
     * @return array
     */
    public function delete($id)
    {
        try {
            /* 驗證資料 */
            if (count(Validator::make(array('id' => $id), array('id' => 'required|alpha_num|min:24|max:24'))->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 刪除資料 */
            $this->oModel->destroy($id);

            return array('result' => true, 'message' => Lang::get('back.s_delete_data'));
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * 刪除多筆資料
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function deleteMulti(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            foreach($aParam['del'] as $id)
            {
                if (count(Validator::make(array('id' => $id), array('id' => 'required|alpha_num|min:24|max:24'))->errors()->all()) > 0) {
                    throw new \Exception(Lang::get('back.f_data_format'));
                }
            }
            /* 刪除資料 */
            $this->oModel->deleteMultiData($aParam['del']);

            return array('result' => true, 'message' => Lang::get('back.s_delete_data'), 'redirect' => Website::getRedirect($aParam, $this->sRedirect));
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

}
