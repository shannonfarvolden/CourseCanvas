<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Submission;
use App\Grade;
use App\User;
use Auth;


class AdminController extends Controller
{
    /**
     * Create a new admin controller instance. User must be logged in to view pages.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Displays submission index.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexSubmissions()
    {
        $submissions = Submission::all();
        return view('admin.submissions', ['submissions'=>$submissions]);
    }


    /**
     * Displays student submissions.
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mark($id)
    {
        $submission = Submission::findorFail($id);

        $submitStudents = $submission->users()->orderBy('pivot_created_at', 'asc')->get()->unique();

        $submitIds = $submitStudents->lists('student_number');
        $noSubmissions = User::where('admin', 0 )->whereNotIn('student_number', $submitIds )->get();


        return view('admin.mark', ['submission'=>$submission, 'submitStudents'=>$submitStudents, 'noSubmissions'=>$noSubmissions]);
    }

    /**
     *  Store a new grade in database.
     *
     * @param Request $request
     * @param $id
     * @param $sid
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeGrade(Request $request, $id, $sid)
    {

        $input = array_add($request->all(), 'submission_id', $id);
        $input = array_add($input, 'user_id', $sid);
        Grade::create($input);
        return redirect()->action('AdminController@mark',['id'=>$id]);

    }

    /**
     * Show the form for creating a new grade for specified student.
     *
     * @param $sub_id
     * @param $student_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createGrade($sub_id, $student_id)
    {
        $student = User::findOrFail($student_id);
        return view('admin.createGrade', ['sub_id'=>$sub_id, 'student'=>$student]);

    }

    /**
     * Show the form for editing the specified submission and student.
     *
     * @param $sub_id
     * @param $student_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editGrade($sub_id, $student_id)
    {
        $student = User::findOrFail($student_id);
        $grade = $student->grades->whereLoose('submission_id', $sub_id)->last();
        return view('admin.editGrade', ['grade'=>$grade]);

    }

    /**
     *  Update the specified grade in database.
     *
     * @param Request $request
     * @param $grade_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateGrade(Request $request, $grade_id)
    {
        $grade = Grade::findOrFail($grade_id);
        $grade->update($request->all());
        return redirect()->action('AdminController@mark',['id'=>$grade->submission_id]);
    }



}
