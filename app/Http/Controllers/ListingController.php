<?php

namespace App\Http\Controllers;

use \App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;


class ListingController extends Controller
{
    public function index(Request $request){


        $listings = Listing::latest()->filter(request(['tag','search']))->paginate(4);
        return view('listings.index',[
           'listings'=>$listings
        ]
        );
    }
    public function show (Request $request, $id) {
        
            $listing = Listing::find($id);
        
            if($listing){
                return view('listings.show',[
                    'listing'=>$listing
                 ]
                 );
            }else{
                abort('404');
            }
            
     }

     public function create(){
        return view('listings.create');
     }

     public function store(Request $request){

        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        //store image
        if($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
             $formFields['logo'] = $logoPath;
        }

        // dd(auth()->user()->id);
        // //assign loggedin  user to post
        $formFields['user_id'] = auth()->user()->id;

        Listing::create($formFields);
        return redirect('/')->with('message','Listing created successfully!');
     }

     public function edit($id){
        $listing = Listing::find($id);
        // dd($listing);
        return view('listings.edit',[
            'listing'=>$listing
        ]);
     }


     public function update(Request $request, $id){
        $listing = Listing::find($id);
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        //store image
        if($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
             $formFields['logo'] = $logoPath;
        }
        $listing->update($formFields);
        return redirect('/')->with('message','Listing updated successfully!');
     }

     public function destroy($id){
        $listing = Listing::find($id);
        $listing->delete();

        return redirect('/')->with('message','Listing deleted successfully!');
     }
     public function demmoo(){
        return view('listings.demo');
     }

     public function manage(){
       
        return view('listings.manage',[
            'listings'=> auth()->user()->listings()->get(),
        ]);
     }

}
