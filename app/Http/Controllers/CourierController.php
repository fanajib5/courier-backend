<?php

// ~\courier-backend\app\Http\Controllers\CourierController.php

namespace App\Http\Controllers;

use App\Models\Courier;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;

class CourierController extends Controller
{
    //
    // show all courier
    public function index(Request $request)
    {
        $responseCode = Response::HTTP_OK;
        $responseMessage = Response::$statusTexts[$responseCode];
        $additionalMsg = "";
        $couriers = Courier::orderBy('name', 'ASC')->get();

        // check parameter query
        $checkPageSize = array_key_exists("pageSize", $request->query());
        $checkSortDoj = array_key_exists("sort", $request->query());
        $checkSearchName = array_key_exists("search", $request->query());
        $checkLevelCourier = array_key_exists("level", $request->query());

        $paginateCouriers = $request->query('pageSize');
        $sortDOJ = $request->query('sort');
        $searchName = $request->query('search');
        $levelCourier = $request->query('level');

        // paginate or pageSize response
        if ($checkPageSize)
        {
            if ($paginateCouriers !== null)
            {
                if (preg_match('/\d/', $paginateCouriers))
                {
                    $couriers = Courier::orderBy('name', 'ASC')
                        ->paginate(perPage: $paginateCouriers);
                }
                else if (!preg_match('/\d/', $paginateCouriers))
                {
                    $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                    $responseMessage = Response::$statusTexts[$responseCode];
                    $additionalMsg = " - Incorrect value. The pageSize value is non digit!";
                    $couriers = null;
                }
            }
            else
            {
                $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $responseMessage = Response::$statusTexts[$responseCode];
                $additionalMsg = " - The pageSize value is null!";
                $couriers = null;
            }
        }

        // sort by Date of Joined response
        if ($checkSortDoj)
        {
            if ($sortDOJ !== null)
            {
                if ($sortDOJ === '-DOJ' or $sortDOJ === '-dateofjoined')
                {
                    $couriers = Courier::orderBy('DOJ', 'DESC')->get();
                }
                else if ($sortDOJ === 'DOJ' or $sortDOJ === 'dateofjoined')
                {
                    $couriers = Courier::orderBy('DOJ', 'ASC')->get();
                }
                else
                {
                    $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                    $responseMessage = Response::$statusTexts[$responseCode];
                    $additionalMsg = " - Incorrect value. Please choose whether the data sort is ascending (+) or descending (-)!";
                    $couriers = null;
                }
            }
            else
            {
                $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $responseMessage = Response::$statusTexts[$responseCode];
                $additionalMsg = " - The sort by (DOJ or dateofjoined) value is null!";
                $couriers = null;
            }
        }

        // search by courier name
        if ($checkSearchName)
        {
            if ($searchName !== null AND !preg_match('/\d/', $searchName))
            {
                $couriers = Courier::where('name', 'LIKE', "%{$searchName}%")
                    ->get();

                if (count($couriers) === 0)
                {
                    $responseCode = Response::HTTP_NOT_FOUND;
                    $responseMessage = Response::$statusTexts[$responseCode];
                    $additionalMsg = " - Looks like the courier data with that name doesn't exist!";
                    $couriers = null;
                }
            }
            else if (preg_match('/\d/', $searchName))
            {
                $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $responseMessage = Response::$statusTexts[$responseCode];
                $additionalMsg = " - Incorrect value. Please don't use digits when searching for names!";
                $couriers = null;
            }
            else
            {
                $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $responseMessage = Response::$statusTexts[$responseCode];
                $additionalMsg = " - The search of name value is null!";
                $couriers = null;
            }
        }

        // search by level
        if ($checkLevelCourier)
        {
            if ($levelCourier !== null)
            {
                if (preg_match('/\d/', $levelCourier))
                {
                    $levelParts = explode(",", $levelCourier);

                    $couriers = Courier::whereIn('level', $levelParts)->get();

                    if (count($couriers) === 0)
                    {
                        $responseCode = Response::HTTP_NOT_FOUND;
                        $responseMessage = Response::$statusTexts[$responseCode];
                        $additionalMsg = " - Looks like the courier data with that level doesn't exist!";
                        $couriers = null;
                    }
                }
                else if (!preg_match('/\d/', $levelCourier))
                {
                    $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                    $responseMessage = Response::$statusTexts[$responseCode];
                    $additionalMsg = " - Incorrect value. Please use digits when searching for level!";
                    $couriers = null;
                }
            }
            else
            {
                $responseCode = Response::HTTP_UNPROCESSABLE_ENTITY;
                $responseMessage = Response::$statusTexts[$responseCode];
                $additionalMsg = " - The level value is null!";
                $couriers = null;
            }
        }

        return response()->json([
            'response_code' => $responseCode,
            'message' => $responseMessage . $additionalMsg,
            'data' => $couriers,
        ])->setStatusCode($responseCode);
    }

