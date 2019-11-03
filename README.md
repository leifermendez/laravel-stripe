# Laravel Stripe SCA

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

> Recuerda colocar tus credenciales en tu archivo .env
>, Mode: "sandbox" or "live"

```
# STRIPE

STRIPE_PK=pk_test_xxxxxxxxxxxx
STRIPE_SK=sk_test_xxxxxxxxxxx
STRIPE_MODE=sandbox
```

---
#### (1) Obtener Token de Tarjeta

En algunos casos es necesario obtener el token de tarjeta vía 
API (no recomendado), se recomienda usar [StripeJS](https://stripe.com/docs/stripe-js/reference)

StripeJS [Demo Live](https://codepen.io/leifermendez/pen/GRRyLBg)
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
#### (2) Guardar Cliente

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

![PDF](https://github.com/leifermendez/laravel-policia-hotel/blob/master/example/documentation/vista_previa.png?raw=true)
---

#### (3) Crear Pago

__NOTA:__ Con la implementación del SCA, los pagos deben realizarse bajo una ["Intención de Pago"](https://stripe.com/docs/api/payment_intents).
 Lo que técnicamente realizamos es una petición para realizar un pago y Stripe se encarga de verificar si la tarjeta requiere o no requiere una verificación en dos pasos.

__Comportamiento:__
Pueden pasar dos cosas:
- (1) No requiere doble verificación y el pago se realiza correctamente.
- (2) Requiere doble verificación :
    - El "status" de la respuesta determinara la acción que se debe tomar [Ver más status](https://stripe.com/docs/api/payment_intents/object#payment_intent_object-status). El status más frecuente en este caso es `requires_action` esta acción solo se puede realizar
      a través del StripeJS

```php

// https://stripe.com/docs/api/payment_intents/create

$amount = 134;
$charge = array(
    'description' => 'Mi primer cobro',
    'amount' => floatval($amount * 100),
    'currency' => 'EUR',
    'payment_method_types' => ['card'],
    'customer' => cus_G0amE3Dmn4p1f0, // <--- ID Customer Paso (2)
    'setup_future_usage' => 'off_session' // <--- Off Session
);

$response = StripeLaravelFacade::charge_sca($charge);

dd($response);

```

![PDF](https://github.com/leifermendez/laravel-policia-hotel/blob/master/example/documentation/vista_previa.png?raw=true)

---
#### (3.1) Crear Pago No Capturado

__NOTA:__ (No capturados), son aquellos pagos que necesitamos retener o bloquear, para posteriormente
usar o no usar.
Ejemplo: Si tienes un hotel y deseas cobrar 100EUR de garantía o fianza, puedes usar esta opción ya que el sistema
bloquea este monto en la tarjeta del cliente por 7 días.
El dinero solo estará disponible para capturar (cobrar) en los siguiente 7 días de lo contrario si no realizas ninguna captura
Stripe libera el monto al cliente.


```php

$amount = 134;

$charge = array(
    'description' => 'Cobro de fianza' ,
    'amount' => floatval($amount * 100),
    'currency' => 'EUR',
    'payment_method_types' => ['card'],
    'off_session' => 'true',
    'confirm' => 'true',
    'capture_method' => 'manual', // <--- Indicamos que es un pago No Capturado
    'source' => 'card_1FX8TaHBaMrHjOH4MeiQmvPC', // <---  ID Source Customer Paso (2)
    'customer' => 'cus_G0amE3Dmn4p1f0'  // <--- ID Customer Paso (2)

);

$response = StripeLaravelFacade::charge_sca($charge);

dd($response);

```

![PDF](https://github.com/leifermendez/laravel-policia-hotel/blob/master/example/documentation/vista_previa.png?raw=true)
---