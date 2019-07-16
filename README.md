# individual-test
Copy project

git clone https://github.com/tipochka/individual-test.git individual-test
cd individual-test/

#Config connection DB:

1. Create file .evn.local, and open file
2. Write: DATABASE_URL=mysql://{login}:{password}@mysql:{port}/{DB Name}

#Run:

$ composer install

## create schemaDB
php bin/console doctrine:database:create
## create Tables and migrations
php bin/console make:migration
php bin/console doctrine:migrations:migrate

##Methods:

GET <hostname>/classroom -- all active classrooms
 
GET <hostname>/classroom/<id> -- classroom by id

POST <hostname>/classroom/add params(string name, int is_active{1|0}) -- add classroom

PUT <hostname>/classroom/update/<id> params(string name, int is_active{1|0}) -- update classroom

DELETE <hostname>/classroom/remove/<id> -- remove classroom
