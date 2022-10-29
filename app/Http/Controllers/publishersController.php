<?php

namespace App\Http\Controllers;

use App\Models\publisher;
use Illuminate\Http\Request;

class publishersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $publishers = Publisher::all();
        return view('admin.indexPublishers' , compact('publishers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.CreatePublisher');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request , [
            'name' => 'required',
            'address' => 'nullable'
        ]);

        $publisher = new publisher();
        $publisher->name = $request->name;
        $publisher->address = $request->address;
        $publisher->save();

        session()->flash('flash_message' , 'The publisher has been added successfully');
        return redirect('/admin/publishers');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show(publisher $publisher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $publisher = publisher::FindOrFail($id);
        return view('admin.EditPublisher' , compact('publisher'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, publisher $publisher)
    {
        $this->validate($request , [
            'name' => 'required',
        ]);

        $publisher->name = $request->name;
        $publisher->address = $request->address;
        $publisher->save();

        session()->flash('flash_message' , 'The publisher has been successfully updated');
        return redirect('/admin/publishers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy(publisher $publisher)
    {
        $publisher->delete();
        session()->flash('flash_message' , 'The publisher has been deleted successfully');
        return redirect('/admin/publishers');
    }

    public function indexPublishers()
    {
        $publishers = publisher::all()->sortBy('name');
        $title = 'publishers';
        return view('project.publishers' , compact('publishers' , 'title'));
    }

    public function search(Request $request)
    {
        $publishers = publisher::where('name' , 'like' , "%{$request->search}%")->get()->sortBy('name');
        $title = 'Search results for: ' . $request->search;
        return view('project.publishers' , compact('publishers' , 'title'));
    }

    public function showPublishers(publisher $publisher)
    {
        $books = $publisher->books()->paginate(12);
        $title = 'Books belonging for : ' . $publisher->name;
        return view('project.gallery' , compact('books' , 'title'));
    }
}
