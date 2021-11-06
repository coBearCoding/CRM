<?php

namespace App\Http\Controllers;

use App\Empresa;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CalendarController extends Controller {

	public function __construct() {
		$this->middleware('configure');
	}

	public function index() {
		return view('calendar.index');
	}

	}
