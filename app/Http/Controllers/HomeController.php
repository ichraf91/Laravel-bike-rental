<?php

namespace App\Http\Controllers;

use App\Model\Contact;
use App\Model\Velo;
use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller {

	public function index() {
		$velo = Velo::paginate(8);
		return view('welcome', compact('velo'));
	}

	public function SearchVelo(Request $request) {
		if ($request -> isMethod('post')) {
			$mot = $request['motcle'];
			$motcle = '%' . $mot . '%';
			//dd($motcle);
			if ($motcle == null) {
				$velo = Velo::paginate(8);
				//dd('aaaaaaaaaaaaaa');
			} else {
				$velo = Voiture::where('title', 'like', $motcle)-> paginate(8);
				//dd($velo);
			}
		} else {
			$velo = Velo::paginate(8);
		}
		return view('welcome', compact('velo'));

	}

	public function contact(Request $request) {
		if ($request -> isMethod('post')) {
			$input = $request -> all();
			$cont = Contact::create($input);
			if ($cont) {
				return redirect('Contact') -> with('success', 'Votre message envoyé avec success');
			}
		}
		return view('pages.contact');
	}

	public function velos() {
		return view('pages.velos');
	}

}
