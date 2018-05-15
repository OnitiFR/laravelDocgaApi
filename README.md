
## DocgaApi ##
 
### Installation ###
 
```
    composer require oniti/docga-api
```
 
The next required step is to add the service provider to config/app.php :
```
    Oniti\DocgaApi\DocgaApiServiceProvider::class,
```


### Env Requiered ###

```
DOCGA_API_KEY= <You'r Key>
DOCGA_API_SECRET= <You'r Secret>
DOCGA_API_URL= <Host>
```