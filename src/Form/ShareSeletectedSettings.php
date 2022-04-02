<?php

namespace Drupal\share_selected\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Custom setting form.
 *
 * @package Drupal\share_selected\Form
 */
class ShareSeletectedSettings extends ConfigFormBase {

  /**
   * Default settings.
   *
   * @return array
   *   An array containing default values.
   */
  public static function defaultSettings() {
    return [
      'facebook' => 1,
      'twitter' => 1,
      'twitter_username' => '',
      'bg_color' => '#333333',
      'icon_color' => '#ffffff',
    ];
  }

  /**
   * Gets the configuration names that will be editable.
   *
   * @return array
   *   An array of configuration object names that are editable if called in
   *   conjunction with the trait's config() method.
   */
  protected function getEditableConfigNames() {
    return ['share_selected.settings'];
  }

  /**
   * Returns a unique string identifying the form.
   *
   * The returned ID should be a unique string that can be a valid PHP function
   * name, since it's used in hook implementation names such as
   * hook_form_FORM_ID_alter().
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'share_selected_settings';
  }

  /**
   * Gets the value for the config key.
   *
   * @return array|mixed|null
   *   Fallbacks to default value if no config exists.
   */
  private function getConfigValue($key) {
    /** @var \Drupal\Core\Config\ImmutableConfig $config */
    $config = $this->config('share_selected.settings');
    $default_settings = $this->defaultSettings();
    return is_null($config->get($key)) ? $default_settings[$key] : $config->get($key);
  }

  /**
   * {@inheritDoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
  
    $form['facebook'] = [
      '#title' => $this->t('Enable Facebook Sharing'),
      '#description' => $this->t('Note:- Facebook sharing will not work in localhost.'),
      '#type' => 'checkbox',
      '#default_value' => $this->getConfigValue('facebook'),
    ];
 
    $form['twitter'] = [
      '#title' => $this->t('Enable Twitter Sharing'),
      '#description' => $this->t('Enable Twitter.'),
      '#type' => 'checkbox',
      '#default_value' => $this->getConfigValue('twitter'),
    ];

    $form['twitter_username'] = [
      '#title' => $this->t('Twitter Username'),
      '#description' => $this->t('Twiiter Username without @.'),
      '#type' => 'textfield',
      '#default_value' => $this->getConfigValue('twitter_username'),
    ];

    $form['bg_color'] = [
      '#title' => $this->t('Background Color'),
      '#description' => $this->t('Background color for icon wrapper.'),
      '#type' => 'color',
      '#default_value' => $this->getConfigValue('bg_color'),
    ];

    $form['icon_color'] = [
      '#title' => $this->t('Icon Color'),
      '#description' => $this->t('Color for icon.'),
      '#type' => 'color',
      '#default_value' => $this->getConfigValue('icon_color'),
    ];
 
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('share_selected.settings');
    $elements = array_keys($this->defaultSettings());
    foreach ($elements as $element) {
      $value = $form_state->getValue($element);
      $config->set($element, $value);
    }
    $config->save();
    parent::submitForm($form, $form_state);
  }

}
