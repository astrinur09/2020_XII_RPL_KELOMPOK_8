<?php
namespace App\Http\Controller;
use app\admin;
use illuminate\Http\request;

class AdminController extends Controller
{
	public function __construct()
	{

		$this->middleware(['auth']);
		$this->middLeware('DisablepreventBack');
	}
	@return

	public function index ()
	{
		return view('admin.master');

	}	

	
