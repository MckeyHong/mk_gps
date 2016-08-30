<?php
/* 邏輯 - 車輛限速設定 */
namespace App\Services\Car;

use App\Repository\CarSpeed as Repository;
use Validator;
use Config;
use Lang;
use Website;

class SpeedService
{
    protected $oModel;

    public function __construct(Repository $Model)
    {
        $this->oModel = $Model;
    }

    /**
     * 取得資料
     * @param  string   $id
     * @return array
     */
    public function find($id)
    {
        $aInfo = $this->oModel->find($id);
        return array('info' => $aInfo);
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
            $aFormat = [
                'id'        => Config::get('validator.id'),
                'speed_min' => 'required|integer|between:0,999',
                'speed_max' => 'required|integer|between:0,999'
            ];
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }

            /* 寫入資料 */
            $this->oModel->updateData($aParam['id'], array_merge([
                'speed_min' => $aParam['speed_min'],
                'speed_max' => $aParam['speed_max']
            ], Website::getSaveInfo('edit')));
            /* 回傳 */
            return ['result'  => true, 'message' => Lang::get('back.s_edit_data')];
        } catch (\Exception $e) {
            return ['result' => false, 'message' => $e->getMessage()];
        }
    }
}
