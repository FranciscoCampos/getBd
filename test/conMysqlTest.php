<?php 


class conMysqlTest extends PHPUnit_Framework_TestCase
{
	
	public function testInsert()
	{
		$con = new \Src\GetbdM();


		$sql = "INSERT INTO OTRA (nombre)VALUES('maduro22')";
        
        $this->assertEquals(true, $con->save($sql , null));
		
	}

}

