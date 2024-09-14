<p style="font-size: 40px" align="center">
Sse Notify Laravel
</p>

## About Sse-Notify Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:


Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Requirements
PHP 8.2 or higher \
Laravel 10.0 or higher \
User table with id uuid column \
Active authentication system \
Active uuid extension in database

## Installation

```shell
composer require luizfabianonogueira/sse-notify
```

After installation, register the service provider.\

In bootstrap/providers.php.
```php
<?php
return [
    ...,
    LuizFabianoNOgueira\SseNotify\SseServiceProvider::class, 
];
```
After that you must publish the migration and js file.

```shell    
php artisan vendor:publish --provider="LuizFabianoNOgueira\SseNotify\SseServiceProvider"
```
Atention: the sse.js file will be exported to public/assets/js/sse.js. \
If you use vite or semilar, configure js correctly to be loaded

Execute the migration to create the table that will store the notifications.

Now we need to configure the communication channel. \

In the view you chose to have the channel open, insert the following code.

```html
    @if(Auth::check())
        <!-- Include the sse.js file -->
        <script src="{{ asset('assets/js/sse.js') }}"></script>
        <script>
            <!-- Call the SseConnect function passing the route to the connection -->
            SseConnect('{{ route('sse.connect', ['userId' => Auth::user()->id]) }}');
        </script>
    @endif
```

## Testing
To run a user test, simply access the following url

yourdomain.com/sse/generateFakeData/{userId}

## Usage Example

### ..::|| javaScript alert() ||::..

```php
    $sseMessageAlert = new SseEventMessageAlert([
        'message' => 'Notify Alert!', //string
        'userId' => {userId}, //uuid
    ]);
    $sseMessageAlert->save();
```

### ..::|| SweetAlert2 ||::..
```php
$data = [
    'title' => 'Notify title Sweet!', //string
    'message' => 'Notify message Sweet!', //string
    'type' => SseEnumStyle::STYLE_SUCCESS, //Enum types: STYLE_SUCCESS, STYLE_ERROR, STYLE_WARNING, STYLE_INFO
    'id' => time(),// int id unique
    'confirm' => false, // if true show confirm button
    'userId' => $this->userId //uuid - user to be notified
];
(new SseEventMessageSweet($data))->save();
```

### ..::|| Bootstrap Notify ||::..
```php
$data = [
    'title' => 'Notify title notify!', //string
    'message' => 'Notify message notify!', //string
    'type' => SseEnumStyle::STYLE_SUCCESS, //Enum types: STYLE_SUCCESS, STYLE_ERROR, STYLE_WARNING, STYLE_INFO
    'id' => time(), // int id unique
    'autoClose' => true, // if true auto close
    'userId' => $this->userId //uuid - user to be notified
];
(new SseEventMessageNotify($data))->save();
```

### ..::|| Bootstrap TOAST ||::..
```php
$data = [
    'title' => 'Notify title toast!', //string
    'message' => 'Notify message toast!', //string   
    'type' => SseEnumStyle::STYLE_SUCCESS, //Enum types: STYLE_SUCCESS, STYLE_ERROR, STYLE_WARNING, STYLE_INFO
    'id' => time(), // int id unique
    'autoClose' => true, // if true auto close
    'userId' => $this->userId, //uuid - user to be notified
    'imgURL' => '/android-chrome-192x192.png', //string - image url [optional]
    'linkURL' => 'https://www.google.com', //string - link url [optional]
    'linkText' => 'Google' //string - link text [optional]
];
(new SseEventMessageToast($data))->save();
```

### ..::|| INJECTION HTML ||::..
```php
(new SseEventInjectHtml([
    'html' => '<div class="alert alert-success">Notify message!</div>', //string - html to be injected 
    'target' => 'boxTestes', //string - target id to inject
    'userId' => $this->userId //uuid - user to be notified
]))->save();
```

### ..::|| INJECTION SCRIPT ||::..
```php
(new SseEventInjectScript([
    'script' => 'console.log("Notify message! - ' . $i . '")', //string - script to be injected
    'userId' => $this->userId //uuid - user to be notified
]))->save();
```

After saving, the system sends the notification to the target user. \
Each notification has a 3 seconds interval between them. \
If you don't have notifications, the next check is in 10 seconds.

## Questions and contributions

luizfabianonogueira@gmail.com \
+55 48 991779088

