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
    public function indexSubmissions()
    {
        $submissions = Submission::all();
        return view('admin.submissions', ['submissions'=>$submissions]);
    }


    public function mark($id)
    {
        $submission = Submission::findorFail($id);

        $submitStudents = $submission->users;
        $submitIds = $submitStudents->lists('student_number');
        $noSubmissions = User::where('admin', 0 )->whereNotIn('id', $submitIds )->get();

        return view('admin.mark', ['submission'=>$submission->name, 'submitStudents'=>$submitStudents, 'noSubmissions'=>$noSubmissions]);
    }


}