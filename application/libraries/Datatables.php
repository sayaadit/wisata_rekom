<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**  	
		API Function For DataTables Version 1.10.4
		
		Author 			: Yusza Redityamurti
		Date Created 	: 08 Februari 2015
		Last Edited		: 08 Februari 2015
**/

class Datatables
{
	var $cols;
	var $where = '';
	var $order = '';
	var $limit = '';
	
	public function __construct()
	{
		$this->CI =& get_instance();
	}
	
	public function set_cols($cols) 
	{
		$this->cols = $cols;
	}
	
	public function set_where($where) 
	{
		$this->where = $where;
	}
	
	public function set_order($order) 
	{
		$this->order = $order;
	}
	
	public function set_limit($limit) 
	{
		$this->limit = $limit;
	}
	
	public function output($total, $filtered)
	{
		return array('draw' 				=> intval($this->CI->input->post('draw')),
					 'recordsTotal' 		=> $total,
					 'recordsFiltered' 		=> $filtered,
					 'data' 				=> array());	
	}
	
	public function query()
	{
		$limit = $this->limit( $this->cols );
		$order = $this->order( $this->cols );
		$where = $this->filter( $this->cols );
		
		return array('where' => $where, 'order' => $order, 'limit' => $limit); 
	}
	
	/**
	 * Create the data output array for the DataTables rows
	 *
	 *  @param  array $columns Column information array
	 *  @param  array $data    Data from the SQL get
	 *  @return array          Formatted data in a row based format
	 */
	/*static function data_output ( $columns, $data )
	{
		$out = array();

		for ( $i=0, $ien=count($data) ; $i<$ien ; $i++ ) {
			$row = array();

			for ( $j=0, $jen=count($columns) ; $j<$jen ; $j++ ) {
				$column = $columns[$j];

				// Is there a formatter?
				if ( isset( $column['formatter'] ) ) {
					$row[ $column['dt'] ] = $column['formatter']( $data[$i][ $column['db'] ], $data[$i] );
				}
				else {
					$row[ $column['dt'] ] = $data[$i][ $columns[$j]['db'] ];
				}
			}

			$out[] = $row;
		}

		return $out;
	}*/


	/**
	 * Paging
	 *
	 * Construct the LIMIT clause for server-side processing SQL query
	 *
	 *  @param  array $columns Column information array
	 *  @return string SQL limit clause
	 */
	private function limit ( $columns )
	{
		$limit = '';

		if ( $this->CI->input->post('length') != -1 ) 
		{
			$limit = "LIMIT ".intval($this->CI->input->post('start')).", ".intval($this->CI->input->post('length'));
		}
		
		return $limit;
	}


	/**
	 * Ordering
	 *
	 * Construct the ORDER BY clause for server-side processing SQL query
	 *
	 *  @param  array $columns Column information array
	 *  @return string SQL order by clause
	 */
	private function order ( $columns )
	{
		if ( $this->CI->input->post('order') && count($this->CI->input->post('order')) ) 
		{
			$orderBy = array();
			$dtColumns = $this->pluck( $columns, 'dt' );
			$order = $this->CI->input->post('order');
			
			foreach($order as $i => $data) 
			{
				$columnIdx = intval($data['column']);
				$requestColumn = $this->CI->input->post('columns');
				
				$columnIdx = array_search( $requestColumn[$columnIdx]['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $requestColumn[$columnIdx]['orderable'] == 'true' ) 
				{
					$dir = $data['dir'] === 'asc' ?
						'ASC' :
						'DESC';

					$orderBy[] = '`'.$column['db'].'` '.$dir;
				}
			}
		}
		
		$order = $this->order;

		if ( count( $orderBy ) ) 
		{
			$order = $order == '' ? implode(', ', $orderBy) : $order.', '.implode(', ', $orderBy);
		}
		$order = 'ORDER BY '.$order;
		
		return $order;
	}


	/**
	 * Searching / Filtering
	 *
	 * Construct the WHERE clause for server-side processing SQL query.
	 *
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here performance on large
	 * databases would be very poor
	 *
	 *  @param  array $columns Column information array
	 *  @return string SQL where clause
	 */
	private function filter ( $columns )
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = $this->pluck( $columns, 'dt' );
		$search = $this->CI->input->post('search');
		$cols = $this->CI->input->post('columns');
		
		if ( !empty($search) && $search['value'] != '' ) 
		{
			$str = $search['value'];
			
			foreach($cols as $id => $col) 
			{
				$columnIdx = array_search( $col['data'], $dtColumns );
				$column = $columns[ $columnIdx ];

				if ( $col['searchable'] == 'true' ) 
				{
					$globalSearch[] = "`".$column['db']."` LIKE '%$str%'";
				}
			}
		}

		/*// Individual column filtering
		foreach($cols as $id => $col) 
		{
			$columnIdx = array_search( $col['data'], $dtColumns );
			$column = $columns[ $columnIdx ];

			$str = $col['search']['value'];

			if ( $col['searchable'] == 'true' && $str != '' ) 
			{
				$columnSearch[] = "`".$column['db']."` LIKE '%$str%'";
			}
		}*/

		// Combine the filters into a single string
		$where = $this->where;

		if ( count( $globalSearch ) ) {
			$where = $where == '' ? '('.implode(' OR ', $globalSearch).')' : $where.' AND ('.implode(' OR ', $globalSearch).')';
		}

		/*if ( count( $columnSearch ) ) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where .' AND '. implode(' AND ', $columnSearch);
		}*/

		if ( $where !== '' ) {
			$where = 'WHERE '.$where;
		}

		return $where;
	}
	
	/**
	 * Pull a particular property from each assoc. array in a numeric array, 
	 * returning and array of the property values from each item.
	 *
	 *  @param  array  $a    Array to get data from
	 *  @param  string $prop Property to read
	 *  @return array        Array of property values
	 */
	private function pluck ( $a, $prop )
	{
		$out = array();

		for ( $i=0, $len=count($a) ; $i<$len ; $i++ ) 
		{
			$out[] = $a[$i][$prop];
		}

		return $out;
	}
}
?>