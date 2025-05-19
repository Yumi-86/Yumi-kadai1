<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Category;

class AdminController extends Controller
{
    public function index()
    {
        $contacts = Contact::with('category')->paginate(7);

        $categories = Category::all();
        return view('admin.index', compact('contacts', 'categories'));
    }
    public function search(Request $request)
    {
        $contacts = Contact::with('category')->KeywordSearch($request->keyword)->GenderSearch($request->gender)->EmailSearch($request->email)->CategorySearch($request->category_id)->DateSearch($request->date)->paginate(7);
        $categories = Category::all();

        return view('admin.index', compact('contacts', 'categories'));
    }
    public function destroy(Request $request)
    {
        Contact::find($request->id)->delete();

        return redirect('/admin');
    }
    public function export(Request $request)
    {

        $contacts = Contact::KeywordSearch($request->keyword)->GenderSearch($request->gender)->CategorySearch($request->category_id)->DateSearch($request->date)->get();

        // CSVヘッダ
        $csvHeader = ['ID', '名前', 'メールアドレス', '電話番号', '住所', '建物名', 'お問い合わせの種類', 'お問い合わせの内容', '作成日'];

        // CSVデータ作成
        $csvData = [];
        $csvData[] = $csvHeader;

        foreach ($contacts as $contact) {
            $csvData[] = [
                $contact->id,
                $contact->full_name,
                $contact->gender_label,
                $contact->email,
                $contact->tel,
                $contact->address,
                $contact->building,
                $contact->category->content,
                $contact->detail,
                $contact->created_at->format('Y-m-d H:i:s'),
            ];
        }

        // ファイル名
        $filename = 'contacts_' . now()->format('Ymd_His') . '.csv';

        // ストリームレスポンスでCSVを返す
        $callback = function () use ($csvData) {
            $file = fopen('php://output', 'w');
            foreach ($csvData as $row) {
                fputcsv($file, $row);
            }
            fclose($file);
        };

        return Response::stream($callback, 200, [
            "Content-Type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ]);
    }
}
