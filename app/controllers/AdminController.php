<?php
use Carbon\Carbon;

/**
 * Class AdminController
 */
class AdminController extends \ApiController
{

	/**
	 * @var
	 */
	private $año;
	/**
	 * @var
	 */
	private $mes;
	/**
	 * @var
	 */
	private $name;
	/**
	 * @var
	 */
	private $query;
	/**
	 * @var
	 */
	private $data;
	/**
	 * @var int
	 */
	private $status = 200;
	/**
	 * @var array
	 */
	private $headers = array('ContentType' => 'application/json', 'charset' => 'utf-8');

	/**
	 *
	 */
	function __construct()
	{
		$date      = new Carbon();
		$this->año = $date->year;
		$this->mes = $date->month;
	}

	/**
	 * @return mixed
	 */
	public function index()
	{
		return View::make('despachos.index');
	}

	/**
	 * @return mixed
	 */
	public function anual()
	{
		$this->name = 'anual' . $this->mes . $this->año;
		if (!Cache::has($this->name)) {
			$this->data['data'] = Cache::get($this->name);
		} else {
			$this->query = "EXEC dbo.BuscaDataResumen_Anual '%s','%s'";
			$this->replaceQuery();
			$this->data['data'] = $this->store_query_cache($this->name, $this->query, 500);
		}
		$this->getMessage();

		return \Response::json($this->data, $this->status, $this->headers);
	}

	/**
	 *
	 */
	public function replaceQuery()
	{
		$this->query = sprintf($this->query, $this->mes, $this->año);
	}

	/**
	 *
	 */
	public function getMessage()
	{
		if (!count($this->data['data'])) {
			$this->data['message'] = 'No se encontraron resultados.';
			$this->data['ok']      = false;
		} else {
			$this->data['message'] = '';
			$this->data['ok']      = true;
		}
	}

	/**
	 * @return mixed
	 */
	public function mensual()
	{
		$this->name = 'mensual' . $this->mes . $this->año;
		if (Cache::has($this->name)) {
			$this->data['data'] = Cache::get($this->name);
		} else {
			$this->query = "EXEC dbo.BuscaDataResumen_Mensual '%s','%s'";
			$this->replaceQuery();
			$this->data['data'] = $this->store_query_cache($this->name, $this->query, 500);
		}
		$this->getMessage();

		return \Response::json($this->data, $this->status, $this->headers);
	}

	/**
	 * @return mixed
	 */
	public function gAnual()
	{
		$this->name = 'gAnual' . $this->mes . $this->año;
		if (Cache::has($this->name)) {
			$this->data['data'] = Cache::get($this->name);
		} else {
			$this->query = "EXEC dbo.BuscaDataResumen_GraficoAnual '%s','%s'";
			$this->replaceQuery();
			$this->data['data'] = $this->store_query_cache($this->name, $this->query, 500);
		}
		$this->getMessage();

		//		dd($this->query);

		return \Response::json($this->data, $this->status, $this->headers);
	}

	/**
	 * @return mixed
	 */
	public function gMensualFija()
	{
		$this->name = 'gMensualFija' . $this->mes . $this->año;
		if (Cache::has($this->name)) {
			$this->data['data'] = Cache::get($this->name);
		} else {
			$this->query = "EXEC dbo.BuscaDataResumen_GraficoMensualFija '%s','%s'";
			$this->replaceQuery();
			$this->data['data'] = $this->store_query_cache($this->name, $this->query, 500);
		}
		$this->getMessage();

		return \Response::json($this->data, $this->status, $this->headers);
	}

	/**
	 * @return mixed
	 */
	public function gMensualMovil()
	{
		$this->name = 'gMensualMovil' . $this->mes . $this->año;
		if (Cache::has($this->name)) {
			$this->data['data'] = Cache::get($this->name);
		} else {
			$this->query = "EXEC dbo.BuscaDataResumen_GraficoMensualMovil '%s','%s'";
			$this->replaceQuery();
			$this->data['data'] = $this->store_query_cache($this->name, $this->query, 500);
		}
		$this->getMessage();

		return \Response::json($this->data, $this->status, $this->headers);
	}
}
