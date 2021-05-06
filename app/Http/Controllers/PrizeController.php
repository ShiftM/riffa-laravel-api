<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PrizeCategories;
use App\Models\Prizes;
use Illuminate\Http\Request;
use Response;

use function Ramsey\Uuid\v1;

class PrizeController extends Controller
{
    //show
    public function showAllPrizes() {
        $prizeList = array();
        $prizes = Prizes::all();


        foreach($prizes as $prize) {
            $prize_categories = PrizeCategories::where([
                'prize_id' => $prize->prize_id,
            ])->get(['category_id']);
            $category_name = "";

            foreach($prize_categories as $prize_category){

                $category = Category::where([
                    'category_id' => $prize_category->category_id
                ])->get(['name']);

                $category_name .= $category[0]['name'] . " ";
                $prize['category_name'] = $category_name;

            }

            array_push($prizeList, $prize);

        }

        return $prizeList;

    }

    public function newPrize(Request $request) {
        $prize = new Prizes([
            'name'            =>       $request->name,
            'description'     =>       isset($request->description),
            'coin_amount'     =>       isset($request->coin_amount),
            'image'           =>       isset($request->image)
        ]);
        $prize->save();

        $prize_category = new PrizeCategories([
            'prize_id'        =>       $prize->prize_id,
            'category_id'     =>       $request->category_id
        ]);
        $prize_category->save();


        return Response::json(
            [
                'prize'             =>      $prize,
                'prize_category'    =>      $prize_category
            ],
            200
        );
    }

    public function editPrize(Request $request) {
        $prize = Prizes::where('prize_id', $request->prize_id)->first();
        $prize->update([
            'name'            =>       $request->name,
            'description'     =>       isset($request->description),
            'coin_amount'     =>       isset($request->coin_amount),
            'image'           =>       isset($request->image)
        ]);

        $prize_category = PrizeCategories::where('prize_id', $request->prize_id)->first();
        $prize_category->update([
            'prize_id'        =>       $prize->prize_id,
            'category_id'     =>       $request->category_id
        ]);

        return Response::json(
            [
                'prize'             =>      $prize,
                'prize_category'    =>      $prize_category
            ],
            200
        );
    }

    public function removePrize(Request $request) {

        if($prizes = Prizes::where([
            ['prize_id', $request->prize_id],
            ['is_available', 1]
        ])->update(['is_available' => 0])) {
            return response('Successful', 200);
        } else {
            return response('Failed/Already Updated', 200);
        }

    }
}
