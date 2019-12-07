# Entity API

## Entities

An entity is a "enhanced" model that defines a couple of things :

- fields : Base fields, as defined in the Field API
- validator : validator for those fields
- routes : routes for this entity, the system provides with basic CRUD uris
- uris : uris for this entity, the system provides with basic CRUD uris
- actions : actions attached to an entity (edit, delete)
- policy : permission access for that entity

Every entity must be registered in the `Entity` facade in order to be available throughout the application. Typically it happens in the `register` method of your service providers.
A method is available for you to do so : `ServiceProvider->registerEntities(array $entities)`

En entity can be bundled or not. A bundled entity will have access to the bundle field API through its bundle.
Example : The User entity has basic fields (username, password) and also belong to the bundle User, where any extra field can be defined.

An entity that wishes to use Bundle fields must use the trait `HasBundleFields`, which is included in the `IsBundled` trait.

### Revisions

Any entity can use revisions if it implements the `hasRevisionContract` and optionnaly uses the `HasRevisions` trait.

### Routes

Every entity has a Routes class accessible through `MyEntity::routes()`, by default it defines basic crud uris : 'index', 'view', 'create', 'store', 'edit', 'update', 'patch', 'confirmDelete' and 'delete' and that, for 3 different namespace : 'admin', 'ajax' and 'web'.
Each have their own properties :
admin :
- prefix : admin
- middleware : web and permission : access admin area
web :
- middleware : web
ajax :
- prefix : ajax
- middleware : ajax

You can add a route for all entities in the register method of your service provider by using the `Entity::routes()` from which every entity extends.

Each route is associated to their uris of the same name.

Routes are protected by a Gate check, either create, index, view, edit or delete.

### Uris

Every entity has a Uri class accessible through `MyEntity::uris()`, the default uris for an entity are : 'index', 'view', 'create', 'store', 'edit', 'update', 'patch', 'confirmDelete' and 'delete'.

Uris are defined as used in the Laravel Route system (with slugs).
Uris can be transformed in urls by calling the `make($action, $replacements, ?string $prefix)` method. The $replacements is an array from which the slugs will be replaced. So if I want the admin edit url for $entity, I'll call `$entity::uris()->make('edit', $entity, adminPrefix())`

Uris can be added to all entities by using the `Entity::uris()` from which all entities Uris extend.

### Actions

Every entity has a class actions accessible through `MyEntity::actions()`. The default actions are edit and delete.
An action is an array defining 3 things :
- 'label : A label
- 'url' : A callback returning an url
- 'access' : A callback returning a boolean, checking if the user has access to that action.

Actions can be added to all entities by using the `Entity::actions()` in the register method of your service provider.

### Policy

Every entity defines a policy as described here : https://laravel.com/docs/5.7/authorization
There is no default policy for entities, it must be defined in every new entity you write.

### CRUD controllers

Entity API comes with default CRUD controllers, `ÀdminEntityController` and `AjaxEntityController` which are all split into traits that can be reused.
Those controllers will be used if no controllers is found for an Entity. If you have an Entity called `Thing`, you may want to create a `ThingAdminController` or `ThingAjaxController` to override the default behaviors. This happens automatically as long as the name conventions are respected.

You can also override the controller for a route in the `controllers` method of your `Routes` class.

## Bundles

There are two types of Bundle in Pingu, the Bundles and the EntityBundles.

Bundles are the basic ones, example User.
EntityBundles are bundles that are associated to an entity. Example : ContentType.
Each ContentType instance (article, blog) is itself a bundle, that have different fields. To each of those Entities instances, a BundleEntity class is associated.

### Registering a bundle

Every Bundle must be registered in the `Bundle` facade in order to be available throughout the application. Typically it happens in the `register` method of your service providers.

EntityBundle will be registered with `MyEntityBundle::registerAll()`.
Basic Bundles will be registered with `MyBundle::register()`.

### Routes

Bundle routes are already registered in the application through the class `BaseBundleRoutes`.

### Uris

Bundle Uris are already registered in the application through the class `BaseBundleUris`. For EntityBundles, the uris are merged with the entity uris in the class `EntityBundleUris`.

### Actions

Bundle actions are already registered in the application through the class `BaseBundleActions`. For EntityBundles, the actions are merged with the entity actions in the class `EntityBundleActions`

### Controllers

Default controllers are defined for handling the fields actions (create, edit, delete) for bundles.

## Commands

- artisan:module-make-entity : Creates a new entity. Will create a field repository, a field validator and a policy as well.
- artisan:module-make-entity-actions : Creates a new Actions class for an entity
- artisan:module-make-entity-policy : Creates a new Policy class for an entity
- artisan:module-make-entity-routes : Creates a new Routes class for an entity
- artisan:module-make-entity-uris : Creates a new Uris class for an entity