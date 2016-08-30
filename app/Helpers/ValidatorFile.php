<?php
/**
 * 檢查檔案格式
 */
namespace App\Helpers;

class ValidatorFile
{
    /**
     * 檢查匯入Excel格式是否符合
     * @param  object    $oFile
     * @return boolean
     */
    public static function checkExcel($oFile)
    {
        return in_array($oFile->getMimeType(),
                    array(
                    'application/msword',
                    'application/vnd.oasis.opendocument.text',
                    'application/vnd.ms-excel',
                    'application/vnd.ms-office'
                ));
    }

}
