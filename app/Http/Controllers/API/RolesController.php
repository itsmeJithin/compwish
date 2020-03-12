<?php
/**
 * User: jithinvijayan
 * Date: 27/02/19
 * Time: 5:48 PM
 */

namespace App\Http\Controllers\API;


use App\Models\Roles;

class RolesController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Roles::all();
        return $this->sendResponse($roles->toArray(), 'Users retrieved successfully.');
    }
}