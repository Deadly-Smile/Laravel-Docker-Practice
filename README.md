# BOLBONA

## How to setup

### Run this command on bash

```bash
make setup
```
### If make commands don't work use separate commands
```bash
docker-compose build --no-cache --force-rm
docker-compose up -d
docker exec laravel-docker bash -c "composer update"
docker exec laravel-docker bash -c "php artisan migrate"
```
### If you have permission issue in linux system
First goto the project directory by
```bash
cd laravel-app # for this case
```
Execute this commands
```bash
sudo chmod o+w ./storage/ -R
```
```bash
sudo chown www-data:www-data -R ./storage
```


## Tutorial

[Youtube](https://www.youtube.com/watch?v=V-MDfE1I6u0)
