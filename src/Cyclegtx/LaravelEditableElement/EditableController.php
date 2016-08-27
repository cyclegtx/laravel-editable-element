<?php namespace Cyclegtx\LaravelEditableElement;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class EditableController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$data = \Request::Input("data");
		$handler = $data['handler'];
		$handler::editPreHandler($data,\Request::Input('content'));
		return;
	}
}
