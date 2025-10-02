<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Brand;
use App\Models\ChartOfAccount;
use App\Models\ChartOfAccountType;
use App\Models\CustomField;
use App\Exports\ProductServiceExport;
use App\Imports\ProductServiceImport;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\ProductServiceUnit;
use App\Models\PurchaseReturn;
use App\Models\Tax;
use App\Models\User;
use App\Models\Utility;
use App\Models\Vender;
use App\Models\WarehouseProduct;
use Google\Service\Dataproc\Session;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;


class SalesReturnController extends Controller
{
    public function index(Request $request)
    {

        if (\Auth::user()->can('manage product & service')) {
            $data = PurchaseReturn::where('type','Sales')->get();
            return view('purchase-return.index', compact('data'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function invoiceNumber()
    {
        $latest = Invoice::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->invoice_id + 1;
    }

    public function create()
    {
//        if (\Auth::user()->can('create purchase')) {
        $branch = Branch::get()->pluck('name', 'id')->toArray();
        $products = ProductService::get()->pluck('name', 'id')->toArray();
        $vendor = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

        return view('purchase-return.create_sales', compact('products', 'branch', 'vendor'));

//        } else {
//            return response()->json(['error' => __('Permission denied.')], 401);
//        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create purchase')) {
            $rules = [
                'number' => 'required',

            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('purchase-return.index')->with('error', $messages->first());
            }
            $requestdata = $request->all();
            $requestdata['type'] = 'Sales';
            $data = PurchaseReturn::create($requestdata);
            if (!empty($request->document)) {
                //storage limit
                $thumbnail = $request->file('document');
                $destinationPath = 'uploads/';
                $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
                $thumbnail->move($destinationPath, $filename);
                $data->document = $filename;
                $data->save();

            }


            $status = Invoice::$statues;
            $invoice = new Invoice();
            $invoice->invoice_id = $this->invoiceNumber();
            $invoice->customer_id = $request->vendor_id;
            $invoice->status = 0;
            $invoice->issue_date = $request->date;
            $invoice->due_date = $request->date;
            $invoice->category_id = ProductService::find($request->product_id)->category_id;
            $invoice->ref_number = $request->number;
            $invoice->type = 'Sales';
            $invoice->created_by = \Auth::user()->creatorId();
            $invoice->save();


            $data->save();


            return redirect()->route('sales-return.index')->with('success', __('Sales Return successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($id)
    {
        $data = PurchaseReturn::find($id);

        if (\Auth::user()->can('edit product & service')) {
            $branch = Branch::get()->pluck('name', 'id')->toArray();
            $products = ProductService::get()->pluck('name', 'id')->toArray();
            $vendor = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('purchase-return.edit', compact('data', 'branch', 'products', 'vendor'));


        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, $id)
    {
//        if (\Auth::user()->can('edit purchase')) {
        $rules = [
            'number' => 'required',


        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->route('sales-return.index')->with('error', $messages->first());
        }

        $data = PurchaseReturn::find($id);
        $data->update($request->except('document'));
        if (!empty($request->document)) {
            //storage limit
            $thumbnail = $request->file('document');
            $destinationPath = 'uploads/';
            $filename = time() . '.' . $thumbnail->getClientOriginalExtension();
            $thumbnail->move($destinationPath, $filename);
            $data->document = $filename;
            $data->save();

        }

        $data->save();
        CustomField::saveData($data, $request->customField);

//                return redirect()->route('purchase-return.index')->with('success', __('Purchase Return successfully updated.'));
        return redirect()->back()->with('success', __('Sales Return successfully updated.'));
//            } else {
//                return redirect()->back()->with('error', __('Permission denied.'));
//            }
    }


    public function destroy($id)
    {
        if (\Auth::user()->can('delete purchase')) {
            $data = PurchaseReturn::find($id);
            $data->delete();
            return redirect()->route('sales-return.index')->with('success', __('Sales Return successfully deleted.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


}
