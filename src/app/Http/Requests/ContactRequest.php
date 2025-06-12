<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Channel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ContactRequest extends FormRequest
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
    protected function failedValidation(Validator $validator)
    {
        Log::error('Validation failed at store:', $validator->errors()->toArray());
        throw new HttpResponseException(
            redirect()->back()->withErrors($validator)->withInput()
        );
    }
    public function prepareForValidation()
    {
        $tel1 = $this->input('tel1');
        $tel2 = $this->input('tel2');
        $tel3 = $this->input('tel3');
        $full_tel = $tel1 . $tel2 . $tel3;
        
        $this->merge([
            'full_tel' => $full_tel,
        ]);
    }

    public function rules()
    {
        return [
            'first_name'=> ['required'],
            'last_name'=> ['required'],
            'gender'=> ['required'],
            'email'=> ['required', 'email'],
            'tel1' => ['required','digits_between:1,5'], 
            'tel2' => ['required','digits_between:1,5'],
            'tel3' => ['required','digits_between:1,5'],
            'full_tel' => ['required', 'regex:/^0\d{9,10}$/'],
            'address'=> ['required'],
            'building' => ['nullable', 'string', 'max:100'],
            'category_id'=> ['required'],
            'detail'=> ['required', 'max:120'],
            'channel_id'=>['required', 'array'],
            'channel_id.*' => [
                function ($attribute, $value, $fail) {
                    $trimmed = trim($value);
                    if (!Channel::where('id', $trimmed)->exists()) {
                        $fail('選択されたチャンネルが無効です。');
                    }
                }
            ],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
    
    public function messages()
    {
        return [
            'first_name.required'=> '姓を入力してください',
            'last_name.required'=> '名を入力してください',
            'gender.required'=> '性別を選択してください',
            'email.required'=> 'メールアドレスを入力してください',
            'email.email'=> '正しいメールアドレス形式で入力してください',
            'tel1.digits' => '電話番号は1フィールド1～5桁で入力してください',
            'tel2.digits' => '電話番号は1フィールド1～5桁で入力してください',
            'tel3.digits' => '電話番号は1フィールド1～5桁で入力してください',
            'full_tel.required' => '電話番号を完全に入力してください',
            'full_tel.regex' => '電話番号を0から始まる10〜11桁の半角数字で入力してください',
            'address.required'=> '住所を入力してください',
            'building.string' => '建物名は文字列で入力してください',
            'building.max' => '建物名は100文字以下で入力してください',
            'category_id.required'=> 'お問い合わせの種類を選択してください',
            'detail.required'=> 'お問い合わせ内容を入力してください',
            'detail.max'=> 'お問い合わせ内容は120文字以内で入力してください',
            'channel_id.required' => '1つ以上選択してください',
            'channel_id.array' => 'チャンネルの選択形式が不正です',
            // 'channel_id.*.exists' => '選択されたチャンネルの中に存在しないものがあります',
            'image.mimes' => '画像形式に誤りがあります',
            'image.max' => '2MB以下のの画像を添付してください',
        ];
    }
}
