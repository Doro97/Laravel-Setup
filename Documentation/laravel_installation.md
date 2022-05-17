## Setting up Laravel
 1. Create a new Laravel project for the  `links` application: 
 `links` is the project name
			`composer create-project --prefer-dist laravel/laravel links`
2.  Database setup

	* Modify the database credentials on the `.env` file
	* Create a new database for the project
	* Adjust the database configuration(database name) in `.env` file
	* Test the database connection:
		`php artisan migrate`

3. Setting up authentication

	* Install the UI composer package:
	`composer install laravel/ui`. The UI package provides a few commands for setting up scaffolding for tools like React, Vue, and Bootstrap.
	* Generate routes, controllers, views, and other files necessary for auth:
	`php artisan ui bootstrap --auth`
	* Compile the CSS UI:
	`npm install`
	`npm run dev`   or 
	`npm run watch`
	The `watch` command will listen for files changes to JS and CSS files, and automatically update them. N/B: Run  `npm run watch`  in a separate tab while developing.

## Start working on the project
### Building a list of links
1. Creating a migration
`php artisan make:migration create_links_table --create=links`
2. Open the file this command. The file is located at: `database/migrations/{{datetime}}_create_links_table.php`
3. Inside the “up()” method, add the following schema:

```
Schema::create('links', function (Blueprint $table) {
	
	$table->increments('id');
	
	$table->string('title');
	
	$table->string('url')->unique();
	
	$table->text('description');
	
	$table->timestamps();

});
```
4. Save the file and run the migration:
`php artisan migrate`
5. While you are working with test data, you can quickly apply the schema:
`php artisan migrate:fresh`
6. To work with test data, laravel provides 2 features:
	* Database seeder: populates the database with data
	* Model factory files: allows generation of fake model data
	`php artisan make:model --factory Link`
Explanation of the features:
	* The `make:model` command creates an `app/Link.php` model file.
	* The `--factory` flag will generate a new factory file in the `database/factories` path for generating app data. In our case, a new `LinkFactory` file will include an empty factory definition for our `Link` model.
7.  Open the `LinkFactory.php` file and fill in the following:

```
<?php


/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Link;

use Faker\Generator as Faker;

$factory->define(Link::class, function (Faker $faker) {
 return [
	'title' => substr($faker->sentence(2), 0, -1),	
	'url' => $faker->url,	
	'description' => $faker->paragraph,
];

});
```

We use the `$faker->sentence()` method to generate a title, and `substr`to remove the period at the end of the sentence.

8.  Create the link seeder
`php artisan make:seeder LinksTableSeeder`
	
	