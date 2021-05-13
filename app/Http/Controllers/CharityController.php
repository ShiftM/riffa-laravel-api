<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Charity;

use Response;
use Config;

class CharityController extends Controller
{
    public function getAllCharities() {
        $charities = Charity::all();

        return Response::json(
            [
                'charities' => $charities
            ],
            200
        );
    }

    public function addCharity(Request $request) {
        $charity_name = $request->charity_name;
        $description = $request->description;
        $contact_person = $request->contact_person;
        $charity_type = $request->charity_type;

        $charity = new Charity([
            'charity_name'     => $charity_name,
            'description'      => $description,
            'contact_person'   => $contact_person,
            'charity_type_id'  => $charity_type,
            'created_at'       => time()
        ]);

        $charity->save();

        return Response::json(
            [
                'charity' => $charity
            ],
            200
        );
    }

    public function updateCharityInfo(Request $request) {
        $charity_id = $request->charity_id;
        $charity_name = $request->charity_name;
        $description = $request->description;
        $contact_person = $request->contact_person;
        $charity_type = $request->charity_type;

        $charity = Charity::where([
            ['charity_id', $charity_id]
        ])->update([
            'charity_name'     => $charity_name,
            'description'      => $description,
            'contact_person'   => $contact_person,
            'charity_type_id'  => $charity_type,
            'updated_at'       => time()
        ]);

        return Response::json(
            [
                'charity' => $charity
            ],
            200
        );
    }
}
