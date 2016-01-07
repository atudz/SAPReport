{!!Html::breadcrumb(['My Account: '.Auth::User()->firstname.' '.Auth::User()->lastname,'Change Password'])!!}
{!!Html::pageheader('Change Password')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">

			{!!Form::open(['url'=>'/controller/changepassword','class'=>'changepassword-form'])!!}
				<div class="form-group row">
					<label class="col-sm-2" for="old_password">Old Password</label>
					<div class="col-sm-5">
				      <input type="password" class="form-control" id="old_password" placeholder="">
				    </div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2" for="old_password">New Password</label>
					<div class="col-sm-5">
				      <input type="password" class="form-control" id="old_password" placeholder="">
				    </div>
				</div>
				<div class="form-group row">
					<label class="col-sm-2" for="old_password">Confirm Password</label>
					<div class="col-sm-5">
				      <input type="password" class="form-control" id="old_password" placeholder="">
				    </div>
				</div>
				<div class="form-group row">
				    <div class="col-sm-offset-2 col-sm-5">
				      <button type="submit" class="btn btn-primary">Submit</button>
				    </div>
			 	</div>
		    </form>
		    {!!Form::close()!!}
			</div>
		</div>
	</div>
</div>