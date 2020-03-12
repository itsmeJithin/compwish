<?php
/**
 * User: jithinvijayan
 * Date: 17/03/19
 * Time: 9:53 AM
 */

namespace App\Http\Controllers\API;


use App\Imports\ServiceProviderImport;
use Maatwebsite\Excel\Facades\Excel;

class ServiceProviderController extends BaseController
{
    public function import()
    {

        try {
            Excel::import(new ServiceProviderImport(), storage_path('service_provider.xlsx'));
        } catch (\Exception $e) {
            return $this->sendJsonError($e->getMessage(), []);
        }
        return $this->sendResponse([], "Imported successfully");

    }

}