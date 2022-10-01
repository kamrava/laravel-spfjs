![Laravel SPF.js](http://up.vbiran.ir/uploads/1716814929346864017_laravel-spfjs.png)

[![Laravel 5.x](https://img.shields.io/badge/Laravel-5.x-orange.svg?style=flat-square)](https://github.com/kamrava/laravel-spfjs)
[![Latest Version](https://img.shields.io/github/release/kamrava/laravel-spfjs.svg?style=flat-square)](https://github.com/kamrava/laravel-spfjs/releases)
[![License](https://poser.pugx.org/kamrava/laravel-spfjs/license.svg?style=flat-square)](https://packagist.org/packages/kamrava/laravel-spfjs)

# Laravel SPF
Integrating SPF.js with Laravel

For Laravel 5.x

Laravel SPF package allows to bring awesome SPF.js to your Laravel app. Here is a description from SPF.js official doc :

> Structured Page Fragments — or SPF for short — is a lightweight JS framework for fast navigation and page updates from YouTube.
>
> Using progressive enhancement and HTML5, SPF integrates with your site to enable a faster, more fluid user experience by updating just the sections of the page that change during navigation, not the whole page. SPF provides a response format for sending document fragments, a robust system for script and style management, an in-memory cache, on-the-fly processing, and more.

[Demo](http://reek.ir/demo)

[Demo Source Code](https://github.com/kamrava/laravel-spfjs-demo)

## Installation

1. Install with composer:

```sh
composer require kamrava/laravel-spfjs
```

2. Open your `config/app.php` and add the following to the providers array:

```sh
Kamrava\Spf\SectionViewServiceProvider::class
```

3. In the same `config/app.php` and add the following to the aliases array:


```sh
'SectionView' => Kamrava\Spf\SectionViewFacade::class
```

4. Run the command below to publish the package asset files:

```sh
php artisan vendor:publish --tag=public --force
```

And that's it! Start building out some awesome and fast Laravel app!

## Get Started

**Blade Files Structure**

As you know each HTML page consists of:

`head` for meta tags as well as styles and title and etc..

`body` for your page body

`script` for javascript files

Most probably you were using some structure like this:


```php
resources/view/admin/users-list.blade.php
```

And the file's content would be something like this :

```html
@extends('layouts.master')
@section('title') Users List @stop
@section('head')
<link href="/css/style1.css" rel="stylesheet" />
<link href="/css/style2.css" rel="stylesheet" />
@stop
@section('content')
<table>
  ...
  @foreach($users as $user)
    <tr>
      <td>{{ $user->id }}</td>
      <td>{{ $user->name }}</td>
      ...
    </tr>
  @endforeach
</table>
@stop
@section('scripts')
<script src="/js/script1.js"></script>
<script src="/js/script2.js"></script>
@stop
```
Right? Ok, for using SPF.js in you Laravel app you need to break them into separate files and put them into sections directory as below :

```php
resources/view/admin/users-list/sections/_title.blade.php
resources/view/admin/users-list/sections/_head.blade.php
resources/view/admin/users-list/sections/_body.blade.php
resources/view/admin/users-list/sections/_foot.blade.php
```

Then put each section content into related blade file. For instance the content of ـhead.blade.php must be:

```html
<link href="/css/style1.css" rel="stylesheet" />
<link href="/css/style2.css" rel="stylesheet" />
```

And so on for other sections.

Now, we have to combine them into two separate files! One for when SPF is not enabled for any reasons! and the other for when SPF is enabled :

First `index.blade.php` which located in : (For when SPF.js is not enabled)

```php
resources/view/admin/users-list/index.blade.php
```

with this content :

```html
@extends('layouts.master')
@section('title')
  @include('admin.users-list.sections._title')
@endsection
@section('head')
  @include('admin.users-list.sections._head')
@endsection
@section('content')
  @include('admin.users-list.sections._body')
@endsection
@section('scripts')
  @include('admin.users-list.sections._foot')
@endsection
```

And `spf_json.blade.php` whcih located in : (For when SPF.js is enabled)

```php
resources/view/admin/users-list/spf_json.blade.php
```

with this content :

```php
{
  "title": "{!! $section->title !!}",
  "head": "{!! $section->head !!}",
  "body": {
    "main-content": "{!! $section->body !!}"
    },
  "foot": "{!! $section->foot !!}"
}
```

__`main-content` in the above code means we have a div with id main-content in the body tag__

Cool, lets have a look at our master page which probably located here :

```php
resources/view/layouts/master.blade.php
```

with this content :

```html
<html>
<head>
   @include('layouts.head')
   @yield('head')
</head>
<body>
   @include('layouts.header')
   	<div id="main-content">
   	   @yield('content')
 	</div>
   @include('layouts.scripts')
   @yield('scripts')
</body>
</html>
```

**Send requests**

SPF does not change your site's navigation automatically and instead uses progressive enhancement to enable dynamic navigation for certain links. Just add a spf-link class to an <a> tag to activate SPF.

```html
<!-- Link enabled: a SPF request will be sent -->
<a class="spf-link" href="/Admin/UsersList">Show Users List</a>
```

**Return responses**

In dynamic navigation, only fragments are sent, using JSON as transport. When SPF sends a request to the server, it appends a configurable identifier to the URL so that your server can properly handle the request. (By default, this will be ?spf=navigate)

**AdminController.php**

```php
use SectionView;

class AdminController extends Controller
{
    public function showUsersList(Request $request)
    {
      $users = User::all();
      if($request->input('spf') == 'navigate') {
        return SectionView::from('admin.users-list')->with(['users' => $users])->render();
      }
      return view('admin.users-list.index', compact('users'));
    }
}
```

Finally don't forget to load asset file in your scripts part of your master page!

```php
<script type="text/javascript" src="{{ asset('vendor/laravel-spf/js/laravel-spf.js') }}"></script>
```

Boom! It's Done!

## Browser Support

To use dynamic navigation, SPF requires the HTML5 History API. This is broadly supported by all current browsers, including Chrome 5+, Firefox 4+, and IE 10+.

## Credits

**Maintainers:**

1. [Hamed Kamrava](https://github.com/kamrava

2. ...


**License**

The MIT License (MIT). Please see License File for more information.
