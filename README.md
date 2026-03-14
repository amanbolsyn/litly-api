# Litly API



## Installation

Clone the repository 
```bash
git clone https://github.com/amanbolsyn/litly-api.git
```

Go to the cloned directory
```bash
cd litly-api/
```

Install all the dependencies 
```bash
composer install
npm install
```

Create local env file
```bash
cp .env.example .env
```

Run the composer
```bash
composer run dev
```

Generate application key
```bash
php artisan key:generate
```

Migrate and seed the database
```
php artisan migrate:fresh --seed
```

Change APP_TIMZONE to sutiable timezone inside .env file

## Roles 

## API Endpoints 

## Possible improvements 


## Bugs 

## Resources 

+ [Laravel Docs](https://laravel.com/docs/12.x/installation)

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

## License

Cannot be used for commercial purposes.