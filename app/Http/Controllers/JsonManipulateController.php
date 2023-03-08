<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JsonManipulateController extends Controller
{
    public function index()
    {
        // Get JSON data from file
        $jsonFilePath = public_path('json1.json');
        $jsonContents = file_get_contents($jsonFilePath);
        $data1 = json_decode($jsonContents, true);

        $jsonFilePath = public_path('json2.json');
        $jsonContents = file_get_contents($jsonFilePath);
        $data2 = json_decode($jsonContents, true);

        $result = [];

        foreach ($data1['data'] as $booking) {
            $workshop = null;

            foreach ($data2['data'] as $item) {
                if ($item['code'] === $booking['booking']['workshop']['code']) {
                    $workshop = $item;
                    break;
                }
            }

            if ($workshop !== null) {
                $result[] = [
                    'name' => $booking['name'],
                    'email' => $booking['email'],
                    'booking_number' => $booking['booking']['booking_number'],
                    'book_date' => $booking['booking']['book_date'],
                    'ahass_code' => $workshop['code'],
                    'ahass_name' => $workshop['name'],
                    'ahass_address' => $workshop['address'],
                    'ahass_contact' => $workshop['phone_number'],
                    'ahass_distance' => $workshop['distance'],
                    'motorcycle_ut_code' => $booking['booking']['motorcycle']['ut_code'],
                    'motorcycle' => $booking['booking']['motorcycle']['name'],
                ];
            }
        }

        $newData = [
            'status' => $data1['status'],
            'message' => $data1['message'],
            'data' => $result,
        ];

        // Return manipulated JSON
        return response()->json($newData);
    }
}
