@extends('app')

@section('content')
    <div class="page-header">
        <h1>Quizzes</h1>
    </div>
    @if(Auth::user()->admin)
        {{--<a href="{{ action('QuizzesController@create') }}" class=" btn btn-primary margin-button"> Create Quiz </a>--}}
        <a href="{{ action('QuizzesController@data') }}" class=" btn btn-default margin-button">Quiz Data</a>
        <a href="{{ action('QuizzesController@setting') }}" class=" btn btn-default margin-button"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
    @endif
    @foreach($quizzes->whereLoose('active',1) as $quiz)
        <a style="color:black; text-decoration:none" href="{{ action('QuizzesController@show', [$quiz->id]) }}">
            <div class="panel panel-default">
                <div class="panel-body">
                    <p>{{$quiz->name}}</p>
                    @if(Auth::user()->hasQuizAttempt($quiz->id))
                        @if(Auth::user()->canRetakeQuiz($quiz->id))
                            <p>Retake</p>

                        @else
                            <p>Retake {{Auth::user()->timeTillRetake($quiz->id)}}</p>
                        @endif
                    @else
                        <p>Take Now</p>
                    @endif
                    @if(Auth::user()->admin)
                        <a href="{{action('QuizzesController@edit', $quiz)}}"
                           class="btn btn-default">Edit Quiz </a>
                        {!! Form::open(['method' => 'DELETE', 'action' => ['QuizzesController@destroy', $quiz], 'style' => 'display:inline;']) !!}
                        {!! Form::submit('Delete Quiz', ['class' => 'btn btn-default', 'onClick'=>"return confirm('Delete this quiz?')"]) !!}
                        {!! Form::close() !!}
                    @endif
                </div>
            </div>
        </a>
    @endforeach
    @if(Auth::user()->admin)
        @if(!$quizzes->whereLoose('active',0)->isEmpty())
            <hr>
            <div class="page-header">
                <h1>Non active submissions</h1>
            </div>
            @foreach($quizzes->whereLoose('active',0) as $quiz)
                <a style="color:black; text-decoration:none" href="{{ action('QuizzesController@show', [$quiz->id]) }}">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <p>{{$quiz->name}}</p>
                                <a href="{{action('QuizzesController@edit', $quiz)}}"
                                   class="btn btn-default">Edit Quiz </a>
                                {!! Form::open(['method' => 'DELETE', 'action' => ['QuizzesController@destroy', $quiz], 'style' => 'display:inline;']) !!}
                                {!! Form::submit('Delete Quiz', ['class' => 'btn btn-default','onClick'=>"return confirm('Delete this quiz?')"]) !!}
                                {!! Form::close() !!}
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
    @endif
@endsection
@section('footer')
    {{--Sends pageview google anaytics--}}
    <script>
        ga('send', {
            hitType: 'pageview',
            title: 'Quiz',
            page: '/quiz'
        });
    </script>
@endsection