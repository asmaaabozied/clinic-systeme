<?php

namespace App\Http\Controllers;


use App\Models\Branch;
use App\Models\DamagedStock;
use App\Models\ProductService;
use DB;
use Illuminate\Http\Request;

class DamagedStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = DamagedStock::latest()->get();

        return view('damaged_stocks.index', compact('data'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = ProductService::get()->pluck('name', 'id');
        $products->prepend('Select Products', '');

        $branch = Branch::get()->pluck('name', 'id');
        $branch->prepend('Select Branch', '');

        return view('damaged_stocks.create', compact('products', 'branch'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('create warehouse')) {
            $validator = \Validator::make(
                $request->all(), [
                    'number' => 'nullable',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $request_all = $request->all();
            $request_all['created_by'] = \Auth::user()->creatorId();
            DamagedStock::create($request_all);

            return redirect()->route('damaged_stocks.index')->with('success', __('damaged_stocks successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\warehouse $warehouse
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\warehouse $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $data = DamagedStock::find($id);
        if (\Auth::user()->can('edit warehouse')) {
            if ($data->created_by == \Auth::user()->creatorId()) {
                $products = ProductService::get()->pluck('name', 'id');
                $products->prepend('Select Products', '');

                $branch = Branch::get()->pluck('name', 'id');
                $branch->prepend('Select Branch', '');
                return view('damaged_stocks.edit', compact('products', 'data','branch'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\warehouse $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = DamagedStock::find($id);

        if (\Auth::user()->can('edit warehouse')) {
            if ($data->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(), [
                        'number' => 'nullable',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $request_all = $request->all();
                $request_all['created_by'] = \Auth::user()->creatorId();
                $data->update($request_all);

                return redirect()->route('damaged_stocks.index')->with('success', __('damaged_stocks successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\warehouse $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = DamagedStock::find($id);

        if (\Auth::user()->can('delete warehouse')) {
            if ($data->created_by == \Auth::user()->creatorId()) {
                $data->delete();


                return redirect()->route('damaged_stocks.index')->with('success', __('damaged_stocks successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
