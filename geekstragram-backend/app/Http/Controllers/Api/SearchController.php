<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public $codeError = 400;
    public $codeSuccess = 200;

    public function search(Request $request)
    {   
        
        $out = new \Symfony\Component\Console\Output\ConsoleOutput();
        $out->writeln($request);

        $validator = Validator::make($request->all(), [
            'hashtag' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], $this->codeError);
        }

        $data = $validator->validate();

        $photos = DB::table('photo')
        ->join('users','user_code', '=','users.id')
        ->join('hashtag_photo','photo_code', '=','photo.id')
        ->join('hashtag', 'hashtag_code', '=', 'hashtag.id')
        ->select('photo.*','users.id', 'users.user_name', 'hashtag.descriptcion')
        ->where('hashtag.descriptcion', '=', $data['hashtag'])
        ->orderby('created_at','desc')
        ->get();

        $out->writeln("Hello from Terminal");
        return  $photos;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
