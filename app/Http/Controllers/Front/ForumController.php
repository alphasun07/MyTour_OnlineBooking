<?php

namespace App\Http\Controllers\Front;

use App\Events\QuestionView;
use Illuminate\Http\Request;
use App\Models\DtbQuestion;
use App\Models\PcmDmsCategory;
use App\Http\Controllers\Controller;
use App\Models\DtbAnswers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{
    private $question;

    public function __construct(DtbQuestion $question)
    {
        $this -> question = $question;
    }

    public function listQuestions(Request $request)
    {
        try {
            $filter_data = $request->input();
            $filtering_category = (new PcmDmsCategory)->getCategoryIsForum($filter_data['category_id'] ?? '')->get() ?? '';
            $questions_query = (new DtbQuestion)->getPublicQuestions() ?? '';
            if(!empty($filter_data['category_id']) && !$filtering_category->isEmpty()){
                $questions_query = (new  DtbQuestion)->filterCategory_id($questions_query,$filter_data['category_id']);
            }
            if(!empty($filter_data['by'])){
                $questions_query = ((new DtbQuestion())->orderByFilter($questions_query, $filter_data['by']));
            }else{
                $questions_query = $questions_query->orderBy('created_at', 'DESC');
            }
            $time = date('Y-m-d', strtotime('-1 '. ($filter_data['time'] ?? 'month')));
            $questions_query = (new DtbQuestion)->filterByTime($questions_query, $time);
            $questions = $questions_query->paginate(10) ?? '';
            $categories = ( new PcmDmsCategory)->getForumCategories()->get();

            return view('front.forum.list', compact('questions', 'categories', 'filter_data'));
        } catch (\Exception $e) {
            log::error('group. message: '. $e->getMessage());
            abort(500);
        }
    }

    public function store(Request $request){
        try {
            $id = $request->id;
            $dataInsert = [
                'user_id' =>auth('web')->id(),
                'category_id' => $request ->category_id ?? '',
                'title' => $request->title ?? '',
                'content' => $request ->contents ?? '',
            ];
            $rule = [
                'category_id' => ['required'],
                'title' => ['required', 'max:255'],
                'contents' => ['required'],
            ];

            $validator = Validator::make($request->input(), $rule);
            if ($validator->fails()) {
                $messagesErrors = $validator->errors();
                return redirect()->back()->withInput($request->input())->withErrors($messagesErrors);
            }

            if($id){
                $question = (new DtbQuestion())->findOrFail($id);
                $question->fill($dataInsert);
                $question->save();

                return redirect()->back();
            }
            $this->question->create($dataInsert);
            return redirect()->route('forum.question.list');
        }catch (\Exception $exception){
            Log::error('Error :' . $exception->getMessage() . '---Line:' .$exception->getLine());
        }
    }

    public function listAnswers($id)
    {
        try {
            $questionFind = (new DtbQuestion)->find($id) ?? '';
            $question = (new DtbQuestion())->getQuestion($id)->first() ?? '';
            $answers = (new DtbAnswers())->getAnswerByQuestion($id)->paginate(10) ?? '';
            $userVoted = (new DtbQuestion())->getUserVoted($id)->pluck('dtb_questions_votes.user_id')->toArray() ?? [];
            event(new QuestionView($questionFind));

            return view('front.forum.answer_list', compact('question', 'answers', 'userVoted'));
        }catch (\Exception $e) {
            log::error('group. message: '. $e->getMessage());
            abort(500);
        }
    }

    public function StoreAnswers(Request $request){
        $question_id = $request->question_id ?? '';
        try {
            $id = $request->answer_id ?? 0;
            $dataInsert = [
                'user_id' =>auth('web')->id(),
                'question_id' => $question_id,
                'content' => $request->contents ?? '',
            ];

            $rule = [
                'contents' => ['required'],
            ];

            $validator = Validator::make($request->input(), $rule);
            if ($validator->fails()) {
                $messagesErrors = $validator->errors();
                return redirect()->back()->withInput($request->input())->withErrors($messagesErrors);
            }

            if (!$id) {
                (new DtbAnswers())->create($dataInsert);
            } else {
                $answer = (new DtbAnswers())->findOrFail($id);
                $answer->fill($dataInsert);
                $answer->save();
            }

            return redirect()->route('forum.question.answer',['id'=>$question_id]);
        }catch (\Exception $exception){
            Log::error('Error :' . $exception->getMessage() . '---Line:' .$exception->getLine());
        }
    }

    public function updateVote(Request $request)
    {
        try{
            $id = $request->question_id ?? 0;
            $user_id = $request->user_id ?? 0;
            $question = (new DtbQuestion())->find($id) ?? '';
            $question->votes()->sync([$user_id]);

            return redirect()->back();
        } catch (\Exception $e) {
            log::error('group. message: '. $e->getMessage());
            abort(500);
        }
    }

    public function deleteAnswer(Request $request){
        try{
            $id = $request->answer_id;
            DtbAnswers::where('id', $id)->delete();
            $request->session()->flash('success', 'Đã xóa phản hồi');

            return redirect()->back();
        } catch (\Exception $e){
            Log::info('---Delete Answer---');
            Log::error($e->getMessage());
            throw $e;
        }
    }
}
