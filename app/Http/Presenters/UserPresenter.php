<?php

namespace App\Http\Presenters;

use App\Core\PresenterCore;
use App\Factories\FilterFactory;
use App\Factories\PresenterFactory;
use App\Factories\ModelFactory;
use Illuminate\Http\Request;

class UserPresenter extends PresenterCore
{
	/**
	 * Return User List view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function userList()
	{
		$this->view->roles = $this->getRoles();		
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->tableHeaders = $this->getUserTableColumns();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		return $this->view('users');
	}

	/**
	 * Display Contact us form.
	 * @return string The rendered html view
	 */
	public function contactUs()
	{
		$this->view->branch = PresenterFactory::getInstance('Reports')->getArea(true);
		return $this->view('contactUs');
	}

	/**
	 * Return Summary of incidents reports.
	 * @return string The rendered html view
	 */
	public function summaryOfIncidentReport()
	{
		$this->view->roles = $this->getRoles();
		$this->view->name = $this->contactUsName();
		$this->view->tableHeaders = $this->getIncidentReportTableColumns();
		$this->view->branch = PresenterFactory::getInstance('Reports')->getArea(true);
		return $this->view('summaryOfIncidentReport');
	}

	/**
	 * Return User Group Rights view
	 * @param string $type
	 * @return string The rendered html view
	 */
	public function userGroupRights()
	{
		$this->view->tableHeaders = $this->getRoleTableColumns();
		return $this->view('userGroupRights');
	}

	
	/**
	 * Display add edit form
	 * @param number $userId
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function addEdit($userId=0)
	{
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		return $this->view('addEdit');
	}
	
	/**
	 * Get user info
	 * @param number $userId
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function getUser($userId)
	{
		$user = ModelFactory::getInstance('User')->find($userId);
		$data = $user ? $user->toArray() : [];
		return response()->json($data);
	}
	
	
	/**
	 * Display add edit form
	 * @return Ambigous <\Illuminate\View\View, \Illuminate\Contracts\View\Factory>
	 */
	public function edit()
	{
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea(true);
		return $this->view('edit');
	}
	
	
	public function changePassword(){
		return $this->view('changePassword');
	}
	
	public function profile(){
		$this->view->assignmentOptions = $this->getAssignmentOptions();
		$this->view->roles = $this->getRoles();
		$this->view->gender = $this->getGender();
		$admin = $this->isAdmin();
		$this->view->areas = PresenterFactory::getInstance('Reports')->getArea();
		$this->view->readOnly = $admin ? '' : 'readonly';
		return $this->view('myProfile');
	}
	
	/**
	 * Get my profile
	 * @return \App\Http\Presenters\Ambigous
	 */
	public function myProfile(){
		return $this->getUser(auth()->user()->id);
	}
	
	/**
	 * Get user roles
	 */
	public function getRoles()
	{
		return \DB::table('user_group')->lists('name','id');	
	}

	/**
	 * Get User name of report.
     */
	public function contactUsName()
	{
		return ModelFactory::getInstance('ContactUs')->distinct()->get()->lists('full_name', 'full_name');
	}

	/**
	 * Get the prepared list of summary of incident reports.
	 */
	public function getPreparedSummaryOfIncidentReportList($withCode = true)
	{
		$summary = ModelFactory::getInstance('ContactUs')->with('users');

		if ($this->request->has('name') && $this->request->get('name') != 0) {
			$filterName = FilterFactory::getInstance('Text');
			$summary = $filterName->addFilter($summary, 'name', function ($self, $model) {
				return $model->where('full_name', $self->getValue());
			});
		}

		if ($this->request->has('branch') && $this->request->get('branch') != 0) {
			$filterBranch = FilterFactory::getInstance('Select');
			$summary = $filterBranch->addFilter($summary, 'branch', function ($self, $model) {
				return $model->where('location_assignment_code', $self->getValue());
			});
		}

		if ($this->request->has('incident_no') && $this->request->get('incident_no') != '') {
			$filterIncidentNo = FilterFactory::getInstance('Text');
			$summary = $filterIncidentNo->addFilter($summary, 'incident_no', function ($self, $model) {
				return $model->where('id', $self->getValue());
			});
		}

		if ($this->request->has('date_range_from') && $this->request->get('date_range_from') != '' && $this->request->has('date_range_to') && $this->request->has('date_range_to') != '') {
			$filterDateRange = FilterFactory::getInstance('DateRange');
			$summary = $filterDateRange->addFilter($summary, 'date_range', function ($self, $model) {
				return $model->whereBetween('created_at', $self->formatValues($self->getValue()));
			});
		}
		if ($withCode) {
			return $summary->get();
		} else {
			return $summary;
		}
	}

	/**
	 * Get the list of summary of incident reports.
	 * @return mixed
     */
	public function getSummaryOfIncidentReports()
	{

		$data['records'] = $this->getPreparedSummaryOfIncidentReportList();
		$data['total'] = count($data['records']);

		return response()->json($data);
	}
	
