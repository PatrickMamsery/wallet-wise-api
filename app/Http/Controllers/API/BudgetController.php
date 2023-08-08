<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Models\UserBudget;
use App\Models\Budget;
use App\Http\Resources\BudgetResource;
use App\Models\BudgetItem;

class BudgetController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $userBudgetItems = UserBudget::where('user_id', $user->id)->pluck('id')->toArray();

        if (count($userBudgetItems) == 0) {
            return $this->sendError('RETRIEVE_MANY_FAILED', 404);
        } else {
            $budgetItems = BudgetItem::whereIn('id', $userBudgetItems);

            if (count($budgetItems->get()) == 0) {
                return $this->sendError('RETRIEVE_MANY_FAILED', 404);
            } else {
                return $this->sendResponse(BudgetResource::collection($budgetItems->latest('updated_at')->paginate()), 'RETRIEVE_SUCCESS');
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
        Log::info('BudgetController@store');

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|string'
        ]);

        if ($validator->fails()) {
            return $this->sendError('VALIDATION_ERROR', 400, $validator->errors());
        }

        try {
            $budgetItem = new BudgetItem();
            $budgetItem->title = $request->title;
            $budgetItem->amount = $request->amount;
            $budgetItem->date = $request->date ? $request->date : \Carbon\Carbon::today();
            $budgetItem->save();

            // create a user budget
            $userBudget = new UserBudget();
            $userBudget->user_id = $user->id;
            $userBudget->budget_item_id = $budgetItem->id;
            $userBudget->save();

            return $this->sendResponse(new BudgetResource($budgetItem), 'CREATE_SUCCESS', 201);
        } catch (\Exception $e) {
            Log::error('BudgetController@store - '. $e->getMessage());
            return $this->sendError('CREATE_FAILED', $e->getMessage(), 500);
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
        Log::info('BudgetController@show');

        $user = Auth::user();

        $userBudgets = UserBudget::where('user_id', $user->id)->get()->pluck('id')->toArray();

        $budgetItems = BudgetItem::whereIn('id', $userBudgets);

        if (!BudgetItem::find($id)) {
            return $this->sendError('NOT_FOUND', 404);
        } else {
            $budgetItem = BudgetItem::find($id);
            // Get expenses for the authenticated user
            $budgetItems = BudgetItem::whereIn('id', UserBudget::where('user_id', $user->id)->get()->pluck('id')->toArray())->pluck('id')->toArray();
            // if the budgetItem does not belong to the authenticated user, return error
            if (!in_array($budgetItem->id, $budgetItems)) {
                return $this->sendError('NOT_FOUND', 404);
            } else {
                // Return a single budgetItem
                return $this->sendResponse(new BudgetResource($budgetItem), 'RETRIEVE_SUCCESS');
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
