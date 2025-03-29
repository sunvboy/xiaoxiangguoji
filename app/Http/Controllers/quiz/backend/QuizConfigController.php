<?php

namespace App\Http\Controllers\quiz\backend;

use App\Http\Controllers\Controller;
use App\Models\QuizConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Validator;

class QuizConfigController extends Controller
{
    protected $table = 'quiz_configs';
    public function __construct()
    {

        View::share(['module' => $this->table]);
    }
    public function index()
    {
        $detail =  QuizConfig::first();
        return view('quiz.backend.config.index', compact('detail'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'experience' => 'required',
            'mark_experience' => 'required',
        ], [
            'experience.required' => 'Số câu trắc nghiệm là trường bắt buộc.',
            'mark_experience.required' => 'Số điểm câu trắc nghiệm là trường bắt buộc.',
        ]);
        $validator->validate();
        $_data = [
            'experience' => $request->experience,
            'mark_experience' => $request->mark_experience,
            'essay' => $request->essay,
            'speak' =>  $request->speak
        ];
        $id = QuizConfig::where('id', $id)->update($_data);
        if (!empty($id)) {
            return redirect()->route('quiz_configs.index')->with('success', "Cập nhập thành công");
        }
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
