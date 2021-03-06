@inject('labs', 'App\Http\Utilities\Lab')

@extends('app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Register</div>
                    <div class="panel-body">

                        @include('partials.error')
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/auth/register') }}">
                        {{--@include('users.form', ['buttonText'=>'Create Account'])--}}
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="col-md-4 control-label">First Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="first_name"
                                           value="{{ old('first_name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Last Name</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="last_name"
                                           value="{{ old('last_name') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Student Number</label>
                                <div class="col-md-6">
                                    <input type="number" class="form-control" name="student_number"
                                           value="{{ old('student_number') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Lab Section</label>
                                <div class="col-md-6">
                                    {!! Form::select('lab', $labs::all(), old('lab'), ['class' => 'form-control']) !!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" name="password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Create Account
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('footer')
    {{--Sends pageview google anaytics--}}
    <script>
        ga('send', {
            hitType: 'pageview',
            title: 'Register',
            page: '/auth/register'
        });
    </script>
@endsection