<?php
/**
 * 商業邏輯 - 工作班別設定
 */
namespace App\Services\Work;

use App\Repository\StaffShifts as Repository;
use App\Repository\User as UserRepository;
use Validator;
use Config;
use Lang;
use Debugbar;

class ShiftService
{
    protected $oModel;
    protected $oUserModel;
    private $iStartYearly = 2015;

    public function __construct(Repository $Model, UserRepository $UserModel)
    {
        $this->oModel = $Model;
        $this->oUserModel = $UserModel;
    }

    /**
     * 列表頁面
     * @param  \Illuminate\Http\Request  $request
     * @return array         [array('info' => '')]
     */
    public function getList(array $aParam = array())
    {
        /* Set */
        $aInfo = $aGet = $aSearch = array();
        $aYear = $this->getYear();
        // $aReplace = array('role' => 'role_name');
        // /* 驗證查詢參數是否正確 */
        // $aFormat = array(
        //     'role'  => 'required|max:20'
        // );
        // $aError = Validator::make($aParam, $aFormat)->messages();
        // foreach ($aFormat as $sKey => $sVal) {
        //     $aGet[$sKey] = ($aError->has($sKey)) ?  '' : $aParam[$sKey];
        //     $aSearch[$aReplace[$sKey]] = $aGet[$sKey];
        // }
        // $aSearch['per_page'] = Config::get('website.per_page');
        // $aInfo = $this->oModel->getList($aSearch);
        return array('info' => $aInfo, 'get' => $aGet, 'year' => $aYear);
    }


    /**
     * 取得人員年度清單
     * @param  array  $aParam [description]
     * @return [type]         [description]
     */
    public function getStaffShifts(array $aParam = array())
    {
        try {
            $aYear = $this->getYear();
            /* 驗證資料 */
            $aFormat = array(
                'no'   => 'required|alpha_num|min:4|max:15',
                'year' => 'required|in:"'.implode('","', $aYear).'"'
            );
            if (count(Validator::make($aParam, $aFormat)->errors()->all()) > 0) {
                throw new \Exception(Lang::get('back.f_data_format'));
            }
            /* 檢查是否有相同資料 */
            $aUser = $this->oUserModel->findUsername($aParam['no'])->toArray();
            if (!isset($aUser[0]['_id']) ) {
                throw new \Exception(Lang::get('back.f_find_staff'));
            }

            $aInfo = array();
            $sStartMonth = (date('Y') == $aParam['year']) ? date('m') : 1;
            for ($iMonth = 1 ; $iMonth <= 12 ; $iMonth++)
            {
                $sTempBtn = 'btn-default';
                if ($iMonth == $sStartMonth) {
                    $sTempBtn = 'btn-success';
                    $sTempDate = $aParam['year'].'-'.sprintf('%02d', $iMonth).'-01';
                    $aInfo['total_day'] = date('t', strtotime($sTempDate));
                    $iTempWeek = date('w', strtotime($sTempDate));
                    while ($iTempWeek > 0) {
                        $aInfo['day'][] = array('day' => '', 'shift_name' => '');
                        $iTempWeek--;
                    }
                    for ($iDay = 1 ; $iDay <= date('t', strtotime($sTempDate)) ; $iDay++ ) {
                        $aInfo['day'][] = array('day' => $iDay, 'shift_name' => '日班');
                    }
                    if (count($aInfo['day'])%7 != 0) {
                        for ($iNum = (count($aInfo['day'])%7) ; $iNum < 7 ; $iNum++) {
                            $aInfo['day'][] = array('day' => '', 'shift_name' => '');
                        }
                    }
                }

                $aInfo['month'][] = array(
                    'month' => sprintf('%02d', $iMonth),
                    'btn'   => $sTempBtn
                );
            }

            return array('result' => true, 'info' => $aInfo);
        } catch (\Exception $e) {
            return array('result' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * 取得年度下拉清單
     * @return array
     */
    private function getYear()
    {
        $aYear = array();
        for ($iYearly = $this->iStartYearly ; $iYearly <= (date('Y') + 1) ; $iYearly++)
        {
            $aYear[] = $iYearly;
        }
        return $aYear;
    }
}
