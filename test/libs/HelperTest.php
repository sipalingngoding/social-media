<?php

namespace SipalingNgoding\MVC\libs;

use PHPUnit\Framework\TestCase;

class HelperTest extends TestCase
{
    public function testView():void
    {
        self::expectOutputRegex('/login/i');
        Helper::view('header',['title'=>'Login']);
    }

    public function testSanitize():void
    {
        $inputs = ['email'=>'diory@gmail<js></js>','age'=>'21dsfd'];
        $result = Helper::sanitize($inputs,['email'=>'email','age'=>'int']);
        self::assertCount(2,$result);
        self::assertArrayHasKey('email',$result);
        self::assertArrayHasKey('age',$result);
        extract($result);
        self::assertNotSame($inputs['email'],$email);
        self::assertNotSame($inputs['age'],$age);
        self::assertSame('21',$age);
    }

    public function testValidateSampleOne():void
    {
        $inputs = ['username'=>'diory','email'=>'diory@gmail<js></js>','password'=>'diory123','confPassword'=>'Diory12'];
        $errors = Helper::validate($inputs,['username'=>'required | between(8,20)','email'=>'required | email','password'=>'required | secure','confPassword'=>'required | same(password)']);
        self::assertCount(4,$errors);
        self::assertArrayHasKey('email',$errors);
        self::assertArrayHasKey('password',$errors);
        self::assertArrayHasKey('confPassword',$errors);
        self::assertArrayHasKey('username',$errors);
        self::assertMatchesRegularExpression('/The username must have between 8 and 20 characters/i',$errors['username']);
        self::assertMatchesRegularExpression('/the confPassword must be the same as the password/i',$errors['confPassword']);
    }

    public function testValidateSampleTwo():void
    {
        $inputs = ['username'=>'diorypribadi','email'=>'diory@gmail.com','password'=>'Diory123?','confPassword'=>'Diory123?'];
        $errors = Helper::validate($inputs,['username'=>'required | between(8,20)','email'=>'required | email','password'=>'required | secure','confPassword'=>'required | same(password)']);
        self::assertCount(0,$errors);
    }

    public function testFilterSampleOne():void
    {
        //Change the filter_has_var to isset
        $inputs = ['username'=>'diorypribadi','email'=>'diory@gmail.com','password'=>'Diory123?','confPassword'=>'Diory123?'];
        foreach ($inputs as $key=>$input) $_POST[$key] = $input;
        [$inputs,$errors] = Helper::filter(['username','email','password','confPassword'],['username'=>'string; required | between(8,20)','email'=>'email; required | email','password'=>'string ; required | secure','confPassword'=>'string ; required | same(password)'],INPUT_POST);
        var_dump($errors);
        self::assertCount(0,$errors);
        self::assertCount(4,$inputs);
    }

    public function testFilterSampleTwo():void
    {
        $inputs = ['username'=>'','email'=>'diory@gmail.com','password'=>'diory123?','confPassword'=>'Diory123?2'];
        foreach ($inputs as $key=>$input) $_POST[$key] = $input;
        [$inputs,$errors] = Helper::filter(['username','email','password','confPassword'],['username'=>'string; required | between(8,20)','email'=>'email; required | email','password'=>'string ; required | secure','confPassword'=>'string ; required | same(password)'],INPUT_POST);
        var_dump($errors);
        self::assertCount(3,$errors);
        self::assertCount(4,$inputs);
        self::assertArrayHasKey('username',$errors);
        self::assertArrayHasKey('password',$errors);
        self::assertArrayHasKey('confPassword',$errors);
        self::assertMatchesRegularExpression('/please enter the username/i',$errors['username']);
        self::assertMatchesRegularExpression('/the confPassword must be the same as the password/i',$errors['confPassword']);
    }

}
