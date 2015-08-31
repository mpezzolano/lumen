<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return response()->json(['movies' => Movie::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store( Request $request )
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required|unique:movies|max:255',
                'director' => 'required|max:255',
                'sinopsis' => 'required'
            ],
            [
                'title.required' => 'El campo title es requerido!',
                'title.unique' => 'El campo title debe ser único',
                'title.max' => 'El campo title no puede tener más de 255 carácteres',
                'director.required' => 'El campo director es requerido!',
                'director.max' => 'El campo director no puede tener más de 255 carácteres',
                'sinopsis.required' => 'El campo sinopsis es requerido!'
            ]
        );

        if ( $validator->fails() )
        {
            return response()->json(
                [
                    'message' => "Validation fails",
                    "errors" => $validator->messages()->toJson()
                ]
            );
        }

        $movie = new Movie();
        $movie->director = $request->input('director');
        $movie->title = $request->input('title');
        $movie->sinopsis = $request->input('sinopsis');
        $movie->created_at = $request->input('created_at') ? $request->input('created_at') : date("Y-m-d H:i:s");
        if( $movie->save() )
        {
            return response()->json(['message' => "The movie has been saved"], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $movie = Movie::find( $id );
        if( ! is_null( $movie ) )
        {
            return response()->json(['movie' => $movie], 200);
        }
        return response()->json(['movie' => [], "message" => "Movie with id {$id} not exists"], 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update( Request $request, $id )
    {
        $movie = Movie::find( $id );
        if( is_null( $movie ) )
        {
            return response()->json(['message' => "Movie with id {$id} NOT FOUND"], 404);
        }

        $validator = Validator::make($request->all(),
            [
                'title' => 'required|max:255',
                'director' => 'required',
                'sinopsis' => 'required'
            ],
            [
                'title.required' => 'El campo title es requerido!',
                'title.max' => 'El campo title no puede tener más de 255 carácteres',
                'director.required' => 'El campo body es requerido!',
                'sinopsis.required' => 'El campo sinopsis es requerido!'
            ]
        );

        if ($validator->fails())
        {
            return response()->json(
                [
                    'message' => "Validation fails",
                    "errors" => $validator->messages()->toJson()
                ], 400
            );
        }

        $movie->director = $request->input('director');
        $movie->title = $request->input('title');
        $movie->sinopsis = $request->input('sinopsis');
        $movie->created_at = $request->input('created_at') ? $request->input('created_at') : date("Y-m-d H:i:s");
        if( $movie->save() )
        {
            return response()->json(['message' => "The movie has been updated"], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $movie = Movie::find( $id );
        if( ! is_null( $movie ) )
        {
            $movie->delete();
            return response()->json(['movie' => "Success deleted"], 200);
        }
        return response()->json(['message' => "Movie with id {$id} NOT FOUND"], 404);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function restore( $id )
    {
        $movie = Movie::withTrashed()->find( $id );
        if( ! is_null( $movie ) )
        {
            $movie->restore();
            return response()->json(['movie' => "Movie with id {$id} has been restored"], 200);
        }
        return response()->json(['message' => "Movie with id {$id} NOT FOUND"], 404);
    }
}
