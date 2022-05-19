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

## Project: Building a list of links
### Database and model data setup

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

8.  Create the link seeder-allows addition of demo data to the table
`php artisan make:seeder LinksTableSeeder`
The `make:seeder` command generates a new database class to seed our `links` table with data

9. Open the `database/seeders/LinksTableSeeder.php` file and add the following:
```
public function run()

    {

        factory (App\Link::class,5)->create();

    }
```

10. In order to “activate” the `LinksTableSeeder`, we need to call it from the main `database/seeders/DatabaseSeeder.php` run method:
```
public function run()

    {
    
        $this->call(LinksTableSeeder::class);

    }
    
```
11. Run the migrations and seeds to add data to the table automatically.
Using the `migrate:fresh` command, we can get a clean schema that applies all migrations and then seeds the database
`php artisan migrate:fresh --seed`
12. Using the [tinker shell](https://laravel-news.com/laravel-tinker) you can start playing around with the model data:
`php artisan tinker`
```
>>> App\Models\Link::first()

```

###  Building the UI
#### Routing and Views
 Update the main project route and define a new route that will display the submission form. We can add new routes to our application in the `routes/web.php` file.
 1. Create a new route using route closure. 
	  Update the home route by getting a collection of links from the database and passing them to the view:
 ```
  Route::get('/', function () {

    $links=App\Models\Link::all();

  

    return view('welcome',['links'=>$links]);

});
```
	
The second argument can be an associative array of data, and the key ends up being the variable name in the template file.

N/B: 
	You can also use a fluent API to define variables if you prefer:
```
// with()
return view('welcome')->with('links', $links);

// dynamic method to name the variable
return view('welcome')->withLinks($links);
```

2. Edit the welcome.blade.php file and add a simple `foreach` to show all the links:
```
    <body>

    <div class="flex-center position-ref full-height">

        @if (Route::has('login'))

            <div class="top-right links">

                @auth

                    <a href="{{ url('/home') }}">Home</a>

                @else

                    <a href="{{ route('login') }}">Login</a>

                    <a href="{{ route('register') }}">Register</a>

                @endauth

            </div>

        @endif

        <div class="content">

            <div class="title m-b-md">

                Laravel

            </div>

            <div class="links">

                @foreach ($links as $link)

                    <a href="{{ $link->url }}">{{ $link->title }}</a>

                @endforeach

            </div>

        </div>

    </div>

</body>
```

#### Display the link submission form
1. Create a new route on `routes/web.php` file:
```
Route::get('/submit', function () {

    return view('submit');

});
```
2. Create the `submit.blade.php` template at `resources/views/submit.blade.php` with the following boilerplate bootstrap markup:
```
@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="row">

            <h1>Submit a link</h1>

        </div>

        <div class="row">

            <form action="/submit" method="post">

                @csrf

                <!-- blade conditional that checks

                if there are any validation errors -->

                @if ($errors->any())

                    <div class="alert alert-danger" role="alert">

                        Please fix the following errors

                    </div>

                @endif

                <div class="form-group">

                    <label for="title">Title</label>

                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" placeholder="Title" value="{{ old('title') }}">

                    @error('title')

                        <div class="invalid-feedback">{{ $message }}</div>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="url">Url</label>

                    <input type="text" class="form-control @error('url') is-invalid @enderror" id="url" name="url" placeholder="URL" value="{{ old('url') }}">

                    @error('url')

                        <div class="invalid-feedback">{{ $message }}</div>

                    @enderror

                </div>

                <div class="form-group">

                    <label for="description">Description</label>

                    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="description">{{ old('description') }}</textarea>

                    @error('description')

                        <div class="invalid-feedback">{{ $message }}</div>

                    @enderror

                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>

        </div>

    </div>

@endsection
```

#### Submitting the form
1. In the `routes/web.php` file, create another route for the `POST` request"
```
use Illuminate\Http\Request;

Route::post('/submit', function (Request $request) {

    $data = $request->validate([

        'title' => 'required|max:255',

        'url' => 'required|url|max:255',

        'description' => 'required|max:255',

    ]);

    $link = tap(new App\Link($data))->save();

    return redirect('/');

});
```

**Explanation of the above**
* injecting the `Illuminate\Http\Request` object, which holds the POST data and other data about the request
* use the request’s `validate()` method to validate the form data. The validated fields are returned to the `$data` variable, and we can use them to populate our model.
* define multiple rules using the pipe characters
* use the `tap()` helper function to create a new `Link` model instance and then save it. Using tap allows us to call `save()` and still return the model instance after the save.

2. Allow the fields to be “fillable” via mass assignment. To allow our model to assign values to these fields, open the `app/Link.php` file and update it to look like the following:
```
use Illuminate\Database\Eloquent\Model;

  

class Link extends Model

{

    protected $fillable = [

        'title',

        'url',

        'description'

    ];

}
```
