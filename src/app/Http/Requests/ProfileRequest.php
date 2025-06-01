<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'gender'=>['required'],
            'birthday'=> ['required', 'date'],
            'tel'=>['nullable', 'regex:/^0\d{9,10}$/'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
    public function messages()
    {
        return [
            'gender.required' => '性別を選択してください。',
            'birthday.required' => '生年月日を入力してください。',
            'birthday.date' => '有効な日付を入力してください。',
            'tel.regex' => '電話番号は0から始まる10〜11桁の数字で入力してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.mimes' => '画像はjpeg、png、jpg、gif形式でアップロードしてください。',
            'image.max' => '画像サイズは2MB以下にしてください。',
        ];
    }
}
