<?php

namespace Drupal\d8_filters\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ViewExecutable;

/**
 * Filters by given list of year options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("d8_filters_views_years_filter")
 */
class ViewsYearsFilter extends InOperator {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = $this->t('Years');
    $this->definition['options callback'] = [$this, 'generateOptions'];
  }

  /**
   * {@inheritdoc}
   */
  public function operators() {
    return [
      '=' => [
        'title' => $this->t('Is equal to'),
        'short' => $this->t('='),
        'method' => 'opFilterYear',
        'values' => 1,
      ],
      '!=' => [
        'title' => $this->t('Is not equal to'),
        'short' => $this->t('!='),
        'method' => 'opFilterYear',
        'values' => 1,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function query() {
    // Override the query
    // So that no filtering takes place if the user doesn't select any options.
    if (!empty($this->value)) {
      parent::query();
    }
  }

  /**
   * {@inheritdoc}
   */
  public function validate() {
    // Skip validation
    // If no options have been chosen so we can use it as a non-filter.
    if (!empty($this->value)) {
      parent::validate();
    }
  }

  /**
   * Helper function that generates the year options.
   *
   * @return string[]
   *   Year list.
   */
  public function generateOptions() {
    // You can add any callback function that can return specific years for the user to choose.
    return [
      'All' => t('- Any -'),
      '2017' => t('2017'),
      '2018' => t('2018'),
      '2019' => t('2019'),
      '2020' => t('2020'),
      '2021' => t('2021'),
    ];
  }

  /**
   * Add SQL condition to filter by Year.
   */
  protected function opFilterYear() {
    if (empty($this->value)) {
      return;
    }
    $this->ensureMyTable();
    $field = $this->tableAlias . '.' . $this->realField;
    $value = $this->value[0];
    $this->query->addWhereExpression($this->options['group'], "YEAR($field) $this->operator $value");
  }

}
