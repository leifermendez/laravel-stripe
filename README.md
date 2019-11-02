# Larave Stripe SCA

A continuación mostraremos como realizar un cargo en Stripe con el protocolo SCA. El siguiente paquete nos permite registrar usuarios, guardar tarjetas para pagos posteriores, crear intenciones de pago.

> __NOTA__: Antes continuar recuerda solicitar tus credenciales de acceso en [Stripe](https://stripe.com)

#### Instalar

`composer require leifermendez/laravel-stripe`

#### Laravel 5.* Integración

Add the service provider to your `config/app.php` file:

```php

    'providers'     => array(

        //...
        leifermendez\stripe\StripeProvider::class,

    ),

```

Add the facade to your `config/app.php` file:

```php

    'aliases'       => array(

        //...
        'StripeSCA'  => leifermendez\stripe\StripeLaravelFacade::class,

    ),

```

#### Uso

---
##### (1) Obtener Token de Tarjeta

En algunos casos es necesario obtener el token de tarjeta via 
API (no recomendado), se recomienda usar [StripeJS](https://stripe.com/docs/stripe-js/reference)

```php
//Test card: https://stripe.com/docs/testing#cards

$card_data = array(
    'card' => [
        'number' => 4000002500003155,
        'exp_month' => 12,
        'exp_year' => 2020,
        'cvc' => 123
    ]
);

$card = StripeLaravelFacade::tokenCard($card_data);
$card = json_decode($card, true);

dd($card);

```
---
##### (2) Guardar Cliente

Si queremos guardar nuestros clientes para consultar posteriormente.

```php
// https://stripe.com/docs/api/payment_intents/create

$data = array(
    'email' => 'leifer33@gmail.com',
    'source' => 'tok_1FOO42HBaMrHjOH4Cu0dnogU' // <-- Token Card Paso (1)
);

$user = StripeLaravelFacade::saveCustomer($data);
$user = json_decode($user, true);

dd($response);

```
---

##### Crear Pago

__NOTA__: Con la implementación del SCA, los pagos deben realizarse bajo una ["Intención de Pago"](https://stripe.com/docs/api/payment_intents/create)
. Lo que tecnicamente realizamos es una peticíon para realizar un pago y Stripe se encarga de verificar si
la tarjeta requiere o no requiere una verificacion en dos pasos.

__Comportamiento:__
Puden pasar dos cosas:
- (1) No require doble verificacion y el pago se realiza correctamente.
- (2) Requiere doble verificación :
    - El "status" de la respuesta determinara la acción que se debe tomar [Ver más status](https://stripe.com/docs/api/payment_intents/object#payment_intent_object-status)
    . El status más frecuente en este caso es `requires_action` esta accion solo se puede realizar
    a travez del StripeJS

```php

// https://stripe.com/docs/api/payment_intents/create

$amount = 134;
$charge = array(
    'description' => 'Mi primer cobro',
    'amount' => floatval($amount * 100),
    'currency' => 'EUR',
    'payment_method_types' => ['card'],
    'customer' => cus_G0amE3Dmn4p1f0, // <--- ID Customer
    'setup_future_usage' => 'off_session'
);

$response = StripeLaravelFacade::charge_sca($charge);

dd($response);


```