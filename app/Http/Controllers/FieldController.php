<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.field.index', [
            'fields' => Field::latest()
                ->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // stavio sam odma na indexu da se moze pravit
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newFieldForm = $request->validate([
            'tag' => 'required'
        ]);

        Field::create($newFieldForm);

        return redirect('/dashboard/fields');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Field $field)
    {
        return view('dashboard.field.show', [
            'field' => $field
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Field $field)
    {
        return view('dashboard.field.edit', [
            'field' => $field
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Field $field)
    {
        $editFieldForm = $request->validate([
            'tag' => 'required'
        ]);

        $field->update($editFieldForm);

        return redirect()->route('solefield', ['field' => $field->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Field $field)
    {
        $field->delete();
        return redirect('/dashboard/fields');
    }
}
