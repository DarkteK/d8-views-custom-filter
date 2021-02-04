<?php

/**
 * @file
 * Custom filter for views.
 */

/**
 * Implements hook_views_data_alter().
 *
 * @phpcsSuppress SlevomatCodingStandard.TypeHints.ParameterTypeHint.MissingTraversableTypeHintSpecification
 */
function d8_filters_views_data_alter(array &$data) {

  $data['node__field_date']['date_field_year'] = [
    'label' => t('Custom Year Filter'),
    'title' => t('Year'),
    'group' => t('Custom Filters'),
    'filter' => [
      'title' => t('Year'),
      'help' => t('Provides a custom filter for nodes by their year from the start-date.'),
      'field' => 'field_date_value',
      'id' => 'd8_filters_views_years_filter',
    ],
  ];

  $data['node__field_date']['date_field_month'] = [
    'label' => t('Custom Month Filter'),
    'title' => t('Month'),
    'group' => t('Custom Filters'),
    'filter' => [
      'title' => t('Month'),
      'help' => t('Provides a custom filter for nodes by their month from the start-date.'),
      'field' => 'field_date_value',
      'id' => 'd8_filters_views_months_filter',
    ],
  ];

}