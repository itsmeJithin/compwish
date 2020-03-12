<?php

namespace App\Imports;

use App\Models\ServiceProvider;
use Maatwebsite\Excel\Concerns\ToModel;
use Ramsey\Uuid\Uuid;

class ServiceProviderImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * @throws \Exception
     */
    public function model(array $row)
    {
        return new ServiceProvider([
            'service_provider_id' => Uuid::uuid4(),
            'name' => "$row[1]",
            'email' => 'test' . $row[0] . '@test.com',
            'address' => "$row[2]",
            'password' => bcrypt("12345678"),
            'latitude' => $row[3],
            'longitude' => $row[4],
            'mobile_number' => empty($row[5]) ? '' : $row[5],
            'created_at' => now()
        ]);
    }
}
