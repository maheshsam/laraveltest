@extends('app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
            	@if ( session()->has('message') )
	                <div class="alert alert-info alert-dismissable">
	                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
	                    <ul>
	                        <li>{{ session()->get('message') }}</li>
	                    </ul>
	                </div>
	            @endif
            	<?php if(Request::segment(1) == "films" && Request::segment(2) != "create"){ ?>
                <div class="panel-heading">Films</div>
                <div class="panel-body">
                	<?php if(count($films) != 0){?>
                    <div class="row">
                    	<div class="col-md-3">
                    		<?php if( $films[0]["photo"] != "" ){?>
							<img src="{{url('/uploads/'.$films[0]["photo"])}}" />
                    		<?php }?>
                    	</div>
                    	<div class="col-md-9">
                    		<h3><a href="{{url('/film/'.$films[0]['slug'])}}">{{$films[0]["name"]}}</a></h3>
                    	</div>
                    </div>
                    <?php }else{?>
                    <div class="row">
                    	<div class="col-md-12">
                    		No Results.
                    	</div>
                    </div>
                    <?php }?>
                    <div class="row">
                    	<div class="col-md-3">
                    		<?php 
                    		$offset = Request::segment(2);
                    		if($offset != ""){ 
                    			if($offset == 1){
                    				$prev = '';
                    			}else{
                    				$prev = $offset - 1;
                    			}
                    		?>
                    		<a class="btn btn-default" href="{{ url('/films/'.$prev)}}">Previous</a> 
                    		<?php }
                    		if(count($films) != 0){
                    		$next = $offset != "" ? $offset + 1 : 1;
                    		?>
                    		<a class="btn btn-default" href="{{ url('/films/'.$next)}}">Next</a>
                    		<?php } ?>
                    	</div> 
                    </div>
                </div>
                <?php }elseif(Request::segment(1) == "film"){
                	?>
                	<div class="panel-heading">Films</div>
	                <div class="panel-body">
						<div class="row">
	                    	<div class="col-md-3">
	                    		<?php if( $filmdetails->photo != "" ){?>
								<img src="{{url('/uploads/'.$filmdetails->photo)}}" />
	                    		<?php }?>
	                    	</div>
	                    	<div class="col-md-9">
	                    		<h3>{{$filmdetails->name}}</a></h3>
	                    		<p>Rating : {{$filmdetails->rating}}</p>
	                    		<p>Genre : {{$filmdetails->genre}}</p>
	                    		<p>Country : {{$filmdetails->country}}</p>
	                    		<p>Release date : {{$filmdetails->release_date}}</p>
	                    		<p>Ticket Price : $ {{$filmdetails->ticket_price}}</p>
	                    		<p>{{$filmdetails->description}}</p>
	                    		<a href="{{url('/films')}}" class="btn btn-primary">Back to films</a>
	                    	</div>
	                    </div>
	                    <div class="row">
	                    	<div class="col-md-12">
	                    		<?php  if(\Auth::check()){?>
	                    		<h4>Comment</h4>
	                    		{{ Form::open(array('url' => url('/comment/create/'.$filmdetails->id), 'class' => '')) }}
								    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Name'); ?></label>
								        <input id="name" type="text" name="name" value="{{ old('name') ? old('name') : Auth::user()->name }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" /> 
								        @if ($errors->has('name'))
								            <span class="help-block">{{ $errors->first('name') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Comment'); ?></label>
								        <textarea class="form-control" name="comment">{{old('comment')}}</textarea>
								        @if ($errors->has('name'))
								            <span class="help-block">{{ $errors->first('name') }}</span>
								        @endif
								    </div>
								    <div class="form-actions">
								        <div class="pull-left">
								            <button type="submit" class="btn btn-primary"><?php echo trans('Submit');?></button>
								        </div>
								    </div>
								</form>
	                    		<?php }else{
	                    			echo "Please login to comment";
	                    		}?>
	                    	</div>
	                    </div>
                    </div>
                    <?php }elseif(Request::segment(2) == "create"){
                	?>
                	<div class="panel-heading">Create Film</div>
                	<div class="panel-body">
	                	<div class="row">
		                	<div class="col-md-12">
		                		{{ Form::open(array('url' => url('/films/create'), 'files' => true, 'class' => '')) }}
								    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Name'); ?></label>
								        <input id="name" type="text" name="name" value="{{ old('name') }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" /> 
								        @if ($errors->has('name'))
								            <span class="help-block">{{ $errors->first('name') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Slug'); ?></label>
								        <input id="slug" type="text" name="slug" value="{{ old('slug') }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" /> 
								        @if ($errors->has('slug'))
								            <span class="help-block">{{ $errors->first('slug') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('rating') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Rating'); ?></label>
								        <select name="rating" class="form-control">
								        	<option value="1" selected>1</option>
								        	<option value="2">2</option>
								        	<option value="3">3</option>
								        	<option value="4">4</option>
								        	<option value="5">5</option>
								        </select>
								        @if ($errors->has('rating'))
								            <span class="help-block">{{ $errors->first('rating') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('genre') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Genre'); ?></label>
								        <input id="genre" type="text" name="genre" value="{{ old('genre') }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" /> 
								        @if ($errors->has('genre'))
								            <span class="help-block">{{ $errors->first('genre') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Country'); ?></label>
								        <input id="country" type="text" name="country" value="{{ old('country') }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" /> 
								        @if ($errors->has('country'))
								            <span class="help-block">{{ $errors->first('country') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('release_date') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Release Date'); ?></label>
								        <input id="release_date" type="text" name="release_date" value="{{ old('release_date') }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" /> 
								        @if ($errors->has('release_date'))
								            <span class="help-block">{{ $errors->first('release_date') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('ticket_price') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Ticket Price'); ?></label>
								        <input id="ticket_price" type="text" name="ticket_price" value="{{ old('ticket_price') }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" /> 
								        @if ($errors->has('ticket_price'))
								            <span class="help-block">{{ $errors->first('ticket_price') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('photo') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Photo'); ?></label>
								        <input id="photo" type="file" name="photo" value="{{ old('photo') }}" class="form-control form-control-solid placeholder-no-fix" autocomplete="off" /> 
								        @if ($errors->has('photo'))
								            <span class="help-block">{{ $errors->first('photo') }}</span>
								        @endif
								    </div>
								    <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
								        <label class="control-label visible-ie8 visible-ie9"><?php echo trans('Description'); ?></label>
								        <textarea class="form-control" name="description">{{old('description')}}</textarea>
								        @if ($errors->has('description'))
								            <span class="help-block">{{ $errors->first('description') }}</span>
								        @endif
								    </div>
								    <div class="form-actions">
								        <div class="pull-left">
								            <button type="submit" class="btn btn-primary"><?php echo trans('Submit');?></button>
								            <a href="{{url('/films')}}" class="">Back to films</a>
								        </div>
								    </div>
								</form>
		                	</div>
		                </div>
	                </div>
                	<?php } ?>
            </div>
        </div>
    </div>
</div>
@endsection
