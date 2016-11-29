<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Telegram\Bot\Laravel\Facades\Telegram;

class TelegramController extends Controller
{

	public function getHome()
	{
		return view('home');
	}

	public function getUpdates()
	{
		$updates = Telegram::getUpdates();
		dd($updates);
	}
}