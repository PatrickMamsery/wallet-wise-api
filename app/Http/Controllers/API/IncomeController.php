<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\Income;
use App\Models\UserIncome;
use App\Http\Resources\IncomeResource;

class IncomeController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user(); // Get the authenticated User

        $userIncomeItems = UserIncome::where('user_id', $user->id)->pluck('id')->toArray();

        if (count($userIncomeItems) == 0) {
            return $this->sendError('RETRIEVE_MANY_FAILED', 404);
        } else {
            $incomeItems = Income::whereIn('id', $userIncomeItems);

            if (count($incomeItems->get()) == 0) {
                return $this->sendError('RETRIEVE_MANY_FAILED', 404);
            } else {
                return $this->sendResponse(IncomeResource::collection($incomeItems->latest('updated_at')->paginate()), 'RETRIEVE_SUCCESS');
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info('IncomeController@store');

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('CREATE_FAILED', 400, $validator->errors());
        } else {
            try {
                $income = Income::create([
                    'title' => $request->input('title'),
                    'amount' => $request->input('amount'),
                ]);

                $userIncome = UserIncome::firstOrCreate([
                    'user_id' => $user->id,
                    'income_id' => $income->id
                ]);

                return $this->sendResponse(new IncomeResource($income), 'CREATE_SUCCESS');
            } catch (\Exception $e) {
                Log::error('IncomeController@store - '. $e->getMessage());
                return $this->sendError('CREATE_FAILED', $e->getMessage(), 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('IncomeController@show');

        $user = Auth::user();

        if (!Income::find($id)) {
            return $this->sendError('NOT_FOUND', 404);
        } else {
            $income = Income::find($id);

            $userIncomeItems = UserIncome::where('user_id', $user->id)->pluck('id')->toArray();

            $incomeItems = Income::whereIn('id', $userIncomeItems)->pluck('id')->toArray();

            if (!in_array($income->id, $incomeItems)) {
                return $this->sendError('NOT_FOUND', 404);
            } else {
                return $this->sendResponse(new IncomeResource($income), 'RETRIEVE_SUCCESS');
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
