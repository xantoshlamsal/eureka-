<?php

namespace App\Http\Controllers;

use App\Models\Gl;
use Illuminate\Http\Request;

class GlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gls = Gl::all();
        foreach ($gls as $gl) {
            $gl['StatusTerm'] = HelpFunctionsController::getStatusTerm($gl['Status']);
            $gl['TranUser'] = HelpFunctionsController::getUserNameFromId($gl['TranUserId']);
            $gl['StatusChangeUser'] = HelpFunctionsController::getUserNameFromId($gl['StatusChangeUserId']);
        }
//        return $gls;
        return view('gl.index')->with(['gls' => $gls]);

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'GlName' => 'required|unique:gl,GlName',
            'GlCode' => 'required|unique:gl,GlCode'
        ]);
        $gl = [];
        $gl['GlCode']=$request['GlCode'];
        $gl['GlName'] = $request['GlName'];
        $gl = HelpFunctionsController::addMandatoryFields($gl);

        GL::create($gl);
        return redirect()->back()->with('message', 'GL Created Successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
