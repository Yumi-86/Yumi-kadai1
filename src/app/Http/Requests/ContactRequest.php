<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    public function rules()
    {
        return [
            'first_name'=> ['required'],
            'last_name'=> ['required'],
            'gender'=> ['required'],
            'email'=> ['required', 'email'],
            'address'=> ['required'],
            'category_id'=> ['required'],
            'detail'=> ['required', 'max:120'],
            'channel_id'=>['required', 'array'],
            'channel_id.*.' => ['exists:channels, id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];
    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $tel1 = $this->input('tel1');
            $tel2 = $this->input('tel2');
            $tel3 = $this->input('tel3');
            $tel = $tel1 . $tel2 . $tel3;

            if (empty($tel1) || empty($tel2) || empty($tel3)) {
                $validator->errors()->add('tel', '電話番号を完全に入力してください');
            } elseif (!preg_match('/^\d{10,11}$/', $tel)) {
                $validator->errors()->add('tel', '電話番号は10〜11桁の半角数字で入力してください');
            }
        });
    }

    public function messages()
    {
        return [
            'first_name.required'=> '姓を入力してください',
            'last_name.required'=> '名を入力してください',
            'gender.required'=> '性別を選択してください',
            'email.required'=> 'メールアドレスを入力してください',
            'email.email'=> '正しいメールアドレス形式で入力してください',
            'address.required'=> '住所を入力してください',
            'category_id.required'=> 'お問い合わせの種類を選択してください',
            'detail.required'=> 'お問い合わせ内容を入力してください',
            'detail.max'=> 'お問い合わせ内容は120文字以内で入力してください',
            'channel_id.required' => '1つ以上選択してください',
            'channel_id.array' => 'チャンネルの選択形式が不正です',
            'channel_id.*.exists' => '選択されたチャンネルの中に存在しないものがあります',
            'image.mimes' => '画像形式に誤りがあります',
            'image.max' => '2MB以下のの画像を添付してください',
        ];
    }
}
