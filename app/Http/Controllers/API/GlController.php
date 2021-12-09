<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gl;
use Illuminate\Http\Request;

class GlController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('q'))
            $gls = Gl::select(['id', 'GlName', 'GlCode'])
                ->where('GlName', 'LIKE', '%' . $request['q'] . '%')
                ->get();
        else
            $gls = Gl::select(['id', 'GlName'])
                ->get();
        return $gls;
        $data = [];
        foreach ($gls as $g) {
            array_push($data,
                [
                    'id' => $g['id'],
                    'text' => $g['GlName']
                ]);
        }

        return json_encode([
            "results" => $data
        ]);
    }

    public function getGlFromGlCode($code)
    {
        return Gl::select(['id', 'GlCode', 'GlName'])
            ->where('GlCode', $code)
            ->first();
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Gl::find($id);
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
