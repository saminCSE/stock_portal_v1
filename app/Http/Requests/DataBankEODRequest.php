<?php
namespace App\Http\Requests;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DataBankEODRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $requestMethod = $request->method();
        return [
            'market_id' => [
                'required',
            ],
            'instrument_id' => [
                'required',
                function ($attribute, $value, $fail) use ($requestMethod) {
                    $query = DB::table('data_banks_eods')->where('market_id', $this->market_id);
                    if ($requestMethod === 'PUT') {
                        $query->where('id', '!=', $this->route('id'));
                    }
                    $exists = $query->where('instrument_id', $value)->exists();
                    if ($exists) {
                        $fail('The selected instrument ID is not unique.');
                    }
                },
            ],
            'sector_id' => [
                Rule::requiredIf(function () use ($request) {
                    $instrumentIds = [10001, 10002, 10003];
                    return !in_array($request->input('instrument_id'), $instrumentIds);
                }),
            ],
            'open' => [
                'required',
            ],
            'high' => [
                'required',
            ],
            'low' => [
                'required',
            ],
            'close' => [
                'required',
            ],
            'ycp' => [
                'required',
            ],
            'volume' => [
                'required',
            ],
            // 'trade' => [
            //     'required',
            // ],
            // 'tradevalues' => [
            //     'required',
            // ],
            'date' => [
                'required',
            ],
            // 'updated' => [
            //     'required',
            // ],
            // 'market_instrument' => [
            //     'required',
            // ],
            // 'batch' => [
            //     'required',
            // ],
        ];
    }
}
