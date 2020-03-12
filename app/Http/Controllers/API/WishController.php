<?php

namespace App\Http\Controllers\API;

use App\Models\ServiceProvider;
use App\Models\Wish;
use App\Models\WishSetting;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\HasApiTokens;
use Validator;

class WishController extends BaseController
{
    use HasApiTokens, Notifiable;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Wish::all();
        return $this->sendResponse($products->toArray(), 'Wishes retrieved successfully.');
    }

    public function listNearestWishes(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'user_id' => 'required|uuid|exists:users,user_id',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendJsonError('Validation Error.', $validator->errors());
        }
        if (!validateLatitude($input['latitude']) && !validateLongitude($input['longitude'])) {
            $this->sendJsonError("Invalid latitude or longitude value", []);
        }
        $userId = $input['user_id'];
        $latitude = $input['latitude'];
        $longitude = $input['longitude'];
        /**
         * radius in km
         */
        $radius = 580;
        $response = DB::select("
                    SELECT DISTINCT s.service_provider_id,s.name as service_provider_name
                    ,s.address,s.mobile_number,s.closing_time,s.opening_time, w.name as wish_name,
                    w.description,c.name as category_name,c.description as category_description,
                    s.latitude,s.longitude,w.wish_id,c.category_id,
                    (6371*
                    ACOS(COS(RADIANS($latitude))*
                    COS(RADIANS(s.latitude))*COS(RADIANS(s.longitude)-RADIANS($longitude))+
                    SIN(RADIANS($latitude))*
                    SIN(RADIANS(s.latitude)))) AS distance
                    FROM wishes w
                    INNER JOIN category_items item on w.category_item_id = item.category_item_id
                    INNER JOIN categories c on item.category_id = c.category_id
                    INNER JOIN service_provider_categories spc on c.category_id = spc.category_id
                    INNER JOIN service_providers s on spc.service_provider_id = s.service_provider_id
                    WHERE w.user_id='$userId' AND s.is_active=1 HAVING distance<$radius ORDER BY distance");
        
        return $this->sendResponse($response, "Wishes fetched successfully");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required|max:127',
            'category_item_id' => 'required|exists:category_items,category_item_id',
            'description' => 'max:255',
            'user_id' => 'required|uuid|exists:users',
            'is_journey' => 'required',
            'journey_date' => 'nullable|date_format:Y-m-d H:i:s',
            'is_notification_enabled' => 'boolean',
            'is_reminder_enabled' => 'boolean',
            'send_notification_from' => 'nullable|date_format:Y-m-d H:i:s',
            'send_notification_to' => 'nullable|date_format:Y-m-d H:i:s',
            'latitude' => 'nullable',
            'longitude' => 'nullable',

        ]);
        if ($validator->fails()) {
            return $this->sendJsonError('Validation Error.', $validator->errors());
        }
        $wishCount = Wish::where(["user_id" => $input['user_id'], "category_item_id" => $input['category_item_id']])->count();
        if ($wishCount > 0) {
            return $this->sendJsonError("Wish item already added", []);
        }

        $wishArray = [];
        $wishArray['name'] = $input['name'];
        $wishArray['description'] = $input['description'];
        $wishArray['category_item_id'] = $input['category_item_id'];
        $wishArray['user_id'] = $input['user_id'];
        $wishArray['is_journey'] = (boolean)$input['is_journey'];
        if (!empty($input['journey_date'])) {
            if ($wishArray['is_journey']) {
                $wishArray['journey_date'] = $input['journey_date'];
            }
            if (!empty($input['latitude'])) {
                $wishArray['latitude'] = $input['latitude'];
            } else {
                return $this->sendJsonError("Invalid latitude given", []);
            }
            if (!empty($input['longitude'])) {
                $wishArray['longitude'] = $input['longitude'];
            } else {
                return $this->sendJsonError("Invalid longitude given", []);
            }
        }
        $wishArray['created_date'] = now();
        $product = Wish::create($wishArray);
        $wishSettingsArray = [];
        $wishSettingsArray['wish_id'] = $product->wish_id;
        $wishSettingsArray['is_notification_enabled'] = (boolean)$input['is_notification_enabled'];
        $wishSettingsArray['is_reminder_enabled'] = $input['is_reminder_enabled'];
        if ($wishSettingsArray['is_notification_enabled']) {
            if (!empty($wishSettingsArray['send_notification_from'])) {
                $wishSettingsArray['send_notification_from'] = $input['send_notification_from'];
            }
            if (!empty($wishSettingsArray['send_notification_to'])) {
                $wishSettingsArray['send_notification_to'] = $input['send_notification_to'];
            }
        }
        $productSettings = WishSetting::create($wishSettingsArray);

        return $this->sendResponse([], 'Wish created successfully.');
    }

}
