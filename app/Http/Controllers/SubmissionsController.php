<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Http\Requests\SubmissionRequest;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Evaluation;
use App\Submission;
use App\Team;
use Auth;
use Gate;

class SubmissionsController extends Controller
{

    /**
     * Create a new submissions controller instance. User must be logged in to view pages.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin', ['except' => [
            'index',
            'studentCreate',
            'studentStore',
            'complete'
        ]]);
    }

    /**
     * Displays submission index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $submissions = Submission::orderBy('created_at', 'desc')->get();

        return view('submission.index', ['submissions' => $submissions]);
    }

    /**
     * Displays create submission view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        $evaluations = Evaluation::lists('category', 'id');

        return view('submission.create', ['evaluations' => $evaluations]);
    }

    /**
     * Store Submission in database.
     *
     * @param SubmissionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(SubmissionRequest $request)
    {

        Submission::create($request->all());

        return redirect()->action('SubmissionsController@index');
    }

    /**
     * Displays edit a submission view.
     *
     * @param Submission $submission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Submission $submission)
    {
        $evaluations = Evaluation::lists('category', 'id');
        return view('submission.edit', ['submission' => $submission, 'evaluations' => $evaluations]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param SubmissionRequest $request
     * @param Submission $submission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SubmissionRequest $request, Submission $submission)
    {
        $submission->update($request->all());

        $submission->active = ($request->input('active')) ? true : false;
        $submission->bonus = ($request->get('bonus'))? true : false;
        $submission->save();

        return redirect()->action('SubmissionsController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Submission $submission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Submission $submission)
    {
        $submission->delete();
        return redirect()->action('SubmissionsController@index');
    }

    /**
     * Show the form for creating a new user submission.
     *
     * @return \Illuminate\Http\Response
     */
    public function studentCreate(Submission $submission)
    {
        if(Gate::denies('submission-active', $submission))
            return view('errors.notactive', ['name' => $submission->name]);
        $lastAttempt = Auth::user()->submissions()->where('id', $submission->id)->get()->last();

        return view('submission.studentCreate', ['submission' => $submission, 'lastAttempt' => $lastAttempt]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function studentStore(Request $request, Submission $submission)
    {
        if(Gate::denies('submission-active', $submission))
            return view('errors.notactive', ['name' => $submission->name]);
        // validate request, check that files are submitted
        $this->validate($request, ['submissions.*' => 'required'], ['submissions.*' => 'Files are required to make a submission']);
        $files = $request->file('submissions');

        foreach ($files as $file) {

            $attempt = (Auth::user()->hasSubmissionAttempt($submission->id)) ? Auth::user()->lastSubmissionMade($submission->id)->pivot->attempt + 1 : 1;
            $invalid = [':', '/', '?', '#', '[', ']', '@'];
            $filename = str_replace($invalid, '-', $file->getClientOriginalName());
            $name = $attempt . '-' . Auth::user()->student_number . '(' . $submission->id . ')' . $filename;
            $comments = $request->input('comments');
            $file->move('submissions', $name);

            if ($comments)
                Auth::user()->submissions()->attach($submission->id, ['file_name' => $file->getClientOriginalName(), 'file_path' => "submissions/{$name}", 'comments' => $comments, 'attempt' => $attempt]);
            else
                Auth::user()->submissions()->attach($submission->id, ['file_name' => $file->getClientOriginalName(), 'file_path' => "submissions/{$name}", 'attempt' => $attempt]);
        }

        return redirect()->action('SubmissionsController@complete', ['id' => $submission->id]);
    }

    /**
     * Displays Submission complete view.
     *
     * @param Submission $submission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function complete(Submission $submission)
    {
        return view('submission.complete', ['submission' => $submission]);
    }

    /**
     * Grade submission by team.
     * @param Submission $submission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function team(Submission $submission){
        $teams = Team::all();

        return view('submission.teams', ['teams' => $teams, 'submission'=>$submission]);
    }

}
