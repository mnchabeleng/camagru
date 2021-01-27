# Camagru

Camagru is a web application developed primarily in php(No frameworks), it allow  user to make basic photo editing, photos are uploaded using webcam or  directly from user's computer.

![Camagru](https://raw.githubusercontent.com/mnchabeleng/Camagru/master/screenshots/camagru.jpg)

### Objectives

* Your web application must produce no errors, no warning or log line in any console,server side and client side. Nonetheless, due to the lack of HTTPS, any error relatedtogetUserMedia()are tolerated.
* You must use ony PHP language to create your server-side application, with just the standard library.
* Client-side, your pages must use HTML, CSS and JavaScript.
* Every framework, micro-framework or library that you don’t create are totally forbidden, except for CSS frameworks that doesn’t need forbidden JavaScript.
* You must use the PDO abstraction driver to communicate with your database,that must be queryable with SQL. The error mode of this driver must be set to PDO::ERRMODE_EXCEPTION
* Your application must be free of any security leak. You must handle at least cases mentioned in the mandatory part. Nonetheless, you are encouraged to go deeper into your application’s safety, think about your data’s privacy!
* You are free to use any webserver you want, like Apache, Nginxor even thebuilt-inwebserver1.
* Your web application should be at least be compatible withFirefox(>= 41) andChrome(>= 46).

### Setup

```
camagru/inc/inc.global_variables.php
```

![Camagru Setup](https://raw.githubusercontent.com/mnchabeleng/Camagru/master/screenshots/camagru_settings.png)