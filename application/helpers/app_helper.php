<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// --------------------------------------------------------------------

if (!function_exists('access')) {
    /**
     * Elements
     *
     * Returns only the array items specified. Will return a default value if
     * it is not set.
     *
     * @token   token
     * @inArray array
     * @return  mixed   depends on what the array contains
     */
    function access()
    {
        $ci = &get_instance();
        return (null !== $ci->session->userdata('access')) && is_array($ci->session->userdata('access')) && count($ci->session->userdata('access')) > 0;
    }
}

if (!function_exists('logout')) {

    function logout()
    {
        $ci = &get_instance();
        $ci->session->unset_userdata('access');
        redirect(site_url('login'));
    }
}

if (!function_exists('manual_log')) {

    function manual_log($file_name = '', $content = array())
    {
        try {
            if (!is_dir('log')) {
                mkdir('log');
            }
            if (!is_null_or_empty($file_name)) {
                file_put_contents('log/' . $file_name . '.txt', json_encode($content), FILE_APPEND);
            }
        } catch (Exception $e) {

        }
        return true;
    }
}

if (!function_exists('ci_breadcrumb')) {
    function ci_breadcrumb($initial_crumb = FALSE, $initial_crumb_url = FALSE, $initial_crumb_icon = FALSE)
    {
        $ci = &get_instance();
        $open_tag = '<ol class="breadcrumb">';
        $close_tag = '</ol>';
        $crumb_open_tag = '<li>';
        $active_crumb_open_tag = '<li class="active">';
        $crumb_close_tag = '</li>';
        $total_segments = $ci->uri->total_segments();
        $breadcrumbs = $open_tag;
        if ($initial_crumb) {
            $breadcrumbs .= $crumb_open_tag;
            $breadcrumbs .= ci_breadcrumb_href($initial_crumb, $initial_crumb_url, TRUE, TRUE, $initial_crumb_icon);
        }
        $segment = '';
        $crumb_href = '';
        for ($i = 1; $i <= $total_segments; $i++) {
            $segment = $ci->uri->segment($i);
            $crumb_href .= $ci->uri->segment($i) . '/';
            if ($total_segments > $i) {
                $breadcrumbs .= $crumb_open_tag;
                $breadcrumbs .= ci_breadcrumb_href($segment, $crumb_href);
            } else {
                $breadcrumbs .= $active_crumb_open_tag;
                $breadcrumbs .= ci_breadcrumb_href($segment, $crumb_href, FALSE, FALSE);
            }
            $breadcrumbs .= $crumb_close_tag;
        }
        $breadcrumbs .= $close_tag;
        return $breadcrumbs;
    }
}

if (!function_exists('ci_breadcrumb_href')) {
    function ci_breadcrumb_href($uri_segment, $crumb_href = FALSE, $initial = FALSE, $active_link = TRUE, $crumb_icon = FALSE)
    {
        $ci = &get_instance();
        $crumb_href = rtrim($crumb_href, '/');
        if ($active_link) {
            if ($initial) {
                return ($crumb_icon ? '<span class="' . $crumb_icon . '"></span> ' : '') . '<a href="' . ($crumb_href ? $crumb_href : site_url()) . '">' . ucwords(str_replace(array('-', '_'), ' ', $uri_segment)) . '</a>';
            } else {
                return ($crumb_icon ? '<span class="' . $crumb_icon . '"></span> ' : '') . '<a href="' . site_url($crumb_href) . '">' . ucwords(str_replace(array('-', '_'), ' ', $uri_segment)) . '</a>';
            }
        } else {
            return ($crumb_icon ? '<span class="' . $crumb_icon . '"></span> ' : '') . ucwords(str_replace(array('-', '_'), ' ', $uri_segment));
        }
    }
}


if (!function_exists('getSessionData')) {
    function getSessionData($key = null)
    {
        $ci = &get_instance();
        $sessData = $ci->session->userdata('access');
        return ($key) ? $sessData[$key] : $sessData;
    }
}

if (!function_exists('checkParams')) {

    function checkParams($post,$params='')
    {
        $msg = '';
        if($params == ''){
            foreach ($post as $param_name => $param_val) {
                if(empty($param_val)){
                    $msg .= "$param_name is missing,";
                }
            }
        } else {
            $params = explode(',', $params);
            foreach ($params as $value) {
                if(!isset($post[$value]) || empty($post[$value])){
                    $msg .= "$value is missing,";
                }
            }
        }
        return $msg;
    }
}

if(!function_exists('parseExcel')) {
    
    function parseExcel($object, $sheetno = 0, $dateCol = -1)
    {
//        print_r($object['tmp_name']);die;
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