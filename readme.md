# Omniva API

PHP wrapper for courier [Omniva integration](https://www.omniva.ee/public/files/failid/manual_xml_dataexchange_eng.pdf).

[![Build Status](https://travis-ci.org/nebijokit/omniva.svg?branch=master)](https://travis-ci.org/nebijokit/omniva)
[![Maintainability](https://api.codeclimate.com/v1/badges/a69c99388dadb58cf74c/maintainability)](https://codeclimate.com/github/nebijokit/omniva/maintainability)
[![Total Downloads](https://img.shields.io/packagist/dt/nebijokit/omniva.svg)](https://packagist.org/packages/nebijokit/omniva)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8151bcc9-e8d6-4b63-909a-bfe550fee571/mini.png)](https://insight.sensiolabs.com/projects/8151bcc9-e8d6-4b63-909a-bfe550fee571)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nebijokit/omniva/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nebijokit/omniva/?branch=master)

## Examples

### Get label

Returns Label response (`stdClass` object) with encoded PDF & barcode. For Response structure view `getLabel` phpdoc.

```php
$client = new Client($username, $password);
$client->getLabel($parcel);
```


### Get pickup points list

This endpoint returns list of pickup points. Pickup point can be Terminal or Post office.
Field _Type_ determines whether field is _Terminal_ (Type: 0) or _Post office_ (Type: 1).

```php
// username & password is not necessary for pickup points
$client = new Client($username, $password);

$points = $client->getPickupPoints();
```

### Create Shipment & get Label

```php
use Omniva\Parcel;
use Omniva\Client;
use Omniva\Address;
use Omniva\Service;

$client = new Client($username, $password);

$shipment = $parcel->getShipment();
$id = $parcel->getId();

$omnivaParcel = new Parcel();
$omnivaParcel
    ->setWeight($parcel->getWeightInKg())
    ->setPartnerId($id)
    ->setComment($shipment->getRemark())
;

if ($shipment->getCodAmount()) {
    $omnivaParcel->setCodAmount($shipment->getCodAmount());
    $omnivaParcel->addService(Service::COD);
}

$sender = new Address();
$sender
    ->setName($shipment->getSender()->getName())
    ->setPhone($shipment->getSender()->getPhone())
    ->setCountryCode($shipment->getSender()->getCountry()->getCode())
    ->setCity($shipment->getSender()->getCity())
    ->setStreet($shipment->getSender()->getStreet())
    ->setPostCode($shipment->getSender()->getPostalCode())
;

if ($shipment->getSender()->getEmail()) {
    $sender->setEmail($shipment->getSender()->getEmail());
}

$omnivaParcel->setSender($sender);

$returnee = clone $sender;
$omnivaParcel->setReturnee($returnee);

$receiver = new Address();
$receiver
    ->setName($shipment->getReceiver()->getName())
    ->setCountryCode($shipment->getReceiver()->getCountry()->getCode())
;

if ($shipment->getReceiver()->getEmail()) {
    $receiver->setEmail($shipment->getReceiver()->getEmail());
}

if ($shipment->getReceiver()->getPhone()) {
    $receiver->setPhone($shipment->getReceiver()->getPhone());
}

if ($shipment->getReceiver()->isTypeTerminal()) {
    $terminal = $shipment->getReceiver()->getTerminal();

    $pickupPoint = new PickupPoint($terminal->getIdentifier());
    $pickupPoint->setType($terminal->isPostOffice() ? PickupPoint::TYPE_POST_OFFICE : PickupPoint::TYPE_TERMINAL);

    $receiver->setPickupPoint($pickupPoint);

    if ($shipment->getReceiver()->getPhone()) {
        $omnivaParcel->addService(Service::SMS);
    }

    if ($shipment->getReceiver()->getEmail()) {
        $omnivaParcel->addService(Service::EMAIL);
    }
} else {
    $receiver
        ->setCity($shipment->getReceiver()->getCity())
        ->setStreet($shipment->getReceiver()->getStreet())
        ->setPostCode($shipment->getReceiver()->getPostalCode())
    ;
}
$omnivaParcel->setReceiver($receiver);

$response = $client->createShipment($omnivaParcel);

$trackingNumber = $response->savedPacketInfo->barcodeInfo->barcode;
$parcel->setTrackingNumber($trackingNumber);
$omnivaParcel->setTrackingNumber($trackingNumber);

$response = $client->getLabel($omnivaParcel);

// PDF content
$content = $response->successAddressCards->addressCardData->fileData;
```

## Ideas for further development
- [ ] implement `Client` tracking
- [ ] add Symfony\Constraint for data validation
