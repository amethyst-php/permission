# amethyst-permission

[![Action Status](https://github.com/amethyst-php/permission/workflows/test/badge.svg)](https://github.com/amethyst-php/permission/actions)

[Amethyst](https://github.com/amethyst-php/amethyst) package.

Define permissions with an extensive customization for your data and routes.

# Requirements

PHP 7.2 and later.

# TODO

- [ ] Attribute Authorization

## Installation

You can install it via [Composer](https://getcomposer.org/) by typing the following command:

```bash
composer require amethyst/permission
```

The package will automatically register itself.

## Usage

A simple usage looks like this

```php
use Amethyst\Models\Permission;
use Symfony\Component\Yaml\Yaml;

Permission::create([
	'effect' => 'accept',
	'type' => 'data',
	'payload' => Yaml::dump([
		'action' => 'create',
		'data' => 'foo'
	]),
	'agent' => '{{ agent.id }} == 1',
]);
```

Permissions will be automatically reloaded whenever a `eloquent.saved` is fired for `Permission` model.

## Effect

The effect can be either `accept` or `deny`. Without any permissions any user is denied to perform anything. If you add both permission accept and deny both of them are applied.

For example you could set "user can see all comments" and "user cannot see this comment". At the end the user can see all comments except the one that you defined.

## Type

The type of your permission indicate which class will be used to resolve your request.

It can be either `data` or `route`, but you can extend it in `amethyst.permissions.permission`

## Agent

The agent is retrieved through the facade `Illuminate\Support\Facades\Auth` and the method `user()`.

When this field is null it means that it's applied to all agents.

Agent must return a condition true or false.

If you wish to see the syntax see [nicoSWD/php-rule-parser](https://github.com/nicoSWD/php-rule-parser).

Before parsing with the logic parser, a twig parser comes in. The only variable passed is the agent and it is your `App\Models\User`. You can then use whanever logic you want to get the information you want. For example you can filter by any attributes and any relations (e.g. groups): `{{ agent.groups.contains('myGroupName') ? 1 : 0 }} === 1`

## Payload

A payload in YAML the define the specification of your permission. For example for the permission `route` it can be a wildcard for the url.

## Payload - Route

- name: The name of the route you wish to use, you can use wildcard `*`
- url: The url of the route, same like before, you can use the wildcard `*`,
- method: The method of the route

Some examples:

Enable endpoint `/profile` for each user.

```php
use Amethyst\Models\Permission;
use Symfony\Component\Yaml\Yaml;

Permission::create([
	'type' => 'route',
	'payload' => Yaml::dump([
		'url' => '/profile'
	])
]);
```

You can also use an array

```php
use Amethyst\Models\Permission;
use Symfony\Component\Yaml\Yaml;

Permission::create([
	'type' => 'route',
	'payload' => Yaml::dump([
		'url' => [
			'/profile',
			'/recovery-password'
		],
		'method' => [
			'POST',
			'GET'
		]
	])
]);
```

Enable endpoints foo.* (foo.index, foo.create, foo.show, foo.update, foo.delete) for user id 2

```php
use Amethyst\Models\Permission;
use Symfony\Component\Yaml\Yaml;

Permission::create([
	'type' => 'route',
	'payload' => Yaml::dump([
		'url' => 'foo.*'
	]),
	'agent' => '{{ agent.id }} === 2'
]);
```

## Payload - Data

The following example will permit the user#2 to visualize only the data named `post` that contains in the name `foo`

```php
use Amethyst\Models\Permission;
use Symfony\Component\Yaml\Yaml;

Permission::create([
	'type' => 'data',
	'payload' => Yaml::dump([
		'name' => [
			'post'
		],
		'action' => [
			'query',
		],
		'filter' => [
			'name ct "foo"'
		]
	]),
	'agent' => '{{ agent.id }} === 2'
]);
```
List of all actions: `query, create, update, remove`