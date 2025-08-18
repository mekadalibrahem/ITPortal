<?php


namespace App\Classes\Export;


interface  InterfaceExport {


    function init_data(): array;
    function get_view();
    function  export();
} 



