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

```
$client = new Client($username, $password);
$client->getLabel($parcel);
```


### Get pickup points list

This endpoint returns list of pickup points. Pickup point can be Terminal or Post office.
Field _Type_ determines whether field is _Terminal_ (Type: 0) or _Post office_ (Type: 1).

```
// username & password is not necessary for pickup points
$client = new Client($username, $password);

$points = $client->getPickupPoints();
```

## Ideas for further development
- [ ] implement `Client` tracking
- [ ] add Symfony\Constraint for data validation
