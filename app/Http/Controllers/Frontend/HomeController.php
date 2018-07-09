<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\Film;
use App\Film_comment;
use Illuminate\Http\Request;
use App\Http\Requests;
use Response;
use Redirect;
use Illuminate\Http\JsonResponse;
use Validator;
use Config;
use Auth;

class HomeController extends Controller
{
    /**
     * Responds to requests to GET /admin
     */
    public function __construct() 
    {
    } 

    public function index()
    {
        return redirect(url('/films'));
    }

    public function pagenotfound()
    {
        echo "Error 404 Page";
    }

    public function films( $offset = 0 ){
        $data["films"] = json_decode(file_get_contents(url("/getfilms/".$offset)) , true);
        return view('home', $data);
    }

    public function filmdetails( $slug = "" ){
        $data["filmdetails"] = Film::where('slug',$slug)->first();
        return view('home', $data);
    }

    public function createfilm(){
        $data = array();
        return view('home', $data);
    }

    public function postcreatefilm(Request $request){
        $formdata = $request->all();
        $validator = Validator::make($formdata, [
            'name' => 'required',
            'slug' => 'required|unique:films',
            'description' => 'required',
            'release_date' => 'required',
            'rating' => 'required',
            'ticket_price' => 'required',
            'country' => 'required',
            'genre' => 'required',
            'photo' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('/films/create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $photo = $request->file('photo');
        $uniqueimgid = rand() .'_'. time();
        $filename = 'film_'. $uniqueimgid .'.' . $photo->getClientOriginalExtension();
        $photofilename =  $filename;
        if($photo->move(public_path() . '/uploads/', $photofilename))
        {
        }else{
            $photofilename = "";
        }

        $film = new Film();
        $film->name = $formdata['name'];
        $film->slug = $formdata['slug'];
        $film->description = $formdata['description'];
        $film->release_date = $formdata['release_date'];
        $film->rating = $formdata['rating'];
        $film->ticket_price = $formdata['ticket_price'];
        $film->country = $formdata['country'];
        $film->genre = $formdata['genre'];
        $film->photo = $photofilename;
        $film->save();
        return redirect('/films')->with('message', trans('Film added successfully').'.');
    }

    public function postfilmcomment(Request $request, $filmid = 0){
        $formdata = $request->all();
        $validator = Validator::make($formdata, [
            'name' => 'required',
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $filmcomment = new Film_comment();
        $filmcomment->name = $formdata['name'];
        $filmcomment->comment = $formdata['comment'];
        $filmcomment->film_id = $filmid;
        $filmcomment->user_id = Auth::id();
        $filmcomment->save();
        return Redirect::back()->with('message', trans('Comment added successfully').'.');
    }

    public function getfilms($offset = 0){
         $films = Film::skip($offset)->take(1)->get();
         return Response::json($films);
    }
    
}
