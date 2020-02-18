<?php

namespace App\Http\Controllers\BackEndCon\Reports;

use App\Customer;
use App\Hajj;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HajjReportController extends Controller
{
    private $controllerInfo;

    public function __construct()
    {
        $this->controllerInfo = (object) array(
            'title' => 'Hajj Report',
            'hajj_type_no' => 1,
            'actionButtons' => true,
            'routeNamePrefix' => 'hajj-report',
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $controllerInfo = $this->controllerInfo;
        $hajis = Hajj::select('*')->with(['customer'])
            ->addSelect(DB::raw('SUM(hajj_payments.amount) as paid_amount'))
            ->addSelect(DB::raw('CAST(packages.total_price - SUM(hajj_payments.amount) AS DECIMAL(10,2)) AS due_amount'))
            ->join('hajj_payments', 'hajjs.id', '=', 'hajj_payments.hajj_id', 'left')
            ->join('packages', 'hajjs.package_id', '=', 'packages.id', 'left')
            ->groupBy('hajjs.id')
            ->groupBy('hajj_payments.hajj_id')
            ->where('hajjs.type', $this->controllerInfo->hajj_type_no)
            ->get();
        return view('Admin.reports.haji-report.index', compact('controllerInfo', 'hajis'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
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
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $delete = Hajj::find($id)->delete();
        if ($delete) {
            return response()->json(['success' => true, 'message' => $this->controllerInfo->title . ' Deleted Successfully'], 200);
        } else {
            return response()->json(['success' => false, 'message' => 'Whoops! ' . $this->controllerInfo->title . ' Not Deleted'], 200);
        }
    }
}
