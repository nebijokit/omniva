# Omniva API

PHP wrapper for courier Omniva integration.

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/8151bcc9-e8d6-4b63-909a-bfe550fee571/mini.png)](https://insight.sensiolabs.com/projects/8151bcc9-e8d6-4b63-909a-bfe550fee571)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nebijokit/omniva/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nebijokit/omniva/?branch=master)

## ToDo

- [ ] implement `Client` tracking
- [x] implement `Client` terminals list

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

## Bonus
- [ ] add Symfony\Constraint for validation
