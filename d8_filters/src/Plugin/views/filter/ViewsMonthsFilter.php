<?php

namespace Drupal\d8_filters\Plugin\views\filter;

use Drupal\views\Plugin\views\display\DisplayPluginBase;
use Drupal\views\Plugin\views\filter\InOperator;
use Drupal\views\ViewExecutable;

/**
 * Filters by given list of month options.
 *
 * @ingroup views_filter_handlers
 *
 * @ViewsFilter("d8_filters_views_months_filter")
 */
class ViewsMonthsFilter extends InOperator {

  /**
   * {@inheritdoc}
   */
  public function init(ViewExecutable $view, DisplayPluginBase $display, array &$options = NULL) {
    parent::init($view, $display, $options);
    $this->valueTitle = $this->t('Months');
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
        'method' => 'opFilterMonth',
        'values' => 1,
      ],
      '!=' => [
        'title' => $this->t('Is not equal to'),
        'short' => $this->t('!='),
        'method' => 'opFilterMonth',
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
   * Helper function that generates the month options.
   *
   * @return string[]
   *   Month list.
   */
  public function generateOptions() {
    return [
      'All' => t('- Any -'),
      '01' => t('January'),
      '02' => t('February'),
      '03' => t('March'),
      '04' => t('April'),
      '05' => t('May'),
      '06' => t('June'),
      '07' => t('July'),
      '08' => t('August'),
      '09' => t('September'),
      '10' => t('October'),
      '11' => t('November'),
      '12' => t('December'),
    ];
  }

  /**
   * Add SQL condition to filter by Month.
   */
  protected function opFilterMonth() {
    if (empty($this->value)) {
      return;
    }
    $this->ensureMyTable();
    $field = $this->tableAlias . '.' . $this->realField;
    $value = $this->value[0];
    $this->query->addWhereExpression($this->options['group'], "MONTH($field) $this->operator $value");
  }

}
