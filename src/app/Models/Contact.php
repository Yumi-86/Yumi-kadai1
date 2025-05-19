<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'category_id', 'first_name', 'last_name', 'gender', 'email', 'tel', 'address', 'building', 'detail'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }
    // app/Models/Contact.php

    public function getGenderLabelAttribute()
    {
        switch ($this->gender) {
            case 1:
                return "男性";
            case 2:
                return "女性";
            case 3:
                return "その他";
            default:
                return "不明";
        }
    }
    public function getFullNameAttribute()
    {
        return $this->last_name . '　' . $this->first_name;
    }
    public function scopeKeywordSearch($query, $keyword)
    {
        if(!empty($keyword)){
            return $query->where(function ($q) use ($keyword) {
                $q->where('first_name', 'like', "%{$keyword}%")
                ->orwhere('last_name', 'like', "%{$keyword}%")->orwhere('email', 'like', "%{$keyword}%");
            });
        }
        return $query;
    }
    public function scopeGenderSearch($query, $gender) 
    {
        if(!empty($gender)){
            return $query->where('gender', $gender);
        }
        return $query;
    }
    public function scopeEmailSearch($query, $email)
    {
        if (!empty($email)) {
            return $query->where('email', $email);
        }
        return $query;
    }
    public function scopeCategorySearch($query, $category_id)
    {
        if (!empty($category_id)) {
            return $query->where('category_id', $category_id);
        }
        return $query;
    }
    public function scopeDateSearch($query, $date)
    {
        if (!empty($date)){
            return $query->whereDate('created_at', $date);
        }
        return $query;
    }
}
