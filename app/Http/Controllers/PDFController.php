<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use PDF;

class PDFController extends Controller
{    
    public function index(Request $request)
	{
	    

	    $data = [
	            'title' => 'Welcome to Websolutionstuff',
	            'date' => date('d/m/Y')
	    ];

	    if($request->has('download'))
	    {
	        $pdf = PDF::loadView('indexpdf',$data);

	        return $pdf->download('users.pdf');
	    }

	    return view('indexpdf',compact('data'));
	}
}