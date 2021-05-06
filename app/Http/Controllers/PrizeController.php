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
}
