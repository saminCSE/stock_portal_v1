@extends('layouts.master')
@section('content')
    @if (session('status'))
    <div class="alert alert-success">{{ session('status')}}</div>
    @endif
    <div class="card">
        <div class="card-body">
        @if(isset($item))
            {!! Form::model($item, ['route'=>["newsportal.update", $item->id],'method' =>'PUT', 'class' => 'custom-validation', 'files' => true,'role'=>"form", 'id' => 'edit-form']) !!}
            @else
            {!! Form::open(['route' => ["newsportal.store"], 'method'=>'POST', 'class' => 'custom-validation', 'files' => true, 'role'=>"form",'id' => 'add-form']) !!}
            @endif
        <form class="custom-validation" action="#">
                <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('news_category', 'News Category') !!}
                </div>
                    <div class="col-md-5">
                    <div class="form-group">
                            {!! Form::select('news_category', $news_category, isset($item->news_category) ? $item->news_category : NULL,['class'=> 'form-control']) !!}
                            {!! $errors->first('news_category', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('title', 'Title') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('title', null,['class'=>'form-control','placeholder'=>'News Title','onkeyup'=>'generateSlug()',]) !!}
                            {!! $errors->first('title', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('slug', 'Slug') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('slug', null,['class'=>'form-control','placeholder'=>'News Slug', 'id'=>'slug']) !!}
                            {!! $errors->first('slug', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('published_date', 'Published Date') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('published_date', $published_date,['class'=>'form-control datepicker']) !!}
                            {!! $errors->first('published_date', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                    {!! Form::label('is_published', 'Published') !!}
                </div>
                    <div class="col-md-5">
                    <div class="form-group">
                            {!! Form::select('is_published', $portalstatus, isset($item->is_published) ? $item->is_published : 0,['class'=> 'form-control']) !!}
                            {!! $errors->first('is_published', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>

                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('source', 'Source') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('source', null,['class'=>'form-control', 'placeholder'=>'News Source']) !!}
                            {!! $errors->first('source', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('source_link', 'Source Link') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::text('source_link', null,['class'=>'form-control', 'placeholder'=>'Source link']) !!}
                            {!! $errors->first('source_link', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('short_description', 'Short Description') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::textarea('short_description', null,['class'=>'form-control', 'placeholder'=>'Short Description']) !!}
                            {!! $errors->first('short_description', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('long_description', 'Long Description') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::textarea('long_description', null,['class'=>'form-control editors', 'placeholder'=>'Long Description']) !!}
                            {!! $errors->first('long_description', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('file', 'File') !!}
                </div>
                    <div class="col-lg-5">
                        <div class="form-group">
                            {!! Form::file('file', null,['class'=>'form-control']) !!}
                            {!! $errors->first('file', '<p class="help-block text-danger">:message</p>') !!}
                        </div>
                        <div>
                        @if(isset($item))
                        <img src="{{ asset('uploads/news/thumbs/'.$item->file) }}" width="120px">
                    @endif
                        </div>
                    </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('is_breaking_news', 'Breaking News') !!}
                </div>
                <div class="col-lg-5">
                        <div class="form-group">
                        {!! Form::checkbox('is_breaking_news', '1',isset($item) ? $item->is_breaking_news : NULL ,['class'=>'', 'id'=>'is_breaking_news']) !!}
                        </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('is_highlight_news', 'Highlight News') !!}
                </div>
                <div class="col-lg-5">
                        <div class="form-group">
                        {!! Form::checkbox('is_highlight_news', '1',isset($item) ? $item->is_highlight_news : NULL ,['class'=>'', 'id'=>'is_highlight_news']) !!}
                        </div>
                </div>
                </div>
                <div class="row">
                <div class="col-md-2 text-right">
                {!! Form::label('is_feature_news', 'Feature News') !!}
                </div>
                <div class="col-lg-5">
                        <div class="form-group">
                        {!! Form::checkbox('is_feature_news', '1',isset($item) ? $item->is_feature_news : NULL ,['class'=>'', 'id'=>'is_feature_news']) !!}
                        </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-md-5 text-right">
                        <div class="form-group mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary waves-effect waves-light mr-1">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div> <!-- end col -->
    @endsection
    @section('script')

<!-- Plugins js -->
<!-- <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js')}}"></script>
<script src="{{ URL::asset('assets/js/pages/datatables.init.js')}}"></script>
<script src="{{ URL::asset('assets/libs/jquery-ui/jquery-ui.min.js')}}"></script> -->
<script src="{{ URL::asset('assets/libs/select2/select2.min.js')}}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js')}}"></script>


<script>
    $(function () {
        $('.datepicker').datepicker({
            autoclose:true,
            todayHighlight:true,
            format:'yyyy-mm-dd',
        });
    });

    function generateSlug() {
    var title = document.getElementById("title").value;
    var slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').substr(0, 50);

    document.getElementById("slug").value = slug;
}
</script>
@endsection
