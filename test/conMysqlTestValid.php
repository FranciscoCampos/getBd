<?php 

class conMysqlTest extends PHPUnit_Framework_TestCase
{
	
	public function testInsertValid()
	{
		$con = new GetbdM();


		$sql = "INSERT INTO OTRA (nombre)VALUES('maduro22')";
        
        $this->assertEquals(null, $con->save($sql , ['OTRA', 'NOMBRE' , 'maduro22']));
        
		
	}

}