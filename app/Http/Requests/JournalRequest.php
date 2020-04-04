<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JournalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'journal.transaction_date' => 'required|date',
            'cash_flow.*.cash_account_id' => 'required|exists:cash_accounts,id',
            'cash_flow.*.description' => 'required',
            'cash_flow.*.debit' => 'required|numeric',
            'cash_flow.*.credit' => 'required|numeric',
        ];
    }

    public function attributes()
    {
        return [
            'journal.transaction_date' => 'Tgl Transaksi',
            'cash_flow.*.cash_account_id' => 'Akun',
            'cash_flow.*.description' => 'Deskripsi',
            'cash_flow.*.debit' => 'Debit',
            'cash_flow.*.credit' => 'Kredit'
        ];
    }
}
