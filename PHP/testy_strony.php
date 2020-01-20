<?php

use PHPUnit\Framework\TestCase;

require_once ('Class\DBConnection.php');
require_once ('Class\Event.php');
require_once ('Class\User.php');
require_once ('Class\ToGo.php');
require_once ('Class\Filter.php');
require_once ('Class\ImgUpload.php');


class Test extends TestCase
{

    public function testFirstTest()
    {
        $user = new User();
        $user->setID(1);
        $this->assertEquals(1,$user->getId());

    }
//niedziałający test
    public function testSecondTest()
    {

      $user = new User();
      $user->logout('login');
      $this->assertEquals('login',$user->doLogin());

    }

    public function testThirdTest() //klasa User posiada atrybut _haslo
    {
        $this -> assertClassHasAttribute ( '_haslo' ,User:: class );
    }

//niedziałający test ponieważ zła metoda :(
    public function testUser()
    {
        // kopiujemy naszą klasę User
        $stub = $this->getMockBuilder('User');
        // zmieniamy działanie jednej z metod
        $stub->addyMethods('doLogin')->willReturn(true);
        // test niepoprawnego adresu e-mail
        $this->assertFalse($stub->User('username', 'this-is-not-an-email'));
        // test dobrego adresu e-mail
        $this->assertTrue($stub->User('username', 'valid@e.mail'));
    }
}
