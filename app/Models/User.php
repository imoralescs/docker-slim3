<?php 

namespace App\Models;

class User 
{
	public function fullName()
	{
		if($this->lastname === null)
		{
			return $this->firstname;
		}

		return "{$this->firstname} {$this->lastname}";
	}

	public function getFormattedBalance()
	{
		if($this->balance === 0){
			return 'Zero funds';
		}

		return '$' . number_format($this->balance, 2);
	}

}