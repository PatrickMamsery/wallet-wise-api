<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\UserExpense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

use App\Http\Resources\ExpenseResource;
use App\Models\BudgetItem;
use App\Models\Expense;

class ExpenseController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userExpenses = UserExpense::where('user_id', Auth::user()->id)->get()->pluck('id')->toArray();

        // var_dump(count($userExpenses) == 0); die;

        // failsafe: if no expenses return error
        if (count($userExpenses) == 0) {
            return $this->sendError('RETRIEVE_MANY_FAILED', 404);
        } else {
            $expenses = Expense::whereIn('id', $userExpenses);

            if (count($expenses->get()) == 0) {
                return $this->sendError('RETRIEVE_MANY_FAILED', 404);
            } else {
                return $this->sendResponse(ExpenseResource::collection($expenses->latest('updated_at')->paginate()), 'RETRIEVE_SUCCESS');
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
        Log::info('ExpenseController@store');

        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'budget_item_id' => 'required|exists:budget_items,id'
        ]);

        if ($validator->fails()) {
            return $this->sendError('VALIDATION_ERROR', 400, $validator->errors());
        }

        try {
            $expense = new Expense();
            $expense->amount = $request->amount;
            $expense->budget_item_id = $request->budget_item_id;
            $expense->save();

            // create user expense
            $userExpense = new UserExpense();
            $userExpense->user_id = Auth::user()->id;
            $userExpense->expense_id = $expense->id;
            $userExpense->save();

            return $this->sendResponse(new ExpenseResource($expense), 'CREATE_SUCCESS');
        } catch (\Exception $e) {
            Log::error('ExpenseController@store - '. $e->getMessage());
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
        Log::info('ExpenseController@show');

        $user = Auth::user();

        $userExpenses = UserExpense::where('user_id', $user->id)->get()->pluck('id')->toArray();

        $expenses = Expense::whereIn('id', $userExpenses);

        if (!Expense::find($id)) {
            return $this->sendError('NOT_FOUND', 404);
        } else {
            $expense = Expense::find($id);
            // Get expenses for the authenticated user
            $expenses = Expense::whereIn('id', UserExpense::where('user_id', Auth::user()->id)->get()->pluck('id')->toArray())->pluck('id')->toArray();
            // if the expense does not belong to the authenticated user, return error
            if (!in_array($expense->id, $expenses)) {
                return $this->sendError('NOT_FOUND', 404);
            } else {
                // Return a single expense
                return $this->sendResponse(new ExpenseResource($expense), 'RETRIEVE_SUCCESS');
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
