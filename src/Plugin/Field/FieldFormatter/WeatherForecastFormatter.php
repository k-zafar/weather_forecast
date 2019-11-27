<?php

namespace Drupal\weather_forecast\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'field_text_weather_forecast' formatter.
 *
 * @FieldFormatter(
 *   id = "field_text_weather_forecast",
 *   label = @Translation("Weather"),
 *   field_types = {
 *     "text"
 *   }
 * )
 */
class WeatherForecastFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      // Fetching Weather Forecast
      $weather_forecast = \Drupal::service('weather_forecast.showweatherforeacast')
                            ->showWeatherForeacast($item->value);
                            
      $elements[$delta] = [
        '#type' => 'processed_text',
        '#weather' => $weather_forecast,
        '#format' => $item->format,
        '#langcode' => $item->getLangcode(),
        '#theme'=> 'text_field_weather_forecast_formatter',
      ];
    }

    return $elements;
  }

}
