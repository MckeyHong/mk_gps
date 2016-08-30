<?php
/* 邏輯 - 系統登入紀錄 */
namespace App\Services\Record;

use App\Repository\RecordLogin as Repository;
use Validator;
use Lang;

class RecordLoginService
{
    protected $oModel;

    public function __construct(Repository $model)
    {
        $this->oModel = $model;
    }

    /**
     * 寫入系統登入紀錄
     * @param  array $_aParm
     * @return array
     */
    public function addData(array $aParam = array())
    {
        try {
            /* 驗證資料 */
            $aCheck = Validator::make(
                $aParam, [
                    'login_username' => 'required|alpha_num|min:4|max:20',
                    'login_type'     => 'required|digits_between:1,4',
                    'login_ip'       => 'required|ip',
                    'create_date'    => 'required|numeric'
            ]);
            if (count($aCheck->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 寫入資料 */
            $this->oModel->create($aParam);
            /* 回傳 */
            return ['result' => true, 'message' => Lang::get('back.s_add_data')];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }
}
