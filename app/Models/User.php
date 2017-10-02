<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	// Eloquent implementation
	protected $table = 'users';

	// Fillable to introduce data to database.
	protected $fillable = [
		'firstname',
		'lastname',
		'username',
		'email',
		'password'
	];

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