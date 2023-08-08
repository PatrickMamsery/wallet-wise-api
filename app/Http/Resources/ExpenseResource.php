<?php

namespace App\Http\Resources;

use App\Models\ExpenseItem;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'budget' => $this->budgetItem->title,
            'amount' => $this->amount,
            'expense_items' => ExpenseItem::where('expense', $this->id)->get(['title', 'amount'])
        ];
    }
}
