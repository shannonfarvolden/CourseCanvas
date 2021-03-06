
<div class="form-group">
    {!! Form::label('name', 'Name') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('due_date', 'Due Date ') !!}
    {!! Form::date('due_date', date('Y-m-d'), ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('total', 'Total Marks') !!}
    {!! Form::text('total', null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('evaluation_id', 'Category') !!}
    {!! Form::select('evaluation_id', $evaluations, null, ['class' => 'form-control']) !!}
</div>
<div class="form-group">
    {!! Form::label('bonus', 'Make this entire submission bonus?') !!}
    {!! Form::checkbox('bonus') !!}
</div>
<div class="form-group">
    {!! Form::label('active', 'Active Submission (students can submit files)') !!}
    {!! Form::checkbox('active') !!}
</div>
<div class="form-group">
    {!! Form::submit($buttonText, ['class' => 'btn btn-primary']) !!}
</div>
