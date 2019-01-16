<?php 

namespace FrieseNiels\Base\Template;

use App\Http\Controllers\Controller;
use App\Http\Service\BaseService;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use \DB;

class BaseController extends \App\Controller
{
    protected $modelService = false;
    protected $editValidationrules = [];
    protected $validationrules = [];

    public $responseType = "html";

    public $request = [];
    public function __construct(Model $model = null)
    {

    }

    public function index()
    {
        if (strpos($this->request->headers->get('referer'), 'window=tab') !== false) {
            return $this->closeTabResponse();
        }
        return $this->response('index');

    }


    public function query() {
        return DB::table($this->modelService->getTable());
    }

    public function anyData() {
        return \Datatables::of($this->query())
            ->addColumn('action', function($row) {
            return generateActionButtons($this->baseRoute, $row->id);
        })
        ->make(true);
    }

    public function search() {
        $zoekterm = $this->request->get('q', '');
        $data = $this->modelService->search($zoekterm);

        return $this->jsonresponse($data);
    }

    public function create()
    {
        $model = $this->modelService->fillModel($this->request->old());
        return $this->response('create', compact('model'));
    }

    public function store()
    {
        $this->validate($this->request, $this->validationrules);
        $this->modelService->store($this->request->all());

        return $this->redirectresponse('index', 'created!');
    }

    public function edit($id)
    {
        $model = $this->modelService->byId($id, $this->request->all());
        return $this->response('edit', compact('model'));
    }

    public function update($id)
    {
        $this->validate($this->request, $this->editValidationrules);
        $this->modelService->update($id, $this->request->all());

        return $this->redirectresponse('index', 'updated!');
    }

    public function destroy($id)
    {
        $this->modelService->delete($id);

        return $this->redirectresponse()
            ->withSuccess('deleted!');
    }

    protected function setRequest(Request $request) {
        $this->request = $request;
    }

    protected function htmlResponse($bladeTempl, $data = []) {
        return view($this->viewRoute . '.' . $bladeTempl,  $data);
    }

    protected function jsonResponse($data) {
        return response()->json($data);
    }

    protected function redirectResponse($page = 'index') {
        if($this->request->get('window') == 'tab') {
            return $this->closeTabResponse();
        }
        return redirect()->route($this->viewRoute . '.' . $page);
    }

    protected function closeTabResponse() {
        return "<script>window.close();</script>";
    }

    public function setModel(Model $model) {
        $this->model = $model;
        $this->modelService = new BaseService($model);
    }

    public function setResponseType($type) {
        $this->responseType = $type;
    }

    public function response($page, array $data = []) {
        if($this->responseType == "html") {
            return $this->htmlResponse($page, $data);
        }else {
            return $this->jsonResponse($data);
        }
    }

    public function setService($service) {
        $this->modelService = new $service($this->model);
    }

    public function setViewRoute($viewRoute) {
        $this->viewRoute = $viewRoute;
    }

    public function setBaseRoute($baseRoute) {
        $this->baseRoute = $baseRoute;
    }

    public function setValidationRules($rules) {
        $this->validationrules = $rules;
    }

    public function setEditValidationRules($rules) {
        $this->editValidationrules = array_merge($this->validationrules, $rules);
    }


}
