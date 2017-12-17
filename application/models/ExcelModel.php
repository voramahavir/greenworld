<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ExcelModel extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->load->database();
        set_time_limit (1000);
	}
    function parseExcel($object, $sheetno = 0, $dateCol = -1)
    {
        $excelArray = array();
        $debug_mode_on = "false";

        // Add Excel File Code
        $file_name = $object['tmp_name'];
        $file_type = $object['type'];
        try
        {
            if ($file_type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet")
            {
                if ($debug_mode_on == "true")
                {
                    echo "\n is spreadsheetml";
                }
                $this->load->library('PHPExcel');
                $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
                $objReader->setReadDataOnly(TRUE);
                $objPHPExcel = $objReader->load($file_name);
                $objWorksheet = $objPHPExcel->setActiveSheetIndex($sheetno);
                $highestRow = $objWorksheet->getHighestRow();
                $totalRecord = 0;
                $totalInsertRecord = 0;
                for ($i = 1; $i <= $highestRow; $i++)
                {
                    $rowArray = array();
                    $highestColumn = PHPExcel_Cell::columnIndexFromString($objWorksheet->getHighestColumn($i));
                    for ($j = 0; $j < $highestColumn; $j++)
                    {
                        $cell = $objWorksheet->getCellByColumnAndRow($j, $i);
                        $value = $cell->getValue();
                        if ($dateCol == $j)
                        {
                            if ($value !== NULL)
                            {
                                $value = date(EXCEL_DATE_FORMAT, PHPExcel_Shared_Date::ExcelToPHP($value));
                            }
                        }
                        $rowArray[] = $value;
                    }
                    $excelArray[] = $rowArray;//array_push($excelArray, $rowArray);
                }
                return $excelArray;
            } else
            {
                return $excelArray;
            }
        } catch (Exception $e)
        {
            return $excelArray;
        }
    }
}
?>