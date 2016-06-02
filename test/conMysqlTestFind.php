<?php 

class conMysqlTest extends PHPUnit_Framework_TestCase
{
	
	public function testFind()
	{
		$con = new GetbdP();


		$sql = "SELECT * FROM OTRA";
        
        $this->assertFalse(empty($con->find($sql)->show()));
		
	}

}