<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Practice;
use Illuminate\Http\Request;
use PhpParser\Node\NullableType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rules\Dimensions;

class PracticeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.practice.index', [
            'practices' => Practice::latest()
                ->paginate(4)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.practice.create', ['fields' => Field::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->fields);
        $newPracticeForm = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'logo' => ['nullable', 'dimensions:min_width:100, min_height:100']
        ]);

        if($request->hasFile('logo')) {
            $newPracticeForm['logo'] = $request->file('logo')->store('public');
        }

        Practice::create($newPracticeForm);

        if($request->fields) {
            foreach($request->fields as $field) {
                $fieldId = Field::where('tag', $field)->value('id');
                $practiceId = Practice::latest()->first();
                $practiceId->fields()->attach($fieldId);
            }
        }

        return redirect('/dashboard/practices');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Practice $practice)
    {
        return view('dashboard.practice.show', [
            'practice' => $practice
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Practice $practice, Field $fields)
    {
        $diff = Field::all()->diff($practice->fields);

        return view('dashboard.practice.edit', [
            'practice' => $practice,
            'diff' => $diff,
            'fields' => $practice->fields
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Practice $practice)
    {
        $editPracticeForm = $request->validate([
            'name' => 'required',
            'email' => ['required', 'email'],
            'website' => 'required',
            'logo' => ['nullable', 'dimensions:min_width:100, min_height:100']
        ]);

        if($request->hasFile('logo')) {
            $editPracticeForm['logo'] = $request->file('logo')->store('public');
        }
        // dd($practice);
        // dd($editPracticeForm);
        $practice->update($editPracticeForm);

        // return Redirect::refresh();
        return redirect()->route('solepractice', ['practice' => $practice->id]);
    }

    // ATTACH DETACH
    public function detach(Request $request, Practice $practice)
    {
        if($request->current) {
            foreach($request->current as $current) {
                $fieldId = Field::where('tag', $current)->value('id');
                $practice->fields()->detach($fieldId);
            }
        }

        return redirect()->route('solepractice', ['practice' => $practice->id]);
    }

    public function attach(Request $request, Practice $practice)
    {
        if($request->potential) {
            foreach($request->potential as $potential) {
                $fieldId = Field::where('tag', $potential)->value('id');
                $practice->fields()->attach($fieldId);
            }
        }

        return redirect()->route('solepractice', ['practice' => $practice->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Practice $practice)
    {
        $practice->delete();
        return redirect('/dashboard/practices');
    }
}
