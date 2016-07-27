<?php
namespace App\Models\Es;
use Elasticsearch\ClientBuilder;
class TourEs
{

	protected $client;

	protected $config;

	function __construct()
	{
		$this->config = \Config::get('es.es');
		$this->client = ClientBuilder::create()->setHosts(array($this->config['server']))
			->build();
	}

	/**
	 * ES搜索
	 */
	public function tourSearch()
	{
		$must = $notMust = $should = array();
	
		
		$arrayData = array("from"=>0,"size"=>5,
				"query"=> array(
						"filtered"=> array(
								"filter"=> array(
										"bool"=> array("must"=> $must,"must_not"=> $notMust,"should"=> $should)))));
		
		$params = ['index'=> $this->config['index'],'type'=> $this->config['type'],'body'=> json_encode($arrayData)];
		$result = $this->client->search($params);
		if(isset($result['hits']))
		{
			$total = isset($result['hits']['total'])? $result['hits']['total']: false;
			if(false === $total)
			{
				return false;
			}
			else
			{
				return array('total'=> $total,'data'=> $result['hits']['hits']);
			}
		}
		return array('total'=> 0,'data'=> array());
	}

}