<?php
/**
 * User: jithinvijayan
 * Date: 11/03/19
 * Time: 4:15 PM
 */

namespace App\Http\Controllers\API;


use App\Models\CategoryItem;
use Illuminate\Http\Request;
use Validator;

class CategoryItemController extends BaseController
{
    public function getByQuery(Request $request)
    {
        $response = [];
        $queryItem = $request->query('queryString');
        if (!empty($queryItem)) {
            try {

                $response = CategoryItem::search($queryItem)->get();
            } catch (\Exception $e) {
                return $this->sendError($e->getMessage(), [], 500);
            }
        }
        return $this->sendResponse($response, 'Wishes retrieved successfully.');
    }

    public function createCategoryItem(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|max:127',
            'category_id' => 'required|exists:category,category_id',
            'description' => 'max:255',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        $categoryItemsArray = [];
        $categoryItemsArray['name'] = $input['name'];
        $categoryItemsArray['description'] = $input['description'];
        $categoryItemsArray['category_id'] = $input['category_id'];
        $categoryItemsArray['created_date'] = now();
        $categoryItem = CategoryItem::create($categoryItemsArray);
        return $this->sendResponse([], 'Category Item created successfully.');

    }
}