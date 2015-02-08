<?php

class UserTableSeeder extends Seeder
{

	public function run()
	{
		$users = array(
			array(
				"email"    => "admin@example.com",
				"password" => Hash::make("admin"),
			),
			array(
				"email"    => "user@example.com",
				"password" => Hash::make("user"),
			)
		);

		foreach ($users as $user) {
			User::create($user);
		}
	}

}
