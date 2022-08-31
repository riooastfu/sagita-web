<?php
/**
 * Created by PhpStorm.
 * User: muhammad.sandy
 * Date: 7/15/2022
 * Time: 9:23 PM
 */
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once APPPATH."third_party/PHPExcel.php";
require_once APPPATH."third_party/PHPExcel/IOFactory.php";

class Excel extends PHPExcel {
    public function __construct() {
        parent::__construct();
    }
}