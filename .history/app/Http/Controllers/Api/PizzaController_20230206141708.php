<?php

namespace App\Http\Controllers\Api;

use Illuminate\Routing\Controller;
use App\Models\Pizza;
use Illuminate\Http\Request;

class PizzaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //$pizzas = Pizza::all();
            $pizzas = Pizza::where('visiblity', '=', 'oui')->orderBy('id', 'desc')->get();

            return response()->json([
                'messages' => ' la liste des  pizzas sont recuperé ',
                'pizza' => $pizzas
            ], 200);
        } catch (\Exception $e) {
            logger('error ');
            return response()->json(['status' => true, 'messages' => 'recuperation  pizza echouees ,pas authorisé'], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $pizza = new Pizza;

            $pizza->user_id = $request->get('user_id');
            $pizza->titre = $request->get('titre');
            $pizza->descripion = $request->get('descripion');
            $pizza->prix = $request->get('prix');
            $pizza->imageurl = $request->get('imageurl');
            $pizza->ingredient = $request->get('ingredient');
            $pizza->visiblity = $request->get('visiblity');

            $pizza->save();

            return response()->json([
                'status' => true,
                'messages' => '  pizza ajouter avec successfully',
                'pizza' => $pizza
            ], 200);
        } catch (\Exception $e) {
            logger('Something went wrong with addpizza');
            return response()->json(['status' => true, 'messages' => 'la requête est malformée ou ne peut pas être traitée '], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try {
            $pizza = Pizza::findOrFail($id)->get();

            return response()->json([
                'messages' => 'The pizza was added successfully',
                'pizza' => $pizza
            ], 200);
        } catch (\Exception $e) {
            logger('Something went wrong with getpizzaByUserId');
            return response()->json(['status' => true, 'messages' => 'Something went wrong deleting the saved pizza'], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pizza $pizza)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pizza  $pizza
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {

        try {
            $pizza = Pizza::findOrFail($id);
            $pizza->delete();

            return response()->json(['success' => 'pizza delete successfully'], 200);
        } catch (\Exception $e) {
            logger('Something went wrong with getpizzaByUserId');
            return response()->json(['status' => true, 'messages' => 'Something went wrong deleting the saved pizza'], 401);
        }
    }
}
