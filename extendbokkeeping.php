<?php

require_once 'extendbokkeeping.civix.php';
use CRM_Extendbokkeeping_ExtensionUtil as E;

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function extendbokkeeping_civicrm_config(&$config) {
  _extendbokkeeping_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function extendbokkeeping_civicrm_xmlMenu(&$files) {
  _extendbokkeeping_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function extendbokkeeping_civicrm_install() {
  _extendbokkeeping_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_postInstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_postInstall
 */
function extendbokkeeping_civicrm_postInstall() {
  _extendbokkeeping_civix_civicrm_postInstall();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function extendbokkeeping_civicrm_uninstall() {
  _extendbokkeeping_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function extendbokkeeping_civicrm_enable() {
  _extendbokkeeping_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function extendbokkeeping_civicrm_disable() {
  _extendbokkeeping_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function extendbokkeeping_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _extendbokkeeping_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function extendbokkeeping_civicrm_managed(&$entities) {
  _extendbokkeeping_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function extendbokkeeping_civicrm_caseTypes(&$caseTypes) {
  _extendbokkeeping_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_angularModules
 */
function extendbokkeeping_civicrm_angularModules(&$angularModules) {
  _extendbokkeeping_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function extendbokkeeping_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _extendbokkeeping_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_preProcess
 *
function extendbokkeeping_civicrm_preProcess($formName, &$form) {

} // */

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_navigationMenu
 *
function extendbokkeeping_civicrm_navigationMenu(&$menu) {
  _extendbokkeeping_civix_insert_navigation_menu($menu, NULL, array(
    'label' => E::ts('The Page'),
    'name' => 'the_page',
    'url' => 'civicrm/the-page',
    'permission' => 'access CiviReport,access CiviContribute',
    'operator' => 'OR',
    'separator' => 0,
  ));
  _extendbokkeeping_civix_navigationMenu($menu);
} // */

/**
 * Implements hook_civicrm_batchItems().
 */
function extendbokkeeping_civicrm_batchItems(&$results, &$items) {
  if (!empty($items)) {
    foreach ($items as $key => $transactions) {
      $batchItems = civicrm_api3('Contribution', 'get', [
        'sequential' => 1,
        'return' => ["contribution_campaign_id"],
        'id' => $transactions['Invoice No'],
        'contact_id' => $transactions['Contact ID'],
      ]);
      if (!empty($batchItems['values']) && !empty($batchItems['values'][0]['contribution_campaign_id'])) {
        $campaign = civicrm_api3('Campaign', 'get', [
          'sequential' => 1,
          'return' => ["title"],
          'id' => $batchItems['values'][0]['contribution_campaign_id'],
        ]);

        if (!empty($campaign['values']) && !empty($campaign['values'][0]['title'])) {
          $campaign_name = $campaign['values'][0]['title'];
          $items[$key]['campaign'] = $campaign_name;
        }
      }
    }
  }
}
