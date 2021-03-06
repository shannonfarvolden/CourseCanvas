<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Submission;
use App\Evaluation;
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
     * Displays view of admin options.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function admin()
    {
        return view('admin.index');
    }


    /**
     * Displays student submissions.
     *
     * @param Submission $submission
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function mark(Submission $submission, Request $request)
    {
        $users = User::students()->get();
        //Session::flash('backUrl', Request::fullUrl());
        if (sizeof($request->input()) > 0) {

            $users = $this->search($request, $submission);
        }

        return view('admin.mark', ['submission' => $submission, 'users' => $users]);
    }

    public function overview()
    {
        $inclassEval = Evaluation::where('category', 'like', 'In-class%')->get()->first();

        // get all evals except inclass
        $evaluations = Evaluation::whereNotIn('id', [$inclassEval->id])->get();
        $evaluationsRisk = collect([]);

        foreach ($evaluations as $evaluation) {
            if (!$evaluation->evalEmpty()) {
                $values = [
                    'id' => $evaluation->id,
                    'category' => $evaluation->category,
                    'min' => $evaluation->evalMin(),
                    'max' => $evaluation->evalMax(),
                    'median' => $evaluation->evalMedian(),
                    'average' => $evaluation->evalAvg(),
                    'danger' => $evaluation->risk('danger')->count(),
                    'warning' => $evaluation->risk('warning')->count(),
                    'success' => $evaluation->risk('success')->count()
                ];

                $evaluationsRisk->push($values);
            }
        }
        return view('admin.overview', ['evaluationsRisk' => $evaluationsRisk]);
    }

    /**
     * Filter and Sort users.
     *
     * @param Request $request
     * @param Submission $submission
     * @return mixed
     */
    public function search(Request $request, Submission $submission)
    {
        $query = User::students();
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $order = $request->get('order');
        if ($filter && $filter != 'none') {
            if (strpos($filter, 'L') !== false) {
                $query = $query->where('lab', $filter);
            } elseif ($filter == "file_submitted") {
                $query = $submission->users();
            }
        }
        if ($sort && $sort != 'none') {
            if ($sort == 'last_name') {
                if ($order && $order == 'desc')
                    $query = $query->orderBy('last_name', 'desc');
                else
                    $query = $query->orderBy('last_name');
            } elseif ($sort == 'first_name') {
                if ($order && $order == 'desc')
                    $query = $query->orderBy('first_name', 'desc');
                else
                    $query = $query->orderBy('first_name');
            } elseif ($sort == 'student_number') {
                if ($order && $order == 'desc')
                    $query = $query->orderBy('student_number', 'desc');
                else
                    $query = $query->orderBy('student_number');
            } elseif ($sort == 'submission_date') {
                if ($order && $order == 'desc')
                    $query = $submission->users()->orderBy('pivot_created_at', 'desc');
                else
                    $query = $submission->users()->orderBy('pivot_created_at');
            }
        }
        // Flash old input to repopulate on search
        $request->flash();

        return $query->get();
    }

    /**
     * Displays students at risk for a given evaluation at a certain level.
     *
     * @param Evaluation $evaluation
     * @param $level
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function risk(Evaluation $evaluation, $level)
    {

        $studentRisk = $evaluation->risk($level);
        $studentIds = [];

        $i = 0;
        foreach ($studentRisk as $student) {
            $studentIds[$i] = $student['user_id'];
            $i++;

        }
        $students = User::students()->whereIn('id', $studentIds)->get();

        return view('admin.risk', ['evaluation' => $evaluation, 'students' => $students, 'level' => $level]);
    }

    /**
     * Display view for student data.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function data()
    {
        return view('admin.data');
    }
}
