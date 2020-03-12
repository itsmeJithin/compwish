<?php
/**
 * User: jithinvijayan
 * Date: 16/03/19
 * Time: 2:44 PM
 */

namespace App\Http\Controllers\API;


use App\Models\Category;
use Illuminate\Http\Request;
use Validator;

class CategoryController extends BaseController
{
    public function createCategoryItem(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|max:127',
            'description' => 'max:255',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $categoryItemsArray = [];
        $categoryItemsArray['name'] = $input['name'];
        $categoryItemsArray['description'] = $input['description'];
        $categoryItemsArray['created_date'] = now();
        $categoryItem = Category::create($categoryItemsArray);
        return $this->sendResponse([], 'Category created successfully.');

    }

}