    //
    // fungsi create
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|regex:/^[a-zA-Z\pL\s\-\,\.]+$/u|max:255',
            'email' => 'required|email|unique:couriers,email|max:255',
            'DOB' => 'required|date_format:Y-m-d',
            'phone' => 'required|max:20',
            'status' => [
                'required',
                Rule::in(['Active', 'Disabled']),
            ],
            'DOJ' => 'required|date_format:Y-m-d',
            'level' => 'required|digits_between:1,5',
            'branch_id' => 'required|numeric',
        ]);

        $courier = Courier::create([
            'name' => $request->name,
            'email' => $request->email,
            'DOB' => $request->DOB,
            'phone' => $request->phone,
            'status' => $request->status,
            'DOJ' => $request->DOJ,
            'level' => $request->level,
            'branch_id' => $request->branch_id,
        ]);

        return response()->json([
            'response_code' => Response::HTTP_CREATED,
            'message' =>  Response::$statusTexts[Response::HTTP_CREATED] . ' - Courier created successfully',
            'data' => $courier,
        ])->setStatusCode(Response::HTTP_CREATED);
    }

    //
    // show a courier data
    public function show($id)
    {
        $responseCode = Response::HTTP_OK;
        $responseMessage = Response::$statusTexts[$responseCode];
        $additionalMsg = "";
        $courier = Courier::find($id);

        if ($courier === null) {
            $responseCode = Response::HTTP_NOT_FOUND;
            $responseMessage = Response::$statusTexts[$responseCode];
            $additionalMsg = " - Looks like the courier data with that ID doesn't exist!";
            $courier = null;
        }

        return response()->json([
            'response_code' => $responseCode,
            'message' =>  $responseMessage . $additionalMsg,
            'data' => $courier,
        ])->setStatusCode($responseCode);
    }

    //
    // fungsi update data courier
    public function update(Request $request, $id)
    {
        $responseCode = Response::HTTP_OK;
        $responseMessage = Response::$statusTexts[$responseCode];
        $additionalMsg = " - Courier updated successfully";
        $courier = Courier::find($id);

        if ($courier === null)
        {
            $responseCode = Response::HTTP_NOT_FOUND;
            $responseMessage = Response::$statusTexts[$responseCode];
            $additionalMsg = " - Looks like the courier data with that ID doesn't exist!";
            $courier = null;
        }
        else
        {
            $request->validate([
                'name' => 'string|regex:/^[a-zA-Z\pL\s\-]+$/u|max:255',
                'email' => 'email|unique:couriers,email|max:255',
                'DOB' => 'date_format:Y-m-d',
                'phone' => 'max:20',
                'status' => Rule::in(['Active', 'Disabled']),
                'DOJ' => 'date_format:Y-m-d',
                'level' => 'digits_between:1,5',
                'branch_id' => 'numeric',
            ]);

            $courier->update($request->all());
        }

        return response()->json([
            'response_code' => $responseCode,
            'message' =>  $responseMessage . $additionalMsg,
            'data' => $courier,
        ])->setStatusCode($responseCode);
    }

    //
    // fungsi hapus data courier
    public function delete(Request $request, $id)
    {
        $responseCode = Response::HTTP_OK;
        $responseMessage = Response::$statusTexts[$responseCode];
        $additionalMsg = " - Courier deleted successfully";
        $courier = Courier::find($id);

        if ($courier === null) {
            $responseCode = Response::HTTP_NOT_FOUND;
            $responseMessage = Response::$statusTexts[$responseCode];
            $additionalMsg = " - Looks like the courier data has deleted!";
            $courier = null;
        }
        else
        {
            $courier->delete();
        }

        return response()->json([
            'response_code' => $responseCode,
            'message' =>  $responseMessage . $additionalMsg,
            'data' => $courier,
        ])->setStatusCode($responseCode);
    }
}
