# Sage HTML Forms

![Latest Stable Version](https://img.shields.io/packagist/v/log1x/sage-html-forms?style=flat-square)
![Total Downloads](https://img.shields.io/packagist/dt/log1x/sage-html-forms?style=flat-square)
![Build Status](https://img.shields.io/github/workflow/status/log1x/sage-html-forms/Main?style=flat-square)

This is a simple package for the [HTML Forms](https://github.com/ibericode/html-forms) plugin that allows you to easily render forms using a corresponding Blade view (if one is present) with Sage 10.

A few additional opinionated tweaks include:

- Moving the HTML Forms admin menu item to the Options submenu.
- Hide the ads shown in the sidebar of the admin page.

## Requirements

- [Sage](https://github.com/roots/sage) >= 10.0
- [PHP](https://secure.php.net/manual/en/install.php) >= 7.2
- [Composer](https://getcomposer.org/download/)

## Installation

Install via Composer:

```bash
$ composer require log1x/sage-html-forms
```

## Usage

### Getting Started

Start by creating a form in the HTML Forms admin menu page if you do not already have one.

You can leave the "Form code" blank as it will not be used if a corresponding Blade view exists.

### Creating a View

Once your form is created, simply generate a view using the slug assigned to your form:

```bash
$ wp acorn make:form contact-us
```

You will find the generated form view in `resources/views/forms/contact-us.blade.php` containing a simple form component:

```php
<x-html-forms :form="$form" class="my-form">
  <input
    name="name"
    type="text"
    placeholder="Full Name"
    required
  >

  <input
    name="emailAddress"
    type="email"
    placeholder="Email Address"
    required
  >

  <input
    type="submit"
    value="Submit"
  />
</x-html-forms>
```

When HTML Forms processes "Form Actions" – it simply fetches each input name to create the usable variables.

That being said, the default view would provide `[NAME]` and `[EMAILADDRESS]`.

#### Error Messages

Outside of defining your error messages on the options page, you can optionally provide them to the `<x-html-forms />` component directly:

```php
<x-html-forms
  :form="$form"
  :messages="['success' => 'Thank you!', 'error' => 'Yikes! Try again.']"
  class="my-form"
/>
```

## Bug Reports

If you discover a bug in Sage HTML Forms, please [open an issue](https://github.com/log1x/sage-html-forms/issues).

## Contributing

Contributing whether it be through PRs, reporting an issue, or suggesting an idea is encouraged and appreciated.

## License

Sage HTML Forms is provided under the [MIT License](https://github.com/log1x/sage-html-forms/blob/master/LICENSE.md).
