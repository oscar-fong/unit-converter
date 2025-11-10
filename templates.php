<?php
const milimeter = 1;
const centimeter = 10;
const meter = 1000;
const kilometer = 1000000;
const inch = 25.4;
const foot = 304.8;
const yard = 914.4;
const mile = 1609000;

const miligram = 1;
const gram = 1000;
const kilogram = 1000000;
const ounce = 28349.5;
const pound = 453592;

$lengthsHtml = '<option value="milimeter">Milimeter</option>
<option value="centimeter">Centimeter</option>
<option value="meter">Meter</option>
<option value="kilometer">Kilometer</option>
<option value="inch">Inch</option>
<option value="foot">Foot</option>
<option value="yard">Yard</option>
<option value="mile">Mile</option>';

$weightsHtml = '<option value="miligram">Miligram</option>
<option value="gram">Gram</option>
<option value="kilogram">Kilogram</option>
<option value="ounce">Ounce</option>
<option value="pound">pound</option>';

$tempsHtml = '<option value="celsius">Celsius</option>
<option value="fahrenheit">Fahrenheit</option>
<option value="kelvin">Kelvin</option>';

function inputPage($select)
{
  return <<<EOD
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
		<title>Unit Converter</title>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<a class="navbar-brand" href="/">Unit Converter</a>
      </div>
      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="/">Lengths</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/weights">Weights</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/temperatures">Temperatures</a>
        </li>
      </ul>
      </div>
		</nav>
		<div class="container-fluid">
			<form method="post" target="_self">
				<div class="mb-3">
          <label for="value">Enter the value to convert</label>
					<input class="form-control" name="value" id="value" required>
				</div>
				<div class="mb-3">
					<label for="from">Unit to convert from</label>
					<select name="from">
          $select
          </select>
				</div>
				<div class="mb-3">
					<label for="to">Unit to convert to</label>
          <select name="to">
          $select
					</select>
				</div>
				<input type="submit" value="Convert" class="btn btn-secondary">
			</form>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
	</body>
</html>'
EOD;
}
function length()
{
  global $lengthsHtml;
  return inputPage($lengthsHtml);
}

function weight()
{
  global $weightsHtml;
  return inputPage($weightsHtml);
}

function temperature()
{
  global $tempsHtml;
  return inputPage($tempsHtml);
}
const units = ['milimeter', 'centimeter', 'meter', 'kilometer', 'inch', 'foot', 'yard', 'mile', 'miligram', 'gram', 'kilogram', 'ounce', 'pound', 'celsius', 'fahrenheit', 'kelvin'];
const abbrs = ['mm', 'cm', 'm', 'km', 'in', 'ft', 'yd', 'mi', 'mg', 'g', 'kg', 'oz', 'lb', '°C', '°F', '°K'];
const conversions = [
  milimeter,
  centimeter,
  meter,
  kilogram,
  inch,
  foot,
  yard,
  mile,
  miligram,
  gram,
  kilogram,
  ounce,
  pound,
];
$tempConversions = [
  function ($from, $value) {
    return match ($from) {
      'celsius' => $value,
      'fahrenheit' => ($value - 32) / 1.8,
      'kelvin' => $value - 273.15,
    };
  },
  function ($_, $value) {
    return $value * 1.8 + 32;
  },
  function ($_, $value) {
    return $value + 273.15;
  },
];
enum Unit
{
  case length;
  case Weight;
  case temperature;
};
function convert(Unit $unit, $value, $from, $to)
{
  $fromKey = array_find_key(units, function ($unit) use ($from) {
    return $unit === $from;
  });
  $toKey = array_find_key(units, function ($unit) use ($to) {
    return $unit === $to;
  });
  if ($unit !== Unit::temperature) {
    $result  = $value * conversions[$fromKey];
    $result /= conversions[$toKey];
  } else {
    global $tempConversions;
    $result = $tempConversions[0]($from, $value);
    $result = $tempConversions[$toKey - 12]($to, $result);
  }
  $value = round($value, 3);
  $result = round($result, 3);
  $fromAbbr = abbrs[$fromKey];
  $toAbbr = abbrs[$toKey];
  return "$value$fromAbbr = $result$toAbbr";
}
function resultPage($result, $priorPath)
{
  return <<<EOD
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
		<title>Unit Converter</title>
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<div class="container">
				<a class="navbar-brand" href="/">Unit Converter</a>
      </div>
      <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="/">Lengths</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/weights">Weights</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/temperatures">Temperatures</a>
        </li>
      </ul>
      </div>
		</nav>
    <div class="container-fluid">
      <p>Result of your calculation</p>
      <p>$result</p>
      <a href="$priorPath" class="btn btn-secondary" role="button">Reset</a>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
	</body>
</html>'
EOD;
}
function lengthResult($value, $from, $to)
{
  return resultPage(convert(Unit::length, $value, $from, $to), '/lengths');
}
function weightResult($value, $from, $to)
{
  return resultPage(convert(Unit::Weight, $value, $from, $to), '/weights');
}
function tempResult($value, $from, $to)
{
  return resultPage(convert(Unit::temperature, $value, $from, $to), '/temperatures');
}
