<?php


namespace App\Classes\Export;

use App\Models\RequestList;

abstract class AbstractExportRequest  implements InterfaceExport {
    public RequestList $request ;

    public function __construct(RequestList $request)
    {
        $this->request = $request ;
    }

    
}


