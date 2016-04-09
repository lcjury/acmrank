@extends('layouts.app')

@section('contents')
    <div class="row">
      <div class="large-8 large-offset-2 columns" style="text-align:center">
        <h1>Ranking Global</h1>
        <hr />
      </div>
    </div>
    <div class="row">
      <div class="large-8 large-offset-2 columns">
        <div class="callout large">
<div class="row">
<div class="small-9 columns">
<h3>Usuario</h3>
</div>
<div class="small-3 columns">
<h3>Accepted</h3>
</div>
</div>
  @foreach($students as $student)
    @include('partials.studentRank', ['student' =>$student])
  @endforeach
        </div>
      </div>
    </div>
@endsection
