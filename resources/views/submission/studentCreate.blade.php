@extends('app')

@section('content')
    @include('partials.error')
    <div class="panel panel-default heading-margin">
        <div class="panel-body padding-sides">
            <div class="page-header">
                <h1>{{$submission->name}} Submission</h1>
            </div>

            @if($lastAttempt)
            <h5>Last Submission</h5>
                <p>Attempt #{{$lastAttempt->pivot->attempt}}
                    <a href="/{{$lastAttempt->pivot->file_path}}">{{$lastAttempt->pivot->file_name}}</a>
                </p>
            <hr>
            @endif
            {!! Form::open([ 'action' => ['SubmissionsController@studentStore', $submission], 'files' => true]) !!}
            @include('submission.studentForm')
            {!! Form::close() !!}

        </div>
    </div>

@endsection
@section('footer')
    {{--Sends pageview google anaytics--}}
    <script>
        ga('send', {
            hitType: 'pageview',
            title: 'Submission',
            page: '/submission/create'
        });
    </script>
@endsection