<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{
    /**
     * Вывод json данных списка валют.
     *
     * @return Response
     */
    public function show()
    {
		$data = $this->_getCurrencyList();
		
		if($data){
			$json = [
				'error' => 200,
				'msg'	=> 'Succes',
				'data'  => $data
			];
		}else{
			$json = [
				'error' => 404,
				'msg'	=> 'JSON data not available',
			];
		}
		
		header('Content-Type: application/json');

		echo json_encode($json);
    }
	
	/**
     * Получение json данных списка валют.
     *
	 * @var url Url файла с данными валют
     * @return Array
     */
	protected function _getCurrencyList($url = 'http://phisix-api3.appspot.com/stocks.json')
	{		
		if($json = file_get_contents($url)){
			return $this->_filter(json_decode($json, true));
		}else{
			return false;
		}
	}
	
	/**
     * Убирает из списка валют неиспользуемые данные.
     *
	 * @var data Array
     * @return Array
     */
	protected function _filter($data = [])
	{
		$result = false;
		
		if(!empty($data['stock'])){
			
			$result = [];
			
			for($i = 0; $i < count($data['stock']); $i++)
			{
				$result[$i]['name'] = $data['stock'][$i]['name'];
				$result[$i]['price'] = $data['stock'][$i]['volume'];
				$result[$i]['amount'] = $data['stock'][$i]['price']['amount'];
			}
		}
		
		return $result;
	}
}