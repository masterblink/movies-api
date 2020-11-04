<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\User;
use Illuminate\Support\Facades\Auth;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $perPage = 10;

    protected $page = 10;

    public function index(Request $request)
    {

        $movies = Movie::where('users_id','=',Auth::guard('api')->id());

        if(!empty($request->title)){
            
            $movies->orWhere('title', 'like', '%' . $request->title . '%');
        }   

        $movies = $movies->paginate(
            !empty($request->perPage) ? $request->perPage : $this->perPage, // per page (may be get it from request)
            ['*'], // columns to select from table (default *, means all fields)
            'page', // page name that holds the page number in the query string
            !empty($request->page) ? $request->page : $this->page // current page, default 1
        );

        return response()->json($movies);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'        => 'required|string',
            'year'        => 'required|integer',
            'description' => 'required|string'
            
        ]);
        $movie = new Movie([
            'title'   => $request->title,
            'year'    => $request->year,
            'description'=> $request->description,
            'users_id' => Auth::guard('api')->id()
        ]);
        $movie->save();

        return response()->json([
            'message' => 'Pelicula creada correctamente!'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Movie::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
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
        $request->validate([
            'title'       => isset($request->title) ? 'required|string' : '',
            'year'        => isset($request->year) ? 'required|integer' : '',
            'description' => isset($request->description) ? 'required|string' : ''
        ]);

        $movie = Movie::findOrFail($id);
        $movie->update($request->all());

        return response()->json([
            'message' => 'Pelicula actualizada correctamente!'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $movie = Movie::find($id);
        if($movie){
            
            $movie->delete();

            return response()->json([
                'message' => 'Registro eliminado'],204);

        } else {
            return response()->json([
                'message' => 'No existe el registro'], 404);
        }

        
    }
}
