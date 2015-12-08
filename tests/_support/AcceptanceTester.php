<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

   /**
    * Define custom actions here
    */
    function login()
    {
        // if snapshot exists - skipping login
        if ($this->loadSessionSnapshot('login')) return;
        // logging in
        $this->amOnPage('/auth/login');
        $this->fillField('email', 'seller@bu.edu');
        $this->fillField('password', '123456');
        $this->click('#login-body button[type="submit"]');
        // saving snapshot
        $this->saveSessionSnapshot('login');
    }
}
