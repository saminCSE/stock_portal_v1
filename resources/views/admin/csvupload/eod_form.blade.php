@extends('layouts.master')



@section('content')
<br>
<div class="card">
    <div class="box-header with-border text-left">
        <h3 class="box-title">Import eod data</h3>
    </div>
    <div class="card-body">
        @if(isset($item))
        {!! Form::model($item, ['route' => ["csvFileImport.ImportEod", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
        @else
        {!! Form::open(['route' => ["csvFileImport.ImportEod"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
        @endif
        <form class="custom-validation" action="#">
            <div class="form-group">
                <input type="file" name="file" />

                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>

    </div>
</div> <!-- end col -->




@endsection

