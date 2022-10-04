<?php

namespace App\Http\Controllers\Client;

use Auth;
Use App\Model\Velo;
Use App\Model\Demande;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VeloController extends Controller {

	public function __construct() {
		$this -> middleware('auth');
		$this -> middleware('client');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		$velo = Velo::paginate(8);
		return view('client.velo.list', compact('velo'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		if ($request -> isMethod('post')) {
			$this -> validate($request, [
			'adresse' => 'required',
			'tel' => 'required',
			'dateDebut' => 'required',
			'nmbejour' => 'required', ]);
			$input = $request -> all();
			$input['user_id'] = Auth::user() -> id;
			$id = $input['velo_id'];
			$velo = Velo::findOrFail($id);
			$total = $velo->price * $input['nmbejour'];
			$input['total'] = $total;
			$demande = Demande::create($input);
			if ($demande) {
				return redirect('ListVelo') -> with('success', 'Demande created successfully!');
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		$velo = Velo::findOrFail($id);
		return view('client.demande.add', compact('velo'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

}
