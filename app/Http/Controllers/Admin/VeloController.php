<?php

namespace App\Http\Controllers\Admin;

use Auth;
use App\Model\Velo;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class VeloController extends Controller {

	public function __construct() {
		$this -> middleware('auth');
		$this -> middleware('admin');
	}

	public function index() {
		$velo = Velo::paginate(8);
		return view('admin.velo.GestionVelo', compact('velo'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create() {
		return view('admin.velo.add');
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
			'title' => 'required',
			'description' => 'required|max:150',
			'price' => 'required',
			'image' => 'required', ]);
			$input = $request -> all();
			$input['user_id'] = Auth::user() -> id;
			if (isset($input['image'])) {
				$input['image'] = $this -> uploadImage($input['image']);
			}

			$velo = Velo::create($input);
			if ($velo) {
				return redirect('GestionVelo') -> with('success', 'Velo created successfully!');
			}
		}
	}

	//upload image
	public function uploadImage($file) {
		$extension = $file -> getClientOriginalExtension();
		$sha1 = sha1($file -> getClientOriginalName());
		$filename = date('Y-m-d-h-i-s') . "_" . $sha1 . "." . $extension;
		$path = public_path('images/velo/');
		$file -> move($path, $filename);
		return 'images/velo/' . $filename;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id) {
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		$velo = Velo::findOrFail($id);
		return view('admin.velo.edit', compact('velo'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		$input = $request -> all();
		$image = $input['photo'];

		if (isset($input['image'])) {
			$input['image'] = $this -> uploadImage($input['image']);
			unlink($image);
		}
		$velo = Velo::findOrFail($id) -> update($input);
		if ($velo) {
			return redirect('GestionVelo') -> with('info', 'Velo Updated successfully!');
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		$velo = Velo::findOrFail($id);
		$img = $velo['image'];
		$velo -> delete();
		unlink($img);
		return redirect() -> back() -> with('success', 'Velo deleted successfully!');
	}

}
