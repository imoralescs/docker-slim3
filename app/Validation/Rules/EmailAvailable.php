<?php

namespace App\Validation\Rules;

use Respect\Validation\Rules\AbstractRule;
use App\Models\User;

class EmailAvailable extends AbstractRule
{
	public function validate($input)
	{
		// If email exist will count 1 and return false, otherwise return true
		return User::where('email', $input)->count() === 0;
	}
}