	/**
	 * Get user emails
	 */
	public function getUserEmails($id=0, $json=true)
	{
		$prepare = \DB::table('user');
		if($id)
		{
			$prepare = $prepare->where('id','<>',$id);
		}
		$result = $prepare->whereNull('deleted_at')->lists('email','id');
		return $json ? response()->json($result) : $result;
	}
	
	/**
	 * Get user emails
	 */
	public function getUsernames($id=0, $json=true)
	{
		$prepare = \DB::table('user');
		if($id)
		{
			$prepare = $prepare->where('id','<>',$id);
		}
		
		$result = $prepare->whereNull('deleted_at')->lists('username','id');
		return $json ? response()->json($result) : $result;
	}
	
	/**
	 * Get assignment options
	 * @return multitype:string
	 */
	public function getAssignmentOptions()
	{
		return [
			1 => 'Permanent',
			2 => 'Reassigned',
			3 => 'Temporary'			
		];	
	}
	
	/**
	 * Get gender
	 * @return multitype:string
	 */
	public function getGender()
	{
		return [
				//0 => 'NA',
				1 => 'Male',
				2 => 'Female'
		];
	}
	
	public function getUsers()
	{
		$select = '
				user.id,
				user.created_at,
				CONCAT(user.firstname,\' \',user.lastname) fullname,
				app_area.area_name,
				IF(user.location_assignment_type = 1, \'Permanent\', IF(user.location_assignment_type = 2, \'Reassigned\', IF(user.location_assignment_type = 3, \'Temporary\', \'\'))) assignment,
				user_group.name role,
				user.status,
				user.email
				';
		
		$prepare = \DB::table('user')
						->selectRaw($select)
						->leftJoin('user_group','user.user_group_id','=','user_group.id')
						->leftJoin('app_area','app_area.area_code','=','user.location_assignment_code');		
		 
		$fnameFilter = FilterFactory::getInstance('Text');
		$prepare = $fnameFilter->addFilter($prepare,'fullname', function($filter, $model){
						return $model->where(function ($query) use ($filter){
							$query->where('user.firstname','like','%'.$filter->getValue().'%')
								  ->where('user.lastname','like','%'.$filter->getValue().'%','or');
						});						
					});
				
		$roleFilter = FilterFactory::getInstance('Select');
		$prepare = $roleFilter->addFilter($prepare,'user_group_id');
		
		$createdFilter = FilterFactory::getInstance('DateRange');
		$prepare = $createdFilter->addFilter($prepare,'created_at', function ($filter, $model){
					return $model->whereBetween(\DB::raw('DATE(user.created_at)'),$filter->getValue());			
					});
		
		$branchFilter = FilterFactory::getInstance('Select');
		$prepare = $branchFilter->addFilter($prepare,'location_assignment_code');
		
		$assignmentFilter = FilterFactory::getInstance('Select');
		$prepare = $assignmentFilter->addFilter($prepare,'location_assignment_type');
		
		$exclude = [1,auth()->user()->id];
		$prepare->whereNotIn('user.id',$exclude);
		$prepare->whereNull('user.deleted_at');
		
		//dd($prepare->toSql());
		$result = $this->paginate($prepare);
		
		$items = $result->items();
		
		foreach($items as $k=>$item)
		{
			if($item->status == 'A')
				$items[$k]->active = true;
			else
				$items[$k]->active = false;
		}
		
		$data['records'] = $items;
		$data['total'] = $result->total();
		
		return response()->json($data);
		
		
	}
	

	public function getUserGroup()
	{
		$select = 'id, name';
		
		$prepare = \DB::table('user_group')
						->selectRaw($select);	
		 
		//dd($prepare->toSql());
		$result = $this->paginate($prepare);
		
		$items = $result->items();
		
		$data['records'] = $items;
		$data['total'] = $result->total();
		
		return response()->json($data);
		
		
	}

	/**
	 * Get User Table Columns
	 * @return multitype:multitype:string
	 */
	public function getUserTableColumns()
	{
		$headers = [
				['name'=>'Full Name', 'sort'=>'lastname'],
				['name'=>'Email', 'sort'=>'email'],
				['name'=>'Role', 'sort'=>'role'],
				['name'=>'Branch', 'sort'=>'area_name'],
				['name'=>'Assignment', 'sort'=>'assignment'],
				['name'=>'Date Created', 'sort'=>'created_at'],
				['name'=>'Actions'],				
		];
		 
		return $headers;
	}

	/**
	 * Get Summary incident of report table columns.
	 * @return multitype:multitype:string
	 */
	public function getIncidentReportTableColumns()
	{
		$headers = [
			['name'=>'Incident #', 'sort'=>'id'],
			['name'=>'Summary', 'sort'=>'message'],
			['name'=>'Status', 'sort'=>'status'],
			['name'=>'Submitted By', 'sort'=>'name']
		];

		return $headers;
	}

	/**
	 * Get UserGroup Table Columns
	 * @return multitype:multitype:string
	 */
	public function getRoleTableColumns()
	{
		$headers = [
				['name'=>'ID', 'sort'=>'id'],
				['name'=>'Name', 'sort'=>'name']		
		];
		 
		return $headers;
	}
}
